<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaListaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consulta_lista', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('consulta_id')->constrained('consultas')->onDelete('cascade');
            $table->foreignId('lista_id')->constrained('listas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consulta_lista');
    }
}
