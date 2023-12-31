<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class DonationTransactionsReport implements FromView, WithTitle, ShouldAutoSize
{
    protected Collection $residentTransactions;
    protected Collection $guestTransactions;
    protected string $donationType;
    protected string $year;
    public function __construct(Collection $residentTransactions, Collection $guestTransactions, $donationType, $year)
    {
        $this->residentTransactions = $residentTransactions;
        $this->guestTransactions = $guestTransactions;
        $this->donationType = $donationType;
        $this->year = $year;
    }

    public function view(): View
    {
        return \view('sheets.donation_report', [
            'residentTransactions' => $this->residentTransactions,
            'guestsTransactions' => $this->guestTransactions
        ]);
    }

    public function title(): string
    {
        return 'Laporan Zakat ' . $this->donationType . ' ' . $this->year;
    }


}
