<?php

use Illuminate\Database\Migrations\Migration;

class CreateTopicTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Topic', function($table)
		{
			$table->increments('TopicID');
			$table->timestamp('DateCreated');
			$table->timestamp('DateModified')->nullable();
			$table->string('Name', 50)->nullable();
			$table->string('Description', 100);
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