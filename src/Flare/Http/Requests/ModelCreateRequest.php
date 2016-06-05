<?php

namespace LaravelFlare\Flare\Http\Requests;

use LaravelFlare\Flare\Admin\AdminManager;

class ModelCreateRequest extends AdminRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return 
            app(AdminManager::class)
            ->getAdminInstance()
            ->getCreateRules();
    }
}
