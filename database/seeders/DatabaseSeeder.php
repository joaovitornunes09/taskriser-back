<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Status;
use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name'      => 'admin',
            'email'     => 'admin@admin.com',
            'login'     => 'admin',
            'user_type' => 1,
            'password' => md5("admin"),
            'remember_token' => Str::random(10),
        ]);

        $status = ["Pending","
        In progress",  "Finished" ,"Delayed"];

        foreach ($status as $key => $value) {
            Status::factory()->create([
                "status" => $value
            ]);
        }

        $status = ["Admin", "Worker"];

        foreach ($status as $key => $value) {
            UserType::factory()->create([
                "type" => $value
            ]);
        }

    }
}
