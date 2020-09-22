<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Grupo de despesas do centro de id $source_id
        Schema::create('exgroups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('description', 255)->nullable();
            $table->unsignedBigInteger('source_id');
            $table->timestamps();

            $table->foreign('source_id')
                ->references('id')
                ->on('sources')
                ->onDelete('cascade');
        });

        // Liga tipos de despesa a grupos de despesas
        Schema::create('exgroup_extype', function (Blueprint $table) {
            $table->id();
            $table->index(['exgroup_id', 'extype_id']);
            $table->unsignedBigInteger('exgroup_id');
            $table->unsignedBigInteger('extype_id');
            $table->foreign('exgroup_id')
                ->references('id')
                ->on('exgroups')
                ->onDelete('cascade');

            $table->foreign('extype_id')
                ->references('id')
                ->on('extypes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exgroups', function (Blueprint $table) {
            $table->dropForeign('source_id');
        });
        Schema::dropIfExists('exgroups');

        Schema::table('exgroup_extype', function (Blueprint $table) {
            $table->dropForeign('exgroup_id');
            $table->dropForeign('extype_id');
        });
        Schema::dropIfExists('exgroup_extype');
    }
}
