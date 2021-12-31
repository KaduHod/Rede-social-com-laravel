<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomizacaoDoUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customizacao_do_usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->constrained();
            $table->string('Imagem_de_fundo_perfil')->nullable();
            $table->string('Imagem_de_fundo_corpo')->nullable();
            $table->string('Cor_de_fundo_profile')->nullable();
            $table->string('Cor_de_fundo_corpo')->nullable();
            $table->string('Cor_do_header')->nullable();
            $table->string('Cor_do_footer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customizacao_do_usuario');
    }
}
