<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacao extends Model
{
    use HasFactory;
    public $table = 'publicacao';
    protected $casts = [
        'userLinked' => 'array'
    ];
    protected $fillable = ['user_id','description','tags','image','userLinkedIds','userLinked','private'];

    public function user(){
         return $this->belongsTo('App\Models\User','user_id','id');
    }   
    public function likes(){
        return $this->hasMany('App\Models\Like');
    }
    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
}
