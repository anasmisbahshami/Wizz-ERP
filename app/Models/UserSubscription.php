<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_id',
        'start_date',
        'end_date',
        'remaining_weight',
        'status',
        'notify_subscribed'
    ];

    protected $dates = ['start_date','end_date'];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function subscription(){
        return $this->hasOne(Subscription::class, 'id', 'subscription_id');
    }

}