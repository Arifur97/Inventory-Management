
@extends('layout.main') @section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<section class="forms">
    {!! Form::open(['route' => ['support_ticket.update', $lims_SupportTicket_data->id], 'method' => 'put', 'files' => true]) !!}
    <!--- header section  --->
    <div class="row item-sticky">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Edit Support Ticket')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary text-center" data-toggle="modal" data-target="#attachmentPopUp"><i class="fa fa-paperclip mr-2" aria-hidden="true"></i> {{ trans('file.Attachments') }} <span class="badge badge-danger notification-number" id="notification"></span></button>
                            <a href="{{route('support_ticket.index')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
                            <button type="submit" id="submit-btn" class="btn btn-primary"><i class="fa fa-check mr-1"></i>{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- header section  --->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Date')}} *</label>
                                            <input type="date" value="{{$lims_SupportTicket_data->date}}" class="form-control" id="date" name="date" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Date')}} *</label>
                                            <input type="text" value="{{$lims_SupportTicket_data->reference_no}}" class="form-control" name="reference_no" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Category')}} *</label>
                                            <input type="hidden" name="category_support_id_hidden" value="{{$lims_SupportTicket_data->category_support_id}}" />
                                            <select name="category_support_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Support Category..." required>
                                                @foreach($lims_CategoriesSupport_list as $CategoriesSupport)
                                                <option value="{{$CategoriesSupport->id}}">{{ $CategoriesSupport->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Priority')}}</label>
                                            <input type="hidden" name="priority_hidden" value="{{$lims_SupportTicket_data->priority}}" />
                                            <select name="priority" class="selectpicker form-control">
                                                <option value="Regular">Regular</option>
                                                <option value="Urgent">Urgent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Status')}}</label>
                                            <input type="hidden" name="status_hidden" value="{{$lims_SupportTicket_data->status}}" />
                                            <select name="status" class="selectpicker form-control">
                                                <option value="0">Pending</option>
                                                <option value="1">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{trans('file.Subject')}}</label>
                                            <input type="text" value="{{$lims_SupportTicket_data->subject}}" name="subject" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{trans('file.Description')}}</label>
                                            <textarea name="description" class="form-control" rows="5">{{$lims_SupportTicket_data->description}}</textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('file.User Note')}}</label>
                                            <textarea rows="3" class="form-control" name="user_note">{{$lims_SupportTicket_data->user_note}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('file.Support Note')}}</label>
                                            <textarea rows="3" class="form-control" name="support_note">{{$lims_SupportTicket_data->support_note}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('file.Company') }}</label><i class="fa fa-asterisk"></i>
                                            <input type="text" class="form-control"value="{{$lims_SupportTicket_data->company->name??''}}" readonly />
                                            <input type="hidden" name="company_id" class="form-control"value="{{$lims_SupportTicket_data->company_id}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('file.Department') }}</label>
                                            <input type="hidden" name="department_id_hidden" value="{{$lims_SupportTicket_data->department_id}}" />
                                            <select name="department_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Department..." >
                                                @foreach($lims_department_list as $department)
                                                <option value="{{$department->id}}">{{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('file.Employee') }}</label>
                                            <input type="hidden" name="employee_id_hidden" value="{{$lims_SupportTicket_data->employee_id}}" />
                                            <select name="employee_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Employee..." >
                                                @foreach($lims_employee_list as $employee)
                                                <option value="{{$employee->id}}">{{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.User')}}</label>
                                            <input type="text" class="form-control"value="{{$lims_SupportTicket_data->user->name??''}}" readonly/>
                                            <input type="hidden" name="user_id" class="form-control"value="{{$lims_SupportTicket_data->user_id}}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 d-none">
                                        <div class="form-group">
                                            <label>{{ trans('file.Attach Document') }}</label>
                                            <i class="dripicons-question" data-toggle="tooltip"
                                                title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                            <input type="file" name="document" class="form-control" />
                                            <input type="hidden" name="document_id" id="documentId"
                                                class="form-control my-2">
                                            @if ($errors->has('extension'))
                                                <span>
                                                    <strong>{{ $errors->first('extension') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.submit')}}" class="btn buttons-print" id="submit-button">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

    <!-- Add Attachments -->
    {{-- @include('multifile_management.partials.multifile_attachment_modal', [
        'route' => route('support_ticket.multifile.store'),
    ]) --}}
    <!--- update Attachments --->
    @include(
        'multifile_management.partials.multifile_attachment_modal',
        [
            'route' => route('support_ticket.multifile.update'),
            'edit' => true,
            'documents' => $lims_SupportTicket_data->documents,
        ]
    )

</section>

<script type="text/javascript">

    // Ctrl+S and Cmd+S trigger Save button click
    $(document).keydown(function(e) {
        if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey))
        {
            e.preventDefault();
            // alert("Ctrl-s pressed");
            $("#submit-btn").trigger('click');
            return false;
        }
        return true;
    });

    $('select[name="priority"]').val($('input[name="priority_hidden"]').val());
    $('select[name="status"]').val($('input[name="status_hidden"]').val());
    $('select[name="category_support_id"]').val($('input[name="category_support_id_hidden"]').val());
    $('select[name="department_id"]').val($('input[name="department_id_hidden"]').val());
    $('select[name="employee_id"]').val($('input[name="employee_id_hidden"]').val());


    $(window).keydown(function(e){
        if (e.which == 13) {
            var $targ = $(e.target);
            if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
                var focusNext = false;
                $(this).find(":input:visible:not([disabled],[readonly]), a").each(function(){
                    if (this === e.target) {
                        focusNext = true;
                    }
                    else if (focusNext){
                        $(this).focus();
                        return false;
                    }
                });
                return false;
            }
        }
    });

</script>
@endsection @section('scripts')
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

@endsection
