<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreatesuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email'=>'admin@gmail.com'],
            [
                'name'=>'admin',
                'password'=>Hash::make('123456'),
                'phone'=>'0612345678',
                'city'=>'benguerir',
                'address'=>'hay salam',
                'zip'=>'43150',
                'role'=>'ADMIN'
            ]
        );
    }
}
