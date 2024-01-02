<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuestTransactionReport implements FromView, WithTitle, ShouldAutoSize, WithStyles
{
    protected Collection $guestTransactions;
    protected string $donationType;
    protected string $year;

    public function __construct(Collection $guestTransactions, $donationType, $year)
    {
        $this->guestTransactions = $guestTransactions;
        $this->donationType = $donationType;
        $this->year = $year;
    }


    public function view(): View
    {
        return \view('sheets.guest_transactions_report', [
            'guestTransactions' => $this->guestTransactions,
        ]);
    }

    public function title(): string
    {
        return 'Tamu';
    }

    public function styles(Worksheet $sheet): void
    {
        $totalData = $this->guestTransactions->count();
        //Alignment
        //alignment for header
        $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:H2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        //alignment for data cell
        $sheet->getStyle('A4:A' . ($totalData+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B4:B' . ($totalData+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C4:C' . ($totalData+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D4:D' . ($totalData+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('E4:E' . ($totalData+4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F4:F' . ($totalData+4))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('G4:G' . ($totalData+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('H4:H' . ($totalData+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);


        //bold
        $sheet->getStyle('A2:H2')->getFont()->setBold(true);
        $sheet->getStyle('A3:H3')->getFont()->setBold(true);
        //rupiah format
        $sheet->getStyle('E4:E' . ($totalData+4))->getNumberFormat()->setFormatCode('Rp #,##0');
        //background and font coloring
        $sheet->getStyle('A1:H1')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A2:H2')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A3:H3')->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('J3:H' . ($totalData+3))->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A1:H1')->getFill()->getStartColor()->setARGB('f7f7f7');
        $sheet->getStyle('A2:H2')->getFill()->getStartColor()->setARGB('4795bf');
        $sheet->getStyle('A3:H3')->getFill()->getStartColor()->setARGB('4795bf');
        $sheet->getStyle('A2:H2')->getFont()->setColor(new Color('FFFFFF'));
        $sheet->getStyle('A3:H3')->getFont()->setColor((new Color('FFFFFF')));
        $sheet->getStyle('H3:H' . ($totalData+3))->getFont()->setBold(true);
        $counter = 1;
        $this->guestTransactions->each(function ($transaction) use (&$counter, $sheet){

            $transaction->completed ? $sheet->getStyle('H' . ($counter+3))->getFont()->setColor((new Color('33cc33'))) : $sheet->getStyle('H' . ($counter+3))->getFont()->setColor((new Color('ff471a')));
            $counter ++;
        });

        //border
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ],
            ],
        ];
        $sheet->getStyle('A2:A' . ($totalData+4))->applyFromArray($borderStyle);
        $sheet->getStyle('B2:B' . ($totalData+4))->applyFromArray($borderStyle);
        $sheet->getStyle('C2:C' . ($totalData+4))->applyFromArray($borderStyle);
        $sheet->getStyle('D2:D' . ($totalData+4))->applyFromArray($borderStyle);
        $sheet->getStyle('E2:E' . ($totalData+4))->applyFromArray($borderStyle);
        $sheet->getStyle('F2:F' . ($totalData+4))->applyFromArray($borderStyle);
        $sheet->getStyle('G2:G' . ($totalData+4))->applyFromArray($borderStyle);
        $sheet->getStyle('H2:G' . ($totalData+4))->applyFromArray($borderStyle);

        //style for Total
        $sheet->getStyle('A' . ($totalData+4) . ':H' . ($totalData+4))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($totalData+4) . ':H' . ($totalData+4))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($totalData+4) . ':H' . ($totalData+4))->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A' . ($totalData+4) . ':H' . ($totalData+4))->getFill()->getStartColor()->setARGB('edf4f8');

    }


}
