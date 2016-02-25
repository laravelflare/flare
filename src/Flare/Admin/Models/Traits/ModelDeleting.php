<?php

namespace LaravelFlare\Flare\Admin\Models\Traits;

use LaravelFlare\Flare\Events\ModelDelete;
use LaravelFlare\Flare\Events\AfterDelete;
use LaravelFlare\Flare\Events\BeforeDelete;
use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelDeleting
{
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
        $this->find($modelitemId);

        event(new BeforeDelete($this));

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
        $this->model->delete();

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
}
