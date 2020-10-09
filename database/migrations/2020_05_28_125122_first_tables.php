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
        Schema::create('income_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 60)->unique();
            $table->unsignedBigInteger('source_id');
            $table->string('description', 255);
            $table->timestamps();
        });

        // Types of expenses
        Schema::create('expense_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 60)->unique();
            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('expense_group_id')->nullable()->default(null);
            $table->string('description', 255);
            $table->boolean('fixed');
            $table->timestamps();

            $table->foreign('expense_group_id')->references('id')->on('expense_groups')
                ->onDelete('set null');
        });

        // A value recorded in expense or income of $holder_id in $year and $month
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->unique(['recordable_id', 'recordable_type', 'year', 'month_id']);
            $table->unsignedBigInteger('recordable_id');
            $table->string('recordable_type', 50);
            $table->string('year', 4);
            $table->unsignedBigInteger('month_id');
            $table->decimal('value', 19,2)->default(0.0);
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });

        // Months
        Schema::create('months', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
            $table->string('short', 5);
            $table->string('number', 2);
        });

        Schema::create('expense_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('description', 255)->nullable();
            $table->unsignedBigInteger('source_id');
            $table->boolean('fixed');
            $table->timestamps();
        });

        // Liga tipos de despesa a grupos de despesas
        Schema::create('expense_group_expense_type', function (Blueprint $table) {
            $table->id();
            $table->unique(['expense_group_id', 'expense_type_id'], 'expense_group_id_expense_type_id_unique');
            $table->unsignedBigInteger('expense_group_id');
            $table->unsignedBigInteger('expense_type_id');
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
        Schema::dropIfExists('income_types');
        Schema::dropIfExists('expense_types');
        Schema::dropIfExists('records');
        Schema::dropIfExists('months');
        Schema::dropIfExists('expense_groups');
        Schema::dropIfExists('expense_group_expense_type');
    }
}
