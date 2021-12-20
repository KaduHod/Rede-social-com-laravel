<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->text('descricao')->nullable();;
            $table->boolean('private');
            $table->string('image');
            $table->string('tags')->nullable();;
            $table->string('pubUserName');
            $table->string('profileUserImage');
            $table->json('likeIds')->nullable();
            $table->json('userLinked')->nullable();
            $table->text('userLinkedIds')->nullable();
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
        Schema::dropIfExists('publicacao');
    }
}
