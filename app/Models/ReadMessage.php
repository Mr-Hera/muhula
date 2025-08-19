<?php

namespace App\Models;

use App\Models\User;
use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReadMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'user_id',
        'read_at',
    ];

    public function message() 
    { 
        return $this->belongsTo(Message::class); 
    }
    
    public function user() 
    { 
        return $this->belongsTo(User::class); }
}
