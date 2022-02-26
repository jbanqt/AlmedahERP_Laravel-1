<?php

namespace App\Http\Controllers;

use App\Models\MaterialsOrdered;
use App\Models\MaterialPurchased;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseReceipt;
use App\Models\WorkOrder;
use \App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use DB;
use Auth;

class PurchaseReceiptController extends Controller
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
        $purchase_receipts = PurchaseReceipt::get(
            ['id','p_receipt_id', 'date_created', 'purchase_id', 'grand_total', 'pr_status']);
        return view('modules.buying.purchasereceipt', ['receipts' => $purchase_receipts, 'permissions'=> $permissions]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $orders = MaterialPurchased::where('mp_status', 'To Receive and Bill')->get([
            'id','purchase_id', 'purchase_date'
        ]);
        return view('modules.buying.newPurchaseReceipt', ['orders' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $form_data = $request->input();

            $data = new PurchaseReceipt();

            $lastReceipt = PurchaseReceipt::orderby('id', 'desc')->first();
            $nextId = ($lastReceipt) ? $lastReceipt->id + 1 : 1;

            $receipt_id = "PR-" . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            $data->p_receipt_id = $receipt_id;
            $data->date_created = $form_data['date_created'];
            $data->purchase_id = $form_data['purchase_id'];
            $data->item_list_received = $form_data['items_received'];
            $data->grand_total = $form_data['grand_total'];

            $data->save();

            //create purchase invoice after purchase receipt

            $p_invoice = new PurchaseInvoice();

            $lastInvoice = PurchaseInvoice::orderby('id', 'desc')->first();
            $nextId = ($lastInvoice) ? $lastInvoice->id + 1 : 1;

            $invoice_id = "PI-" . str_pad($nextId, 3, '0', STR_PAD_LEFT);

            $p_invoice->p_invoice_id = $invoice_id;
            $p_invoice->p_receipt_id = $receipt_id;
            $p_invoice->date_created = date('Y-m-d');
            $p_invoice->payment_mode = 'Cash';
            $p_invoice->grand_total = $form_data['grand_total'];
            $p_invoice->payment_balance = $form_data['grand_total'];

            $p_invoice->save();
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
        $receipt = PurchaseReceipt::find($id);
        $orders = MaterialPurchased::where('mp_status', 'To Receive and Bill')
                                    ->with('supplier_quotation')
                                    ->get();
        $materials = $receipt->receivedMats();
        $mat_purchased = $receipt->order;
        $supplier = $mat_purchased->supplier_quotation->supplier;
        return view('modules.buying.purchasereceiptinfo', 
        ['receipt' => $receipt, 'materials' => $materials, 'orders' => $orders, 'supplier' => $supplier]);
    }

    public function updateReceipt(Request $request)
    {
        try {
            $form_data = $request->input();

            $data = PurchaseReceipt::where('p_receipt_id', $form_data['receipt_id'])->first();

            $data->date_created = $form_data['date_created'];
            $data->purchase_id = $form_data['purchase_id'];
            $data->item_list_received = $form_data['items_received'];
            $data->grand_total = $form_data['grand_total'];

            $data->save();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function getOrderedMaterials($id)
    {
        try {
            $mat_purchased = MaterialPurchased::with('supplier_quotation')->find($id);
            $supplier = $mat_purchased->supplier_quotation->supplier;
            $ordered_mats = $mat_purchased->itemsPurchased();
            return ['ordered_mats' => $ordered_mats, 
                    'purchase_id' => $mat_purchased->purchase_id, 
                    'supplier' => $supplier];
        } catch (Exception $e) {
            return $e;
        }
    }

    public function getReceivedMats($id)
    {
        try {
            $receipt = PurchaseReceipt::with('order')->find($id);
            $receipt_id = $receipt->p_receipt_id;
            $supplier = $receipt->order->supplier_quotation->supplier;
            $received_mats = $receipt->receivedMats();
            return ['p_receipt_id' => $receipt_id, 
                    'received_mats' => $received_mats, 
                    'supplier' => $supplier];
        } catch (Exception $e) {
            return $e;
        }
    }

    public function getOrderedMaterialsFromInvoice($receipt_id)
    {
        try {
            $receipt = PurchaseReceipt::with('order')->find($receipt_id);
            $mat_purchased = $receipt->order;
            $supplier = $mat_purchased->supplier_quotation->supplier;
            $ordered_mats = $mat_purchased->itemsPurchased();
            return ['ordered_mats' => $ordered_mats, 
                    'p_receipt_id' => $receipt->p_receipt_id, 
                    'supplier' => $supplier];
        } catch (Exception $e) {
            return $e;
        }
    }

    public function changeStatus($receipt_id)
    {
        try {
            $receipt = PurchaseReceipt::where('p_receipt_id', $receipt_id)->first();

            $receipt->pr_status = "To Receive and Bill";
            $receipt->save();

            $lastMatOrder = MaterialsOrdered::orderby('id', 'desc')->first();
            $nextOrderId = ($lastMatOrder) ? $lastMatOrder->id + 1 : 1;
            $mo_id = "MAT-ORD-" . str_pad($nextOrderId, 3, '0', STR_PAD_LEFT);

            $pending_item_list = array();
            $items = $receipt->receivedMats();
            foreach ($items as $item) {
                array_push(
                    $pending_item_list,
                    array(
                        'item_code' => $item['item_code'],
                        'qty_received' => '0',
                        'item_condition' => 'New'
                    )
                );
            }

            $mat_order = new MaterialsOrdered();
            $mat_order->mat_ordered_id = $mo_id;
            $mat_order->p_receipt_id = $receipt->p_receipt_id;
            $mat_order->items_list_received = json_encode($pending_item_list);
            $mat_order->save();

            /* 
            Below is the connection established from Materials Purchased going to Work Order
            in order to assign a materials_ordered_id to the Work Order table. The materials_ordered_id
            is used for getting the raw material quantity for the Work Order table.
            */

            $work_order_no = $receipt->order->supplier_quotation->req_quotation->material_request->work_order_no;

            foreach(json_decode($work_order_no, true) as $w){
                $work_order = WorkOrder::where('id', $w)->first();
                if(empty($work_order->mat_ordered_id)){
                    WorkOrder::where('id', $w)->update(['mat_ordered_id' => $mo_id]);
                }
            }
            return response($work_order_no);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function addReceivedMats(Request $request)
    {
        try {
            $form_data = $request->input();

            $receipt = PurchaseReceipt::where('p_receipt_id', $form_data['receipt_id'])
                        ->with(['order', 'invoice', 'order_record'])
                        ->first();
            $received_mats = json_decode($form_data['mat_received'], true);
            $receipt_mats = json_decode($receipt->item_list_received, true);

            $i = 1;

            foreach ($receipt_mats as $key => $mat) {
                $curr_quantity = intval($receipt_mats[$key]['qty_received']) - intval($received_mats[$i]['qty_received']);
                $receipt_mats[$key]['qty_received'] = strval($curr_quantity);
                $receipt_mats[$key]['amount'] = strval($curr_quantity * intval($receipt_mats[$key]['rate']));
                $i++;
            }

            $receipt->item_list_received = json_encode($receipt_mats);
            $receipt->save();

            $i = 1;

            $pending_order = $receipt->order_record;
            $order_items = json_decode($pending_order->items_list_received, true);
            
            foreach ($order_items as $index => $order_item) {
                $new_qty = intval($order_items[$index]['qty_received']) + intval($received_mats[$i]['qty_received']);
                $order_items[$index]['qty_received'] = strval($new_qty);
                $i++;
            }
            
            $pending_order->items_list_received = json_encode($order_items);
            $pending_order->save();

            $pending_order = $receipt->order_record;
            $pending_order_items = $pending_order->items_list();
            $is_complete = true;

            foreach($pending_order_items as $item) {
                if($item['curr_progress'] != '100') {
                    $is_complete = !$is_complete;
                    break;
                }
            } 

            if($is_complete) {
                $pending_order->mo_status = 'Completed';
                $pending_order->save();
                $invoice = $receipt->invoice;
                if($invoice) {
                    $new_status = ($invoice->pi_status === 'Paid') ? 'Completed' : 'To Bill';
                    if($invoice->pi_status === 'Paid'){
                        $receipt->order->supplier_quotation->archive();
                    }
                } else {
                    $new_status = 'To Bill';
                }
                $order = $receipt->order;
                $order->mp_status =$new_status;
                $order->save();
                $receipt->pr_status = $new_status;
                $receipt->save();
            } 

        } catch (Exception $e) {
            return $e;
        }
    }
}
