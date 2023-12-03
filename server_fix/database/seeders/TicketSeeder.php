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
                'MaSach' => 'BOK_01',
                'DateCreateTicket' => Carbon::now(),
                'DateAcceptTiket' => Carbon::now(),
                'DateGiveBack' => Carbon::now(),
                'StatusTicket' => '0',
                'Note' => 'OKOK',
            ],
            [
                'MaSV' => '112',
                'MaSach' => 'BOK_01',
                'DateCreateTicket' => Carbon::now(),
                'DateAcceptTiket' => Carbon::now(),
                'DateGiveBack' => Carbon::now(),
                'StatusTicket' => '0',
                'Note' => 'OKOK',
            ],
            [
                'MaSV' => '113',
                'MaSach' => 'BOK_01',
                'DateCreateTicket' => Carbon::now(),
                'DateAcceptTiket' => Carbon::now(),
                'DateGiveBack' => Carbon::now(),
                'StatusTicket' => '0',
                'Note' => 'OKOK',
            ],
            [
                'MaSV' => '114',
                'MaSach' => 'BOK_01',
                'DateCreateTicket' => Carbon::now(),
                'DateAcceptTiket' => Carbon::now(),
                'DateGiveBack' => Carbon::now(),
                'StatusTicket' => '0',
                'Note' => 'OKOK',
            ],
            [
                'MaSV' => '115',
                'MaSach' => 'BOK_01',
                'DateCreateTicket' => Carbon::now(),
                'DateAcceptTiket' => Carbon::now(),
                'DateGiveBack' => Carbon::now(),
                'StatusTicket' => '0',
                'Note' => 'OKOK',
            ],
            [
                'MaSV' => '116',
                'MaSach' => 'BOK_01',
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
