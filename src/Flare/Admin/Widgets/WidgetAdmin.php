<?php

namespace LaravelFlare\Flare\Admin\Widgets;

use LaravelFlare\Flare\Admin\Admin;

abstract class WidgetAdmin extends Admin
{
    /**
     * The Module Admin Default View.
     *
     * @var string
     */
    protected static $view = 'admin.widgets.widget';

    /**
     * Default View Data.
     *
     * @var array
     */
    protected $viewData = [];

    /**
     * Class Prefix used for matching and removing term
     * from user provided Admin sections.
     *
     * @var string
     */
    const CLASS_PREFIX = 'Widget';

    /**
     * Render the Widget.
     * 
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return view($this->getView(), $this->getViewData());
    }

    /**
     * Returns the Widget Admin View.
     *
     * @return string
     */
    public function getView()
    {
        $viewList = [
                        static::$view,
                        'admin.widgets.'.static::safeTitle().'.widget',
                        'admin.widgets.'.static::safeTitle(),
                        'admin.'.static::safeTitle(),
                        'flare::'.self::$view,
                    ];

        foreach ($viewList as $view) {
            if (view()->exists($view)) {
                return $view;
            }
        }

        return parent::getView();
    }

    /**
     * Returns an Array of View Data that is constructed
     * using the current View Data and any inherited View Data.
     * 
     * @return array
     */
    public function getViewData()
    {
        if (is_callable('parent::getViewData')) {
            return array_merge($this->viewData, parent::getViewData());
        }

        return $this->viewData;
    }

    /**
     * Widget SafeTitle.
     *
     * @return string
     */
    public static function safeTitle()
    {
        return str_replace(' ', '', strtolower(str_replace(static::CLASS_PREFIX, '', static::title())));
    }
}
