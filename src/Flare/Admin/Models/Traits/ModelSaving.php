<?php

namespace LaravelFlare\Flare\Admin\Models\Traits;

use LaravelFlare\Flare\Events\ModelSave;
use LaravelFlare\Flare\Events\AfterSave;
use LaravelFlare\Flare\Events\BeforeSave;

trait ModelSaving
{
    /**
     * Relations to Update during Save and
     * the appropriate method to fire the update with.
     * 
     * @var array
     */
    protected $doSaveRelations = ['BelongsTo' => 'associate'];

    /**
     * Relations to Update after Save and
     * the appropriate method to fire the update with.
     * 
     * @var array
     */
    protected $afterSaveRelations = ['BelongsToMany' => 'sync'];

    /**
     * Method fired before the Save action is undertaken.
     * 
     * @return
     */
    protected function beforeSave()
    {
    }

    /**
     * Save Action.
     *
     * Fires off beforeSave(), doSave() and afterSave()
     * 
     * @return
     */
    public function save()
    {
        event(new BeforeSave($this));

        $this->beforeSave();

        $this->doSave();

        $this->afterSave();

        event(new AfterSave($this));
    }

    /**
     * The actual Save action, which does all of hte pre-processing
     * required before we are able to perform the save() function.
     * 
     * @return
     */
    private function doSave()
    {
        foreach (\Request::only(array_keys($this->fields)) as $key => $value) {
            if ($this->hasSetMutator($key)) {
                $this->setAttribute($key, $value);
                continue;
            }

            // Could swap this out for model -> getAttribute, then check if we have an attribute or a relation... getRelationValue() is helpful
            if (method_exists($this->model, $key) && is_a(call_user_func_array([$this->model, $key], []), 'Illuminate\Database\Eloquent\Relations\Relation')) {
                $this->saveRelation('doSave', $key, $value);
                continue;
            }

            $this->model->setAttribute($key, $value);
        }

        $this->model->save();

        event(new ModelSave($this));
    }

    /**
     * Method fired after the Save action is complete.
     * 
     * @return
     */
    protected function afterSave()
    {
        $this->brokenAfterSave = false;

        foreach (\Request::except('_token') as $key => $value) {

            // Could swap this out for model -> getAttribute, then check if we have an attribute or a relation... getRelationValue() is helpful
            if (method_exists($this->model, $key) && is_a(call_user_func_array([$this->model, $key], []), 'Illuminate\Database\Eloquent\Relations\Relation')) {
                $this->saveRelation('afterSave', $key, $value);
            }
        }
    }

    /**
     * Method fired to Save Relations.
     *
     * @param string $action The current action (either doSave or afterSave)
     * @param string $key
     * @param string $value
     * 
     * @return
     */
    private function saveRelation($action, $key, $value)
    {
        // Could swap this out for model -> getAttribute, then check if we have an attribute or a relation... getRelationValue() is helpful
        if (method_exists($this->model, $key) && is_a(call_user_func_array([$this->model, $key], []), 'Illuminate\Database\Eloquent\Relations\Relation')) {
            foreach ($this->{$action.'Relations'} as $relationship => $method) {
                if (is_a(call_user_func_array([$this->model, $key], []), 'Illuminate\Database\Eloquent\Relations\\'.$relationship)) {
                    $this->model->$key()->$method($value);

                    return;
                }
            }
        }
    }
}
