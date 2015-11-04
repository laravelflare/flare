<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

use LaravelFlare\Flare\Events\ModelEdit;
use LaravelFlare\Flare\Events\AfterEdit;
use LaravelFlare\Flare\Events\BeforeEdit;
use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelEditting
{
    /**
     * Used by beforeEdit() to ensure child classes call parent::beforeEdit().
     * 
     * @var bool
     */
    protected $brokenBeforeEdit = false;

    /**
     * Used by afterEdit() to ensure child classes call parent::afterEdit().
     * 
     * @var bool
     */
    protected $brokenAfterEdit = false;

    /**
     * Trait Requires Find Method (usually provided by ModelQuerying).
     *
     * @param int $modelitem_id
     * 
     * @return
     */
    abstract protected function find($modelitem_id);

    /**
     * Trait Requires Save Method (usually provided by ModelWriting).
     * 
     * @return
     */
    abstract protected function save();

    /**
     * Method fired before the Edit action is undertaken.
     * 
     * @return
     */
    protected function beforeEdit()
    {
        $this->brokenBeforeEdit = false;

        event(new BeforeEdit($this));
    }

    /**
     * Edit Action.
     *
     * Fires off beforeEdit(), doEdit() and afterEdit()
     * 
     * @param int $modelitem_id
     * 
     * @return
     */
    public function edit($modelitem_id)
    {
        $this->find($modelitem_id);

        $this->brokenBeforeEdit = true;
        $this->beforeEdit();
        if ($this->brokenBeforeEdit) {
            throw new WriteableException('ModelAdmin has a broken beforeEdit method. Make sure you call parent::beforeEdit() on all instances of beforeEdit()', 1);
        }

        $this->doEdit();

        $this->brokenAfterEdit = true;
        $this->afterEdit();
        if ($this->brokenAfterEdit) {
            throw new WriteableException('ModelAdmin has a broken afterEdit method. Make sure you call parent::afterEdit() on all instances of afterEdit()', 1);
        }
    }

    /**
     * The actual Edit action, which does all of the pre-processing
     * required before we are able to perform the save() function.
     * 
     * @return
     */
    private function doEdit()
    {
        if (is_callable(array('self', 'save'))) {
            $this->save();

            event(new ModelEdit($this));

            return;
        }

        throw new WriteableException('For a Model to be Editable the ModelAdmin must have the Save method implemented using the ModelWriting trait', 1);
    }

    /**
     * Method fired after the Edit action is complete.
     * 
     * @return
     */
    protected function afterEdit()
    {
        $this->brokenAfterEdit = false;

        event(new AfterEdit($this));
    }
}