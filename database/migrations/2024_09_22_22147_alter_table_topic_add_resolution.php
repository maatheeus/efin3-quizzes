<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableTopicAddResolution extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topic_quizzes_alternatives', function (Blueprint $table) {
            $table->text('resolution')->nullable();
        });

        Schema::table('topic_quizzes_questions', function (Blueprint $table) {
            $table->text('resolution')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
