<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contributions', function (Blueprint $table) {
            // $table->foreignId('period_affected_id')->constrained()->cascadeOnDelete();
            // $table->foreignId('period_received_id')->constrained()->cascadeOnDelete();
            $table->foreignId('period_affected_id')->constrained('periods')->onDelete('cascade'); 
            $table->foreignId('period_received_id')->constrained('periods')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contributions', function (Blueprint $table) {
            $table->dropForeign('contributions_period_affected_id_foreign');
            $table->dropForeign('contributions_period_received_id_foreign');
        });
    }
};
