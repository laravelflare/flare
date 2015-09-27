<?php

namespace LaravelFlare\Flare\Admin\Widgets;

use LaravelFlare\Flare\Admin\Models\ManagedModel;
use LaravelFlare\Flare\Admin\Widgets\WidgetAdmin;

class DefaultWidget extends WidgetAdmin
{
    /**
     * The Module Admin Default View
     *
     * @var string
     */
    protected static $view = 'flare::admin.widgets.default';

    /**
     * Background colour options
     *
     * @var array
     */
    protected $bgColours = ['light-blue', 'aqua', 'green', 'yellow', 'red', 'navy', 'teal', 'purple', 'orange', 'maroon'];

    /**
     * Counter
     *
     * Determines which $bgColour index to use next
     *
     * @var int
     */
    protected static $counter = 0;

    /**
     * __construct
     *
     * @param ManagedModel $managedModel
     */
    public function __construct(ManagedModel $managedModel)
    {
        if (!$managedModel) {
            return false;
        }

        if (self::$counter == 10) {
            self::$counter = 0;
        }

        $this->viewData['bgColour'] = $this->bgColours[self::$counter];
        $this->viewData['pluralTitle'] = $managedModel::pluralTitle();
        $this->viewData['modelTotal'] = $managedModel->model->count();
        $this->viewData['icon'] = $managedModel::$icon;

        self::$counter++;
    }
}
