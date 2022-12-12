<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use Dompdf\Dompdf;
use \Carbon\Carbon;


class BillController extends Controller
{
    public function view()
    {
        return view('dashboard.bills.view');
    }

    public function monthly_generate(Request $request)
    {
        $StartDate = Carbon::createFromDate($request->year, $request->month)->startOfMonth()->format('Y-m-d');
        $EndDate = Carbon::createFromDate($request->year, $request->month)->endOfMonth()->format('Y-m-d');

        if (empty($request->vehicle_id)) {
            $trips = Trip::whereBetween('date',[ $StartDate, $EndDate])->get();
        }else{
            $trips = Trip::whereBetween('date',[ $StartDate, $EndDate])->where('vehicle_id', $request->vehicle_id)->get();
        }

        $avatarUrl = public_path('/assets/images/footer-logo.png');
        $arrContextOptions=array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );

        $type = pathinfo($avatarUrl, PATHINFO_EXTENSION);
        $avatarData = file_get_contents($avatarUrl, false, stream_context_create($arrContextOptions));
        $avatarBase64Data = base64_encode($avatarData);
        $base64 = 'data:image/' . $type . ';base64,' . $avatarBase64Data;

        $html = view('pdf.bill_pdf', compact('trips','base64'));

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browse
        $dompdf->stream('invoice.pdf',array(
            'Attachment' => 0
        ));
    }

    public function monthly_range_generate(Request $request)
    {
        $StartDate = Carbon::createFromDate($request->year, $request->starting_month)->startOfMonth()->format('Y-m-d');
        $EndDate = Carbon::createFromDate($request->year, $request->ending_month)->endOfMonth()->format('Y-m-d');

        if (empty($request->vehicle_id)) {
            $trips = Trip::whereBetween('date',[ $StartDate, $EndDate])->get();
        }else{
            $trips = Trip::whereBetween('date',[ $StartDate, $EndDate])->where('vehicle_id', $request->vehicle_id)->get();
        }
        
        $avatarUrl = public_path('/assets/images/footer-logo.png');
        $arrContextOptions=array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );

        $type = pathinfo($avatarUrl, PATHINFO_EXTENSION);
        $avatarData = file_get_contents($avatarUrl, false, stream_context_create($arrContextOptions));
        $avatarBase64Data = base64_encode($avatarData);
        $base64 = 'data:image/' . $type . ';base64,' . $avatarBase64Data;

        $html = view('pdf.bill_pdf', compact('trips','base64'));

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browse
        $dompdf->stream('invoice.pdf',array(
            'Attachment' => 0
        ));
    }

    public function date_range_generate(Request $request)
    {
        if (empty($request->vehicle_id)) {
            $trips = Trip::whereBetween('date',[$request->starting_date, $request->ending_date])->get();
        }else{
            $trips = Trip::whereBetween('date',[$request->starting_date, $request->ending_date])->where('vehicle_id', $request->vehicle_id)->get();
        }
        
        $avatarUrl = public_path('/assets/images/footer-logo.png');
        $arrContextOptions=array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );

        $type = pathinfo($avatarUrl, PATHINFO_EXTENSION);
        $avatarData = file_get_contents($avatarUrl, false, stream_context_create($arrContextOptions));
        $avatarBase64Data = base64_encode($avatarData);
        $base64 = 'data:image/' . $type . ';base64,' . $avatarBase64Data;

        $html = view('pdf.bill_pdf', compact('trips','base64'));

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browse
        $dompdf->stream('invoice.pdf',array(
            'Attachment' => 0
        ));
    }

}