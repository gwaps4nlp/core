<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corpuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->string('title',500)->default("");
            $table->integer('language_id')->unsigned();
            $table->text('description');
            $table->integer('source_id')->unsigned();
            $table->boolean('playable')->default(0);
            $table->integer('number_answers')->default(0);
            $table->string('url_source',500)->default("");
            $table->string('url_info_license',500)->default("");
            $table->timestamps();
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('corpuses', function(Blueprint $table) {
            $table->dropForeign(['language_id']);
        });        
        Schema::drop('corpuses');
    }
}
