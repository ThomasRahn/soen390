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
			$table->integer('Flags')->default(0);
			$table->integer('Views')->default(0);
			$table->integer('Agrees')->default(0);
			$table->integer('Disagrees')->default(0);
			$table->integer('Indifferents')->default(0);
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