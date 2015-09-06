<?php

namespace JacobBaileyLtd\Flare\Traits\ModelAdmin;

use JacobBaileyLtd\Flare\Exceptions\ModelAdminWriteableException as WriteableException;

trait ModelWriteable
{
    /**
     * Used by beforeCreate() to ensure child classes call parent::beforeCreate()
     * 
     * @var boolean
     */
    protected $brokenBeforeCreate = false;

    /**
     * Used by afterCreate() to ensure child classes call parent::afterCreate()
     * 
     * @var boolean
     */
    protected $brokenAfterCreate = false;
    
    /**
     * Used by beforeEdit() to ensure child classes call parent::beforeEdit()
     * 
     * @var boolean
     */
    protected $brokenBeforeEdit = false;

    /**
     * Used by afterEdit() to ensure child classes call parent::afterEdit()
     * 
     * @var boolean
     */
    protected $brokenAfterEdit = false;
    
    /**
     * Used by beforeSave() to ensure child classes call parent::beforeSave()
     * 
     * @var boolean
     */
    protected $brokenBeforeSave = false;

    /**
     * Used by afterSave() to ensure child classes call parent::afterSave()
     * 
     * @var boolean
     */
    protected $brokenAfterSave = false;
    
    /**
     * Used by beforeDelete() to ensure child classes call parent::beforeDelete()
     * 
     * @var boolean
     */
    protected $brokenBeforeDelete = false;

    /**
     * Used by afterDelete() to ensure child classes call parent::afterDelete()
     * 
     * @var boolean
     */
    protected $brokenAfterDelete = false;
    
    /**
     * Method fired before the Create action is undertaken
     * 
     * @return
     */
    protected function beforeCreate()
    {
        $this->brokenBeforeCreate = false;
    }
    
    /**
     * Create Action
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
            throw new WriteableException("ModelAdmin has a broken beforeCreate method. Make sure you call parent::beforeCreate() on all instances of beforeCreate()", 1);
        }
        
        $this->doCreate();

        $this->brokenAfterCreate = true;
        $this->afterCreate();
        if ($this->brokenAfterCreate) {
            throw new WriteableException("ModelAdmin has a broken afterCreate method. Make sure you call parent::afterCreate() on all instances of afterCreate()", 1);
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
        /**
         * Pre-processing is required.
         */
        
        // Unguard the model so we can set and store non-fillable entries
        $this->model()->unguard();

        unset($this->input['_token']); // This is incredibly dirty. Really we want to loop through the input and only use the attributes which are assigned to a Model

        $this->model()->create($this->input);

        // Reguard.
        $this->model()->reguard();
    }

    /**
     * Method fired after the Create action is complete
     * 
     * @return
     */
    protected function afterCreate()
    {
        $this->brokenAfterCreate = false;
    }
    
    /**
     * Method fired before the Edit action is undertaken
     * 
     * @return
     */
    protected function beforeEdit()
    {
        $this->brokenBeforeEdit = false;
    }

    /**
     * Edit Action
     *
     * Fires off beforeEdit(), doEdit() and afterEdit()
     * 
     * @return
     */
    public function edit()
    {
        $this->brokenBeforeEdit = true;
        $this->beforeEdit();
        if ($this->brokenBeforeEdit) {
            throw new WriteableException("ModelAdmin has a broken beforeEdit method. Make sure you call parent::beforeEdit() on all instances of beforeEdit()", 1);
        }
        
        $this->doEdit();

        $this->brokenAfterEdit = true;
        $this->afterEdit();
        if ($this->brokenAfterEdit) {
            throw new WriteableException("ModelAdmin has a broken afterEdit method. Make sure you call parent::afterEdit() on all instances of afterEdit()", 1);
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
        /**
         * Pre=processing is required.
         */
        $this->save();
    }

    /**
     * Method fired after the Edit action is complete
     * 
     * @return
     */
    protected function afterEdit()
    {
        $this->brokenAfterEdit = false;
    }

    /**
     * Method fired before the Save action is undertaken
     * 
     * @return
     */
    protected function beforeSave()
    {
        $this->brokenBeforeSave = false;
    }

    /**
     * Save Action
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
            throw new WriteableException("ModelAdmin has a broken beforeSave method. Make sure you call parent::beforeSave() on all instances of beforeSave()", 1);
        }
        
        $this->doSave();

        $this->brokenAfterSave = true;
        $this->afterSave();
        if ($this->brokenAfterSave) {
            throw new WriteableException("ModelAdmin has a broken afterSave method. Make sure you call parent::afterSave() on all instances of afterSave()", 1);
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
        /**
         *
         *  --- AMAZING STUFF IS GOING TO HAPPEN HERE ---
         * 
         */
    }

    /**
     * Method fired after the Save action is complete
     * 
     * @return
     */
    protected function afterSave()
    {
        $this->brokenAfterSave = false;
    }

    /**
     * Method fired before the Delete action is undertaken
     * 
     * @return
     */
    protected function beforeDelete()
    {
        $this->brokenBeforeDelete = false;
    }

    /**
     * Delete Action
     *
     * Fires off beforeDelete(), doDelete() and afterDelete()
     * 
     * @return
     */
    public function delete()
    {
        $this->brokenBeforeDelete = true;
        $this->beforeDelete();
        if ($this->brokenBeforeDelete) {
            throw new WriteableException("ModelAdmin has a broken beforeDelete method. Make sure you call parent::beforeDelete() on all instances of beforeDelete()", 1);
        }
        
        $this->doDelete();

        $this->brokenAfterDelete = true;
        $this->afterDelete();
        if ($this->brokenAfterDelete) {
            throw new WriteableException("ModelAdmin has a broken afterDelete method. Make sure you call parent::afterDelete() on all instances of afterDelete()", 1);
        }
    }

    private function doDelete()
    {
        /**
         * Delete the Model entry, or SoftDelete it.
         *
         * I guess if a Model has SoftDeletes, we should SoftDelete it first. Then allow full deletion.
         */
    }

    /**
     * Method fired after the Delete action is complete
     * 
     * @return
     */
    protected function afterDelete()
    {
        $this->brokenAfterDelete = false;
    }
}
