<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

use LaravelFlare\Flare\Events\CreateEvent;
use LaravelFlare\Flare\Events\AfterCreateEvent;
use LaravelFlare\Flare\Events\BeforeCreateEvent;
use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelCreating
{
    /**
     * Used by beforeCreate() to ensure child classes call parent::beforeCreate().
     * 
     * @var bool
     */
    protected $brokenBeforeCreate = false;

    /**
     * Used by afterCreate() to ensure child classes call parent::afterCreate().
     * 
     * @var bool
     */
    protected $brokenAfterCreate = false;

    /**
     * Trait Requires Save Method (usually provided by ModelQuerying).
     * 
     * @return
     */
    abstract protected function save();

    /**
     * Method fired before the Create action is undertaken.
     * 
     * @return
     */
    protected function beforeCreate()
    {
        $this->brokenBeforeCreate = false;

        event(new BeforeCreateEvent($this));
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
        $this->brokenBeforeCreate = true;
        $this->beforeCreate();
        if ($this->brokenBeforeCreate) {
            throw new WriteableException('ModelAdmin has a broken beforeCreate method. Make sure you call parent::beforeCreate() on all instances of beforeCreate()', 1);
        }

        $this->doCreate();

        $this->brokenAfterCreate = true;
        $this->afterCreate();
        if ($this->brokenAfterCreate) {
            throw new WriteableException('ModelAdmin has a broken afterCreate method. Make sure you call parent::afterCreate() on all instances of afterCreate()', 1);
        }
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

            event(new CreateEvent($this));

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
        $this->brokenAfterCreate = false;

        event(new AfterCreateEvent($this));
    }
}
