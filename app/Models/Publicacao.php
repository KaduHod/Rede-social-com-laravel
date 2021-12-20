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

    // public function user(){
    //     return $this->belongsTo('\Models\User');
    // }   
}
