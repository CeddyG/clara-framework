<?php

namespace App\Models\Traits;

use App\Models\Relations\HasManyTranslation;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasTranslation
{    
    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->translatable && in_array($key, $this->translatable)
            ? $this->defaultTranslation->$key
            : parent::__get($key);
    }
    
    public function __isset($key)
    {
        return $this->translatable && in_array($key, $this->translatable);
    }
    
    protected static function bootHasTranslation(): void
    {
        static::deleting(function ($model) {
            $model->translations()->delete();
        });
    }
    
    public function translations(): HasManyTranslation
    {
        $parent = static::class;
        
        return $this->hasManyTranslation($parent.'Translation');
    }
 
    public function defaultTranslation(): HasOne
    {
        // Making sure that we always retrieve current locale information
        return $this->translations()->one()->where('locale', app()->getLocale());
    }
    
    /**
     * Define a one-to-many relationship for translations.
     *
     * @param  string  $related
     * @param  string|null  $foreignKey
     * @param  string|null  $localKey
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasManyTranslation($related, $foreignKey = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        return new HasManyTranslation(
            $instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey
        );
    }
}
