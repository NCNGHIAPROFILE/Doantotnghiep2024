<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = [
            [
                'NameAdmin' => 'A',
                'AddressAdmin' => 'DaNang',
                'Phone' => '0123456789',
                'email' => 'a@gmail.com',
                'password' => Hash::make('123456789'),
                'ImageAdmin' => 'NULL'
            ],
            [
                'NameAdmin' => 'B',
                'AddressAdmin' => 'DaNang',
                'Phone' => '0123456789',
                'email' => 'b@gmail.com',
                'password' => Hash::make('123456789'),
                'ImageAdmin' => 'NULL'
            ],
            [
                'NameAdmin' => 'C',
                'AddressAdmin' => 'DaNang',
                'Phone' => '0123456789',
                'email' => 'c@gmail.com',
                'password' => Hash::make('123456789'),
                'ImageAdmin' => 'NULL'
            ],
            [
                'NameAdmin' => 'D',
                'AddressAdmin' => 'DaNang',
                'Phone' => '0123456789',
                'email' => 'd@gmail.com',
                'password' => Hash::make('123456789'),
                'ImageAdmin' => 'NULL'
            ],
            [
                'NameAdmin' => 'E',
                'AddressAdmin' => 'DaNang',
                'Phone' => '0123456789',
                'email' => 'e@gmail.com',
                'password' => Hash::make('123456789'),
                'ImageAdmin' => 'NULL'
            ],
            [
                'NameAdmin' => 'F',
                'AddressAdmin' => 'DaNang',
                'Phone' => '0123456789',
                'email' => 'f@gmail.com',
                'password' => Hash::make('123456789'),
                'ImageAdmin' => 'NULL'
            ]
        ];
        foreach ($admin as $adminValue) {
            Admin::create(array(
                'NameAdmin' => $adminValue['NameAdmin'],
                'AddressAdmin' => $adminValue['AddressAdmin'],
                'Phone' => $adminValue['Phone'],
                'email' => $adminValue['email'],
                'password' => $adminValue['password'],
                'ImageAdmin' => $adminValue['ImageAdmin'],
            ));
        }
    }
}
