<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('customer_documents', function($table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**z
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_documents', function($table) {
            $table->dropColumn('customer_id');
        });
    }
};
