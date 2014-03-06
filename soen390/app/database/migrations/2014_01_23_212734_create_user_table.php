<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('User', function($table)
		{
			$table->increments('UserID');
			$table->integer('PrivilegeID');
			$table->integer('LanguageID')->nullable();
			$table->string('Email');
			$table->string('Password');
			$table->string('Name')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('User');
	}

}
