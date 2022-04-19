<?php

namespace App\Http\Controllers;

use App\Models\Operation;
use App\Models\RoutingOperation;
use App\Models\Routings;
use App\Models\WorkCenter;
use \App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Auth;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Foreach_;

class RoutingsController extends Controller
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

        $routings = Routings::get(['id', 'routing_name', 'created_at']);
        return view('modules.BOM.routing', ['routings' => $routings, 'permissions'=> $permissions]);
    }

    public function view($id)
    {
        $routing = Routings::find($id);
        $operations = Operation::get(['id', 'operation_id', 'operation_name']);
        $routing_operation = $routing->operations();
        $work_centers = WorkCenter::all();
        return view('modules.BOM.editrouting', ['route' => $routing,'routing_operations' => $routing_operation,
                                                'work_centers' => $work_centers, 'operations' => $operations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $operations = Operation::get(['id', 'operation_id', 'operation_name']);
        $work_centers = WorkCenter::all();
        return view('modules.BOM.newrouting', ['operations' => $operations, 'work_centers' => $work_centers]);
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
            $routing = new Routings();
            $last_routing = Routings::latest()->first();
            $form_data = $request->input();
            $next_id = $last_routing ? $last_routing->id + 1 : 1;
            $routing_id = "RT" . str_pad($next_id, 5, '0', STR_PAD_LEFT);
            $routing->routing_id = $routing_id;
            $routing->routing_name = $form_data['Routing_Name'];
            $routing->save();
            $routing = Routings::where('routing_id', $routing_id)->first();

            $routing_ops = json_decode($form_data['routing_operations']);
            foreach ($routing_ops as $r_ops) {
                $hour_rate = $r_ops->hour_rate;
                $op_time = $r_ops->operation_time;
                $r_operation = new RoutingOperation();
                $r_operation->sequence_id = $r_ops->seq_id;
                $r_operation->operation_id = $r_ops->operation;
                $r_operation->routing_id = $routing_id;
                $r_operation->hour_rate = $hour_rate;
                $r_operation->operation_time = $op_time;
                $r_operation->operating_cost = floatval($hour_rate) * floatval($op_time);
                $r_operation->save();
            }

        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Routings  $routings
     * @return \Illuminate\Http\Response
     */
    public function show(Routings $routings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Routings  $routings
     * @return \Illuminate\Http\Response
     */
    public function edit(Routings $routings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Routings  $routings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Routings $routings)
    {
        //
        try {
            $form_data = $request->input();
            $routing = Routings::find($routings->id);
            $routing->routing_name = $form_data['Routing_Name'];
            $routing->save();

            $routing_ops = json_decode($form_data['routing_operations']);

            DB::table('routings_operations')->where('routing_id', $routing->routing_id)->delete();

            foreach ($routing_ops as $r_ops) {
                $hour_rate = $r_ops->hour_rate;
                $op_time = $r_ops->operation_time;
                $r_operation = new RoutingOperation();
                $r_operation->sequence_id = $r_ops->seq_id;
                $r_operation->operation_id = $r_ops->operation;
                $r_operation->routing_id = $routings->routing_id;
                $r_operation->hour_rate = $hour_rate;
                $r_operation->operation_time = $op_time;
                $r_operation->operating_cost = floatval($hour_rate) * floatval($op_time);
                $r_operation->save();
            }
        } catch (Exception $e) {
            return $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Routings  $routings
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $routing = Routings::find($id);
        $routing->delete();
    }

    public function getOperations($routing_id) {
        $routing = Routings::where('routing_id', $routing_id)->first();
        $operations = $routing->operations();
        return ['operations' => $operations];
    }

}
