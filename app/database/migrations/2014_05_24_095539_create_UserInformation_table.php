<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInformationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{	
		Schema::create('UserInformation',function($table)
		{
			$table->increments('UserID');
			$table->string('Username');
			$table->string('Userpasswd');
			$table->string('Nickname');
			$table->string('Realname');
			$table->string('Birthday');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('UserInformation');
	}

}
