<?php

namespace LaravelFlare\Flare\Admin\Modules;

use LaravelFlare\Flare\Admin\Admin;

abstract class ModuleAdmin extends Admin
{
    /**
     * The Controller to be used by the Module Admin.
     *
     * This defaults to parent::getController()
     * if it has been left undefined. 
     * 
     * @var string
     */
    protected static $controller = '\LaravelFlare\Flare\Admin\Modules\ModuleAdminController';

    /**
     * The Module Admin Default View.
     *
     * @var string
     */
    protected static $view = 'admin.modules.index';

    /**
     * Returns the Module Admin View.
     *
     * Determines if a view exists by:
     * Looking for $this->view
     * Then looks for  'admin.modulename.index',
     * Then looks for  'admin.modulename',
     * Then defaults to 
     * 
     * @return string
     */
    public function getView()
    {
        if (view()->exists(static::$view)) {
            return static::$view;
        }

        if (view()->exists('admin.'.static::urlPrefix().'.index')) {
            return 'admin.'.static::urlPrefix().'.index';
        }

        if (view()->exists('admin.'.static::urlPrefix())) {
            return 'admin.'.static::urlPrefix();
        }

        if (view()->exists('flare::'.self::$view)) {
            return 'flare::'.self::$view;
        }

        return parent::getView();
    }
}
