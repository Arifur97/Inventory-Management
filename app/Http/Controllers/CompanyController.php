<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Company;
use App\Currency;
use App\Theme;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Auth;

class CompanyController extends Controller
{
    public function index()
    {
        $lims_company_all = Company::with('currency')->orderBy('id', 'desc')->get();
        return view('company.index', compact('lims_company_all'));
    }

    public function create()
    {
        $lims_currency_all = Currency::all();
        $lims_theme_all = Theme::all();
        return view('company.create', compact('lims_currency_all', 'lims_theme_all'));
    }

    public function store(Request $request)
    {
        $data = $request->except('company_logo');
        $data = $request->except('favicon');
        $company_logo = $request->company_logo;
        $favicon = $request->favicon;
        if($company_logo){
            $v = Validator::make(
                [
                    'extension' => strtolower($request->company_logo->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());
            $company_logoName = $company_logo->getClientOriginalName();
            $company_logo->move('companies/images', $company_logoName);
            $data['company_logo'] = $company_logoName;
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
            $favicon->move('companies/favicon/', $faviconName);
            $data['favicon'] = $faviconName;
        }

        Company::create($data);
        return redirect('company')->with('message', 'Company created successfully');
    }

    public function show(company $company)
    {
        //
    }

    public function edit($id)
    {
        $lims_currency_all = Currency::all();
        $lims_theme_all = Theme::all();
        $lims_company_all  = Company::find($id);
        return view('company.edit', compact('lims_company_all', 'lims_currency_all', 'lims_theme_all'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('company_logo');
        $data = $request->except('favicon');
        $company_logo = $request->company_logo;
        $favicon = $request->favicon;
        if($company_logo){
            $v = Validator::make(
                [
                    'extension' => strtolower($request->company_logo->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());
            $company_logoName = $company_logo->getClientOriginalName();
            $company_logo->move('companies/images', $company_logoName);
            $data['company_logo'] = $company_logoName;
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
            $favicon->move('companies/favicon/', $faviconName);
            $data['favicon'] = $faviconName;
        }
        $lims_company_data = Company::find($id);
        $lims_company_data->update($data);
        return redirect('company')->with('message', 'Company updated successfully');
    }

    public function destroy($id)
    {
        $lims_company_data = Company::find($id);
        $lims_company_data->delete();
        return redirect('company')->with('not_permitted', 'Company deleted successfully');
    }
}
