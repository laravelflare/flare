<?php

namespace LaravelFlare\Flare\Admin\Modules;

use LaravelFlare\Flare\Admin\AdminCollection;
use LaravelFlare\Flare\Permissions\Permissions;

class ModuleAdminCollection extends AdminCollection
{
    /**
     * Admin Config Key
     *
     * Key which defined where in the Flare Admin Config to
     * load the ModuleAdmin classes from.
     *
     * @var string
     */
    const ADMIN_KEY = 'modules';

    /**
     * Base Class
     *
     * The Base Class for Module Admin's
     */
    const BASE_CLASS = 'LaravelFlare\Flare\Admin\Modules\ModelAdmin';

    /**
     * __construct.
     */
    public function __construct()
    {
        parent::__construct();

        $this->items = $this->getAdminClasses();
    }
}
