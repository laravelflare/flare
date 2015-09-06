<?php

namespace JacobBaileyLtd\Flare\Traits\ModelAdmin;

use JacobBaileyLtd\Flare\Exceptions\ModelAdminValidationException as ValidationException;

trait ModelValidation
{
    /**
     * Used by beforeValidate() to ensure child classes call parent::beforeValidate()
     * 
     * @var boolean
     */
    protected $brokenBeforeValidate = false;

    /**
     * Used by afterValidate() to ensure child classes call parent::afterValidate()
     * 
     * @var boolean
     */
    protected $brokenAfterValidate = false;

    /**
     * Method fired before the Validate action is undertaken
     * 
     * @return
     */
    protected function beforeValidate()
    {
        $this->brokenBeforeValidate = false;
    }

    /**
     * Validate Action
     *
     * Fires off beforeValidate(), doValidate()) and afterValidate()
     * 
     * @return
     */
    public function validate() {
        $this->brokenBeforeValidate = true;
        $this->beforeValidate();
        if ($this->brokenBeforeValidate) {
            throw new ValidationException("ModelAdmin has a broken beforeValidate method. Make sure you call parent::beforeValidate() on all instances of beforeValidate()", 1);
        }
        
        $this->doValidate();

        $this->brokenAfterValidate = true;
        $this->afterValidate();
        if ($this->brokenAfterValidate) {
            throw new ValidationException("ModelAdmin has a broken afterValidate method. Make sure you call parent::afterValidate() on all instances of afterValidate()", 1);
        }
    }

    /**
     * The actual Validate action
     * 
     * @return
     */
    private function doValidate()
    {
        
    }

    /**
     * Method fired after the Create action is complete
     * 
     * @return
     */
    protected function afterValidate()
    {
        $this->brokenAfterValidate = false;
    }
}
