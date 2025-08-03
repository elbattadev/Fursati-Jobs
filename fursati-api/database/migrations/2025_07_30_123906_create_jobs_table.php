<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('work_place');
            $table->unsignedInteger('education_level_id')->nullable();
            $table->unsignedInteger('country_of_graduation')->nullable();
            $table->unsignedInteger('country_of_residence')->nullable();
            $table->unsignedInteger('work_field_id')->nullable();
            $table->string('gender_preference')->nullable(); // all, male, female
            $table->unsignedInteger('work_experience')->nullable();
            $table->unsignedInteger('business_man_id')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->boolean('favorite')->default(false);
            $table->string('company_name')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('category')->nullable();
            $table->string('salary')->nullable();
            $table->date('deadline')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->timestamp('posted_time')->nullable();
            $table->json('skills')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
