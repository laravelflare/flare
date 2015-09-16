<?php

namespace Flare\Admin\Models;

use Illuminate\Support\Collection;

class ManagedModelCollection extends Collection
{
    /**
     * The items contained in the collection.
     *
     * @var array
     */
    protected $items = [];

    /**
     * __construct.
     */
    public function __construct($items = [])
    {
        parent::__construct($items = []);
    }
}
