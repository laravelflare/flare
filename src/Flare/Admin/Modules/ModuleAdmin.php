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
    protected $controller = '\LaravelFlare\Flare\Admin\Modules\ModuleAdminController';

    /**
     * The Module Admin Default View.
     *
     * @var string
     */
    protected static $view = 'admin.modules.index';

    /**
     * Class Prefix used for matching and removing term
     * from user provided Admin sections.
     *
     * @var string
     */
    const CLASS_PREFIX = 'Module';

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
        $viewList = [
                static::$view,
                'admin.'.static::urlPrefix().'.index',
                'admin.'.static::urlPrefix(),
                'flare::'.self::$view,
            ];

        foreach ($viewList as $view) {
            if (view()->exists($view)) {
                return $view;
            }
        }

        return parent::getView();
    }
}
