<?php

namespace App\Http\Controllers;

use App\Document;
use App\Employee;
use App\DocumentType;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use Carbon\Carbon ;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('account-index')){
            $lims_document_all = Document::with('employee', 'document_type' )->orderBy('id', 'desc')->where('is_active', true)->get();
            return view('documents.index', compact('lims_document_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lims_employee_list = Employee::where('is_active', true)->get();
        $lims_document_type_list = DocumentType::where('is_active', true)->get();
        $lims_document_all  = Document::where('is_active', true)->get();

        return view('documents.create', compact('lims_document_all', 'lims_employee_list', 'lims_document_type_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('document_file');
        //return dd($data);
        $data['employee_id'] = $data['employee_id'];
        $data['document_type_id'] = $data['document_type_id'];
        $data['document_title'] = $data['document_title'];
        $data['issue_date'] = $data['issue_date'];
        $data['notify_before_days'] = $data['notify_before_days'];
        $data['is_notify'] = $data['is_notify'];
        $data['expiry_date'] = $data['expiry_date'];
        $data['is_active'] = true;
        $multiFile = $request->file('document_file');



        if ($multiFile) {
            $imageDb = [];
            foreach ($multiFile as $docfile) {
                $v = Validator::make(
                    [
                        'extension' => strtolower($docfile->getClientOriginalExtension()),
                    ],
                    [
                        'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                    ]
                );
                if ($v->fails()) return redirect()->back()->withErrors($v->errors());

                $documentName = $docfile->getClientOriginalName();
                $docfile->move(public_path('document/documents'), $documentName);

                $imageDb[] = $documentName;
            }
            $imageDbUrl = implode(",", $imageDb);

            $data['document_file'] = $imageDbUrl;
        }
        //return dd($data);
        Document::create($data);
        return redirect('documents')->with('message', 'Documents created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lims_employee_list = Employee::where('is_active', true)->get();
        $lims_document_type_list = DocumentType::where('is_active', true)->get();
        $lims_document_all  = Document::find($id);

        return view('documents.edit', compact('lims_document_all', 'lims_employee_list', 'lims_document_type_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('document_file');
        $document = $request->document;
        $multiFile = $request->file('document_file');
        if ($multiFile) {
            $imageDb = [];
            foreach ($multiFile as $docfile) {
                $v = Validator::make(
                    [
                        'extension' => strtolower($docfile->getClientOriginalExtension()),
                    ],
                    [
                        'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                    ]
                );
                if ($v->fails()) return redirect()->back()->withErrors($v->errors());

                $documentName = $docfile->getClientOriginalName();
                $docfile->move(public_path('document/documents'), $documentName);

                $imageDb[] = $documentName;
            }
            $imageDbUrl = implode(",", $imageDb);

            $data['document_file'] = $imageDbUrl;
        }

        $lims_document_data = Document::find($id);

        $lims_document_data->update($data);
        return redirect('documents')->with('message', 'Documents updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lims_document_data = Document::find($id);
        $lims_document_data->delete();
        return redirect('documents')->with('not_permitted', 'Document deleted successfully');
    }
}
