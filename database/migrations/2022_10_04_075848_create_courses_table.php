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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->nullable()->constrained('groups')->nullOnDelete();
            $table->foreignId('mentor_id')->nullable()->constrained('mentors')->nullOnDelete();
            $table->string("title");
            $table->string("description")->nullable();
            $table->string('image')->nullable();
            $table->float('budget')->nullable();
            $table->integer('participants_count')->default(0);
            $table->integer('hour_count')->default(0);
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->enum('status', ['draft', 'completed', 'ongoing'])->default('draft');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
