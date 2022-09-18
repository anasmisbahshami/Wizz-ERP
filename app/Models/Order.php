<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user_subscription(){
        return $this->hasOne(UserSubscription::class, 'user_id', 'user_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function items(){
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
