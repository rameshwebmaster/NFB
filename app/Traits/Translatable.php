<?php

namespace App\Traits;

use App\Translation;

trait Translatable
{


    /**
     * Add a meta or update if one exists with specific key
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public function addOrUpdateTranslation($key, $value)
    {
        if ($translation = $this->hasTranslation($key)) {
            $translation = $this->updateTranslation($translation, $value);
        } else {
            $translation = $this->addTranslation($key, $value);
        }
        return $translation;
    }

    /**
     * Does a translation with a specific key exists or not
     *
     * @param $key
     * @return mixed
     */
    private function hasTranslation($key)
    {
        $translation = $this->translations()->where('key', $key)->first();
        if (!$translation) {
            return false;
        }
        return $translation;
    }

    /**
     * Update an existing translation with a new value
     *
     * @param $translation
     * @param $newValue
     * @return mixed
     */
    private function updateTranslation($translation, $newValue)
    {
        $translation->value = $newValue;
        $translation->save();
        return $translation;
    }

    /**
     * Create a new translation with key and value pair
     *
     * @param $key
     * @param $value
     * @param string $lang
     * @return mixed
     */
    private function addTranslation($key, $value, $lang = 'ar', $trans='program_entry')
    {
        $translation = new Translation(['key' => $key, 'value' => $value, 'lang' => $lang, 'translatable_type' => $trans]);
      
        $this->translations()->save($translation);
        return $translation;
    }


    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function trans($key, $lang = 'ar')
    {
        $trans = $this->translations()->where('key', $key)->first();
        if ($trans) {
            return $trans->value;
        }
        return null;
    }

}