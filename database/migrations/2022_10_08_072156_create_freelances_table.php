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
        Schema::create('freelances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('platform_id')->constrained('platforms')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->string('job_title');
            $table->text('job_description')->nullable();
            $table->string('job_link')->nullable();
            $table->string('attachment')->nullable();
            $table->string('salary');
            $table->string('client_feedback')->nullable();
            $table->enum('status', ['completed', 'ongoing'])->default('ongoing');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('freelances');
    }
};
