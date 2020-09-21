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

        // The owner of expenses and incomes
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('slug', 90)->unique();
            $table->boolean('income')->default(0);
            $table->timestamps();
        }); 

        // Types of incomes
        Schema::create('intypes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 60)->unique();
            $table->string('description', 255);
            $table->timestamps();
        });

        // Instances of an income type, when associated to a source in a set year / month
        Schema::create('intype_source', function (Blueprint $table) {
            $table->id();
            $table->index(['intype_id', 'source_id', 'year', 'month']);
            $table->unsignedBigInteger('intype_id');
            $table->unsignedBigInteger('source_id');
            $table->string('year', 4);
            $table->string('month', 2);
            $table->decimal('value', 19,4);
            $table->string('observations', 255)->nullable();

            $table->foreign('intype_id')
                ->references('id')
                ->on('intypes')
                ->onDelete('cascade');

            $table->foreign('source_id')
                ->references('id')
                ->on('sources')
                ->onDelete('cascade');
        });

        // Describes a period of association between a source and an intype
        Schema::create('source_intype_period', function (Blueprint $table) {
            $table->id();
            $table->index(['intype_id', 'source_id', 'start_year', 'start_month'], "intype_id_source_id_start_year_start_month_index");
            $table->unsignedBigInteger('intype_id');
            $table->unsignedBigInteger('source_id');
            $table->string('start_year', 4);
            $table->string('start_month', 2);
            $table->string('end_year', 4);
            $table->string('end_month', 2);
            $table->string('details', 255)->nullable();

            $table->foreign('intype_id')
                ->references('id')
                ->on('intypes')
                ->onDelete('cascade');

            $table->foreign('source_id')
                ->references('id')
                ->on('sources')
                ->onDelete('cascade');
        });

        // Types of expenses
        Schema::create('extypes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 60)->unique();
            $table->string('description', 255);
            $table->timestamps();
        });

        // Instances of an expense type, when associated to a source in a set year / month
        Schema::create('extype_source', function (Blueprint $table) {
            $table->id();
            $table->index(['extype_id', 'source_id', 'year', 'month']);
            $table->unsignedBigInteger('extype_id');
            $table->unsignedBigInteger('source_id');
            $table->string('year', 4);
            $table->string('month', 2);
            $table->decimal('value', 19,4);
            $table->string('observations', 255)->nullable();

            $table->foreign('extype_id')
                ->references('id')
                ->on('extypes')
                ->onDelete('cascade');

            $table->foreign('source_id')
                ->references('id')
                ->on('sources')
                ->onDelete('cascade');
        });

        // Describes a period of association between a source and an extype
        Schema::create('source_extype_period', function (Blueprint $table) {
            $table->id();
            $table->index(['extype_id', 'source_id', 'start_year', 'start_month'], "extype_id_source_id_start_year_start_month_index");
            $table->unsignedBigInteger('extype_id');
            $table->unsignedBigInteger('source_id');
            $table->decimal('default', 19,4)->nullable();
            $table->string('start_year', 4);
            $table->string('start_month', 2);
            $table->string('end_year', 4);
            $table->string('end_month', 2);
            $table->string('details', 255)->nullable();

            $table->foreign('extype_id')
                ->references('id')
                ->on('extypes')
                ->onDelete('cascade');

            $table->foreign('source_id')
                ->references('id')
                ->on('sources')
                ->onDelete('cascade');
        });

        // Months
        Schema::create('months', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
            $table->string('short', 5);
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

        Schema::table('source_intype_period', function (Blueprint $table) {
            $table->dropForeign('intype_id');
            $table->dropForeign('source_id');
        });
        Schema::dropIfExists('source_intype_period');
        
        Schema::dropIfExists('extypes');

        Schema::table('extype_source', function (Blueprint $table) {
            $table->dropForeign('extype_id');
            $table->dropForeign('source_id');
        });
        Schema::dropIfExists('extype_source');

        Schema::table('source_extype_period', function (Blueprint $table) {
            $table->dropForeign('extype_id');
            $table->dropForeign('source_id');
        });
        Schema::dropIfExists('source_extype_period');

        Schema::dropIfExists('months');
    }
}
