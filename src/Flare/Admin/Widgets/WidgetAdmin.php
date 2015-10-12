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
    const CLASS_SUFFIX = 'Widget';

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
        if (view()->exists(static::$view)) {
            return static::$view;
        }

        if (view()->exists('admin.widgets.' . static::safeTitle() . '.widget')) {
            return 'admin.'.static::safeTitle().'.widget';
        }

        if (view()->exists('admin.widgets.' . static::safeTitle())) {
            return 'admin.widgets.' . static::safeTitle();
        }

        if (view()->exists('admin.' . static::safeTitle())) {
            return 'admin.' . static::safeTitle();
        }

        if (view()->exists('flare::' . self::$view)) {
            return 'flare::' . self::$view;
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
        return str_replace(' ', '', strtolower(str_replace(static::CLASS_SUFFIX, '', static::title())));
    }
}
