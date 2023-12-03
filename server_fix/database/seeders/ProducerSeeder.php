<?php

namespace Database\Seeders;

use App\Models\Producer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProducerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $producer = [
            [
                'NameNXB' => 'A',
                'AddressNXB' => 'DaNang',
                'Note' => 'OKOK',
            ],
            [
                'NameNXB' => 'B',
                'AddressNXB' => 'DaNang',
                'Note' => 'OKOK',
            ],
            [
                'NameNXB' => 'C',
                'AddressNXB' => 'DaNang',
                'Note' => 'OKOK',
            ],
            [
                'NameNXB' => 'D',
                'AddressNXB' => 'DaNang',
                'Note' => 'OKOK',
            ],
            [
                'NameNXB' => 'E',
                'AddressNXB' => 'DaNang',
                'Note' => 'OKOK',
            ],
            [
                'NameNXB' => 'F',
                'AddressNXB' => 'DaNang',
                'Note' => 'OKOK',
            ],
        ];
        foreach ($producer as $producerValue) {
            Producer::create(array(
                'NameNXB' => $producerValue['NameNXB'],
                'AddressNXB' => $producerValue['AddressNXB'],
                'Note' => $producerValue['Note'],
            ));
        }
    }
}
