<?php

namespace LaravelFlare\Flare\Admin\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait HumanTimestampAttributes
{
    /**
     * Format our created_at times nicely.
     * 
     * @param string
     */
    protected function getCreatedAtAttribute(Model $model)
    {
        if (!$model->created_at) {
            return;
        }

        return $model->created_at->diffForHumans();
    }

    /**
     * Format our updated_at times nicely.
     * 
     * @param string
     */
    protected function getUpdatedAtAttribute(Model $model)
    {
        if (!$model->updated_at) {
            return;
        }

        return $model->updated_at->diffForHumans();
    }
}
