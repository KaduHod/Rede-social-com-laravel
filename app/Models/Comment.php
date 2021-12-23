<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $table = 'comments';
    protected $fillable = ['user_id','publicacao_id','coment'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function publicacao(){
        return $this->belongsTo('App\Models\Publicacao');
    }
}
