<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Company;
use App\Holding;
use App\HoldingCompany;
use App\Currency;
use App\Theme;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;

class HoldingController extends Controller
{
    public function index()
    {
        $lims_holding_all = Holding::with('currency')->orderBy('id', 'desc')->get();
        return view('holding.index', compact('lims_holding_all'));
    }

    public function create()
    {
        $lims_currency_all = Currency::all();
        $lims_theme_all = Theme::all();
        $lims_company_list = Company::all();
        return view('holding.create', compact('lims_currency_all', 'lims_theme_all', 'lims_company_list'));
    }

    public function getSelectedCompany(Request $request) {
        $data['companies'] = Company::findorfail($request->ids);
        return response()->json($data);
    }

    public function limsCompanytSearch(Request $request)
    {
        $todayDate = date('Y-m-d');
        $product_code = explode("(", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");
        $product_variant_id = null;
        $lims_product_data = Product::where('code', $product_code[0])->first();
        if(!$lims_product_data) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.*', 'product_variants.id as product_variant_id', 'product_variants.item_code', 'product_variants.additional_price')
                ->where('product_variants.item_code', $product_code[0])
                ->first();
            $product_variant_id = $lims_product_data->product_variant_id;
            $lims_product_data->code = $lims_product_data->item_code;
            $lims_product_data->price += $lims_product_data->additional_price;
        }
        $product[] = $lims_product_data->name;
        $product[] = $lims_product_data->code;

        if($lims_product_data->promotion && $todayDate <= $lims_product_data->last_date){
            $product[] = $lims_product_data->promotion_price;
        }
        else
            $product[] = $lims_product_data->price;

        if($lims_product_data->tax_id) {
            $lims_tax_data = Tax::find($lims_product_data->tax_id);
            $product[] = $lims_tax_data->rate;
            $product[] = $lims_tax_data->name;
        }
        else{
            $product[] = 0;
            $product[] = 'No Tax';
        }
        $product[] = $lims_product_data->tax_method;
        if($lims_product_data->type == 'standard'){
            $units = Unit::where("base_unit", $lims_product_data->unit_id)
                        ->orWhere('id', $lims_product_data->unit_id)
                        ->get();
            $unit_name = array();
            $unit_operator = array();
            $unit_operation_value = array();
            foreach ($units as $unit) {
                if($lims_product_data->sale_unit_id == $unit->id) {
                    array_unshift($unit_name, $unit->unit_name);
                    array_unshift($unit_operator, $unit->operator);
                    array_unshift($unit_operation_value, $unit->operation_value);
                }
                else {
                    $unit_name[]  = $unit->unit_name;
                    $unit_operator[] = $unit->operator;
                    $unit_operation_value[] = $unit->operation_value;
                }
            }

            $product[] = implode(",",$unit_name) . ',';
            $product[] = implode(",",$unit_operator) . ',';
            $product[] = implode(",",$unit_operation_value) . ',';
        }
        else {
            $product[] = 'n/a'. ',';
            $product[] = 'n/a'. ',';
            $product[] = 'n/a'. ',';
        }
        $product[] = $lims_product_data->id;
        $product[] = $product_variant_id;
        $product[] = $lims_product_data->promotion;
        $product[] = $lims_product_data->is_batch;
        return $product;
    }

    public function store(Request $request)
    {
        $data = $request->except('holding_logo');
        $data = $request->except('favicon');

        $holding_logo = $request->holding_logo;
        $favicon = $request->favicon;
        if($holding_logo){
            $v = Validator::make(
                [
                    'extension' => strtolower($holding_logo->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());
            $holding_logoName = $holding_logo->getClientOriginalName();
            $holding_logo->move('/holdings/images', $holding_logoName);
            $data['holding_logo'] = $holding_logoName;
        }

        if($favicon){
            $v = Validator::make(
                [
                    'extension' => strtolower($favicon->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());
            $faviconName = $favicon->getClientOriginalName();
            $favicon->move('/holdings/images', $faviconName);
            $data['favicon'] = $faviconName;
        }

        Holding::create($data);

        $lims_holding_data  = Holding::latest()->first();

        $holding_id         = $lims_holding_data->id;
        $company_id         = $data['company_id'];
        $staff_access       = $data['staff_access'];
        $is_active          = $data['is_active'];
        $holding_companies= [];

        foreach ($company_id as $i => $id) {
            $holding_companies['holding_id'] = $lims_holding_data->id ;
            $holding_companies['company_id'] = $company_id[$i];
            $holding_companies['staff_access'] = $staff_access[$i];
            $holding_companies['is_active'] = $is_active;
            HoldingCompany::create($holding_companies);
        }


        return redirect('holding')->with('message', 'Holding created successfully');
    }

    public function show(company $company)
    {
        //
    }

    public function edit($id)
    {
        $lims_currency_all = Currency::all();
        $lims_theme_all = Theme::all();
        $lims_holding_all  = Holding::with('holdingCompany')->find($id);
        $lims_company_list = Company::all();
        return view('holding.edit', compact('lims_holding_all', 'lims_currency_all', 'lims_theme_all', 'lims_company_list'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('holding_logo');
        $data = $request->except('favicon');
        $holding_logo = $request->holding_logo;
        $favicon = $request->favicon;
        if($holding_logo){
            $v = Validator::make(
                [
                    'extension' => strtolower($request->holding_logo->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());
            $holding_logoName = $holding_logo->getClientOriginalName();
            $holding_logo->move('/holdings/images', $holding_logoName);
            $data['holding_logo'] = $holding_logoName;
        }

        if($favicon){
            $v = Validator::make(
                [
                    'extension' => strtolower($request->favicon->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());
            $faviconName = $favicon->getClientOriginalName();
            $favicon->move('/holdings/images', $faviconName);
            $data['favicon'] = $faviconName;
        }
        $lims_company_data = Holding::find($id);
        $lims_company_data->update($data);

        HoldingCompany::where('holding_id', $id)->delete();
        $holding_id         = $id;
        $company_id         = $data['company_id'];
        $staff_access       = $data['staff_access'];
        $is_active          = $data['is_active'];
        $holding_companies= [];

        foreach ($company_id as $i => $id) {
            $holding_companies['holding_id'] = $holding_id;
            $holding_companies['company_id'] = $company_id[$i];
            $holding_companies['staff_access'] = $staff_access[$i];
            $holding_companies['is_active'] = $is_active;
            HoldingCompany::create($holding_companies);
        }


        return redirect('holding')->with('message', 'Holding updated successfully');
    }

    public function destroy($id)
    {
        $lims_holding_data = Holding::find($id);
        $lims_holding_company_data = HoldingCompany::where('holding_id', $id)->get();
        foreach ($lims_holding_company_data as $holding_company_data) {
            $holding_company_data->delete();
        }
        $lims_holding_data->delete();
        return redirect('holding')->with('not_permitted', 'Holding deleted successfully');
    }

}
