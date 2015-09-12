<?php

namespace JacobBaileyLtd\Flare\Http\Requests;

use JacobBaileyLtd\Flare\Http\Requests\AdminRequest;

class ModelAdminEditRequest extends AdminRequest {

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
        return [

        ];
    }

}
