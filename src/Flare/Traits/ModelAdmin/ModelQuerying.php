<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

trait ModelQuerying
{
    /**
     * Allows filtering of the query, for instance:.
     *
     *      $queryFilter = [
     *                          'whereNotNull' => ['parent_id'],
     *                          'where' => ['name', 'John'],
     *                      ]
     *
     * Would result in an Eloquent query with the following scope:
     *     Model::whereNotNull('parent_id')->where('name', 'John')->get();
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
        $model = $this->model;

        return $this->query($model);
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
        
        $model = $this->model->withTrashed();

        return $this->query($model);
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
        
        $model = $this->model->onlyTrashed();

        return $this->query($model);
    }

    /**
     * Performs the Model Query
     * 
     * @param  \Illuminate\Database\Eloquent\Model $model
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function query($model)
    {
        if (count($this->query_filter) > 0) {
            foreach ($this->query_filter as $filter => $parameters) {
                if (!is_array($parameters)) {
                    $parameters = [$parameters];
                }
                $model = call_user_func_array([$this->model, $filter], $parameters);
            }
        }

        if ($this->orderBy()) {
            $model = $model->orderBy(
                                $this->orderBy(),
                                $this->sortBy()
                            );
        }

        if ($this->perPage > 0) {
            return $model->paginate($this->perPage);
        }

        return $model->get();
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
}
