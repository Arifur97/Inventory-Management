<?php

namespace App\Http\Controllers;

use App\Color;
use App\Roles;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ColorController extends Controller
{
    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('tax')) {
            $lims_color_all = Color::where('is_active', true)->get();
            return view('color.index', compact('lims_color_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }


    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('users-add')){
            $lims_role_list = Roles::where('is_active', true)->get();

            return view('color.index', compact('lims_role_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['is_active'] = true;
        Color::create($data);
        $message = 'Color created successfully';
        return redirect('color')->with('message', $message);
    }
    public function edit($id)
    {
        $lims_color_data = Color::findOrFail($id);
        return $lims_color_data;
    }

    public function update(Request $request, $id)
    {

        $data = $request->all();
        $lims_color_data = Color::where('id', $data['color_id'])->first();
        $lims_color_data->update($data);
        return redirect('color')->with('message', 'Color updated successfully');
    }
    public function destroy($id)
    {
        $lims_color_data = Color::findOrFail($id);
        $lims_color_data->is_active = false;
        $lims_color_data->save();
        return redirect('color')->with('not_permitted', 'Color deleted successfully');
    }
}
