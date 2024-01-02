<?php

namespace App\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ResidentTransactionsReport implements FromView, WithTitle, ShouldAutoSize, WithStyles
{
    protected Collection $residentTransactions;
    protected string $donationType;
    protected string $year;
    public function __construct(Collection $residentTransactions, $donationType, $year)
    {
        $this->residentTransactions = $residentTransactions;
        $this->donationType = $donationType;
        $this->year = $year;
    }

    public function view(): View
    {
        return \view('sheets.resident_transactions_report', [
            'residentTransactions' => $this->residentTransactions,
        ]);
    }

    public function title(): string
    {
        return 'Warga DKM Riyadhul Jannah';
    }

    public function styles(Worksheet $sheet)
    {
        $totalData = $this->residentTransactions->count();
        //Alignment
            //alignment for header
        $sheet->getStyle('A2:J2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:J2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A3:J3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            //alignment for data cell
        $sheet->getStyle('A4:A' . ($totalData+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B4:B' . ($totalData+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C4:C' . ($totalData+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D4:D' . ($totalData+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('E4:E' . ($totalData+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('F4:F' . ($totalData+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('G4:G' . ($totalData+4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('H4:H' . ($totalData+4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('I4:I' . ($totalData+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('J4:J' . ($totalData+3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);


        //bold
        $sheet->getStyle('A2:J2')->getFont()->setBold(true);
        $sheet->getStyle('A3:J3')->getFont()->setBold(true);
        //rupiah format
        $sheet->getStyle('G4:G' . ($totalData+4))->getNumberFormat()->setFormatCode('Rp #,##0');
        //background and font coloring
        $sheet->getStyle('A1:J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:J2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A3:J3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('J3:J' . ($totalData+3))->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('f7f7f7');
        $sheet->getStyle('A2:J2')->getFill()->getStartColor()->setARGB('4795bf');
        $sheet->getStyle('A3:J3')->getFill()->getStartColor()->setARGB('4795bf');
        $sheet->getStyle('A2:J2')->getFont()->setColor(new Color('FFFFFF'));
        $sheet->getStyle('A3:J3')->getFont()->setColor((new Color('FFFFFF')));
        $sheet->getStyle('J3:J' . ($totalData+3))->getFont()->setBold(true);
        $counter = 1;
        $this->residentTransactions->each(function ($transaction) use (&$counter, $sheet){

            $transaction->completed ? $sheet->getStyle('J' . ($counter+3))->getFont()->setColor((new Color('33cc33'))) : $sheet->getStyle('J' . ($counter+3))->getFont()->setColor((new Color('ff471a')));
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
        $sheet->getStyle('H2:H' . ($totalData+4))->applyFromArray($borderStyle);
        $sheet->getStyle('I2:I' . ($totalData+4))->applyFromArray($borderStyle);
        $sheet->getStyle('J2:J' . ($totalData+4))->applyFromArray($borderStyle);

        //style for Total
        $sheet->getStyle('A' . ($totalData+4) . ':J' . ($totalData+4))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($totalData+4) . ':J' . ($totalData+4))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($totalData+4) . ':J' . ($totalData+4))->getFill()->setFillType(Fill::FILL_SOLID);
        $sheet->getStyle('A' . ($totalData+4) . ':J' . ($totalData+4))->getFill()->getStartColor()->setARGB('edf4f8');
    }


}
