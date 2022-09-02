<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Models\Employee;
use App\Models\RFQ;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use App\Models\Item;
use App\Models\Activity;
use App\Models\Tender;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all 70% and 2 days deadlines, update PO statuses and send emails.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $seventy_percent = PurchaseOrder::where('status', 'Confirmed')->where('seventy_percent', Carbon::now()->toDateString())->get();
        $two_days = PurchaseOrder::where('status', 'Confirmed')->where('two_days', Carbon::now()->toDateString())->get();
        $after_one = PurchaseOrder::where('status', 'Confirmed')->where('after_one', Carbon::now()->toDateString())->get();
        $invoice_paid = PurchaseOrder::where('status', 'Delivered')->where('etp', Carbon::now()->subDay()->toDateString())->get();

        $tender_date = Tender::where('status', '!=', 'Completed')->where('date', Carbon::now()->subDay()->toDateString())->get();
        $activity_complete_date = Activity::whereIn('status', ['In-Progress', 'Scheduled'] )->where('date', Carbon::now()->subDay()->toDateString())->get();

        $rfq_status = RFQ::where('status', 'Pending')->where('date', Carbon::now()->subDay()->toDateString())->get();

        foreach($seventy_percent as $purchase_order){
            $email = $purchase_order->employee->user->email;
            $rfq_no = $purchase_order->rfq->rfq_no;
            $name = $purchase_order->employee->first_name.' '.$purchase_order->employee->last_name;

            $purchase_order->status = "ETD - 70%";
            $purchase_order->save();


            $data = array( 'email' => $email,
                        'name' => $name, 
                        'rfq_no' => $rfq_no, 
                        'purchase_order' => $purchase_order);
                            
            Mail::send('emails.seventy_percent', $data,
            function($message) use($data){
                $message->to($data['email'], $data['name'])
                ->subject('PO EDD Validity Check | '.$data['purchase_order']->po_no);
                $message->from('donotreply@kudon.com','Kudon Engineering');
            });
        }

        foreach($two_days as $purchase_order){
            $email = $purchase_order->employee->user->email;
            $rfq_no = $purchase_order->rfq->rfq_no;
            $name = $purchase_order->employee->first_name.' '.$purchase_order->employee->last_name;
            
            $purchase_order->status = "ETD - 2 Days";
            $purchase_order->save();

            $data = array( 'email' => $email,
            'name' => $name, 
            'rfq_no' => $rfq_no, 
            'purchase_order' => $purchase_order);
                
            Mail::send('emails.two_days', $data,
            function($message) use($data){
                $message->to($data['email'], $data['name'])
                ->subject('PO EDD Validity Check | '.$data['purchase_order']->po_no);
                $message->from('donotreply@kudon.com','Kudon Engineering');
            });
        }

        foreach($after_one as $purchase_order){
            $email = $purchase_order->employee->user->email;
            $rfq_no = $purchase_order->rfq->rfq_no;
            $name = $purchase_order->employee->first_name.' '.$purchase_order->employee->last_name;

            $purchase_order->status = "ETD - Passed";
            $purchase_order->save();


            $data = array( 'email' => $email,
                        'name' => $name, 
                        'rfq_no' => $rfq_no, 
                        'purchase_order' => $purchase_order);
                            
            Mail::send('emails.etd_passed', $data,
            function($message) use($data){
                $message->to($data['email'], $data['name'])
                ->subject('Purchase Order ETD Passed');
                $message->from('donotreply@kudon.com','Kudon Engineering');
            });
        }

        foreach($invoice_paid as $purchase_order){
            $email = $purchase_order->employee->user->email;
            $rfq_no = $purchase_order->rfq->rfq_no;
            $name = $purchase_order->employee->first_name.' '.$purchase_order->employee->last_name;
            
            $purchase_order->status = "ETP - Passed";
            $purchase_order->save();

            $data = array( 'email' => $email,
            'name' => $name, 
            'rfq_no' => $rfq_no, 
            'purchase_order' => $purchase_order);
                
            Mail::send('emails.invoice_paid', $data,
            function($message) use($data){
                $message->to($data['email'], $data['name'])
                ->subject('Invoice Payment Confirmation'.' | '. $data['purchase_order']->invoice_no);
                $message->from('donotreply@kudon.com','Kudon Engineering');
            });
        }

        foreach($rfq_status as $rfq){
            $rfq->status = 'Incomplete';
            $rfq->save();
        }

        foreach($activity_complete_date as $activity){
            $activity->status = 'Over-due';
            $activity->save();
        }

        foreach($tender_date as $tender){
            $tender->status = 'Incomplete';
            $tender->save();
        }
        
        $this->info('Notifications sent to PO Owners with upcoming deadlines and PO statuses changed.');
    }
}
