<?php

use Illuminate\Database\Migrations\Migration;

class CreateFlagTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Flag', function($table)
		{
			$table->increments('FlagID');
			$table->integer('NarrativeID')->nullable();
			$table->integer('CommentID')->nullable();
			$table->string('Comment')->nullable();
			$table->timestamp('deleted_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('Flag');
	}

}
