<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();             // Tạo cột ID (khóa chính)
            $table->string('title');  // Tạo cột title (kiểu chuỗi)
            $table->text('content');  // Tạo cột content (kiểu văn bản)
            $table->timestamps();     // Tạo các cột created_at và updated_at
        });}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
