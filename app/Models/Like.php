<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['pub_id','user_id'];

    public function publicacao(){
        return $this->belongsTo('App\Models\Publicacao');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
