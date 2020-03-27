<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToListas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listas', function (Blueprint $table) {
            $table->string('stat_mailman_before')->nullable();
            $table->string('stat_mailman_after')->nullable();
            $table->string('stat_mailman_added')->nullable();
            $table->string('stat_mailman_removed')->nullable();
            $table->string('stat_mailman_replicado')->nullable();
            $table->string('stat_replicado_updated')->nullable();
            $table->datetime('stat_mailman_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listas', function (Blueprint $table) {
            //
        });
    }
}
