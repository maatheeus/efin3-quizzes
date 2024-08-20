<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTopicQuizzes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topic_quizzes', function (Blueprint $table) {
            $table->integer('max_attempts')->nullable();
            $table->integer('max_execution_time')->nullable();
            $table->integer('min_pass_score')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topic_quizzes', function (Blueprint $table) {
            $table->dropColumn(['max_attempts', 'max_execution_time', 'min_pass_score']);
        });
    }
}
