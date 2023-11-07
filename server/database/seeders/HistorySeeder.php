<?php

namespace Database\Seeders;

use App\Models\History;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $history = [
            [
                'MaSV' => '111',
                'MaSach' => '111',
                'DateDownload' => Carbon::now(),
            ],
            [
                'MaSV' => '112',
                'MaSach' => '112',
                'DateDownload' => Carbon::now(),
            ],
            [
                'MaSV' => '113',
                'MaSach' => '113',
                'DateDownload' => Carbon::now(),
            ],
            [
                'MaSV' => '114',
                'MaSach' => '114',
                'DateDownload' => Carbon::now(),
            ],
            [
                'MaSV' => '115',
                'MaSach' => '115',
                'DateDownload' => Carbon::now(),
            ],
            [
                'MaSV' => '116',
                'MaSach' => '116',
                'DateDownload' => Carbon::now(),
            ],
        ];
        foreach ($history as $historyValue) {
            History::create(array(
                'MaSV' => $historyValue['MaSV'],
                'MaSach' => $historyValue['MaSach'],
                'DateDownload' => $historyValue['DateDownload'],
            ));
        }
    }
}
