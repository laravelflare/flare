<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelWriteable
{
    use ModelCreatable, ModelEditable, ModelDeleteable;

    /**
     * Used by beforeSave() to ensure child classes call parent::beforeSave().
     * 
     * @var bool
     */
    protected $brokenBeforeSave = false;

    /**
     * Used by afterSave() to ensure child classes call parent::afterSave().
     * 
     * @var bool
     */
    protected $brokenAfterSave = false;

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
     * Finds an existing Model entry and sets it to the current model.
     * 
     * @param int $modelitem_id
     * 
     * @return
     */
    protected function find($modelitem_id)
    {
        $this->model = $this->model->findOrFail($modelitem_id);
    }

    /**
     * Method fired before the Save action is undertaken.
     * 
     * @return
     */
    protected function beforeSave()
    {
        $this->brokenBeforeSave = false;
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
        $this->brokenBeforeSave = true;
        $this->beforeSave();
        if ($this->brokenBeforeSave) {
            throw new WriteableException('ModelAdmin has a broken beforeSave method. Make sure you call parent::beforeSave() on all instances of beforeSave()', 1);
        }

        $this->doSave();

        $this->brokenAfterSave = true;
        $this->afterSave();
        if ($this->brokenAfterSave) {
            throw new WriteableException('ModelAdmin has a broken afterSave method. Make sure you call parent::afterSave() on all instances of afterSave()', 1);
        }
    }

    /**
     * The actual Save action, which does all of hte pre-processing
     * required before we are able to perform the save() function.
     * 
     * @return
     */
    private function doSave()
    {
        foreach (\Request::except('_token') as $key => $value) {
            if ($this->modelManager->hasSetMutator($key)) {
                $this->modelManager->setAttribute($key, $value);
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
