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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('requirements')->nullable();
            $table->integer('minutes');
            $table->integer('price');
            $table->string('code');
            $table->text('warning_message')->nullable();

            //este campo sirve para saber quien creo la cita
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');


            $table->unsignedBigInteger('dependency_id')->nullable();
            $table->foreign('dependency_id')->references('id')->on('dependencies');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
