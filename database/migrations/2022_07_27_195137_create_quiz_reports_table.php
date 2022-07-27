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
        Schema::create('quiz_reports', function (Blueprint $table) {
            $table->id();
            $table->char('quiz_id', 32);
            $table->foreign('quiz_id')->references('id')->on('quizzes');
            $table->foreignId('user_id')->constrained();
            $table->string('report');
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
        Schema::dropIfExists('quiz_reports');
    }
};
