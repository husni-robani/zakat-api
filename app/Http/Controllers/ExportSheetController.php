<?php

namespace App\Http\Controllers;

use App\Exports\DonationTransactionsReport;
use App\Exports\ReportFitrah;
use App\Exports\Sheets\OverallReportResident;
use App\Models\DonationType;
use App\Models\Donor;
use App\Models\Guest;
use App\Models\Resident;
use App\Models\Transaction;
use App\Services\TransactionReport;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExportSheetController extends Controller
{
    public function overallReport(){
        $residentData = Transaction::with('donor.donorable', 'donationType', 'goodType')
            ->whereHas('donor', function (Builder $builder){
                $builder->where('donorable_type', 'App\Models\Resident');
            })
            ->get();
//        return $residentData;
        return \Excel::download(new OverallReportResident($residentData), 'resident.xlsx');
    }

    public function fidyahReport(){
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

    public function donationReport(Request $request){
        $guestTransactions = Transaction::with('donor.donorable', 'donationType', 'goodType')
            ->whereYear('updated_at', '=', $request->get('year'))
            ->where('donation_types_id', $request->get('donation_type_id'))
            ->whereHas('donor', function (Builder $builder){
            $builder->where('donorable_type', Guest::class);
        })->get();
        $residentTransactions = Transaction::with('donor.donorable', 'donationType', 'goodType')
            ->whereYear('updated_at', '=', $request->get('year'))
            ->where('donation_types_id', $request->get('donation_type_id'))
            ->whereHas('donor', function (Builder $builder){
                $builder->where('donorable_type', Resident::class);
            })->get();
        $donation_type_name = DonationType::find($request->get('donation_type_id'))->name;
        return \Excel::download(new DonationTransactionsReport($residentTransactions,
            $guestTransactions,
            $donation_type_name,
            $request->get('year')),
            'laporan '.$donation_type_name . ' ' . $request->get('year') .'.xlsx' );
    }
}
