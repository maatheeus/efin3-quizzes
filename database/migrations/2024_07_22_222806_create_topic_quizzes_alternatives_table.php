<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopicQuizzesAlternativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_quizzes_alternatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('topic_quizzes_questions')->onDelete('cascade');
            $table->text('alternative_text');
            $table->boolean('is_correct')->default(false);
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
        Schema::dropIfExists('topic_quizzes_alternatives');
    }
}
