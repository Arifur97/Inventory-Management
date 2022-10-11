<?php

namespace App\Http\Controllers;

use App\SystemColor;
use App\Warehouse;
use App\Color;
use App\Roles;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SystemColorController extends Controller
{
    public function index()
    {
        $lims_warehouse_all = SystemColor::where('is_active', true)->get();
        return view('system_color.index', compact('lims_warehouse_all'));
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $input['is_active'] = true;
        SystemColor::create($input);
        return redirect('systemcolor')->with('message', 'System Color inserted successfully');
    }

    public function edit($id)
    {
        $lims_warehouse_data = SystemColor::findOrFail($id);
        return $lims_warehouse_data;
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $lims_warehouse_data = SystemColor::find($input['warehouse_id']);
        $lims_warehouse_data->update($input);
        return redirect('systemcolor')->with('message', 'System Color updated successfully');
    }

    public function deleteBySelection(Request $request)
    {
        $warehouse_id = $request['warehouseIdArray'];
        foreach ($warehouse_id as $id) {
            $lims_warehouse_data = Warehouse::find($id);
            $lims_warehouse_data->is_active = false;
            $lims_warehouse_data->save();
        }
        return 'Warehouse deleted successfully!';
    }

    public function destroy($id)
    {
        $lims_warehouse_data = Warehouse::find($id);
        $lims_warehouse_data->is_active = false;
        $lims_warehouse_data->save();
        return redirect('warehouse')->with('not_permitted', 'Data deleted successfully');
    }
}
