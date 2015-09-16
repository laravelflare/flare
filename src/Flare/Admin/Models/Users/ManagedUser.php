<?php

namespace LaravelFlare\Flare\Admin\Models\Users;

use App\Models\User as User;
use LaravelFlare\Flare\Admin\Models\ManagedModel;

class ManagedUser extends ManagedModel
{
    /**
     * Managed Model Instance.
     * 
     * @var string
     */
    public $managedModel = 'App\Models\User';

    /**
     * Map User Attributes to their Attribute Types.
     * 
     * @var array
     */
    protected $mapping = [
        'name' => ['type' => 'text', 'length' => 32],
        'email' => ['type' => 'email', 'length' => 255],
        'password' => ['type' => 'password', 'length' => 32],
    ];

    /**
     * Validation Rules for onCreate, onEdit actions.
     * 
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:32',
        'email' => 'required|email',
        'password' => 'required|min:8|max:32', // removed `confirmed` while we are looping through fillable
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
        'group.name' => 'Group',
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
        $this->model->setAttribute('password', bcrypt($value));
    }
}
