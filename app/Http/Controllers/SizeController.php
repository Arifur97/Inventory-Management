<?php

namespace App\Http\Controllers;

use App\Size;
use App\Roles;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SizeController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('tax')) {
            $lims_size_all = Size::where('is_active', true)->get();
            return view('size.index', compact('lims_size_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }


    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('users-add')){
            $lims_role_list = Roles::where('is_active', true)->get();

            return view('size.index', compact('lims_role_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {

        $data = $request->all();
        $data['is_active'] = true;
        Size::create($data);
        $message = 'Size created successfully';
        return redirect('size')->with('message', $message);
    }
    public function edit($id)
    {
        $lims_size_data = Size::findOrFail($id);
        return $lims_size_data;
    }

    public function update(Request $request, $id)
    {

        $data = $request->all();
        $lims_size_data = Size::where('id', $data['size_id'])->first();
        $lims_size_data->update($data);
        return redirect('size')->with('message', 'Size updated successfully');
    }
    public function destroy($id)
    {
        $lims_size_data = Size::findOrFail($id);
        $lims_size_data->is_active = false;
        $lims_size_data->save();
        return redirect('size')->with('not_permitted', 'Size deleted successfully');
    }
}
