<?php

namespace LaravelFlare\Flare\Traits\ManagedModel;

trait HumanTimestampAttributes
{
    /**
     * Format the created_at time in Human format.
     * 
     * @param string
     */
    protected function getCreatedAtAttribute($model)
    {
        return $model->created_at->diffForHumans();
    }

    /**
     * Format the updated_at time in Human format.
     * 
     * @param string
     */
    protected function getUpdatedAtAttribute($model)
    {
        return $model->updated_at->diffForHumans();
    }
}
