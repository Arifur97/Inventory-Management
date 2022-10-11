<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\workflow_setup;
use App\FormName;
use App\Roles;
use App\Biller;
use App\Warehouse;
use App\CustomerGroup;
use App\Customer;
use App\Designation;
use App\WorkflowSetup;
use App\WorkflowSetupStage;
use DB;
use Auth;
use Hash;
use Keygen;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class WorkflowSetupController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('users-index')){
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            $lims_workflow_list = WorkflowSetup::with('formname', 'user')->orderBy('id', 'desc')->get();;
            $lims_form_list = FormName::all();
            return view('workflow_setup.index', compact('lims_workflow_list','lims_form_list', 'all_permission'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('users-add')){
            $lims_role_list = Roles::where('is_active', true)->get();
            $lims_form_list = FormName::all();
            $lims_user_list = User::where('is_active', true)->get();
            $lims_designation_list = Designation::where('is_active', true)->get();
            return view('workflow_setup.create', compact('lims_role_list', 'lims_form_list', 'lims_user_list', 'lims_designation_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }


    public function store(Request $request)
    {
        $workflowFormNameExist = WorkflowSetup::where('form_id', '=', $request->form_id)->get();
        if(sizeof($workflowFormNameExist) == 0) {
            $data = $request->except('document');
            $data['user_id'] = Auth::id();
            WorkflowSetup::create($data);

            $lims_purchase_data = WorkflowSetup::latest()->first();
            // $product_id = $data['product_id'];
            $stage = $data['stage'];
            $designation = $data['designation'];
            $user_id = $data['user_id'];

            $product_purchase = [];
            foreach($request->stage as $key => $li) {
                $product_purchase[$key]['workflow_setup_id'] = $lims_purchase_data->id;
                $product_purchase[$key]['stage'] = $request->stage[$key];
                $product_purchase[$key]['designation_id'] = $request->designation[$key];
                $product_purchase[$key]['created_at'] = Carbon::now()->toDateTimeString();
                $product_purchase[$key]['updated_at'] = Carbon::now()->toDateTimeString();
                $product_purchase[$key]['user_id'] = $request->user_id[$key];
            }
            WorkflowSetupStage::insert($product_purchase);

            return redirect('workflow')->with('message', 'Workflow created successfully');
        } else {
            return redirect()->back()->with('message', 'Form name already exist');
        }
    }


    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('users-edit')){
            $lims_role_list = Roles::where('is_active', true)->get();
            $lims_form_list = FormName::all();
            $lims_user_list = User::where('is_active', true)->get();
            $lims_designation_list = Designation::where('is_active', true)->get();
            $lims_workflow_data = WorkflowSetup::find($id);
            $lims_workflow_stage_data = WorkflowSetupStage::where('workflow_setup_id', $id)->get();
            // return response()->json($lims_workflow_data);
            return view('workflow_setup.edit', compact('lims_role_list','lims_workflow_data', 'lims_workflow_stage_data', 'lims_form_list', 'lims_user_list', 'lims_designation_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function getWorkflowStageData($id) {
        $workflow_stage_data = WorkflowSetupStage::where('workflow_setup_id', $id)
            ->join('designations', 'designations.id', '=', 'workflow_setup_stages.designation_id')
            ->leftJoin('users', 'users.id', '=', 'workflow_setup_stages.user_id')
            ->select(
                DB::raw("(case when users.name is null then 'None' else users.name end) as name"),
                'designations.designation_name',
                'workflow_setup_stages.*'
            )
            ->get();
        return response()->json($workflow_stage_data);
    }


    public function update(Request $request, $id)
    {
        $workflow_setup = WorkflowSetup::where('id', '=', $id)->first();
        $data = $request->except('document');
        $data['user_id'] = Auth::id();
        $workflow_setup->update($data);

        WorkflowSetupStage::where('workflow_setup_id', '=', $id)->delete();

        $product_purchase = [];
        foreach($request->stage as $key => $li) {
            $product_purchase[$key]['workflow_setup_id'] = $id;
            $product_purchase[$key]['stage'] = $request->stage[$key];
            $product_purchase[$key]['designation_id'] = $request->designation[$key];
            $product_purchase[$key]['updated_at'] = Carbon::now()->toDateTimeString();
            $product_purchase[$key]['user_id'] = $request->user_id[$key];
        }
        WorkflowSetupStage::insert($product_purchase);

        return redirect('workflow')->with('message', 'Workflow Updated successfully');
    }

    public function destroy($id)
    {
        $lims_workflow_data = WorkflowSetup::find($id);
        $lims_workflow_stage_data = WorkflowSetupStage::where('workflow_setup_id', $id)->get();
        foreach ($lims_workflow_stage_data as $workflow_stage_data) {
            $workflow_stage_data->delete();
        }
        $lims_workflow_data->delete();
        return redirect('workflow')->with('not_permitted', 'Workflow deleted successfully');
    }
}
