<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 30);
            $table->boolean('sex')->default(false);
            $table->integer('age')->nullable;
            $table->string('tel', 11)->nullable;
            $table->string('wechat')->nullable;
            $table->integer('state')->unsigned()->default(0);
            $table->string('keyword', 30)->nullable;
            $table->string('pageurl')->nullable;
            $table->string('mark')->nullable;
            $table->float('price')->default(0);
            $table->boolean('first')->default(true);
            $table->timestamp('advisory_date');
            $table->timestamp('arrive_date')->nullable;
            $table->timestamps();
        });

        Schema::create('patient_disease', function (Blueprint $table) {
            $table->integer('patient_id')->unsigned();
            $table->integer('disease_id')->unsigned();

            $table->foreign('patient_id')->references('id')->on('patients')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('disease_id')->references('id')->on('diseases')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['patient_id', 'disease_id']);
        });

        Schema::create('patient_doctor', function (Blueprint $table) {
            $table->integer('patient_id')->unsigned();
            $table->integer('doctor_id')->unsigned();

            $table->foreign('patient_id')->references('id')->on('patients')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['patient_id', 'doctor_id']);
        });

        Schema::create('patient_channel', function (Blueprint $table) {
            $table->integer('patient_id')->unsigned();
            $table->integer('channel_id')->unsigned();

            $table->foreign('patient_id')->references('id')->on('patients')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('channel_id')->references('id')->on('channels')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['patient_id', 'channel_id']);
        });

        Schema::create('patient_advisory', function (Blueprint $table) {
            $table->integer('patient_id')->unsigned();
            $table->integer('advisory_id')->unsigned();

            $table->foreign('patient_id')->references('id')->on('patients')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('advisory_id')->references('id')->on('advisories')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['patient_id', 'advisory_id']);
        });

        Schema::create('patient_user', function (Blueprint $table) {
            $table->integer('patient_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('patient_id')->references('id')->on('patients')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['patient_id', 'user_id']);
        });

        DB::commit();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('patients');
        Schema::drop('patient_disease');
        Schema::drop('patient_doctor');
        Schema::drop('patient_channel');
        Schema::drop('patient_advisory');
        Schema::drop('patient_user');
    }
}
