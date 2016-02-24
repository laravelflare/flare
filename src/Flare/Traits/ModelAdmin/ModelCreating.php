<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

use LaravelFlare\Flare\Events\ModelCreate;
use LaravelFlare\Flare\Events\AfterCreate;
use LaravelFlare\Flare\Events\BeforeCreate;
use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelCreating
{
    /**
     * Method fired before the Create action is undertaken.
     * 
     * @return
     */
    protected function beforeCreate()
    {
    }

    /**
     * Create Action.
     *
     * Fires off beforeCreate(), doCreate() and afterCreate()
     * 
     * @return
     */
    public function create()
    {
        event(new BeforeCreate($this));

        $this->beforeCreate();

        $this->doCreate();

        $this->afterCreate();

        event(new AfterCreate($this));
    }

    /**
     * The actual Create action, which does all of hte pre-processing
     * required before we are able to perform the save() function.
     * 
     * @return
     */
    private function doCreate()
    {
        if (is_callable(array('self', 'save'))) {
            $this->save();

            event(new ModelCreate($this));

            return;
        }

        throw new WriteableException('For a Model to be Creatable the ModelAdmin must have the Save method implemented using the ModelWriting trait', 1);
    }

    /**
     * Method fired after the Create action is complete.
     * 
     * @return
     */
    protected function afterCreate()
    {
    }
}
