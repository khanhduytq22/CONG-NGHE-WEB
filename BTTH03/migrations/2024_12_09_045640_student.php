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
        Schema::create('students', function (Blueprint $table) {
            $table->id('id');
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->datetime('date_of_birth');
            $table->string('parent_phone',20);
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes');
                

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
