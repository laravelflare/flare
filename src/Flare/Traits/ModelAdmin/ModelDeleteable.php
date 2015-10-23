<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

use LaravelFlare\Flare\Events\DeleteEvent;
use LaravelFlare\Flare\Events\AfterDeleteEvent;
use LaravelFlare\Flare\Events\BeforeDeleteEvent;
use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelDeleteable
{
    /**
     * Used by beforeDelete() to ensure child classes call parent::beforeDelete().
     * 
     * @var bool
     */
    protected $brokenBeforeDelete = false;

    /**
     * Used by afterDelete() to ensure child classes call parent::afterDelete().
     * 
     * @var bool
     */
    protected $brokenAfterDelete = false;

    /**
     * Trait Requires Find Method (usually provided by ModelQueryable).
     *
     * @param int $modelitem_id
     * 
     * @return
     */
    abstract protected function find($modelitem_id);

    /**
     * Method fired before the Delete action is undertaken.
     * 
     * @return
     */
    protected function beforeDelete()
    {
        $this->brokenBeforeDelete = false;

        event(new BeforeDeleteEvent($this));
    }

    /**
     * Delete Action.
     *
     * Fires off beforeDelete(), doDelete() and afterDelete()
     * 
     * @param int $modelitem_id
     * 
     * @return
     */
    public function delete($modelitem_id)
    {
        $this->find($modelitem_id);

        $this->brokenBeforeDelete = true;
        $this->beforeDelete();
        if ($this->brokenBeforeDelete) {
            throw new WriteableException('ModelAdmin has a broken beforeDelete method. Make sure you call parent::beforeDelete() on all instances of beforeDelete()', 1);
        }

        $this->doDelete();

        $this->brokenAfterDelete = true;
        $this->afterDelete();
        if ($this->brokenAfterDelete) {
            throw new WriteableException('ModelAdmin has a broken afterDelete method. Make sure you call parent::afterDelete() on all instances of afterDelete()', 1);
        }
    }

    /**
     * The actual delete action.
     * 
     * @return
     */
    private function doDelete()
    {
        $this->model->delete();

        event(new DeleteEvent($this));
    }

    /**
     * Method fired after the Delete action is complete.
     * 
     * @return
     */
    protected function afterDelete()
    {
        $this->brokenAfterDelete = false;

        event(new AfterDeleteEvent($this));
    }
}
