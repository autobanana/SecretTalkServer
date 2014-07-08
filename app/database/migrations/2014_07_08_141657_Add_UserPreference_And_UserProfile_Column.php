<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserPreferenceAndUserProfileColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('UserPreference',function($table){
				$table->string('Interest')->default('0');
				$table->string('Personality')->default('0');
			});
		Schema::table('UserProfile',function($table){
				$table->string('Interest')->default('0');
				$table->string('Personality')->default('0');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('UserPreference',function($table){
				$table->dropColumn(array('Interest','Personality'));
			});

		Schema::table('UserProfile',function($table){
				$table->dropColumn(array('Interest','Personality'));
			});
	}

}
