<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Model;

class Advisory extends Model
{
    protected $hidden = ['created_at', 'updated_at'];

    public function patient()
    {
        return $this->belongsToMany('App\Models\Patient', 'patient_advisory', 'advisory_id', 'patient_id');
    }
}
