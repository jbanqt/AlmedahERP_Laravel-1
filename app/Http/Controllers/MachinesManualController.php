<?php

namespace App\Http\Controllers;

use App\Models\MachinesManual;
use Illuminate\Http\Request;
use \App\Models\UserRole;
use Auth;
class MachinesManualController extends Controller
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
        $machines_manual = MachinesManual::all();
        return view('modules.BOM.machinemanual', ['machines_manuals' => $machines_manual,'permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('modules.BOM.newmachinemanual');
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
        if($request->hasfile('Machine_Image')){
            $imagePath = array();
            foreach($request->file('Machine_Image') as $file)
            {
                $name = $file->store('uploads', 'public');
                array_push($imagePath, $name);
            }
        }else{
            $imagePath = request('template_img');
        }

        $form_data = $request->input();
        $last_mm = MachinesManual::latest()->first();
        $next_id = $last_mm ? $last_mm->id + 1 : 1;
        $machine_code = "MM_";

        $machine_manual = new MachinesManual();

        $machine_name = $form_data['Machine_name'];
        $words = explode(' ', $machine_name);

        foreach ($words as $word) {
            $machine_code .= strtoupper($word[0]);
        }

        $machine_code .= "_" . str_pad($next_id, 3, "0", STR_PAD_LEFT);

        $machine_manual->machine_code = $machine_code;
        $machine_manual->machine_name = $machine_name;
        $machine_manual->machine_image = json_encode($imagePath);
        $machine_manual->machine_description = $form_data['Machine_Description'];
        $machine_manual->machine_process = $form_data['Machine_Process'];
        $machine_manual->setup_time = $form_data['Setup_time'];
        $machine_manual->running_time = $form_data['Running_time'];
        $machine_manual->save();
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
        return view('modules.BOM.machineinfo', ['manual' => MachinesManual::find($id)]);
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
        $machine_manual = MachinesManual::find($id);
        $form_data = $request->input();

        if($request->hasfile('Machine_Image')){
            $imagePath = array();
            foreach($request->file('Machine_Image') as $file)
            {
                $name = $file->store('uploads', 'public');
                array_push($imagePath, $name);
            }
            $machine_manual->machine_image = json_encode($imagePath);
        }

        $machine_name = $form_data['Machine_name'];
        $words = explode(' ', $machine_name);
        $machine_code = "MM_";
        foreach ($words as $word) {
            $machine_code .= strtoupper($word[0]);
        }
        $machine_manual->machine_code = $machine_code;
        $machine_manual->machine_name = $machine_name;
        $machine_manual->machine_description = $form_data['Machine_Description'];
        $machine_manual->machine_process = $form_data['Machine_Process'];
        $machine_manual->setup_time = $form_data['Setup_time'];
        $machine_manual->running_time = $form_data['Running_time'];
        $machine_manual->save();
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
        $machine_manual = MachinesManual::find($id);
        $machine_manual->delete();
    }

    public function getMachine($machine_code)
    {
        return ["machine" => MachinesManual::where('machine_code', $machine_code)->first()];
    }
}
