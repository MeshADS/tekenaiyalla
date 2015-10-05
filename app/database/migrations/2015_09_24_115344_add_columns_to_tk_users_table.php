<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddColumnsToTkUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tk_users', function(Blueprint $table)
		{
			$table->text('bio');
			$table->string('facebook')->nullable();
			$table->string('instagram')->nullable();
			$table->string('twitter')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tk_users', function(Blueprint $table)
		{
			$table->dropColumn('bio');
			$table->dropColumn('facebook');
			$table->dropColumn('instagram');
			$table->dropColumn('twitter');
		});
	}

}
