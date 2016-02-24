<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

use LaravelFlare\Flare\Events\ModelDelete;
use LaravelFlare\Flare\Events\AfterDelete;
use LaravelFlare\Flare\Events\BeforeDelete;
use LaravelFlare\Flare\Events\ModelRestore;
use LaravelFlare\Flare\Events\AfterRestore;
use LaravelFlare\Flare\Events\BeforeRestore;
use LaravelFlare\Flare\Events\ModelSoftDelete;
use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelSoftDeleting
{
    use ModelDeleting;

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
        event(new BeforeDelete($this));

        $this->findWithTrashed($modelitem_id);

        $this->beforeDelete();

        $this->doDelete();

        $this->afterDelete();

        event(new AfterDelete($this));
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
    }

    /**
     * Method fired before the Restore action is undertaken.
     * 
     * @return
     */
    protected function beforeRestore()
    {
    }

    /**
     * Restore Action.
     *
     * Fires off beforeRestore(), doRestore() and afterRestore()
     * 
     * @param int $modelitem_id
     * 
     * @return
     */
    public function restore($modelitem_id)
    {
        event(new BeforeRestore($this));

        $this->findOnlyTrashed($modelitem_id);

        $this->beforeRestore();

        $this->doRestore();

        $this->afterRestore();

        event(new AfterRestore($this));
    }

    /**
     * The actual restore action.
     * 
     * @return
     */
    private function doRestore()
    {
        $this->model->restore();
        
        event(new ModelRestore($this));
    }

    /**
     * Method fired after the Restore action is complete.
     * 
     * @return
     */
    protected function afterRestore()
    {
    }
}
