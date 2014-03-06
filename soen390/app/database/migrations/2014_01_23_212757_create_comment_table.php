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
			$table->timestamp('deleted_at')->nullable();
			$table->string('Name', 20);
			$table->integer('Views')->default(0);
			$table->integer('Agrees')->default(0);
			$table->integer('Disagrees')->default(0);
			$table->integer('Indifferents')->default(0);
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
		Schema::dropIfExists('Comment');
	}

}
