<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LotteryUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 10; $i++) {
            $cnt = rand(1,10);
            $numbers = [];
            for($j = 0; $j<$cnt; $j++){
                array_push($numbers, strval(rand(1000,9999)));
            }
            $numbersString = join(",", $numbers);
            DB::table('lottery_users')->insert([
                "name"=> $faker->name,
                "numbers"=> $numbersString,
                "created_at"=> Carbon::now(),
                "updated_at"=> Carbon::now(),
            ]);
        }

    }
}
