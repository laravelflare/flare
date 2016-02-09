<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

trait ModelCloning
{
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
