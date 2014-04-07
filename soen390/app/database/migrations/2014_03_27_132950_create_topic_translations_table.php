<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('topic_translations', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->timestamps();
			$table->integer('language_id')->unsigned();
			$table->integer('topic_id')->unsigned();
			$table->string('translation');

			// Define foreign keys
			$table->foreign('language_id')->references('LanguageID')->on('Language');
			$table->foreign('topic_id')->references('TopicID')->on('Topic');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('topic_translations');
	}

}
