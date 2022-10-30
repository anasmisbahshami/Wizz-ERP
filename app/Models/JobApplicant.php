<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicant extends Model
{
    use HasFactory;

    public function job(){
        return $this->hasOne(Job::class, 'id', 'job_id');
    }
}
