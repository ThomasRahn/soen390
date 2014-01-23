<?php

use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Comment', function($table)
		{
			$table->increments('CommentID');
			$table->integer('NarrativeID');
			$table->integer('CommentParentID')->nullable();
			$table->timestamp('DateCreated');
			$table->string('Name', 20);
			$table->integer('Flags');
			$table->integer('Views');
			$table->integer('Agrees');
			$table->integer('Disagrees');
			$table->string('Comment', 100);
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