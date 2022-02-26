<?php

namespace App\Http\Controllers;

use App\Models\PaymentInvoiceLog;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseReceipt;
use \App\Models\UserRole;
use Auth;
use Illuminate\Http\Request;
use Exception;

class PurchaseInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()){
            $role_id = Auth::user()->role_id;
            $user_role = UserRole::where('role_id', $role_id)->first();
            $permissions = json_decode($user_role->permissions, true);
        }else{
            $permissions = null;
        }
        //
        $purchase_invoice = PurchaseInvoice::get(
            ['id', 'p_invoice_id', 'date_created', 'p_receipt_id', 'total_amount_paid', 'grand_total', 'payment_balance', 'pi_status']
        );
        return view('modules.buying.purchaseinvoice', ['invoices' => $purchase_invoice, 'permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $receipts = PurchaseReceipt::where('pr_status', 'NOT LIKE', 'Draft')->get(
            ['id', 'p_receipt_id', 'date_created', 'purchase_id', 'grand_total']
        );
        return view('modules.buying.newPurchaseInvoice', ['receipts' => $receipts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {

            $form_data = $request->input();

            $data = new PurchaseInvoice();

            $lastInvoice = PurchaseInvoice::orderby('id', 'desc')->first();
            $nextId = ($lastInvoice) ? $lastInvoice->id + 1 : 1;

            $invoice_id = "PI-" . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            $data->p_invoice_id = $invoice_id;
            $data->p_receipt_id = $form_data['receipt_id'];
            $data->date_created = $form_data['date_created'];
            $data->payment_mode = $form_data['payment_mode'];
            $data->grand_total = $form_data['amount'];
            $data->payment_balance = $form_data['amount'];

            if (isset($form_data['installment_type'])) {
                $data->installment_type = $form_data['installment_type'];
            }

            $data->save();
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $invoice = PurchaseInvoice::with(['receipt', 'invoice_logs'])->find($id);
        $received_items = $invoice->receipt->order->itemsPurchased();
        $supplier = $invoice->receipt->order->supplier_quotation->supplier;
        $logs = $invoice->invoice_logs;
        return view(
            'modules.buying.purchaseInvoiceInfo',
            [
                'invoice' => $invoice,
                'received_items' => $received_items,
                'supplier' => $supplier,
                'logs' => $logs
            ]
        );
    }

    public function updateInvoice(Request $request)
    {
        try {

            $form_data = $request->input();

            $data = PurchaseInvoice::where('p_invoice_id', $form_data['invoice_id'])->first();

            $data->p_invoice_id = $form_data['invoice_id'];
            $data->date_created = $form_data['date_created'];
            $data->payment_mode = $form_data['payment_mode'];

            if (isset($form_data['installment_type'])) {
                $data->installment_type = $form_data['installment_type'];
            }

            $data->save();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function updateInvoiceStatus($id)
    {
        $invoice = PurchaseInvoice::where('p_invoice_id', $id)->first();
        $invoice->pi_status = "Unpaid";
        $invoice->save();
    }

    public function viewCheck($id)
    {
        return ['log' => PaymentInvoiceLog::find($id)];
    }

    //Generate ordinal numbers
    private function ordinal(int $number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        return (($number % 100) >= 11) && (($number % 100) <= 13) ? $number . 'th' : $number . $ends[$number % 10];
    }

    private function generateDescription(PurchaseInvoice $invoice, PaymentInvoiceLog $pi_log)
    {
        if ($invoice->payment_mode === 'Installment') {
            if (is_null($pi_log)) return "Downpayment";
            $all_data = PaymentInvoiceLog::where('p_invoice_id', $invoice->p_invoice_id)
                        ->where('payment_description', '!=', 'Downpayment');
            $current_count = $all_data->count() + 1;
            $ordinal_string = $this->ordinal($current_count);
            return strval($ordinal_string) . " Installment";
        } else {
            return "Fully Paid";
        }
    }

    public function payInvoice(Request $request)
    {
        //form data here
        $form_data = $request->input();
        $data = new PaymentInvoiceLog();
        
        if (strcmp($form_data['payment_method'], 'Cheque') == 0) {
            $validation = $request->validate([
                'account_no' => 'required',
                'cheque_no' => 'required',
                'bank_name' => 'required',
                'bank_location' => 'required'
            ]);
            $data->account_no = $form_data['account_no'];
            $data->cheque_no = $form_data['cheque_no'];
            $data->bank_name = $form_data['bank_name'];
            $data->bank_location = $form_data['bank_location'];
        }

        //get the corresponding invoice
        //try to find the last log corresponding to the invoice and then 
        //create a description
        $invoice = PurchaseInvoice::where('p_invoice_id', $form_data['invoice_id'])
            ->with(['receipt'])->first();

        $lastLog = PaymentInvoiceLog::orderby('id', 'desc')->first();
        $nextID = ($lastLog) ? $lastLog->id + 1 : 1;
        $description = $this->generateDescription($invoice, $lastLog);
        

        $pi_log_id = "PI-LOG-" . str_pad($nextID, 3, '0', STR_PAD_LEFT);
        $data->pi_logs_id = $pi_log_id;
        $data->p_invoice_id = $form_data['invoice_id'];
        $data->date_of_payment = $form_data['payment_date'];
        $data->payment_method = $form_data['payment_method'];
        $data->payment_description = $description;
        $data->amount_paid = $form_data['amount_paid'];
        $data->save();

        $new_price = $invoice->total_amount_paid + $form_data['amount_paid'];
        $new_balance = $invoice->payment_balance - $form_data['amount_paid'];
        $invoice->total_amount_paid = $new_price;
        $invoice->payment_balance = $new_balance;
        

        if ($description === 'Downpayment') {
            $invoice->grand_total = $new_balance;
            //$invoice->total_amount_paid = 0;
        }
        if ($new_price == $invoice->grand_total) {
            $new_status = "Paid";
            $receipt = $invoice->receipt;
            if ($receipt->pr_status === 'To Receive and Bill') {
                $new_pr_status = "To Receive";
            } else {
                $new_pr_status = "Completed";
                $receipt->order->supplier_quotation->archive();
            }
            $receipt->pr_status = $new_pr_status;
            $receipt->save();
            $order = $receipt->order;
            $order->mp_status = $new_pr_status;
            $order->save();
        } else {
            $new_status = "With Outstanding Balance";
        }

        $invoice->pi_status = $new_status;
        $invoice->save();

    }

}
