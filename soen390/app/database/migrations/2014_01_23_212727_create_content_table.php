<?php

use Illuminate\Database\Migrations\Migration;

class CreateContentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Content', function($table)
		{
			$table->increments('ContentID');
			$table->integer('NarrativeID')->nullable();
			$table->integer('CategoryID')->nullable();
			$table->integer('CommentID')->nullable();
			$table->string('AudioPath', 100)->nullable();
			$table->string('PicturePath', 100)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}