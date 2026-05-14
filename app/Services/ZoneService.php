<?php

namespace App\Services;

use App\Models\ZoneRegistration;

class ZoneService
{
    /**
     * Register a new area/zone request.
     *
     * @param array $data
     * @return ZoneRegistration
     */
    public function registerZone(array $data): ZoneRegistration
    {
        return ZoneRegistration::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'area' => $data['area'],
        ]);
    }
}
