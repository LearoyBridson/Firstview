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
				'name' => 'Name' . $i,
				'email' => 'user' . $i . '@gmail.com',
				'password' => bcrypt('secret' . $i),
			]);
		}
		
		for ($i = 0; $i < 10; $i++) {
			for ($x = 0; $x < 20; $x++) {
				DB::table('companies')->insert([
					'name' => 'CompanyName' . $i . $x,
					'email' => 'company' . $i . $x . '@gmail.com',
					'logo' => '',
					'website' => 'www.company' . $i . $x . '.com',
					'user_id' => $i,
				]);
			}
		}
		
		for ($x = 0; $x < 200; $x++) {
			for ($y = 0; $y < 20; $y++) {
				DB::table('assets')->insert([
					'description' => 'Detailed description ' . $x,
					'model' => 'model' . $x . $y,
					'value' => (1000) - $x,
					'company_id' => $x,
				]);
			}
		}
    }
}
