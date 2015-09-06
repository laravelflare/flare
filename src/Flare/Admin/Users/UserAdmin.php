<?php

namespace JacobBaileyLtd\Flare\Admin\Users;

use App\Models\User as User;
use JacobBaileyLtd\Flare\Admin\ModelAdmin;

class UserAdmin extends ModelAdmin
{
    /**
     * List of managed {@link Model}s.
     *
     * Note: This must either be a single Namespaced String
     * or an Array of Namespaced Strings
     *
     * Perhaps in the future we will allow App\Models\Model::class format aswell!
     */
    protected $managedModels = ['App\Models\User', 'App\Models\UserGroup'];

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
}
