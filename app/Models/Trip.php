<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id', 'route_id', 'date', 'rate','status','notify_start','notify_complete'];

    public function vehicle(){
        return $this->hasOne(Vehicle::class, 'id', 'vehicle_id');
    }

    public function route(){
        return $this->hasOne(Route::class, 'id', 'route_id');
    }

}
