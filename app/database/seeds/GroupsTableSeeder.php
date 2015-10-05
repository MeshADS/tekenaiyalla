<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class GroupsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		$names = ["Administrators", "Users"];

		foreach($names as $name)
		{
			try{
				$exists = Sentry::findGroupByName($name);
				// Do nothing
			}
			catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e){

				Sentry::createGroup([
					"name" => $name,
					"permissions" => []
				]);
			}
		}
	}

}