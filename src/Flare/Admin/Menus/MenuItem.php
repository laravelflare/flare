<?php

namespace LaravelFlare\Flare\Admin\Menus;

use LaravelFlare\Flare\Admin\Admin;

abstract class MenuItem extends Admin
{
    /**
     * The Menu Item Default View.
     *
     * @var string
     */
    protected static $view = 'admin.menus.item';

    /**
     * The Menu Item Location.
     *
     * @var string
     */
    protected static $location;

    /**
     * Returns the Menu Item View.
     *
     * @return string
     */
    public function getView()
    {
        if (view()->exists(static::$view)) {
            return static::$view;
        }

        if (view()->exists('admin.menus.'.static::location().'.widget')) {
            return 'admin.'.static::safeTitle().'.widget';
        }

        if (view()->exists('admin.menus.'.static::safeTitle())) {
            return 'admin.menus.'.static::safeTitle();
        }

        if (view()->exists('flare::'.self::$view)) {
            return 'flare::'.self::$view;
        }
    }

    /**
     * Widget SafeTitle.
     *
     * @return string
     */
    public static function location()
    {
        return static::$location;
    }
}
