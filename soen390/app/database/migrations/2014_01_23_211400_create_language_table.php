<?php

use Illuminate\Database\Migrations\Migration;

class CreateLanguageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Language', function($table)
		{
			$table->increments('LanguageID');
			$table->string('Description', 20);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('Language');
	}

}
