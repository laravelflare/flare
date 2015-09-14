<?php

namespace JacobBaileyLtd\Flare\Admin\Models\Users;

use App\Models\User as User;
use JacobBaileyLtd\Flare\Admin\Models\ManagedModel;

class ManagedUserGroup extends ManagedModel
{
    /**
     * Managed Model Instance
     * 
     * @var string
     */
    public $managedModel = 'App\Models\UserGroup';

    /**
     * Map User Group Attributes to their Attribute Types.
     * 
     * @var array
     */
    protected $mapping = [
        'name' => ['type' => 'text', 'length' => 32],
    ];

    /**
     * Validation Rules for onCreate, onEdit actions.
     * 
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:32',
    ];

    /**
     * Validation Rules for onCreate, onEdit actions.
     * 
     * @var array
     */
    protected $summary_fields = [
        'id' => 'ID',
        'name',
    ];
}