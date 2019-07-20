<?php

namespace LaMomo\MomoApp\Traits;

use LaMomo\MomoApp\Models\Remittance;

trait HasRemittances
{
    public function remittance()
    {
        return $this->morphOne(Remittance::class, 'remittable');
    }
}
