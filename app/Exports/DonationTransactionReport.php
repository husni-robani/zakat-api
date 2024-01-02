<?php

namespace App\Exports;

use App\Exports\Sheets\GuestTransactionReport;
use App\Exports\Sheets\ResidentTransactionsReport;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DonationTransactionReport implements WithMultipleSheets
{
    protected Collection $residentTransactions;
    protected Collection $guestTransaction;
    protected string $donationType;
    protected string $year;
    public function __construct(Collection $residentTransactions, Collection $guestTransaction, $donationType, $year)
    {
        $this->residentTransactions = $residentTransactions;
        $this->guestTransaction = $guestTransaction;
        $this->donationType = $donationType;
        $this->year = $year;
    }

    public function sheets(): array
    {
        return [
            new ResidentTransactionsReport($this->residentTransactions, $this->donationType, $this->year),
            new GuestTransactionReport($this->guestTransaction, $this->donationType, $this->year)
        ];
    }

}
