<?php

namespace App\Imports;

use App\Models\user;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class UserImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function headingRow(): int
    {
        return 1;
    }
    public function model(array $row)
    {
        $masv = $row['ma_sinh_vien'] ?? null;
        $fistnameuser = $row['ho'] ?? null;
        $lastnameuser = $row['ten'] ?? null;
        $class = $row['lop'] ?? null;
        $addressuser = $row['dia_chi'] ?? null;
        $phone = $row['sdt'] ?? null;
        $email = $row['email'] ?? null;

        if ($masv && $fistnameuser && $lastnameuser && $class && $addressuser && $phone && $email) {
            return new User([
                'MaSV' => $masv,
                'FistNameUser' => $fistnameuser,
                'LastNameUser' => $lastnameuser,
                'Class' => $class,
                'AddressUser' => $addressuser,
                'Phone' => $phone,
                'email' => $email,
                'password' => Hash::make('123456789'),
                'ImageUser' => '1700892153.jpg',
                'role' => 'user'
            ]);
        }

        return null;
    }
}
