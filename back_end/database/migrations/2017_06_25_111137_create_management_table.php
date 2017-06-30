<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing diseases
        Schema::create('diseases', function(Blueprint $table) {
            // These columns are needed for Baum's Nested Set implementation to work.
            // Column names may be changed, but they *must* all exist and be modified
            // in the model.
            // Take a look at the model scaffold comments for details.
            // We add indexes on parent_id, lft, rgt columns by default.
            $table->increments('id');
            $table->integer('parent_id')->nullable()->index();
            $table->integer('lft')->nullable()->index();
            $table->integer('rgt')->nullable()->index();
            $table->integer('depth')->nullable();

            // Add needed columns here (f.ex: name, slug, path, etc.)
            $table->string('name', 30);

            $table->timestamps();
        });

        // Create table for storing channels
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->unique();
            $table->boolean('state')->default(false);
            $table->timestamps();
        });

        // Create table for storing channels
        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->unique();
            $table->boolean('state')->default(false);
            $table->timestamps();
        });

        // Create table for storing advisorys
        Schema::create('advisories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('diseases');
        Schema::drop('doctors');
        Schema::drop('channels');
        Schema::drop('advisories');
    }
}
