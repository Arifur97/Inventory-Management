<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AccountTypes;
use App\AccountCategories;
use DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class AccountCategoriesController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('account-index')){
            $lims_account_categories_all = AccountCategories::with('account_type')->orderBy('id', 'desc')->where('is_active', true)->get();
            return view('account_categories.index', compact('lims_account_categories_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('account-index')){
            $lims_account_categories_all = AccountCategories::where('is_active', true)->get();
            $lims_account_type_list = AccountTypes::where('is_active', true)->get();
            return view('account_categories.create', compact('lims_account_categories_all', 'lims_account_type_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['is_active'] = true;
        AccountCategories::create($data);
        return redirect('accounts-categories')->with('message', 'Account categories created successfully');
    }

    public function edit($id)
    {
        $lims_account_type_list = AccountTypes::where('is_active', true)->get();
        $lims_account_categories_all = AccountCategories::find($id);
        return view('account_categories.edit', compact('lims_account_categories_all', 'lims_account_type_list'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $lims_account_categories_update = AccountCategories::find($id);
        $lims_account_categories_update->update($data);

        return redirect('accounts-categories')->with('message', 'Account categories updated successfully');
    }

    public function destroy($id)
    {
        $lims_document_data = AccountCategories::find($id);
        $lims_document_data->delete();
        return redirect('accounts-categories')->with('not_permitted', 'Account categories deleted successfully');
    }


}
