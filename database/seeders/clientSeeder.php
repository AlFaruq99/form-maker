<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class clientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i=0; $i < 100; $i++) { 

            $user = User::create([
                'name' => $faker->name(),
                'email' => $faker->email(),
                'password' => Hash::make('client123')
            ]);

            Role::create(
                [
                    'user_id' => $user->id,
                    'level' => 'client'
                ]
            );

        }
    }
}
