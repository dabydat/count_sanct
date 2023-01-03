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
    WithEvents
{
    use Exportable;
    protected $period_id;
    function __construct($period_id)
    {
        $this->period_id = $period_id;
    }
    public function view(): View
    {
        return view('exports.contributions', [
            'contributions' => Contribution::exportAllContributions($this->period_id),
            'categories' => Category::all(),
            'categoriesCount' => Category::countAllCategories()
        ]);
    }
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
}