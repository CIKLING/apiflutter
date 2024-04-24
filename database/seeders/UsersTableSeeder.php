<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate random data for users
        $users = [];
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $users[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'), // Set default password 'password' (you can change this)
                'avatar' => $faker->imageUrl(),
                'nik' => $faker->numerify('##########'),
                'phone' => $faker->phoneNumber,
                'photo' => $faker->imageUrl(),
                'kec' => $faker->city,
                'kel' => $faker->streetName,
                'status' => $faker->randomElement(['active', 'inactive']),
                'token_user' => $faker->uuid,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Insert data into the database
        User::insert($users);
    }
}
