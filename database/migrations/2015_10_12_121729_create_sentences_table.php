<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sentences', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->text('corrected_content')->default("");
            $table->integer('corpus_id')->unsigned();
            $table->decimal('difficulty',4,2);
            $table->string('sentid',255);
            $table->integer('source_id')->unsigned();
            $table->text('conll');
            $table->timestamps();
            $table->foreign('corpus_id')->references('id')->on('corpuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sentences', function(Blueprint $table) {
            $table->dropForeign(['corpus_id']);
        });
        Schema::drop('sentences');
    }
}
