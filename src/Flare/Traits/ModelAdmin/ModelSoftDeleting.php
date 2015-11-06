<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

use LaravelFlare\Flare\Events\ModelDelete;
use LaravelFlare\Flare\Events\AfterDelete;
use LaravelFlare\Flare\Events\BeforeDelete;
use LaravelFlare\Flare\Events\ModelSoftDelete;
use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelSoftDeleting
{
    /**
     * Shows that this is a soft deleting model.
     * 
     * @var bool
     */
    public $softDeletingModel = true;

    /**
     * Overrides the ModelQuerying provided method 
     * with one which searches withTrashed scope.
     * 
     * @param int $modelitem_id
     * 
     * @return
     */
    public function find($modelitem_id)
    {
        return $this->findWithTrashed($modelitem_id);
    }

    /**
     * Finds model and includes withTrashed() scope in query.
     *
     * @param int $modelitem_id
     * 
     * @return
     */
    public function findWithTrashed($modelitem_id)
    {
        $this->model = $this->model->withTrashed()->findOrFail($modelitem_id);

        return $this->model;
    }

    /**
     * Finds model and includes onlyTrashed() scope in query.
     *
     * @param int $modelitem_id
     * 
     * @return
     */
    public function findOnlyTrashed($modelitem_id)
    {
        $this->model = $this->model->onlyTrashed()->findOrFail($modelitem_id);

        return $this->model;
    }

    /**
     * Method fired before the Delete action is undertaken.
     * 
     * @return
     */
    protected function beforeDelete()
    {
        $this->brokenBeforeDelete = false;

        event(new BeforeDelete($this));
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
        $this->findWithTrashed($modelitem_id);

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
        if (!$this->model->trashed()) {
            $this->model->delete();
            event(new ModelSoftDelete($this));

            return;
        }

        $this->model->forceDelete();
        event(new ModelDelete($this));
    }

    /**
     * Method fired after the Delete action is complete.
     * 
     * @return
     */
    protected function afterDelete()
    {
        $this->brokenAfterDelete = false;

        event(new AfterDelete($this));
    }
}
