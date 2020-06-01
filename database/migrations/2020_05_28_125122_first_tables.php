<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FirstTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();

        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('slug', 90)->unique()->nullable();
            $table->boolean('income')->default(0);
            $table->timestamps();
        }); 

        Schema::create('intypes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 60)->unique()->nullable();
            $table->string('description', 255);
            $table->timestamps();
        });

        Schema::create('intype_source', function (Blueprint $table) {
            $table->id();
            $table->index(['intype_id', 'source_id', 'year']);
            $table->unsignedBigInteger('intype_id');
            $table->unsignedBigInteger('source_id');
            $table->decimal('default', 19,4);
            $table->string('year', 4);

            $table->foreign('intype_id')
                ->references('id')
                ->on('intypes')
                ->onDelete('cascade');

            $table->foreign('source_id')
                ->references('id')
                ->on('sources')
                ->onDelete('cascade');
        });

        Schema::create('inregisters', function (Blueprint $table) {
            $table->id();
            $table->index(['intype_source_id', 'month']);
            $table->unsignedBigInteger('intype_source_id');
            $table->string('month', 2);
            $table->decimal('value', 19,4);
            $table->string('observations', 255)->nullable();
            $table->timestamps();

            $table->foreign('intype_source_id')->references('id')
                ->on('intype_source')->onDelete('no action');
        }); 

        Schema::create('extypes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 60)->unique()->nullable();
            $table->string('description', 255);
            $table->timestamps();
        });

        Schema::create('extype_source', function (Blueprint $table) {
            $table->id();
            $table->index(['extype_id', 'source_id', 'year']);
            $table->unsignedBigInteger('extype_id');
            $table->unsignedBigInteger('source_id');
            $table->decimal('default', 19,4);
            $table->string('year', 4);

            $table->foreign('extype_id')
                ->references('id')
                ->on('extypes')
                ->onDelete('cascade');

            $table->foreign('source_id')
                ->references('id')
                ->on('sources')
                ->onDelete('cascade');
        });

        Schema::create('exregisters', function (Blueprint $table) {
            $table->id();
            $table->index(['extype_source_id', 'month']);
            $table->unsignedBigInteger('extype_source_id');
            $table->string('month', 2);
            $table->decimal('value', 19,4);
            $table->string('observations', 255)->nullable();
            $table->timestamps();

            $table->foreign('extype_source_id')->references('id')
                ->on('extype_source')->onDelete('no action');
        }); 

        Schema::create('months', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
            $table->string('number', 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sources');
        Schema::dropIfExists('intypes');

        Schema::table('intype_source', function (Blueprint $table) {
            $table->dropForeign('intype_id');
            $table->dropForeign('source_id');
        });
        Schema::dropIfExists('intype_source');

        Schema::table('inregisters', function (Blueprint $table) {
            $table->dropForeign('intype_source_id');
        });
        Schema::dropIfExists('inregisters');
        
        Schema::dropIfExists('extypes');

        Schema::table('extype_source', function (Blueprint $table) {
            $table->dropForeign('extype_id');
            $table->dropForeign('source_id');
        });
        Schema::dropIfExists('extype_source');

        Schema::table('exregisters', function (Blueprint $table) {
            $table->dropForeign('extype_source_id');
        });
        Schema::dropIfExists('exregisters');

        Schema::dropIfExists('months');

    }
}
