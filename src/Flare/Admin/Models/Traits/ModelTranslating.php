<?php

namespace LaravelFlare\Flare\Admin\Models\Traits;

trait ModelTranslating
{
    /**
     * Return the Defined Languages for this ModelAdmin.
     * 
     * @return array
     */
    public function languages(): array
    {
        return $this->languages ?? [];
    }

    /**
     * Returns if the current ModelAdmin has the language available.
     * 
     * @return boolean
     */
    public function hasLanguage($key)
    {
        return false;
    }

    /**
     * Does the Model have the language created.
     * 
     * @param  Model $model
     * @param  string $key  
     * 
     * @return boolean
     */
    public function modelHasLanguage($model, $key)
    {
        if ($this->isLanguage($key)) {
            return true;
        }

        if ($model->translations->get($key)) {
            return true;
        }

        return $this->model->language === $key;
    }

    /**
     * Is the current model on this ModelAdmin match for the language key.
     * 
     * @param  string  $key
     * 
     * @return boolean      
     */
    public function isLanguage($key)
    {
        if (!$this->model) {
            return null;
        }

        return $this->model->language === $key;
    }

    /**
     * Return route to Create Model Translation Page.
     * 
     * @param  string $key   
     * @param  Model $model 
     * 
     * @return string
     */
    public function routeToCreateModelTranslation($key, $model)
    {
        return $this->currentUrl('create/?parent_id='.$model->id);
    }

    /**
     * Return route to Create Model Translation Page.
     * 
     * @param  string $key   
     * @param  Model $model 
     * 
     * @return string
     */
    public function routeToViewModelTranslation($key, $model)
    {
        if ($translation = $model->translations->get($key)) {
            return $this->currentUrl('view/'.$translation->id);
        }
    }

    /**
     * Applies the Translation Filter to the current query.
     * 
     * @return void
     */
    protected function applyTranslationFilter()
    {
        if (!array_key_exists($lang = request()->get('lang'), $this->languages())) {
            return;
        }

        return $this->query->whereLanguage($lang);
    }
}
