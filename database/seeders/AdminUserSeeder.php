<?php

namespace Database\Seeders;
use App\Models\Admin;
use Illuminate\Support\Str;

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => "Gaurav Sharma",
            'email' => "admin@admin.com",
            'password' => bcrypt('112233'),
            'phone' => "9971695047",
            'about' => "InfoIcon Technologies",
            'status' => 1,
            'address' => "Noida, UP, India",
            'uuid' => Str::uuid('admin@admin.com'),
        ]);
    }
}
