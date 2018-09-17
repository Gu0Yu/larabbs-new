<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ActivitiesExport implements FromCollection
{
    public function collection()
    {
        return Activity::all();
    }
}