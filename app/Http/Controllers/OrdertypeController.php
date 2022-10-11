<?php

namespace App\Http\Controllers;

use App\Ordertype;
use App\Roles;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class OrdertypeController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('tax')) {
            $lims_ordertype_all = Ordertype::where('is_active', true)->get();
            return view('ordertype.index', compact('lims_ordertype_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }


    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('users-add')){
            $lims_role_list = Roles::where('is_active', true)->get();

            return view('ordertype.index', compact('lims_role_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $data['is_active'] = true;
        Ordertype::create($data);
        $message = 'Order Type created successfully';
        return redirect('ordertype')->with('message', $message);
    }
    public function edit($id)
    {
        $lims_ordertype_data = Ordertype::findOrFail($id);
        return $lims_ordertype_data;
    }

    public function update(Request $request, $id)
    {

        $data = $request->all();
        $lims_ordertype_data = Ordertype::where('id', $data['ordertype_id'])->first();
        $lims_ordertype_data->update($data);
        return redirect('ordertype')->with('message', 'Order Type updated successfully');
    }
    public function destroy($id)
    {
        $lims_ordertype_data = Ordertype::findOrFail($id);
        $lims_ordertype_data->is_active = false;
        $lims_ordertype_data->save();
        return redirect('ordertype')->with('not_permitted', 'Order Type deleted successfully');
    }


}
