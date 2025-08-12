<?php

namespace App\Models;

use App\Models\User;
use App\Models\ReadMessage;
use App\Models\Conversation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $guarded = [];

    public function getUser(){

         return $this->hasOne('App\User','id','from_user_id');
    }

    public function conversation() 
    { 
        return $this->belongsTo(Conversation::class); 
    }
    public function sender() 
    { 
        return $this->belongsTo(User::class, 'sender_id'); 
    }
    public function replyTo() 
    { 
        return $this->belongsTo(Message::class, 'reply_to_id'); 
    }

    public function reads()
    {
        return $this->hasMany(ReadMessage::class);
    }
}
