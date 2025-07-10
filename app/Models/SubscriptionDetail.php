<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionDetail extends Model
{
    use HasFactory;
    protected $table = 'subscription_detail';
    protected $guarded = [];

    public function getSubscription(){

        return $this->hasOne('App\Models\SubscriptionMaster','id','subscription_master_id');
    }

}
