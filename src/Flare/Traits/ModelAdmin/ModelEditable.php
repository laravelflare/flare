<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelEditable
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
     * Method fired before the Edit action is undertaken.
     * 
     * @return
     */
    protected function beforeEdit()
    {
        $this->brokenBeforeEdit = false;
    }

    /**
     * Edit Action.
     *
     * Fires off beforeEdit(), doEdit() and afterEdit()
     * 
     * @param integer $modelitem_id
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
        // Unguard the model so we can set and store non-fillable entries
        $this->modelManager->model->unguard();

        // Save 
        if (is_callable(array("self", "save"))) {
            $this->save();
        } else {
            throw new WriteableException('For a Model to be Editable the ModelAdmin must have the Save method implemented using the ModelWriteable trait', 1);
        }

        // Reguard.
        $this->modelManager->model->reguard();
    }

    /**
     * Method fired after the Edit action is complete.
     * 
     * @return
     */
    protected function afterEdit()
    {
        $this->brokenAfterEdit = false;
    }
}
