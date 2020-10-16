<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'username', 'password', 'token'
    ];

    public function generateToken(){
        $this->api_token = Str::random(60);
        $this->save();
        return $this->token;
    }
}
