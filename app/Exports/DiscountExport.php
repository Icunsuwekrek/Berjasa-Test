<?php

namespace App\Exports;

use App\Models\Discount;
use Maatwebsite\Excel\Concerns\FromCollection;

class DiscountExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Discount::all();
    }
}
