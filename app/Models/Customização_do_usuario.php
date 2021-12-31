<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customização_do_usuario extends Model
{
    use HasFactory;

    public $table = 'customizacao_do_usuario';
    
    protected $fillable = ['Imagem_de_fundo_perfil','Imagem_de_fundo_corpo','Cor_de_fundo_profile','Cor_de_fundo_corpo','Cor_do_header','Cor_do_footer'];

    public function user(){
        return $this->belongsTo('App\Models\Users');
    }

}
