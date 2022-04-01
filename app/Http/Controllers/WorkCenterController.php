<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\MachinesManual;
use App\Models\WorkCenter;
use Exception;
use Illuminate\Http\Request;

class WorkCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $wc = WorkCenter::get(['id', 'wc_code', 'wc_label', 'wc_type']);
        return view('modules.BOM.workcentertable', ['work_centers' => $wc]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return $this->returnCreateForm('native');
    }

    public function routingCreateForm() {
        return $this->returnCreateForm('routing');
    }

    private function returnCreateForm($source_path) {
        $destination = $source_path == 'native' ? 'createworkcenter' : 'newWorkCenter';
        $machines_manual = MachinesManual::all();
        $employees = Employee::all();
        return view("modules.BOM.$destination", ['machines_manuals' => $machines_manual, 'employees' => $employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form_data = $request->input();
        $last_wc = WorkCenter::latest()->first();
        $next_id = $last_wc ? $last_wc->id + 1 : 1; //duplicate checker || Current ID + 1
        $wc_code = "MOUNT-"; //initialize prefix "mount-"

        $work_center = new WorkCenter(); //inserting all the necessary data/value needed

        $wc_label = $form_data['wc_label'];
        $words = explode(' ', $wc_label);
        //$wc_code .= strtoupper($words[0]); //get wc_label first word

        $wc_code .= strtoupper($words[0]). "-" . str_pad($next_id, 3, "0", STR_PAD_LEFT);

        $wc_type = $form_data['wc_type'];
        $duration = $form_data["duration"];


        $work_center->wc_code = $wc_code;
        $work_center->wc_label = $wc_label;
        $work_center->wc_type = $wc_type;
        $work_center->duration = $duration;
        $work_center->production_capacity = $form_data['prod_cost'];
        $work_center->electricity_cost = $form_data['elec_cost'];
        $work_center->consumable_cost = $form_data['con_cost'];
        $work_center->rent_cost = $form_data['rent_cost'];
        $work_center->wages = $form_data['wages'];
        $work_center->hour_rate = $form_data['hour_rate'];

        if(isset($form_data['employee_id_set'])){ //checks if theres employee ID
            $work_center->employee_id_set = $form_data['employee_id_set'];
        }
        if(isset($form_data['machine_code'])){ //checks if theres machine_code
            $work_center->machine_code = $form_data['machine_code'];
        }

        $work_center->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkCenter  $workCenter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $wc = WorkCenter::find($id);
        $machine = $wc->machine_manual;
        $employees = Employee::all();
        $machines_manual = MachinesManual::all();
        return view('modules.BOM.editworkcenter',
                    ['wc' => $wc, 'machine' => $machine, 'employees' => $employees, 'machines_manuals' => $machines_manual]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkCenter  $workCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $form_data = $request->input();
        $wc_type = $form_data['wc_type'];
        $duration = $form_data["duration"];

        $work_center = WorkCenter::find($id); //inserting all the necessary data/value needed
        $work_center->wc_type = $wc_type;
        $work_center->duration = $duration;
        $work_center->production_capacity = $form_data['prod_cost'];
        $work_center->electricity_cost = $form_data['elec_cost'];
        $work_center->consumable_cost = $form_data['con_cost'];
        $work_center->rent_cost = $form_data['rent_cost'];
        $work_center->wages = $form_data['wages'];
        $work_center->hour_rate = $form_data['hour_rate'];

        if(isset($form_data['employee_id_set'])){ //checks if theres employee ID
            $work_center->employee_id_set = $form_data['employee_id_set'];
        }
        if(isset($form_data['machine_code'])){ //checks if theres machine_code
            $work_center->machine_code = $form_data['machine_code'];
        }

        $work_center->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkCenter  $workCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try{
            $wc = WorkCenter::find($id);
            $wc->delete();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
