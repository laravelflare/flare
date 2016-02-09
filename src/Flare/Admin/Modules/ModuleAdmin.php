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
    protected $view = 'admin.modules.index';

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
        if (view()->exists($this->view)) {
            return $this->view;
        }

        if (view()->exists('admin.'.$this->urlPrefix().'.index')) {
            return 'admin.'.$this->urlPrefix().'.index';
        }

        if (view()->exists('admin.'.$this->urlPrefix())) {
            return 'admin.'.$this->urlPrefix();
        }

        if (view()->exists('flare::'.$this->view)) {
            return 'flare::'.$this->view;
        }

        return parent::getView();
    }
}
