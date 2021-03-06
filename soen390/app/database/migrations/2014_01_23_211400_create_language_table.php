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
			$table->engine = 'InnoDB';
			
			$table->increments('LanguageID');
			$table->string('Code');
			$table->string('Description');
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
