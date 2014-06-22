<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSettingTable extends Migration {

	public function up()
	{
		Schema::create('UserProfile',function($table)
		{
			
			$table->string('Username');	
			$table->string('Gender');
			$table->string('BloodType');
			$table->enum('Sign',array(
					'Aries',
					'Taurus',
					'Gemini',
					'Cancer',
					'Leo',
					'Virgo',
					'Libra',
					'Scorpio',
					'Sagittarius',
					'Capricorn',
					'Aquarius',
					'Pisces'));
			$table->string('Age');
			$table->string('Characterristics');
			$table->string('Mood');
			$table->string('Profession');	
			$table->timestamps();			
		});		

		Schema::create('UserPreference',function($table)
		{
				
			$table->string('Username');
			$table->string('Gender');
			$table->string('BloodType');
			$table->enum('Sign',array(
					'Aries',
					'Taurus',
					'Gemini',
					'Cancer',
					'Leo',
					'Virgo',
					'Libra',
					'Scorpio',
					'Sagittarius',
					'Capricorn',
					'Aquarius',
					'Pisces'));
			$table->string('Age');
			$table->string('Characterristics');
			$table->string('Mood');
			$table->string('Profession');
			$table->timestamps();			
		});
	}

	public function down()
	{	
		Schema::dropIfExists('UserProfile');
		Schema::dropIfExists('UserPreference');	
	
	}

}
