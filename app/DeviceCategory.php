<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceCategory extends Model
{
    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }
}
