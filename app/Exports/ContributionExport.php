<?php

namespace App\Exports;

use App\Models\Contribution;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContributionExport implements FromCollection, WithMapping
{
    public function headings(): array
    {
        return [
            ['Fecha de aporte'],
            ['Estudiante'],
            ['Descripcion'],
            ['Monto'],
            ['Descripcion'],
            ['Periodo'],
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Contribution::exportAllContributions();
    }


}