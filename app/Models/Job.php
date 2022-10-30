<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    public function city(){
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function responsibilities(){
        return $this->hasMany(JobResponsibility::class, 'job_id', 'id');
    }

    public function applicants(){
        return $this->hasMany(JobApplicant::class, 'job_id', 'id');
    }
}
