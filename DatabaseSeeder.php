<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
			DB::table('users')->insert([
				'name' => 'name' . $i,
				'email' => $i . '@gmail.com',
				'password' => bcrypt('secret' . $i),
			]);
			
			DB::table('companies')->insert([
				'name' => 'name' . $i,
				'email' => '',
				'logo' => '',
				'website' => '',
				'user_id' => $i,
			]);
				
			for ($a = 0; $a < 3; $a++) {
				DB::table('assets')->insert([
					'description' => 'Description' . $a,
					'model' => 'ModelVersion' . $a,
					'value' => 233.34,
					'company_id' => $i,
				]);
			}
		}
    }
}
