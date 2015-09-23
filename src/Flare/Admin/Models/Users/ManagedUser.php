<?php

namespace LaravelFlare\Flare\Admin\Models\Users;

use App\Models\User;
use App\Models\UserGroup;
use LaravelFlare\Flare\Admin\Models\ManagedModel;

class ManagedUser extends ManagedModel
{
    /**
     * Managed Model Instance.
     * 
     * @var string
     */
    public $managedModel = \App\Models\User::class;

    /**
     * ManagedModel Icon.
     *
     * Font Awesome Defined Icon, eg 'user' = 'fa-user'
     *
     * @var string
     */
    public static $icon = '';

    /**
     * Map User Attributes to their Attribute Types.
     * 
     * @var array
     */
    protected $mapping = [
        'name' => ['type' => 'text', 'length' => 32, 'required' => 'required'],
        'email' => ['type' => 'email', 'length' => 255, 'required' => 'required'],
        'password' => ['type' => 'password', 'length' => 32, 'required' => 'required'],
        'usergroup' => ['type' => 'radio', 'required' => 'required'], 
                                            // Options should either be an array or a string referencing a method on the ManagedModel class
                                            // Titles can definitely be improved on

        // 'checkbox' => ['type' => 'checkbox'],
        // 'date' => ['type' => 'date'],
        // 'radio' => ['type' => 'radio'],
        // 'textarea' => ['type' => 'textarea'],
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
        'usergroup.name' => 'Group', // This might be better as user_group, camelCased to the method name
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
     * Don't output passwords
     * 
     * @param string
     */
    protected function getPasswordAttribute()
    {
        return;
    }

    /**
     * Don't output passwords
     * 
     * @param string
     */
    protected function getUsergroupAttribute($model)
    {
        return $model->userGroup->name; // I dont like having to do this, I'd prefer some sweet dot notation.
    }

    /**
     * Format our created_at times nicely
     * 
     * @param string
     */
    protected function getCreatedAtAttribute($model)
    {
        return $model->created_at->diffForHumans(); // I dont like having to do this, I'd prefer some sweet dot notation.
    }

    /**
     * Format our updated_at times nicely
     * 
     * @param string
     */
    protected function getUpdatedAtAttribute($model)
    {
        return $model->updated_at->diffForHumans(); // I dont like having to do this, I'd prefer some sweet dot notation.
    }

    /**
     * Returns the available options for the Group Option
     * 
     * @return array
     */
    public function getUsergroupOptions()
    {
        return \App\Models\UserGroup::lists('name', 'id')->toArray(); // Example of Using Model Collection Lists :D
        //return ['Admins', 'Moderators', 'Cool Kids']; // Example use of flat array
    }
}
