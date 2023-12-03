<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            'MaSV' => '1',
            'FistNameUser' => 'Nguyễn Văn',
            'LastNameUser' => 'A',
            'Class' => 'D.A.U',
            'AddressUser' => 'Đại học Kiến trúc Đà Nẵng',
            'Phone' => '0816988288',
            'email' => 'admin@dau.edu.vn',
            'password' => Hash::make('123456789'),
            'ImageUser' => 'NULL',
            'role' => 'admin'
        ]);
        // $user = [
        //     [
        //         'MaSV' => '111',
        //         'FistNameUser' => 'Nguyễn Chính',
        //         'LastNameUser' => 'Nghĩa',
        //         'Class' => '19CT3',
        //         'AddressUser' => 'DaNang',
        //         'Phone' => '123456789',
        //         'email' => 'a@gmail.com',
        //         'password' => Hash::make('123456789'),
        //         'ImageUser' => 'NULL',
        //     ],
        //     [
        //         'MaSV' => '112',
        //         'FistNameUser' => 'Nguyễn Chính',
        //         'LastNameUser' => 'Nghĩa',
        //         'Class' => '19CT2',
        //         'AddressUser' => 'DaNang',
        //         'Phone' => '123456789',
        //         'email' => 'b@gmail.com',
        //         'password' => Hash::make('123456789'),
        //         'ImageUser' => 'NULL',
        //     ],
        //     [
        //         'MaSV' => '113',
        //         'FistNameUser' => 'Nguyễn Chính',
        //         'LastNameUser' => 'Nghĩa',
        //         'Class' => '19CT1',
        //         'AddressUser' => 'DaNang',
        //         'Phone' => '123456789',
        //         'email' => 'c@gmail.com',
        //         'password' => Hash::make('123456789'),
        //         'ImageUser' => 'NULL',
        //     ],
        //     [
        //         'MaSV' => '114',
        //         'FistNameUser' => 'Nguyễn Chính',
        //         'LastNameUser' => 'Nghĩa',
        //         'Class' => '19CT3',
        //         'AddressUser' => 'DaNang',
        //         'Phone' => '123456789',
        //         'email' => 'd@gmail.com',
        //         'password' => Hash::make('123456789'),
        //         'ImageUser' => 'NULL',
        //     ],
        //     [
        //         'MaSV' => '115',
        //         'FistNameUser' => 'Nguyễn Chính',
        //         'LastNameUser' => 'Nghĩa',
        //         'Class' => '19CT3',
        //         'AddressUser' => 'DaNang',
        //         'Phone' => '123456789',
        //         'email' => 'e@gmail.com',
        //         'password' => Hash::make('123456789'),
        //         'ImageUser' => 'NULL',
        //     ],
        //     [
        //         'MaSV' => '116',
        //         'FistNameUser' => 'Nguyễn Chính',
        //         'LastNameUser' => 'Nghĩa',
        //         'Class' => '19CT3',
        //         'AddressUser' => 'DaNang',
        //         'Phone' => '123456789',
        //         'email' => 'f@gmail.com',
        //         'password' => Hash::make('123456789'),
        //         'ImageUser' => 'NULL',
        //     ],
        // ];
        // foreach ($user as $userValue) {
        //     User::create(array(
        //         'MaSV' => $userValue['MaSV'],
        //         'FistNameUser' => $userValue['FistNameUser'],
        //         'LastNameUser' => $userValue['LastNameUser'],
        //         'Class' => $userValue['Class'],
        //         'AddressUser' => $userValue['AddressUser'],
        //         'Phone' => $userValue['Phone'],
        //         'email' => $userValue['email'],
        //         'password' => $userValue['password'],
        //         'ImageUser' => $userValue['ImageUser'],
        //     ));
        // }
    }
}
