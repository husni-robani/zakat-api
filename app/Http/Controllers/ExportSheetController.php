<?php

namespace App\Http\Controllers;

use App\Exports\DonationTransactionReport;
use App\Exports\ReportFitrah;
use App\Exports\Sheets\GuestTransactionReport;
use App\Exports\Sheets\OverallReportResident;
use App\Models\DonationType;
use App\Models\Guest;
use App\Models\Resident;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ExportSheetController extends Controller
{
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
        return \Excel::download(new DonationTransactionReport(
            $residentTransactions,
            $guestTransactions,
            $donation_type_name,
            $request->get('year')),
            'laporan Zakat '.$donation_type_name . ' ' . $request->get('year') .'.xlsx'
        );
    }
}
