<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Filesystem\Filesystem;

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
			$table->integer('TopicID');
			$table->integer('LanguageID');
			$table->timestamp('DateCreated');
			$table->timestamp('DateModified')->nullable();
			$table->timestamp('deleted_at')->nullable();
			$table->string('Name')->nullable();
			$table->integer('Views')->default(0);
			$table->integer('Agrees')->default(0);
			$table->integer('Disagrees')->default(0);
			$table->integer('Indifferents')->default(0);
			$table->boolean('Published');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('Narrative');
	}

}
