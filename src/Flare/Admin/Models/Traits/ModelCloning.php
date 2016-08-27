<?php

namespace LaravelFlare\Flare\Admin\Models\Traits;

trait ModelCloning
{
    /**
     * Method fired before the Clone action is undertaken.
     * 
     * @return
     */
    protected function beforeClone()
    {
    }

    /**
     * Clone Action.
     *
     * Fires off beforeClone(), doClone() and afterClone()
     *
     * @param int $modelitemId
     * 
     * @return
     */
    public function clone($modelitemId)
    {
        event(new BeforeClone($this));

        $this->beforeClone();

        $this->doClone();

        $this->afterClone();

        event(new AfterClone($this));
    }

    /**
     * The actual Clone action, which does all of hte pre-processing
     * required before we are able to perform the save() function.
     * 
     * @return
     */
    private function doClone()
    {
        if (is_callable(array('self', 'save'))) {
            $this->find($modelitemId)->replicate($this->excludeOnClone())->save();

            event(new ModelClone($this));

            return;
        }

        throw new WriteableException('For a Model to be Creatable the ModelAdmin must have the Save method implemented using the ModelWriting trait', 1);
    }

    /**
     * Method fired after the Clone action is complete.
     * 
     * @return
     */
    protected function afterClone()
    {
    }

    /**
     * An Array of Fields to Exclude on Clone.
     *
     * When cloning a Model ceratin data might need to be skipped
     * either because it is irrelevant (such as datestamps) or
     * because it is primary or unique data in the database.
     * 
     * @return array
     */
    public function excludeOnClone()
    {
        return [
            $this->model->getKeyName(),
            $this->model->getCreatedAtColumn(),
            $this->model->getUpdatedAtColumn(),
        ];
    }

    /**
     * 
     */
    public function unCloneableColumns()
    {
        // We will use this: SHOW INDEXES FROM users WHERE Non_unique != 0 AND Column_name != 'id'
        // To determine if there are unCloneable Columns and if that is the case, we will render
        // the clone view and validate the unCloneable Columns to be unique before saving.
    }
}
