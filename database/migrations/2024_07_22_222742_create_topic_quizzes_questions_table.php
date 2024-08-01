<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicQuizzesQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_quizzes_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_quiz_id')->constrained('topic_quizzes')->onDelete('cascade');
            $table->text('question_text');
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
        Schema::dropIfExists('topic_quizzes_questions');
    }
}
