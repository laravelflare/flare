<?php

namespace LaravelFlare\Flare\Admin\Widgets;

use LaravelFlare\Flare\Admin\Models\ModelAdmin;

class DefaultWidget extends WidgetAdmin
{
    /**
     * The Module Admin Default View.
     *
     * @var string
     */
    protected static $view = 'flare::admin.widgets.default';

    /**
     * Background colour options.
     *
     * @var array
     */
    protected $bgColours = ['light-blue', 'aqua', 'green', 'yellow', 'red', 'navy', 'teal', 'purple', 'orange', 'maroon'];

    /**
     * Counter.
     *
     * Determines which $bgColour index to use next
     *
     * @var int
     */
    protected static $counter = 0;

    /**
     * __construct.
     *
     * @param ModelAdmin $modelAdmin
     */
    public function __construct(ModelAdmin $modelAdmin)
    {
        if (!$modelAdmin) {
            return;
        }

        if (self::$counter == 10) {
            self::$counter = 0;
        }

        /**
         * Remove this from the __construct, it breaks migrations.
         */
        $this->viewData['bgColour'] = $this->bgColours[self::$counter];
        $this->viewData['pluralTitle'] = $modelAdmin::pluralTitle();
        $this->viewData['modelTotal'] = $modelAdmin->model()->count();
        $this->viewData['icon'] = $modelAdmin::$icon;

        ++self::$counter;
    }
}
