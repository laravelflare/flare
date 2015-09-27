<?php

namespace LaravelFlare\Flare\Admin\Models;

use LaravelFlare\Flare\Admin\AdminCollection;

class ModelAdminCollection extends AdminCollection
{
    /**
     * Admin Config Key
     *
     * Key which defined where in the Flare Admin Config to
     * load the ModelAdmin classes from.
     *
     * @var string
     */
    const ADMIN_KEY = 'models';

    /**
     * Base Class
     *
     * The Base Class for Model Admin's
     */
    const BASE_CLASS = 'LaravelFlare\Flare\Admin\Models\ModelAdmin';

    /**
     * __construct.
     */
    public function __construct()
    {
        parent::__construct();

        $this->items = $this->getAdminClasses();
    }
}
