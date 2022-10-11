<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Expense;
use App\Account;
use App\CashRegister;
use App\Warehouse;
use App\Company;
use App\ExpenseCategory;
use App\User;
use App\Document;
use App\Attachments;
use Auth;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('expenses-index')){

            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $lims_account_list = Account::where('is_active', true)->get();

            if($request->input('warehouse_id')) $warehouse_id = $request->input('warehouse_id');
            else $warehouse_id = null;

            if($request->input('expense_category_id')) $expense_category_id = $request->input('expense_category_id');
            else $expense_category_id = null;

            if($request->input('user_id')) $user_id = $request->input('user_id');
            else $user_id = null;

            if($request->input('reference_no')) $reference_no = $request->input('reference_no');
            else $reference_no = null;

            if($request->input('starting_date')) {
                $starting_date = $request->input('starting_date');
                $ending_date = $request->input('ending_date');
            } else {
                $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d') )))));
                $ending_date = date("Y-m-d");
            }

            if(Auth::user()->role_id > 2 && $general_setting->staff_access == 'own'){
                $lims_expense_all = Expense::with('warehouse', 'expenseCategory', 'user')
                    ->whereDate('created_at', '>=', $starting_date)
                    ->whereDate('created_at', '<=', $ending_date)
                    ->where('user_id', Auth::id())
                    ->orderBy('id', 'desc')
                    ->get();
            }else{
                $lims_expense_all = Expense::with('warehouse', 'expenseCategory', 'user')
                    ->whereDate('created_at', '>=', $starting_date)
                    ->whereDate('created_at', '<=', $ending_date)
                    ->when($user_id != null, function ($q) use ($user_id) {
                        return $q->where('user_id', $user_id);
                    })
                    ->when($warehouse_id != null, function ($q) use ($warehouse_id) {
                        return $q->where('warehouse_id', $warehouse_id);
                    })
                    ->when($expense_category_id != null, function ($q) use ($expense_category_id) {
                        return $q->where('expense_category_id', $expense_category_id);
                    })
                    ->when($reference_no != null, function ($q) use ($reference_no) {
                        return $q->where('reference_no', 'LIKE', "%{$reference_no}%");
                    })
                    ->orderBy('id', 'desc')
                    ->get();
            }

            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_category_list = ExpenseCategory::where('is_active', true)->get();
            $lims_user_list     = User::where('is_active', true)->get();

            return view('expense.index', compact('lims_account_list', 'lims_expense_all', 'warehouse_id', 'expense_category_id', 'user_id', 'all_permission', 'starting_date', 'ending_date', 'lims_warehouse_list', 'lims_category_list','lims_user_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $lims_expense_category_list = ExpenseCategory::where('is_active', true)->get();
        $lims_warehouse_list = Warehouse::where('is_active', true)->get();
        $lims_account_list = Account::where('is_active', true)->get();
        $lims_company_list = Company::where('is_active', true)->get();
        return view('expense.create', compact('lims_expense_category_list', 'lims_warehouse_list', 'lims_account_list', 'lims_company_list'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['reference_no'] = 'er-' . date("Ymd") . '-'. date("his");
        // $data['user_id'] = Auth::id();
        $cash_register_data = CashRegister::where([
            ['user_id', $data['user_id']],
            ['warehouse_id', $data['warehouse_id']],
            ['status', true]
        ])->first();
        if($cash_register_data)
            $data['cash_register_id'] = $cash_register_data->id;
        Expense::create($data);
        return redirect('expenses')->with('message', 'Expense inserted successfully');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $role = Role::firstOrCreate(['id' => Auth::user()->role_id]);
        if ($role->hasPermissionTo('expenses-edit')) {
            $lims_expense_category_list = ExpenseCategory::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_account_list = Account::where('is_active', true)->get();
            $lims_company_list = Company::where('is_active', true)->get();
            $lims_expense_all  = Expense::with( 'company')->find($id);
            // $lims_attachments_all  = Attachments::latest()->first();
            return view('expense.edit', compact('lims_expense_category_list', 'lims_warehouse_list', 'lims_account_list', 'lims_company_list', 'lims_expense_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');

    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $lims_expense_data = Expense::find($id);
        $lims_expense_data->update($data);
        return redirect('expenses')->with('message', 'Expense updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $expense_id = $request['expenseIdArray'];
        foreach ($expense_id as $id) {
            $lims_expense_data = Expense::find($id);
            $lims_expense_data->delete();
        }
        return 'Expense deleted successfully!';
    }

    public function destroy($id)
    {
        $lims_expense_data = Expense::find($id);
        $lims_expense_data->delete();
        return redirect('expenses')->with('not_permitted', 'Data deleted successfully');
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
            $doc = Attachments::store($documents, 'App\Expense');
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
            $doc = Attachments::docUpdate($documents, 'App\Expense', $oldDocs, $id);
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
