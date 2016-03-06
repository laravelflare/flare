<?php

namespace LaravelFlare\Flare\Admin\Models\Traits;

use LaravelFlare\Flare\Events\ModelDelete;
use LaravelFlare\Flare\Events\AfterDelete;
use LaravelFlare\Flare\Events\BeforeDelete;
use LaravelFlare\Flare\Events\ModelRestore;
use LaravelFlare\Flare\Events\AfterRestore;
use LaravelFlare\Flare\Events\BeforeRestore;
use LaravelFlare\Flare\Events\ModelSoftDelete;

trait ModelSoftDeleting
{
    use ModelDeleting;

    /**
     * Overrides the ModelQuerying provided method 
     * with one which searches withTrashed scope.
     * 
     * @param int $modelitemId
     * 
     * @return
     */
    public function find($modelitemId)
    {
        return $this->findWithTrashed($modelitemId);
    }

    /**
     * Finds model and includes withTrashed() scope in query.
     *
     * @param int $modelitemId
     * 
     * @return
     */
    public function findWithTrashed($modelitemId)
    {
        $this->model = $this->model->withTrashed()->findOrFail($modelitemId);

        return $this->model;
    }

    /**
     * Finds model and includes onlyTrashed() scope in query.
     *
     * @param int $modelitemId
     * 
     * @return
     */
    public function findOnlyTrashed($modelitemId)
    {
        $this->model = $this->model->onlyTrashed()->findOrFail($modelitemId);

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
     * @param int $modelitemId
     * 
     * @return
     */
    public function delete($modelitemId)
    {
        event(new BeforeDelete($this));

        $this->findWithTrashed($modelitemId);

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
     * @param int $modelitemId
     * 
     * @return
     */
    public function restore($modelitemId)
    {
        event(new BeforeRestore($this));

        $this->findOnlyTrashed($modelitemId);

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
