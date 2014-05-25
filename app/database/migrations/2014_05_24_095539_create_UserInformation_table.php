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
			$table->incretment('UserID');
			$talbe->string('Username');
			$talbe->string('Userpasswd');
			$table->string('Nickname');
			$talbe->string('Realname');
			$talbe->string('Birthday');
		}
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
