<?php

namespace App\Traits;

use App\Meta;

trait Metable
{


    /**
     * Add a meta or update if one exists with specific key
     *
     * @param $metaKey
     * @param $metaValue
     * @return mixed
     */
    public function addOrUpdateMeta($metaKey, $metaValue)
    {
        if ($meta = $this->hasMeta($metaKey)) {
            $meta = $this->updateMeta($meta, $metaValue);
        } else {
            $meta = $this->addMeta($metaKey, $metaValue);
        }
        return $meta;
    }

    /**
     * Does a meta with a specific key exists or not
     *
     * @param $metaKey
     * @return mixed
     */
    private function hasMeta($metaKey)
    {
        $meta = $this->metas()->where('key', $metaKey)->first();
        if (!$meta) {
            return false;
        }
        return $meta;
    }

    /**
     * Update an existing meta with a new value
     *
     * @param $meta
     * @param $newMetaValue
     * @return mixed
     */
    private function updateMeta($meta, $newMetaValue)
    {
        $meta->value = $newMetaValue;
        $meta->save();
        return $meta;
    }

    /**
     * Create a new meta with key and value pair
     *
     * @param $metaKey
     * @param $metaValue
     * @return mixed
     */
    private function addMeta($metaKey, $metaValue)
    {
        $meta = new Meta(['key' => $metaKey, 'value' => $metaValue]);
        $this->metas()->save($meta);
        return $meta;
    }


    /**
     * Meta Polymorphic relationship
     *
     * @return mixed
     */
    public function metas()
    {
        return $this->morphMany(Meta::class, 'metable');
    }

    /**
     * Get meta for specific key
     *
     * @param string $metaKey
     * @return mixed|null
     */
    public function metaFor($metaKey)
    {
        if ($meta = $this->hasMeta($metaKey)) {
            return $meta;
        }
        return null;
    }

    public function getMeta($metaKey)
    {
        return ($meta = $this->metaFor($metaKey)) ? $meta->value : '';
    }


}