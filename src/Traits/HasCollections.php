<?php

namespace LaMomo\MomoApp\Traits;

use LaMomo\MomoApp\Models\Collection;

trait HasCollections
{
    public function momoCollection()
    {
        return $this->morphOne(Collection::class, 'collectionable');
    }

    // public function getMophKey()
    // {

    // }
}
