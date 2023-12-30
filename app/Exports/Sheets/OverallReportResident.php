<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OverallReportResident implements FromArray, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data->toArray();
    }

    public function headings(): array
    {
        return [
            [
                'No Transaksi',
                'tanggal',
                'Nama',
                'No.KK / No.Rumah',
                'Tipe Donasi',
                'Tipe Barang',
                '',
                'Deskripsi',
                'Status'
            ],
        ];
    }

    public function map($row): array
    {
        return [
            $row['id'],
            $row['created_at'],
            $row['donor']['name'],
            $row['donor']['donorable']['no_kk'] . ' / ' . $row['donor']['donorable']['house_number'],
            $row['donation_type']['name'],
            $row['good_type']['name'],
            '',
            $row['description'],
            $row['completed']
        ];
    }


}
