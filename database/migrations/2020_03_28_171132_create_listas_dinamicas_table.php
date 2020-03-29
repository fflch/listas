<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListasDinamicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listas_dinamicas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('url_mailman');
            $table->string('name');
            $table->string('pass');
            $table->text('emails_allowed')->nullable();
            $table->text('description');
            $table->text('emails_adicionais')->nullable();
            $table->string('stat_mailman_total')->nullable();
            $table->datetime('stat_mailman_date')->nullable();
            $table->string('listas_ids')->nullable();

            $table->unsignedBigInteger('last_user_id')->nullable();
            $table->foreign('last_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lista_dinamicas');
    }
}
