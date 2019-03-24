<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'owner_id',
        'lancer_id',
    ];
    public function owner()
    {
        return $this->hasOne(User::class,'id','owner_id');
    }
    public function lancer()
    {
        return $this->hasOne(User::class,'id','lancer_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class,'room_id','id' );
    }
}
