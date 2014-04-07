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
			$table->engine = 'InnoDB';
			
			$table->increments('CommentID');
			$table->integer('NarrativeID');
			$table->integer('CommentParentID')->nullable();
			$table->timestamp('DateCreated');
			$table->boolean('Deleted')->default(0);
			$table->string('Name');
			$table->integer('Agrees')->default(0);
			$table->integer('Disagrees')->default(0);
			$table->integer('Indifferents')->default(0);
			$table->text('Comment');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('Comment');
	}

}
