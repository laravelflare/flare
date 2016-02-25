<?php

namespace LaravelFlare\Flare\Admin\Models\Traits;

use LaravelFlare\Flare\Events\ModelEdit;
use LaravelFlare\Flare\Events\AfterEdit;
use LaravelFlare\Flare\Events\BeforeEdit;
use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelEditting
{
    /**
     * Method fired before the Edit action is undertaken.
     * 
     * @return
     */
    protected function beforeEdit()
    {
    }

    /**
     * Edit Action.
     *
     * Fires off beforeEdit(), doEdit() and afterEdit()
     * 
     * @param int $modelitemId
     * 
     * @return
     */
    public function edit($modelitemId)
    {
        $this->find($modelitemId);

        event(new BeforeEdit($this));

        $this->beforeEdit();

        $this->doEdit();

        $this->afterEdit();

        event(new AfterEdit($this));
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
    }
}
