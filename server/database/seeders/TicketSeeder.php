<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ticket = [
            [
                'MaSV' => '111',
                'MaAdmin' => '111',
                'MaSach' => '111',
                'DateCreateTicket' => Carbon::now(),
                'DateAcceptTiket' => Carbon::now(),
                'DateGiveBack' => Carbon::now(),
                'StatusTicket' => '0',
                'Note' => 'OKOK',
            ],
            [
                'MaSV' => '112',
                'MaAdmin' => '112',
                'MaSach' => '112',
                'DateCreateTicket' => Carbon::now(),
                'DateAcceptTiket' => Carbon::now(),
                'DateGiveBack' => Carbon::now(),
                'StatusTicket' => '0',
                'Note' => 'OKOK',
            ],
            [
                'MaSV' => '113',
                'MaAdmin' => '113',
                'MaSach' => '113',
                'DateCreateTicket' => Carbon::now(),
                'DateAcceptTiket' => Carbon::now(),
                'DateGiveBack' => Carbon::now(),
                'StatusTicket' => '0',
                'Note' => 'OKOK',
            ],
            [
                'MaSV' => '114',
                'MaAdmin' => '114',
                'MaSach' => '114',
                'DateCreateTicket' => Carbon::now(),
                'DateAcceptTiket' => Carbon::now(),
                'DateGiveBack' => Carbon::now(),
                'StatusTicket' => '0',
                'Note' => 'OKOK',
            ],
            [
                'MaSV' => '115',
                'MaAdmin' => '115',
                'MaSach' => '115',
                'DateCreateTicket' => Carbon::now(),
                'DateAcceptTiket' => Carbon::now(),
                'DateGiveBack' => Carbon::now(),
                'StatusTicket' => '0',
                'Note' => 'OKOK',
            ],
            [
                'MaSV' => '116',
                'MaAdmin' => '116',
                'MaSach' => '116',
                'DateCreateTicket' => Carbon::now(),
                'DateAcceptTiket' => Carbon::now(),
                'DateGiveBack' => Carbon::now(),
                'StatusTicket' => '0',
                'Note' => 'OKOK',
            ],
        ];
        foreach ($ticket as $ticketValue) {
            Ticket::create(array(
                'MaSV' => $ticketValue['MaSV'],
                'MaAdmin' => $ticketValue['MaAdmin'],
                'MaSach' => $ticketValue['MaSach'],
                'DateCreateTicket' => $ticketValue['DateCreateTicket'],
                'DateAcceptTiket' => $ticketValue['DateAcceptTiket'],
                'DateGiveBack' => $ticketValue['DateGiveBack'],
                'StatusTicket' => $ticketValue['StatusTicket'],
                'Note' => $ticketValue['Note'],
            ));
        }
    }
}
