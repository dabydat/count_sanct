<?php

namespace App\Exports;

use App\Models\Contribution;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\{WithHeadings, WithMapping, FromCollection, Exportable, ShouldAutoSize, WithEvents, WithCustomStartCell, FromView};
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;

class ContributionExport implements
    FromView,
    ShouldAutoSize,
    // WithMapping, 
    // WithHeadings, 
    WithEvents
// WithCustomStartCell

{
    use Exportable;
    // private $contributions;

    // /**
    //  * Export constructor
    //  * @param Collection $contributions
    //  */
    // public function __construct(Collection $contributions)
    // {
    //     $this->contributions = $contributions;
    // }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Contribution::exportAllContributions();
    }

    public function view(): View
    {
        return view('exports.contributions', [
            'contributions' => Contribution::exportAllContributions(),
            'categories' => Category::all(),
            'categoriesCount' => Category::countAllCategories()
        ]);
    }

    // public function headings(): array
    // {
    //     return [
    //         ['Fecha de aporte', ['dia 1', 'dia 2']],
    //         // ['Categoria'],
    //         // ['Monto'],
    //         // ['Descripcion'],
    //         // ['Periodo'],
    //         // 'Fecha de aporte',
    //         // 'Estudiante',
    //         // 'Categoria',
    //         // 'Monto',
    //         // 'Descripcion',
    //         // 'Periodo',
    //     ];
    // }

    // public function map($contribution): array
    // {
    //     return [
    //         $contribution->contribution_date,
    //         $contribution->student->name . ' ' . $contribution->student->last_name,
    //         $contribution->category->description,
    //         $contribution->amount,
    //         $contribution->description,
    //         $contribution->period->description,
    //     ];
    // }

    public function registerEvents(): array
    {
        return [
                AfterSheet::class => function (AfterSheet $event) {
                    $event->sheet->getStyle('A1:F1')->applyFromArray([
                        'font' => [
                            'bold' => true
                        ]
                    ]);
                },
        ];
    }
// public function startCell(): string
// {
//     return 'A8';
// }
}