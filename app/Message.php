<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected  $fillable = [
        'message',
        'user_id',
        'room_id',
    ];
   public function user()
   {
       return $this->belongsTo(User::class);
   }
   public function room()
   {
       return $this->belongsTo(Room::class);
   }
}
