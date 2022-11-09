<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker= Faker::create();

        for ($i=1;$i<=10;$i++){
            $user = new User();
            $user->name=$faker->name;
            $user->email=$faker->email;
            $user->password=$faker->password;
            $user->remember_token=$faker->realText(14);
            $user->role_id=2;
            $user->is_active=1;
            $user->save();
        }
    }
}
