<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnsInListas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listas', function (Blueprint $table) {
            $table->dropColumn('replicado_query');
            $table->dropColumn('stat_mailman_before');
            $table->dropColumn('stat_mailman_added');
            $table->dropColumn('stat_mailman_removed');
            $table->dropColumn('stat_mailman_replicado');
            $table->renameColumn('stat_replicado_updated', 'stat_mailman_updated');
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
