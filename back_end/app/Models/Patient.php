<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public function user()
    {
        return $this->belongsToMany('App\Models\User', 'patient_user', 'patient_id', 'user_id');
    }

    public function advisory()
    {
        return $this->belongsToMany('App\Models\Management\Advisory', 'patient_advisory', 'patient_id', 'advisory_id');
    }

    public function channel()
    {
        return $this->belongsToMany('App\Models\Management\Channel', 'patient_channel', 'patient_id', 'channel_id');
    }

    public function disease()
    {
        return $this->belongsToMany('App\Models\Management\Disease', 'patient_disease', 'patient_id', 'disease_id');
    }

    public function doctor()
    {
        return $this->belongsToMany('App\Models\Management\Doctor', 'patient_doctor', 'patient_id', 'doctor_id');
    }
}
