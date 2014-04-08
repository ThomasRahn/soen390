<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('media', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->timestamps();
			$table->integer('narrative_id')->nullable();
			$table->integer('topic_id')->nullable();
			$table->integer('comment_id')->nullable();
			$table->string('type');
			$table->string('filename');
			$table->string('basename');
			$table->string('audio_duration')->nullable();
			$table->string('audio_codec')->nullable();

			$table->index('narrative_id');
			$table->index('filename');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('media');
	}

}
