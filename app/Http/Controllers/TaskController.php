<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use App\Warehouse;
use App\Employee;
use App\Attachments;
use App\Sale;
use App\GeneralSetting;

use DB;
use Auth;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    public function index(){

        $lims_task_list = Task::where('is_active', true)->get();
        return view('task.index', compact( 'lims_task_list'));
    }

    public function create(){
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('sales-add')) {
            $lims_warehouse_list = [];
            foreach(json_decode(Auth::user()->warehouse_id) as $warehouseId) {
                $lims_warehouse_list[] = Warehouse::where('is_active', true)
                    ->findorfail($warehouseId);
            }

            $lims_employee_list = Employee::where('is_active', true)->get();
            return view('task.create', compact( 'lims_employee_list', 'lims_warehouse_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $document = $request->document;
        if ($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($request->document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());

            $documentName = $document->getClientOriginalName();
            $document->move('/task', $documentName);
            $data['document'] = $documentName;
        }
        $data['is_active'] = true;
        $data['document'] = $data['document_id'];
        Task::create($data);
        return redirect('task')->with('message', 'Task created successfully');

    }

    public function edit($id){
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('sales-add')){
            $lims_warehouse_list = [];
            foreach(json_decode(Auth::user()->warehouse_id) as $warehouseId) {
                $lims_warehouse_list[] = Warehouse::where('is_active', true)
                    ->findorfail($warehouseId);
            }
            $lims_task_list = Task::with('documents', 'user')->find($id);
            $lims_employee_list = Employee::where('is_active', true)->get();
            return view('task.edit', compact('lims_task_list', 'lims_employee_list', 'lims_warehouse_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('document');
        // return dd($data);
        $document = $request->document;
        if($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($request->document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());

            $documentName = $document->getClientOriginalName();
            $document->move('/task', $documentName);
            $data['document'] = $documentName;
        }
        $lims_task_data = Task::find($id);
        $lims_task_data->document = $data['document_id'];
        $lims_task_data->update($data);
        $message = 'Task updated successfully';
        return redirect('task')->with('message', $message);
    }

    public function destroy($id)
    {
        $lims_task_data = Task::find($id);
        $lims_task_data->delete();
        return redirect('task')->with('not_permitted', 'Task deleted successfully');
    }

    public function storeMultifile(Request $request) {
        $documents = $request->file('documents');
        try {
            foreach ($documents as $document) {
                $validator = Validator::make(
                    ['extension' => strtolower($document->getClientOriginalExtension())],
                    ['extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt']
                );
                if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());
            }
            $doc = Attachments::store($documents, 'App\Task');
            return response()->json([
                'success' => true,
                'id' => $doc->id
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function updateMultifile(Request $request) {
        $documents = $request->file('documents');
        $id = $request->id;
        $oldDocs = $request->docs;
        try {
            if($documents) {
                foreach ($documents as $document) {
                    $validator = Validator::make(
                        ['extension' => strtolower($document->getClientOriginalExtension())],
                        ['extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt']
                    );
                    if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());
                }
            }
            $doc = Attachments::docUpdate($documents, 'App\Task', $oldDocs, $id);
            return response()->json([
                'success' => true,
                'id' => $id ?? $doc->id,
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 400);
        }
    }


}
