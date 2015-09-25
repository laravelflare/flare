<?php

namespace LaravelFlare\Flare\Admin\Modules;

abstract class ModuleAdmin extends Admin
{
    /**
     * Class Prefix used for matching and removing term
     * from user provided Admin sections.
     *
     * @var string
     */
    const CLASS_PREFIX = 'Module';
}
