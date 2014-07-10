<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScoreAndLevelColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('UserProfile',function($table){
				$table->integer('Level')->default(0);
				$table->integer('Score')->default(0);
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('UserProfile',function($table){
				$table->dropColumn(array('Level','Score'));

		});
	}

}
