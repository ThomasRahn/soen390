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
			$table->string('Email', 100);
			$table->string('Password', 100);
			$table->string('Name', 50)->nullable();
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