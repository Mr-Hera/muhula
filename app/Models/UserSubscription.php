<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;
    protected $table = 'user_subscription';
    protected $guarded = [];

    public function getUser(){

        return $this->hasOne('App\User','id','user_id');
    }

    public function getSubscription(){

        return $this->hasOne('App\Models\SubscriptionMaster','id','subscription_id');
    }

    public function getPayment(){

        return $this->hasOne('App\Models\Payment','user_subscription_id','id');
    }
}
