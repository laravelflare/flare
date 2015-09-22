<?php

namespace LaravelFlare\Flare\Traits\ModelAdmin;

use LaravelFlare\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelWriteable
{
    /**
     * Used by beforeCreate() to ensure child classes call parent::beforeCreate().
     * 
     * @var bool
     */
    protected $brokenBeforeCreate = false;

    /**
     * Used by afterCreate() to ensure child classes call parent::afterCreate().
     * 
     * @var bool
     */
    protected $brokenAfterCreate = false;

    /**
     * Used by beforeEdit() to ensure child classes call parent::beforeEdit().
     * 
     * @var bool
     */
    protected $brokenBeforeEdit = false;

    /**
     * Used by afterEdit() to ensure child classes call parent::afterEdit().
     * 
     * @var bool
     */
    protected $brokenAfterEdit = false;

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
     * Used by beforeDelete() to ensure child classes call parent::beforeDelete().
     * 
     * @var bool
     */
    protected $brokenBeforeDelete = false;

    /**
     * Used by afterDelete() to ensure child classes call parent::afterDelete().
     * 
     * @var bool
     */
    protected $brokenAfterDelete = false;

    /**
     * Method fired before the Create action is undertaken.
     * 
     * @return
     */
    protected function beforeCreate()
    {
        $this->brokenBeforeCreate = false;
    }

    /**
     * Finds an existing Model entry and sets it to the current modelManager model.
     * 
     * @return
     */
    public function find($modelitem_id)
    {
        /*
         * We should validate that a model is found etc/
         */
        $this->modelManager->model = $this->modelManager->model->find($modelitem_id);
    }

    /**
     * Create Action.
     *
     * Fires off beforeCreate(), doCreate() and afterCreate()
     * 
     * @return
     */
    public function create()
    {
        $this->brokenBeforeCreate = true;
        $this->beforeCreate();
        if ($this->brokenBeforeCreate) {
            throw new WriteableException('ModelAdmin has a broken beforeCreate method. Make sure you call parent::beforeCreate() on all instances of beforeCreate()', 1);
        }

        $this->doCreate();

        $this->brokenAfterCreate = true;
        $this->afterCreate();
        if ($this->brokenAfterCreate) {
            throw new WriteableException('ModelAdmin has a broken afterCreate method. Make sure you call parent::afterCreate() on all instances of afterCreate()', 1);
        }
    }

    /**
     * The actual Create action, which does all of hte pre-processing
     * required before we are able to perform the save() function.
     * 
     * @return
     */
    private function doCreate()
    {
        /*
         * Pre=processing is required.
         */
        // Unguard the model so we can set and store non-fillable entries

        $this->modelManager->model->unguard();


        foreach (\Request::except('_token') as $key => $value) {

            if ($this->modelManager->hasSetMutator($key)) {
                $this->modelManager->setAttribute($key, $value);
                continue;
            } 

            // Could swap this out for model -> getAttribute, then check if we have an attribute or a relation... getRelationValue() is helpful
            if (method_exists($this->modelManager->model, $key) && is_a(call_user_func_array([$this->modelManager->model, $key], []), 'Illuminate\Database\Eloquent\Relations\Relation')) {
                // This will need expanding on, as we only really account for BelongsTo relations with this code.
                $this->modelManager->model->$key()->associate($value);
                continue;
            }

            $this->modelManager->model->setAttribute($key, $value);

        }

        $this->save();

        // Reguard.
        $this->modelManager->model->reguard();
    }

    /**
     * Method fired after the Create action is complete.
     * 
     * @return
     */
    protected function afterCreate()
    {
        $this->brokenAfterCreate = false;
    }

    /**
     * Method fired before the Edit action is undertaken.
     * 
     * @return
     */
    protected function beforeEdit()
    {
        $this->brokenBeforeEdit = false;
    }

    /**
     * Edit Action.
     *
     * Fires off beforeEdit(), doEdit() and afterEdit()
     * 
     * @return
     */
    public function edit($modelitem_id)
    {
        $this->find($modelitem_id);

        $this->brokenBeforeEdit = true;
        $this->beforeEdit();
        if ($this->brokenBeforeEdit) {
            throw new WriteableException('ModelAdmin has a broken beforeEdit method. Make sure you call parent::beforeEdit() on all instances of beforeEdit()', 1);
        }

        $this->doEdit($modelitem_id);

        $this->brokenAfterEdit = true;
        $this->afterEdit();
        if ($this->brokenAfterEdit) {
            throw new WriteableException('ModelAdmin has a broken afterEdit method. Make sure you call parent::afterEdit() on all instances of afterEdit()', 1);
        }
    }

    /**
     * The actual Edit action, which does all of the pre-processing
     * required before we are able to perform the save() function.
     * 
     * @return
     */
    private function doEdit()
    {
        /*
         * Pre=processing is required.
         */
        // Unguard the model so we can set and store non-fillable entries

        $this->modelManager->model->unguard();


        foreach (\Request::except('_token') as $key => $value) {

            if ($this->modelManager->hasSetMutator($key)) {
                $this->modelManager->setAttribute($key, $value);
                continue;
            } 

            // Could swap this out for model -> getAttribute, then check if we have an attribute or a relation... getRelationValue() is helpful
            if (method_exists($this->modelManager->model, $key) && is_a(call_user_func_array([$this->modelManager->model, $key], []), 'Illuminate\Database\Eloquent\Relations\Relation')) {
                // This will need expanding on, as we only really account for BelongsTo relations with this code.
                $this->modelManager->model->$key()->associate($value);
                continue;
            }

            $this->modelManager->model->setAttribute($key, $value);

        }

        $this->save();

        // Reguard.
        $this->modelManager->model->reguard();
    }

    /**
     * Method fired after the Edit action is complete.
     * 
     * @return
     */
    protected function afterEdit()
    {
        $this->brokenAfterEdit = false;
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
        /*
         *
         *  --- AMAZING STUFF IS GOING TO HAPPEN HERE ---
         * 
         */

        $this->modelManager->model->save();

        /*
         *
         *  --- AND HERE TOO, HOPEFULLY! ---
         * 
         */
    }

    /**
     * Method fired after the Save action is complete.
     * 
     * @return
     */
    protected function afterSave()
    {
        $this->brokenAfterSave = false;
    }

    /**
     * Method fired before the Delete action is undertaken.
     * 
     * @return
     */
    protected function beforeDelete()
    {
        $this->brokenBeforeDelete = false;
    }

    /**
     * Delete Action.
     *
     * Fires off beforeDelete(), doDelete() and afterDelete()
     * 
     * @return
     */
    public function delete($modelitem_id)
    {
        $this->find($modelitem_id);

        $this->brokenBeforeDelete = true;
        $this->beforeDelete();
        if ($this->brokenBeforeDelete) {
            throw new WriteableException('ModelAdmin has a broken beforeDelete method. Make sure you call parent::beforeDelete() on all instances of beforeDelete()', 1);
        }

        $this->doDelete($modelitem_id);

        $this->brokenAfterDelete = true;
        $this->afterDelete();
        if ($this->brokenAfterDelete) {
            throw new WriteableException('ModelAdmin has a broken afterDelete method. Make sure you call parent::afterDelete() on all instances of afterDelete()', 1);
        }
    }

    private function doDelete()
    {
        /*
         * Delete the Model entry, or SoftDelete it.
         *
         * I guess if a Model has SoftDeletes, we should SoftDelete it first. Then allow full deletion.
         */
        $this->modelManager->model->delete();
    }

    /**
     * Method fired after the Delete action is complete.
     * 
     * @return
     */
    protected function afterDelete()
    {
        $this->brokenAfterDelete = false;
    }
}
