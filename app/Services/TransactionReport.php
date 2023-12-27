<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TransactionReport
{
    private Collection $transactions;

    public function __construct()
    {
        $this->transactions = Transaction::with('donor.donorable', 'goodType', 'donationType')->get();
    }


    public function allTransactions(): Collection
    {
        return $this->transactions;
    }

    public function fitrahResidentTransactions(){
        return Transaction::with([
            'goodType',
            'donationType' => function(Builder $query){
                $query->where('name', 'FITRAH');
            },
            'donor'
        ])->get();
    }
}
