<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function patient()
    {
        return $this->belongsToMany('App\Models\Patient', 'patient_channel', 'channel_id', 'patient_id');
    }
}
