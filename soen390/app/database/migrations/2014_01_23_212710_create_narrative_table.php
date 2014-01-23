<?php

use Illuminate\Database\Migrations\Migration;

class CreateNarrativeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Narrative', function($table)
		{
			$table->increments('NarrativeID');
			$table->integer('CategoryID');
			$table->integer('LanguageID');
			$table->timestamp('DateCreated');
			$table->timestamp('DateModified')->nullable();
			$table->string('Name', 30)->nullable();
			$table->integer('Flags');
			$table->integer('Views');
			$table->integer('Agrees');
			$table->integer('Disagrees');
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