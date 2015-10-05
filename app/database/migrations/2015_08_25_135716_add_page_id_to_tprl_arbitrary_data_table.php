<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddPageIdToTprlArbitraryDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tk_content_data', function(Blueprint $table)
		{
			$table->integer('page_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tk_content_data', function(Blueprint $table)
		{
			$table->dropColumn('page_id');
		});
	}

}
