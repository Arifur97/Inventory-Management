
@extends('layout.main') @section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<section class="forms">
    {!! Form::open(['route' => 'support_ticket.store', 'method' => 'post', 'files' => true, 'class' => 'support_ticket-form']) !!}
    <!--- header section  --->
    <div class="row item-sticky">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Add Support Ticket')}}</h3>
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
                                    <?php
                                        $month = date('m');
                                        $day = date('d');
                                        $year = date('Y');
                                        $today = $year . '-' . $month . '-' . $day;
                                    ?>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Date')}} *</label>
                                            <input type="date" value="<?php echo $today; ?>" class="form-control" id="date" name="date" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Category')}} *</label>
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
                                            <select name="priority" class="selectpicker form-control">
                                                <option value="Regular">Regular</option>
                                                <option value="Urgent">Urgent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Status')}}</label>
                                            <select name="status" class="selectpicker form-control">
                                                <option value="0">Pending</option>
                                                <option value="1">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{trans('file.Subject')}}</label>
                                            <input type="text" name="subject" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{trans('file.Description')}}</label>
                                            <textarea name="description" class="form-control" rows="5"></textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('file.User Note')}}</label>
                                            <textarea rows="3" class="form-control" name="user_note"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('file.Support Note')}}</label>
                                            <textarea rows="3" class="form-control" name="support_note"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('file.Company') }}</label><i class="fa fa-asterisk"></i>
                                            <input type="text" class="form-control" value="{{ $userGeneralSetting->company->name ?? '' }}" readonly />
                                            <input type="hidden" class="form-control" name="company_id" value="{{ $userGeneralSetting->company->id ?? '' }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ trans('file.Department') }}</label>
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
                                            <input type="text" value="{{ucfirst(Auth::user()->name)}}" class="form-control" readonly/>
                                            <input type="hidden" value="{{ucfirst(Auth::user()->id)}}" name="user_id" class="form-control" readonly/>
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
    @include('multifile_management.partials.multifile_attachment_modal', [
        'route' => route('support_ticket.multifile.store'),
    ])

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

    // tinymce.init({
    //   selector: 'textarea',
    //   height: 130,
    //   plugins: [
    //     'advlist autolink lists link image charmap print preview anchor textcolor',
    //     'searchreplace visualblocks code fullscreen',
    //     'insertdatetime media table contextmenu paste code wordcount'
    //   ],
    //   toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
    //   branding:false
    // });


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
