<?php

namespace App\Exports;

use App\Models\PrintCard;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PrintingExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $printing = PrintCard::whereNotNull('card_code')
            ->whereNull('confirm_status')
            ->with('printing')
            ->get();

        $list = [];

        foreach ($printing as $card) {
          
            $list[] = [
                $card->customer_name,
                $card->card_code, // Assuming you want to export the customer phone
            ];
        }

        // Return as a collection
        return collect($list);
    }

    public function headings(): array
    {
        return [
            'Card Name',
            'Card Code',
        ];
    }
}
