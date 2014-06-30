<?php
class DatabaseSeeder extends Seeder{

	public function run()
	{
		Eloquent::unguard();

		$this->command->info('Start Seed User Information');
		
		$faker=Faker\Factory::create();
		for($i=0;$i<100;$i++)
		{
			$user=User::create(array(
				'Username'=>$faker->userName,
				'Userpasswd'=>$faker->word,
				'Nickname'=>$faker->name,
				'Realname'=>$faker->name
				
				));

		}
		
	}



}
