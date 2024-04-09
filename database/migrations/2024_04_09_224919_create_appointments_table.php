<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date');
            $table->string('citizen_name');
            $table->string('citizen_firstname');
            $table->string('citizen_secondname');
            $table->string('email')->nullable();
            $table->string('curp');
            $table->string('phone')->nullable();
            $table->string('folio')->nullable();
            $table->string('ip')->nullable();
            $table->string('appointment_status')->nullable();

            $table->unsignedBigInteger('transaction_id');
            $table->foreign('transaction_id')->references('id')->on('transactions');

            $table->unsignedBigInteger('office_id');
            $table->foreign('office_id')->references('id')->on('offices');

            //este campo sirve para saber quien creo la cita
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->foreign('created_by_user_id')->references('id')->on('users');

            //este campo sirve para saber quien edito la cita
            $table->unsignedBigInteger('updated_by_user_id')->nullable();
            $table->foreign('updated_by_user_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
