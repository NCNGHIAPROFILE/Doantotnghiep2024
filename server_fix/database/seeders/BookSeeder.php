<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $book = [
            [
                'NameBook' => 'A',
                'Author' => 'Nghia',
                'MaAdmin' => '1',
                'Category' => 'Cười',
                'Type' => '0',
                'MaProducer' => '1',
                'YearPublish' => Carbon::now(),
                'Quantity' => '4',
                'Content' => 'hello word',
                'Status' => '0',
                'Picture' => 'NULL',
                'Sum_Quantity' => '10'
            ],
            [
                'NameBook' => 'B',
                'Author' => 'Nghia',
                'MaAdmin' => '1',
                'Category' => 'Cười',
                'Type' => '0',
                'MaProducer' => '1',
                'YearPublish' => Carbon::now(),
                'Quantity' => '4',
                'Content' => 'hello word',
                'Status' => '0',
                'Picture' => 'NULL',
                'Sum_Quantity' => '10'
            ],
            [
                'NameBook' => 'C',
                'Author' => 'Nghia',
                'MaAdmin' => '1',
                'Category' => 'Cười',
                'Type' => '0',
                'MaProducer' => '1',
                'YearPublish' => Carbon::now(),
                'Quantity' => '4',
                'Content' => 'hello word',
                'Status' => '0',
                'Picture' => 'NULL',
                'Sum_Quantity' => '10'
            ],
            [
                'NameBook' => 'D',
                'Author' => 'Nghia',
                'MaAdmin' => '1',
                'Category' => 'Cười',
                'Type' => '0',
                'MaProducer' => '1',
                'YearPublish' => Carbon::now(),
                'Quantity' => '4',
                'Content' => 'hello word',
                'Status' => '0',
                'Picture' => 'NULL',
                'Sum_Quantity' => '10'
            ],
            [
                'NameBook' => 'E',
                'Author' => 'Nghia',
                'MaAdmin' => '1',
                'Category' => 'Cười',
                'Type' => '0',
                'MaProducer' => '1',
                'YearPublish' => Carbon::now(),
                'Quantity' => '4',
                'Content' => 'hello word',
                'Status' => '0',
                'Picture' => 'NULL',
                'Sum_Quantity' => '10'
            ],
            [
                'NameBook' => 'F',
                'Author' => 'Nghia',
                'MaAdmin' => '1',
                'Category' => 'Cười',
                'Type' => '0',
                'MaProducer' => '1',
                'YearPublish' => Carbon::now(),
                'Quantity' => '4',
                'Content' => 'hello word',
                'Status' => '0',
                'Picture' => 'NULL',
                'Sum_Quantity' => '10'
            ]
        ];
        foreach ($book as $bookValue) {
            Book::create(array(
                'NameBook' => $bookValue['NameBook'],
                'Author' => $bookValue['Author'],
                'MaAdmin' => $bookValue['MaAdmin'],
                'Category' => $bookValue['Category'],
                'Type' => $bookValue['Type'],
                'MaProducer' => $bookValue['MaProducer'],
                'YearPublish' => $bookValue['YearPublish'],
                'Quantity' => $bookValue['Quantity'],
                'Content' => $bookValue['Content'],
                'Status' => $bookValue['Status'],
                'Picture' => $bookValue['Picture'],
                'Sum_Quantity' => $bookValue['Sum_Quantity'],
            ));
        }
    }
}
