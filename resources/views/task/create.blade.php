@extends('layout.main') @section('content')
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}
        </div>
    @endif
    <div id="alert"></div>
    <section class="forms">

        {!! Form::open(['route' => 'task.store', 'method' => 'post', 'files' => true, 'id' => 'task-form']) !!}
        <div class="row item-sticky">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body item-page">
                        <div class="float-left brand-text mt-2 pl-4">
                            <h3>{{ trans('file.Add Task') }}</h3>
                        </div>
                        <div class="float-right mr-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary text-center" data-toggle="modal" data-target="#attachmentPopUp"><i class="fa fa-paperclip mr-2" aria-hidden="true"></i> {{ trans('file.Attachments') }} <span class="badge badge-danger notification-number" id="notification"></span></button>
                                <a href="{{route('task.index')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
                                <button type="submit" id="submit-btn" class="btn btn-primary"><i class="fa fa-check mr-1"></i>{{trans('file.submit')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{trans('file.Date')}}</label>
                                                <input type="date" class="form-control" name="date" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{trans('file.Title')}}</label>
                                                <input type="text" class="form-control" name="title" placeholder="Please Enter Title" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{trans('file.Employee')}}</label><i class="fa fa-asterisk"></i>
                                                <select required name="employee_id" id="employee_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Employee...">
                                                    @foreach($lims_employee_list as $employee)
                                                    <option value="{{$employee->id}}">{{$employee->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('file.Warehouse') }}</label><i class="fa fa-asterisk"></i>
                                                <select required name="warehouse_id" id="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select warehouse...">
                                                    @foreach ($lims_warehouse_list as $warehouse)
                                                        <option value="{{ $warehouse->id }}" @if(Auth::user()->default_warehouse_id == $warehouse->id) selected @endif>
                                                            {{ $warehouse->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{trans('file.Start Date')}}</label>
                                                <input type="date" class="form-control" name="start_date" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{trans('file.End Date')}}</label>
                                                <input type="date" class="form-control" name="end_date" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ trans('file.Company') }}</label><i class="fa fa-asterisk"></i>
                                                <input type="text" class="form-control" value="{{ $userGeneralSetting->company->name ?? '' }}" readonly />
                                                <input type="hidden" class="form-control" name="company_id" value="{{ $userGeneralSetting->company->id ?? '' }}" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{trans('file.User')}}</label>
                                                <input type="text" value="{{ucfirst(Auth::user()->name)}}" class="form-control" readonly/>
                                                <input type="hidden" value="{{ucfirst(Auth::user()->id)}}" name="user_id" class="form-control" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{trans('file.Status')}}</label><i class="fa fa-asterisk"></i>
                                                <select name="status" class="form-control">
                                                    <option value="0">{{trans('file.Draft')}}</option>
                                                    <option value="1">{{trans('file.In Process')}}</option>
                                                    <option value="2">{{trans('file.Completed')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 d-none">
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
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{trans('file.Note')}}</label>
                                                <textarea rows="5" class="form-control" name="note"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="{{ trans('file.submit') }}" class="btn btn-primary" id="submit-button">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        {{-- Add Attachments --}}
        @include('multifile_management.partials.multifile_attachment_modal', [
            'route' => route('task.multifile.store'),
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

        $("ul#task").siblings('a').attr('aria-expanded', 'true');
        $("ul#task").addClass("show");
        $("ul#task #task-create-menu").addClass("active");

        $('.selectpicker').selectpicker({
            style: 'btn-link',
        });

    </script>
@endsection
