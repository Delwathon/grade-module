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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('s_class_id')->unsigned()->nullable();
            $table->bigInteger('branch_id')->unsigned();
            $table->bigInteger('session_id')->unsigned()->nullable();
            $table->float('from');
            $table->float('to');
            $table->string('grade');
            $table->text('remark')->nullable();
            $table->foreign('s_class_id')->references('id')->on('s_classes')->onDelete('cascade');
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
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
        Schema::dropIfExists('grades');
    }
};