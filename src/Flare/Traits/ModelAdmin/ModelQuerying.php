<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

trait ModelQuerying
{
    /**
     * Query
     * 
     * @var string
     */
    public $query;

    /**
     * Allows filtering of the default query, for instance:.
     *
     *      $queryFilter = [
     *                          'whereNotNull' => ['parent_id'],
     *                          'where' => ['name', 'John'],
     *                      ]
     *
     * Would result in an Eloquent query with the following scope:
     *     Model::whereNotNull('parent_id')->where('name', 'John')->get();
     *
     * Note: This queryFilter is not used for custom filters and
     * can also be overridden by setQueryFilter();
     * 
     * @var array
     */
    protected $queryFilter = [];

    /**
     * The number of models to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    /**
     * Order By - Column/Attribute to OrderBy.
     *
     * Primary Key of Model by default
     * 
     * @var string
     */
    protected $orderBy;

    /**
     * Sort By - Either Desc or Asc.
     * 
     * @var string
     */
    protected $sortBy;

    /**
     * Finds an existing Model entry and sets it to the current model.
     * 
     * @param int $modelitemId
     * 
     * @return
     */
    public function find($modelitemId)
    {
        $this->model = $this->model->findOrFail($modelitemId);

        return $this->model;
    }

    /**
     * Returns Model Items, either all() or paginated().
     *
     * Filtered by any defined query filters ($queryFilter)
     * Ordered by Managed Model orderBy and sortBy methods
     * 
     * @return
     */
    public function items()
    {
        $this->query = $this->model->newQuery();

        return $this->query();
    }

    /**
     * Returns All Model Items, either all() or paginated().
     *
     * Filtered by any defined query filters ($queryFilter)
     * Ordered by Managed Model orderBy and sortBy methods
     * 
     * @return
     */
    public function allItems()
    {
        if (!$this->hasSoftDeleting()) {
            throw new \Exception('Model does not have Soft Deleting');
        }

        $this->query = $this->model->newQuery()->withTrashed();

        return $this->query();
    }

    /**
     * Returns Model Items, either all() or paginated().
     *
     * Filtered by any defined query filters ($queryFilter)
     * Ordered by Managed Model orderBy and sortBy methods
     * 
     * @return
     */
    public function onlyTrashedItems()
    {
        if (!$this->hasSoftDeleting()) {
            throw new \Exception('Model does not have Soft Deleting');
        }

        $this->query = $this->model->newQuery()->onlyTrashed();

        return $this->query();
    }

    /**
     * Performs the Model Query
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function query()
    {
        $this->applyQueryFilters();

        if ($this->orderBy()) {
            $this->query = $this->query->orderBy(
                                $this->orderBy(),
                                $this->sortBy()
                            );
        }

        if ($this->perPage > 0) {
            return $this->query->paginate($this->perPage);
        }

        return $this->query->get();
    }

    /**
     * Return Totals of All, With Trashed and Only Trashed
     * 
     * @return array
     */
    public function totals()
    {
        if ($this->hasSoftDeleting()) {
            return [
                        'all' => $this->model->count(),
                        'with_trashed' => $this->model->withTrashed()->count(),
                        'only_trashed' => $this->model->onlyTrashed()->count(),
                    ];
        }

        return ['all' => $this->model->count()];
    }

    /**
     * Return Managed Model OrderBy.
     *
     * Primary key is default.
     *
     * @return string
     */
    public function orderBy()
    {
        if (\Request::input('order')) {
            return \Request::input('order');
        }

        if ($this->orderBy) {
            return $this->orderBy;
        }
    }

    /**
     * Return Managed Model SortBy (Asc or Desc).
     *
     * Descending is default.
     * 
     * @return string
     */
    public function sortBy()
    {
        if (\Request::input('sort')) {
            return \Request::input('sort');
        }

        if ($this->sortBy == 'asc') {
            return 'asc';
        }

        return 'desc';
    }

    /**
     * Get the number of models to return per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Set the number of models to return per page.
     *
     * @param int $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * Apply the Query Filters
     * 
     * @return 
     */
    private function applyQueryFilters()
    {
        if (is_array($this->getQueryFilter())) {
            return $this->createQueryFilter();
        }

        return $this->getQueryFilter();
    }

    /**
     * Create the Query Filter from Array
     * 
     * @return
     */
    private function createQueryFilter()
    {
        if (count($this->getQueryFilter()) > 0) {
            foreach ($this->getQueryFilter() as $filter => $parameters) {
                if (!is_array($parameters)) {
                    $parameters = [$parameters];
                }
                $this->query = call_user_func_array([$this->query, $filter], $parameters);
            }
        }
    }

    /**
     * Access the Query Filter
     * 
     * @return 
     */
    public function getQueryFilter()
    {
        return $this->queryFilter;
    }

    /**
     * Set the Query Filter
     * 
     * @param array $filter
     *
     * @return void
     */
    public function setQueryFilter($filter = [])
    {
        $this->queryFilter = $filter;
    }
}
