<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RemovePageFromTprlHeadersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tk_headers', function(Blueprint $table)
		{
			$table->dropColumn('page');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tk_headers', function(Blueprint $table)
		{
			$table->string('page');
		});
	}

}
