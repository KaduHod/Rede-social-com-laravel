<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function publicacao(){
         return $this->hasMany('App\Models\Publicacao');
    }
    public function following() {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'following_id');
    }
    public function followers() {
        return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
    }
    public function likes(){
        return $this->belongsToMany('App\Models\Like');
    }
    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
    public function customLayout(){
        return $this->HasOne('App\Models\Customização_do_usuario');
    }
    public function chats(){
        return $this->belongsToMany('App\Models\Chat');
    }
    public function messages(){
        return $this->hasMany('App\Models\Message');
    }
}
