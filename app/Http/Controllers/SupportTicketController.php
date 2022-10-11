<?php

namespace App\Http\Controllers;
use App\SupportTicket;
use App\CategoriesSupport;
use App\Department;
use App\Employee;
use App\Attachments;
use App\FormName;
use Carbon\Carbon;
use App\GeneralSetting;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Auth;
use GeniusTS\HijriDate\Date;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $lims_SupportTicket_list = SupportTicket::all();
        return view('support_ticket.index', compact('lims_SupportTicket_list'));
    }

    public function create()
    {
        $lims_CategoriesSupport_list = CategoriesSupport::get();
        $lims_department_list = Department::get();
        $lims_employee_list = Employee::all();
        return view('support_ticket.create', compact('lims_CategoriesSupport_list', 'lims_department_list', 'lims_employee_list'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $yeardate = Carbon::now()->format('y');
        $support_ticket_form_name = FormName::findorfail(FormName::supportTicketId());
        $work_order_ref_seq = sprintf("%05d", $support_ticket_form_name->reference_no_latest);
        $data['reference_no'] = $support_ticket_form_name->reference_no_prefix . '-' . $yeardate . $work_order_ref_seq;
        $support_ticket_form_name->reference_no_latest += $support_ticket_form_name->reference_no_sequence;
        $support_ticket_form_name->update();

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
            $document->move('/SupportTicket', $documentName);
            $data['document'] = $documentName;
        }

        $data['document'] = $data['document_id'];
        SupportTicket::create($data);
        return redirect('support_ticket')->with('message', 'Support Ticket inserted successfully');
    }

    public function edit($id)
    {
        $lims_SupportTicket_data = SupportTicket::with('documents', 'user', 'company')->find($id);
        $lims_CategoriesSupport_list = CategoriesSupport::get();
        $lims_department_list = Department::get();
        $lims_employee_list = Employee::all();
        return view('support_ticket.edit', compact('lims_SupportTicket_data', 'lims_CategoriesSupport_list', 'lims_department_list', 'lims_employee_list'));
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
            $document->move('/SupportTicket', $documentName);
            $data['document'] = $documentName;
        }
        $lims_work_order_data = SupportTicket::find($id);
        $lims_work_order_data->document = $data['document_id'];

        $lims_work_order_data->update($data);
        $message = 'Support Ticket updated successfully';
        return redirect('support_ticket')->with('message', $message);
    }

    public function destroy($id)
    {
        $lims_SupportTicket_data = SupportTicket::findOrFail($id);
        $lims_SupportTicket_data->delete();
        return redirect('support_ticket');
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
            $doc = Attachments::store($documents, 'App\SupportTicket');
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
            $doc = Attachments::docUpdate($documents, 'App\SupportTicket', $oldDocs, $id);
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
