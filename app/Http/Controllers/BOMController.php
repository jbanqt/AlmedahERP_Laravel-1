<?php

namespace App\Http\Controllers;

use App\Models\BillOfMaterials;
use App\Models\Component;
use App\Models\ManufacturingMaterials;
use App\Models\ManufacturingProducts;
use App\Models\MaterialPurchased;
use App\Models\Routings;
use \App\Models\UserRole;
use Illuminate\Http\Request;
use Exception;
use Auth;
use Illuminate\Support\Facades\DB;


class BOMController extends Controller
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
        $bills_of_materials = BillOfMaterials::get(['bom_id', 'bom_name', 'product_code', 'component_code', 'is_active', 'is_default']);
        foreach ($bills_of_materials as $bom) {
            # code...
            $bom->item_code = is_null($bom->product_code) ? $bom->component_code : $bom->product_code;
        }
        return view('modules.BOM.bom', ['boms' => $bills_of_materials, 'permissions'=>$permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $man_prod = ManufacturingProducts::get(['product_code', 'product_name']);
        $components = Component::get(['component_code', 'component_name']);
        $routings = Routings::get(['routing_id', 'routing_name']);
        return view('modules.BOM.newbom', ['man_prods' => $man_prod, 'components' => $components, 'routings' => $routings]);
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
            $last_bom = BillOfMaterials::latest()->first();
            $next_id = $last_bom ? $last_bom->bom_id + 1 : 1;
            $bom_name = "BOM-"; //initialize "BOM-"

            $bom = new BillOfMaterials();

            $item_key = isset($form_data['product_code']) ? 'product_code' : 'component_code';
            $code = $form_data[$item_key];

            if (isset($form_data['product_code'])) {
                $bom->product_code = $code;
                $item = ManufacturingProducts::where('product_code', $code)->first();

            } else {
                $bom->component_code = $code;
                $item = Component::where('component_code', $code)->first();
            }

            $name = is_null($item->product_name) ? $item->component_name : $item->product_name;

            $bom_name .= $name . "-" . str_pad($next_id, 3, "0", STR_PAD_LEFT);

            $matching_boms = BillOfMaterials::where('product_code', $code)
                                            ->orWhere('component_code', $code)
                                            ->get();

            $is_default_boms = $matching_boms->where('is_default', 1)->first();

            $default_flag = false;

            if ($is_default_boms && $form_data['is_default'] == 1) {
                $is_default_boms->is_default = 0;
                $is_default_boms->is_active = 1;
                $is_default_boms->save();
                $default_flag = true;
            }

            $bom->routing_id = $form_data['routing_id'];
            $bom->raw_materials_rate = $form_data['rm_rates'];
            $bom->raw_material_cost = $form_data['rm_cost'];
            $bom->total_cost = $form_data['total_cost'];
            $bom->is_active = $form_data['is_active'];
            $bom->is_default = $form_data['is_default'];
            $bom->bom_name = $bom_name;

            $bom->save();

            if ($default_flag) {
                return ['message' => 'This will be the new default bill of materials for ' . $name . '. '];
            }
        } catch (Exception $e) {
            return $e;
        } //
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
        $bom = BillOfMaterials::find($id);
        $routing = $bom->routing;
        $item = ($bom->product != null) ? $bom->product : $bom->component;
        $routing_ops = $routing->operations();
        $rateList = $bom->rateList();
        $man_prod = ManufacturingProducts::get(['product_code', 'product_name']);
        $components = Component::get(['component_code', 'component_name']);
        $routings = Routings::get(['routing_id', 'routing_name']);
        return view(
            'modules.BOM.bominfo',
            [
                'bom' => $bom, 'routing' => $routing, 'item' => $item, 'routing_ops' => $routing_ops, 'rateList' => $rateList,
                'man_prods' => $man_prod, 'routings' => $routings, 'components' => $components
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        try {
            $bom = BillOfMaterials::find($id);
            $form_data = $request->input();

            $bom_name = "BOM-"; //initialize "BOM-"

            if (isset($form_data['product_code'])) {
                $bom->product_code = $form_data['product_code'];
                $code = $form_data['product_code'];
                $product = ManufacturingProducts::where('product_code', $form_data['product_code'])->first();
                $name = $product->product_name;
            } else {
                $bom->component_code = $form_data['component_code'];
                $code = $form_data['component_code'];
                $component = Component::where('component_code', $form_data['component_code'])->first();
                $name = $component->component_name;
            }

            $bom_name .= $name . "-" . str_pad($id, 3, "0", STR_PAD_LEFT);

            $matching_boms = BillOfMaterials::where('product_code', $code)->orWhere('component_code', $code)->get();

            $is_default_boms = $matching_boms->where('is_default', 1)->first();

            $default_flag = false;

            if ($is_default_boms && $form_data['is_default'] == 1) {
                $is_default_boms->is_default = 0;
                $is_default_boms->is_active = 1;
                $is_default_boms->save();
                $default_flag = true;
            }

            $bom->routing_id = $form_data['routing_id'];
            $bom->raw_materials_rate = $form_data['rm_rates'];
            $bom->raw_material_cost = $form_data['rm_cost'];
            $bom->total_cost = $form_data['total_cost'];
            $bom->is_active = $form_data['is_active'];
            $bom->is_default = $form_data['is_default'];
            $bom->bom_name = $bom_name;

            $bom->save();

            if ($default_flag) {
                return ['message' => 'This will be the new default bill of materials for ' . $name . '. '];
            }
        } catch (Exception $e) {
            return $e;
        } //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $bills_of_materials = BillOfMaterials::find($id);
        $bills_of_materials->delete();
    }

    public function getItem($item_type, $value)
    {
        try {
            $item = null;
            if ($item_type === 'product') {
                $item = ManufacturingProducts::where('product_code', $value)->first();
            } else {
                $item = Component::where('component_code', $value)->first();
            }
            $item_mats = $item->materials();
            $items_and_rates = array();
            foreach ($item_mats as $material) {
                $item_code = $material['material']->item_code;
                $p_order = MaterialPurchased::where('items_list_purchased', 'LIKE', "%{$item_code}%")->first();
                if ($p_order != null) {
                    $po_items = $p_order->productsAndRates($item_code, $value);
                }
                //dd(DB::getQueryLog());
                else {
                    $raw_mat = ManufacturingMaterials::where('item_code', $material['material']->item_code)->first();
                    $po_items = array(
                        'item_code' => $material['material']->item_code,
                        'item' => $raw_mat,
                        'uom' => $raw_mat->uom,
                        'req_date' => date('Y-m-d'),
                        'qty' => $material['qty'],
                        'rate' => 1,
                        'subtotal' => $material['qty']
                    );
                }
                array_push($items_and_rates, $po_items);
            }
            return ["item" => $item, 'materials_info' => $items_and_rates];
        } catch (Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ]);
        }
    }

}
