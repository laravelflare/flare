<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

use Validator;
use LaravelFlare\Flare\Exceptions\ModelAdminValidationException as ValidationException;

trait ModelValidation
{
    /**
     * Validation Rules for onCreate, onEdit actions.
     * 
     * @var array
     */
    protected $rules = [];

    /**
     * Used by beforeValidate() to ensure child classes call parent::beforeValidate().
     * 
     * @var bool
     */
    protected $brokenBeforeValidate = false;

    /**
     * Used by afterValidate() to ensure child classes call parent::afterValidate().
     * 
     * @var bool
     */
    protected $brokenAfterValidate = false;

    /**
     * Retrunes the Rules Array.
     * 
     * @return
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * Method fired before the Validate action is undertaken.
     * 
     * @return
     */
    protected function beforeValidate()
    {
        $this->brokenBeforeValidate = false;
    }

    /**
     * Validate Action.
     *
     * Fires off beforeValidate(), doValidate()) and afterValidate()
     * 
     * @return
     */
    public function validate()
    {
        $this->brokenBeforeValidate = true;
        $this->beforeValidate();
        if ($this->brokenBeforeValidate) {
            throw new ValidationException('ModelAdmin has a broken beforeValidate method. Make sure you call parent::beforeValidate() on all instances of beforeValidate()', 1);
        }

        $this->doValidate();

        $this->brokenAfterValidate = true;
        $this->afterValidate();
        if ($this->brokenAfterValidate) {
            throw new ValidationException('ModelAdmin has a broken afterValidate method. Make sure you call parent::afterValidate() on all instances of afterValidate()', 1);
        }
    }

    /**
     * The actual Validate action.
     * 
     * @return
     */
    private function doValidate()
    {
        $validator = Validator::make($this->input, $this->rules);

        if ($validator->fails()) {
            throw new ValidationException($validator->errors()); //We need some nice Custom Validator Exception which can hold error messages for fields etc
        }
    }

    /**
     * Method fired after the Create action is complete.
     * 
     * @return
     */
    protected function afterValidate()
    {
        $this->brokenAfterValidate = false;
    }
}
