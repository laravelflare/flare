<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

trait ModelCloning
{
    /**
     * Map Model Attributes to AttributeTypes with
     * additional parameters which will be output
     * as fields when viewing, editting or adding
     * a new model entry.
     * 
     * @var array
     */
    protected $fields = [];
    
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
}
