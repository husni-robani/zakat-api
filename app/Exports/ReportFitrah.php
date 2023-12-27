<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportFitrah extends DefaultValueBinder implements FromArray, WithTitle, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    private array $residentTransactions;
    private array $guestTransactions;
    private array $guestHeader;
    private array $residentHeader;
    public function __construct(Collection $residentTransactions, Collection $guestTransactions)
    {
        $this->residentTransactions = $residentTransactions->map(function ($transaction){
            return [
                $transaction->created_at->format('Y-m-d'),
                $transaction->id,
                $transaction->donor->name,
                $transaction->donor->donorable->no_kk,
                $transaction->donor->donorable->house_number,
                $transaction->amount,
                $transaction->goodType->name,
                ($transaction->description == null ? '-' : $transaction->description),
                ($transaction->completed == 0 ? 'Belum Selesai' : 'Selesai')
            ];
        })->toArray();
        $this->guestTransactions = $guestTransactions->map(function ($transaction){
            return [
                $transaction->created_at->format('Y-m-d'),
                $transaction->id,
                $transaction->donor->name,
                $transaction->amount,
                $transaction->goodType->name,
                ($transaction->description == null ? '-' : $transaction->description),
                ($transaction->completed == 0 ? 'Belum Selesai' : 'Selesai')
            ];
        })->toArray();

        $this->residentHeader = [
            ['Resident'],
            ['tanggal', 'No.Transaksi', 'Nama', 'No.KK', 'No.Rumah', 'Jumlah (Rp/kg)', 'Tipe barang', 'Deskripsi', 'status'],
        ];

        $this->guestHeader = [
            ['Guest'],
            ['tanggal', 'No.Transaksi', 'Nama', 'Jumlah (Rp/kg)', 'Tipe barang', 'Deskripsi', 'status']
        ];
    }

    public function array(): array
    {

        return array_merge($this->residentHeader, $this->residentTransactions, $this->guestHeader, $this->guestTransactions);

    }


    public function title(): string
    {
        return 'Report Zakat Fitrah';
    }

    public function columnFormats(): array
    {
        return [
        ];
    }

    /**
     * @throws Exception
     */
    public function styles(Worksheet $sheet): void
    {
        $totalData = count(array_merge($this->residentHeader, $this->residentTransactions, $this->guestHeader, $this->guestTransactions));
        $rowTitleGuest = count($this->residentTransactions) + 3;
        // remove empty column
        for ($i = $totalData-1; $i <= 10; $i++){
            $sheet->getStyle('H' . $i)->getBorders()->applyFromArray([
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF']
                ]
            ]);
            $sheet->getStyle('I' . $i)->getBorders()->applyFromArray([
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'bottom' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF']
                ]
            ]);

        }

        // Merge
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A' . $rowTitleGuest . ':' . 'I' . $rowTitleGuest);

        // Header
        $sheet->getStyle('A2:I2')->getFont()->setBold(true);
        $sheet->getStyle('A' . $rowTitleGuest+1 . ':' . 'I' . $rowTitleGuest+1)->getFont()->setBold(true);


        // Title
        $sheet->getStyle('A1:I1')->applyFromArray([
            'font' => [
                'size' => 16,
                'color' => ['rgb' => '333333']
            ],
            'borders' => [
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'top' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF']
                ],
            ],
        ]);

        $sheet->getStyle('A' . $rowTitleGuest . ':' . 'I' . $rowTitleGuest)->applyFromArray([
            'font' => [
                'size' => 16,
                'color' => ['rgb' => '333333']
            ],
            'borders' => [
                'left' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF']
                ],
            ],
        ]);

    }


}
