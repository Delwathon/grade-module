<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_id')->unsigned();
            $table->bigInteger('s_class_id')->unsigned();
            $table->bigInteger('section_id')->unsigned();
            $table->bigInteger('student_id')->unsigned();
            $table->bigInteger('session_id')->unsigned();
            $table->bigInteger('subject_id')->unsigned();
            $table->bigInteger('distribution_id')->unsigned();
            $table->bigInteger('term_id')->unsigned();
            $table->integer('mark')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('s_class_id')->references('id')->on('s_classes')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('distribution_id')->references('id')->on('distributions')->onDelete('cascade');
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('cascade');
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
        Schema::dropIfExists('marks');
    }
};