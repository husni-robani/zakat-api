<?php

namespace App\Http\Controllers;

use App\Exports\ReportFitrah;
use App\Models\DonationType;
use App\Models\Donor;
use App\Models\Transaction;
use App\Services\TransactionReport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExportSheetController extends Controller
{
    public function exportFitrah(){
        $residentTransactions = Transaction::with('donor.donorable', 'donationType', 'goodType')
            ->whereHas('donationType', function (Builder $builder){
                $builder->where('name', 'FIDYAH');
            })
            ->whereHas('donor', function (Builder $builder){
                $builder->where('donorable_type', 'App\Models\Resident');
            })
            ->get();
        $guestTransactions = Transaction::with('donor.donorable', 'donationType', 'goodType')
            ->whereHas('donationType', function (Builder $builder){
                $builder->where('name', 'FIDYAH');
            })
            ->whereHas('donor', function (Builder $builder){
                $builder->where('donorable_type', 'App\Models\Guest');
            })
            ->get();


        return \Excel::download(new ReportFitrah($residentTransactions, $guestTransactions), 'report.xlsx');
    }
}
