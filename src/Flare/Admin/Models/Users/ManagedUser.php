<?php

namespace LaravelFlare\Flare\Admin\Models\Users;

use App\Models\User;
use App\Models\UserGroup;
use LaravelFlare\Flare\Admin\Models\ManagedModel;
use LaravelFlare\Flare\Traits\ManagedModel\HumanTimestampAttributes;

class ManagedUser extends ManagedModel
{
    use HumanTimestampAttributes;

    /**
     * Managed Model Instance.
     * 
     * @var string
     */
    public $managedModel = \App\User::class;

    /**
     * ManagedModel Icon.
     *
     * Font Awesome Defined Icon, eg 'user' = 'fa-user'
     *
     * @var string
     */
    public static $icon = 'user';

    /**
     * Map User Attributes to their Attribute Types.
     * 
     * @var array
     */
    protected $mapping = [
        'name' => ['type' => 'text', 'length' => 32, 'required' => 'required'],
        'email' => ['type' => 'email', 'length' => 255, 'required' => 'required'],
        'password' => ['type' => 'password', 'length' => 32, 'required' => 'required'],
    ];

    /**
     * Validation Rules for onCreate, onEdit actions.
     * 
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:32',
        'email' => 'required|email',
        'password' => 'required|min:8|max:32',
    ];

    /**
     * Summary Fields for Model.
     *
     * Defines which fields to show in the listing tables output.
     * 
     * @var array
     */
    protected $summary_fields = [
        'id' => 'ID',
        'name',
        'email',
        'created_at' => 'Created',
        'updated_at' => 'Updated',
    ];

    /**
     * The number of models to return for pagination.
     *
     * If int greater than 0 then pagination is used, otherwise
     * all entries will be output.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * When a new password is set, hash it.
     * 
     * @param string
     */
    protected function setPasswordAttribute($value)
    {
        if ($value == '') {
            return;
        }

        $this->model->setAttribute('password', bcrypt($value));
    }

    /**
     * Don't output passwords.
     * 
     * @param string
     */
    protected function getPasswordAttribute()
    {
        return;
    }
}
