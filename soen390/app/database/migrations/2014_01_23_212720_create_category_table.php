<?php

use Illuminate\Database\Migrations\Migration;

class CreateCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Category', function($table)
		{
			$table->increments('CategoryID');
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
		Schema::dropIfExists('Category');
	}

}