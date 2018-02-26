<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //有顺序之分
        $this->call(UsersTableSeeder::class);
		$this->call(TopicsTableSeeder::class);
        $this->call(ReplysTableSeeder::class);
    }
}
