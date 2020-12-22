<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaydaySoftdeletes extends Migration
{
    public function up()
    {
        Schema::table('paydays', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('paydays', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
