<?php

namespace LaravelFlare\Flare\Admin\Models\Traits;

trait ModelQuerying
{
    /**
     * Query.
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
     * Any array of Filters.
     *
     * Filter should be setup in the same fashion as a default
     * $queryFilter is setup, however, inside an associative
     * array.
     *
     * The associative array is your filter 'action' and is 
     * used as the filter label (and converted to a URL safe
     * query parameter).
     * 
     * @var array
     */
    protected $filters = [];

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
    public function items($count = false)
    {
        \DB::enableQueryLog();
        $this->query = $this->model->newQuery();

        return $this->query($count);
    }

    /**
     * Returns All Model Items, either all() or paginated().
     *
     * Filtered by any defined query filters ($queryFilter)
     * Ordered by Managed Model orderBy and sortBy methods
     * 
     * @return
     */
    public function allItems($count = false)
    {
        if (!$this->hasSoftDeleting()) {
            throw new \Exception('Model does not have Soft Deleting');
        }

        $this->query = $this->model->newQuery()->withTrashed();

        return $this->query($count);
    }

    /**
     * Returns Model Items, either all() or paginated().
     *
     * Filtered by any defined query filters ($queryFilter)
     * Ordered by Managed Model orderBy and sortBy methods
     * 
     * @return
     */
    public function onlyTrashedItems($count = false)
    {
        if (!$this->hasSoftDeleting()) {
            throw new \Exception('Model does not have Soft Deleting');
        }

        $this->query = $this->model->newQuery()->onlyTrashed();

        return $this->query($count);
    }

    /**
     * Performs the Model Query.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function query($count)
    {
        $this->applyQueryFilters();

        if ($this->orderBy()) {
            $this->query = $this->query->orderBy(
                                $this->orderBy(),
                                $this->sortBy()
                            );
        }

        //dd(\DB::getQueryLog());

        if ($count) {
            return $this->query->count();
        }

        if ($this->perPage > 0) {
            return $this->query->paginate($this->perPage);
        }

        return $this->query->get();
    }

    /**
     * Return Totals of All, With Trashed and Only Trashed.
     * 
     * @return array
     */
    public function totals()
    {
        if ($this->hasSoftDeleting()) {
            return [
                        'all' => $this->items($count = true),
                        'with_trashed' => $this->allItems($count = true),
                        'only_trashed' => $this->onlyTrashedItems($count = true),
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
     * Apply the Query Filters.
     * 
     * @return 
     */
    private function applyQueryFilters()
    {
        if (is_array($this->queryFilter())) {
            $this->createQueryFilter();
        } else {
            $this->queryFilter();
        }

        $this->queryFilterRequest();
    }

    private function queryFilterRequest()
    {
        if (!$safeFilter = \Request::get('filter')) {
            return false;
        }

        if (!isset($this->safeFilters()[$safeFilter])) {
            return false;
        }

        return $this->query = $this->filters()[$this->safeFilters()[$safeFilter]];
    }

    /**
     * Create the Query Filter from Array.
     * 
     * @return
     */
    private function createQueryFilter()
    {
        if (count($this->queryFilter()) > 0) {
            foreach ($this->queryFilter() as $filter => $parameters) {
                if (!is_array($parameters)) {
                    $parameters = [$parameters];
                }
                $this->query = call_user_func_array([$this->query, $filter], $parameters);
            }
        }
    }

    /**
     * Access the Query Filter.
     * 
     * @return 
     */
    public function queryFilter()
    {
        return $this->queryFilter;
    }

    /**
     * Access the Query Filter Options.
     * 
     * @return 
     */
    public function filters()
    {
        return $this->filters;
    }

    /**
     * Associative array of safe filter names to 
     * their corresponding normal counterpart.
     * 
     * @return 
     */
    public function safeFilters()
    {
        $filters = [];

        foreach ($this->filters() as $filterName => $query) {
            $filters[str_slug($filterName)] = $filterName;
        }

        return $filters;
    }

    /**
     * Set the Query Filter.
     * 
     * @param array $filter
     */
    public function setQueryFilter($filter = [])
    {
        $this->queryFilter = $filter;
    }
}
