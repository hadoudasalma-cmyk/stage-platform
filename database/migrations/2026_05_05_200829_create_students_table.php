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
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('first_name');
        $table->string('last_name');
        $table->string('phone')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->string('city')->nullable();
        $table->text('address')->nullable();
        $table->string('education_level')->nullable();
        $table->string('field_of_study')->nullable();
        $table->string('university')->nullable();
        $table->string('cv_path')->nullable();
        $table->string('photo_path')->nullable();
        $table->timestamps();
    });
}
};
