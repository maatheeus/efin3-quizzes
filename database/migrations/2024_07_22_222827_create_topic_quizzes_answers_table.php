<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicQuizzesAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_quizzes_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('topic_quizzes_questions')->onDelete('cascade');
            $table->foreignId('alternative_id')->constrained('topic_quizzes_alternatives')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('topic_quizzes_answers');
    }
}
