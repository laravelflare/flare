<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

use LaravelFlare\Flare\Events\ModelSave;
use LaravelFlare\Flare\Events\AfterSave;
use LaravelFlare\Flare\Events\BeforeSave;
use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelViewing
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
}
