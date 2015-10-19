<?php

namespace LaravelFlare\Flare\Admin\Menus\Sidebar;

use LaravelFlare\Flare\Admin\Menus\MenuItem;

class SidebarItem extends MenuItem
{
    /**
     * The Menu Item Default View.
     *
     * @var string
     */
    protected static $view = 'admin.menus.sidebar.item';

    /**
     * The Menu Item Location
     *
     * @var string
     */
    protected static $location = 'sidebar';
}
