<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddAuthorIdToTkPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tk_posts', function(Blueprint $table)
		{
			$table->integer('author_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tk_posts', function(Blueprint $table)
		{
			$table->dropColumn('author_id');
		});
	}

}
