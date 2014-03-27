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
			$table->timestamps();
			$table->string('Name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('Topic');
	}

}
