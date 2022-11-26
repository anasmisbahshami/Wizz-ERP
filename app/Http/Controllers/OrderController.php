<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use Dompdf\Dompdf;
use Storage;

class OrderController extends Controller
{
    public function view()
    {
        if (\Auth::user()->hasRole('User')) {
            //Arranging User Orders
            $Unconfirmed = Order::where('user_id', \Auth::id())->where('status','Unconfirmed')->orderBy('id','DESC')->get();
            $Confirmed = Order::where('user_id', \Auth::id())->where('status','Confirmed')->orderBy('id','DESC')->get();
            $Unpaid = Order::where('user_id', \Auth::id())->where('status','Unpaid')->orderBy('id','DESC')->get();
            $Paid = Order::where('user_id', \Auth::id())->where('status','Paid')->orderBy('id','DESC')->get();
            $Started = Order::where('user_id', \Auth::id())->where('status','Started')->orderBy('id','DESC')->get();
            $In_progress = Order::where('user_id', \Auth::id())->where('status','In progress')->orderBy('id','DESC')->get();
            $Complete = Order::where('user_id', \Auth::id())->where('status','Complete')->orderBy('id','DESC')->get();

            $orders = $Unconfirmed->merge($Confirmed);
            $orders = $orders->merge($Unpaid);
            $orders = $orders->merge($Paid);
            $orders = $orders->merge($Started);
            $orders = $orders->merge($In_progress);
            $orders = $orders->merge($Complete);
        }else{
            //Arranging User Orders
            $Unconfirmed = Order::where('status','Unconfirmed')->orderBy('id','DESC')->get();
            $Confirmed = Order::where('status','Confirmed')->orderBy('id','DESC')->get();
            $Unpaid = Order::where('status','Unpaid')->orderBy('id','DESC')->get();
            $Paid = Order::where('status','Paid')->orderBy('id','DESC')->get();
            $Started = Order::where('status','Started')->orderBy('id','DESC')->get();
            $In_progress = Order::where('status','In progress')->orderBy('id','DESC')->get();
            $Complete = Order::where('status','Complete')->orderBy('id','DESC')->get();

            $orders = $Unconfirmed->merge($Confirmed);
            $orders = $orders->merge($Unpaid);
            $orders = $orders->merge($Paid);
            $orders = $orders->merge($Started);
            $orders = $orders->merge($In_progress);
            $orders = $orders->merge($Complete);
        }
        return view('dashboard.order.view', compact('orders'));
    }

    public function destroy_order($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);
        foreach ($order->items as $item) {
            $item->delete();
        }
        $order->delete();
        return redirect()->back()->with('success', 'Order Deleted Successfully!');
    }

    public function view_order_details($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);
        return view('dashboard.order.view_details', compact('order'));
    }

    public function download_paid_invoice($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);
        return Storage::download($order->paid_invoice);
    }
    
    public function edit_order_details($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);
        return view('dashboard.order.edit_details', compact('order'));
    }

    public function order_paid(Request $request, $id)
    {
        $id = decrypt($id);
        $order = Order::find($id);

        //Paid Invoice Slip Upload
        $uploadedFile = $request->file('file');
        $filename = 'W-'.$order->id.'.'.$uploadedFile->extension();
        $filepath = 'files/order/paid_invoices/'.$filename;
  
        Storage::disk('local')->putFileAs(
          'files/order/paid_invoices/',
          $uploadedFile,
          $filename
        );

        $order->status = "Paid";
        $order->notify_paid = '1';
        $order->paid_invoice = $filepath;
        $order->save();

        return redirect()->back()->with('success', 'Order Marked as Paid');
    }

    public function order_start($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);
        $order->status = "Started";
        $order->notify_paid = '0';
        $order->notify_start = '1';
        $order->tracking_code = random_int(1000000000, 99999999999);
        $order->save();

        $data = array('email' => $order->user->email,'name' => $order->user->name, 'order' => $order);

        Mail::send('emails.order_start', $data,
        function($message) use($data){
        $message->to($data['email'], $data['name'])
        ->subject('Order Started | W-'.$data['order']->id)
        ->from('donotreply@wizz-express.com','Wizz Express & Logistics');
        });

        return redirect()->back()->with('success', 'Order Marked as Started!');
    }

    public function order_in_progress($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);
        $order->status = "In progress";
        $order->notify_in_progress = '1';
        $order->notify_start = '0';
        $order->save();

        $data = array('email' => $order->user->email,'name' => $order->user->name, 'order' => $order);

        Mail::send('emails.order_in_progress', $data,
        function($message) use($data){
        $message->to($data['email'], $data['name'])
        ->subject('Order In Progress | W-'.$data['order']->id)
        ->from('donotreply@wizz-express.com','Wizz Express & Logistics');
        });

        return redirect()->back()->with('success', 'Order Marked as In progress!');
    }

    public function order_complete($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);
        $order->status = "Complete";
        $order->notify_complete = '1';
        $order->notify_in_progress = '0';
        $order->save();

        $data = array('email' => $order->user->email,'name' => $order->user->name, 'order' => $order);

        Mail::send('emails.order_complete', $data,
        function($message) use($data){
        $message->to($data['email'], $data['name'])
        ->subject('Order Completed | W-'.$data['order']->id)
        ->from('donotreply@wizz-express.com','Wizz Express & Logistics');
        });

        return redirect()->back()->with('success', 'Order Marked as Completed!');
    }

    public function acknowledge_order($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);

        if(\Auth::user()->hasRole('User')){
            $order->notify_start = '0';
            $order->notify_in_progress = '0';
            $order->notify_complete = '0';
        }else{
            $order->notify_paid = '0';
        }

        $order->save();

        return redirect()->back()->with('success', 'Order Acknowledged!');
    }
    
    public function download_invoice($id)
    {
        $id = decrypt($id);
        $order = Order::find($id);

        //Order Invoice Generation (Logo)
        $avatarUrl = public_path('/assets/images/logo.png');
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

        //Dimension Invoice
        $avatarUrl1 = public_path('/assets/images/dimension.png');
        $arrContextOptions1=array(
                        "ssl"=>array(
                            "verify_peer"=>false,
                            "verify_peer_name"=>false,
                        ),
                    );
        $type1 = pathinfo($avatarUrl1, PATHINFO_EXTENSION);
        $avatarData1 = file_get_contents($avatarUrl1, false, stream_context_create($arrContextOptions1));
        $avatarBase64Data1 = base64_encode($avatarData1);
        $base641 = 'data:image/' . $type1 . ';base64,' . $avatarBase64Data1;

        $html = view('pdf.order_invoice', compact('base64', 'base641','order'));

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('letter', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browse
        $dompdf->stream('W-'.$order->id.'-Invoice.pdf',array(
            'Attachment' => 0
        ));
    }
}