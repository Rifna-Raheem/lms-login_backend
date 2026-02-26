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
    Schema::create('teachers', function (Blueprint $table) {
        $table->id();
        $table->string('teacher_code')->unique(); // TCH0001
        $table->string('full_name');
        $table->string('name_with_initial');
        $table->string('nic')->unique();
        $table->string('email')->unique();
        $table->string('phone');
        $table->string('whatsapp');
        $table->string('photo')->nullable();
        $table->enum('status', ['active', 'frozen', 'blocked'])->default('active');
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
        Schema::dropIfExists('teachers');
    }
};
