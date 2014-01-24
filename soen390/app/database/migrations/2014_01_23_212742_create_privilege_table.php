<?php

use Illuminate\Database\Migrations\Migration;

class CreatePrivilegeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Privilege', function($table)
		{
			$table->increments('PrivilegeID');
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
		//
	}

}