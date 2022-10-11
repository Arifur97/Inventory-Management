@extends('layout.main') @section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif

    <section>

        <!--- header section  --->

        <div class="row ">
            <div class="col-md-12 item-sticky">
                <div class="card ">
                    <div class="card-body item-page">
                        <div class="float-left brand-text mt-2 pl-4">
                            <h3>{{ trans('file.Attendance') }}</h3>
                        </div>
                        <div class="float-right mr-2">
                            <div class="form-group">
                                <button class="btn btn-secondary" data-toggle="modal" data-target="#Filter"
                                    title="{{ trans('file.Filter') }}"><i class="fa fa-filter mr-1"></i>
                                    {{ trans('file.Filter') }}</button>
                                <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary"><i
                                        class="dripicons-copy mr-1"></i> {{ trans('file.import') }}</a>
                                <button class="btn buttons-add" data-toggle="modal" data-target="#createModal"><i
                                        class="fa fa-plus mr-1" aria-hidden="true"></i> {{ trans('file.add') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--- header section  --->

            <div class="table-responsive">
                <table id="attendance-table" class="table attendance-list" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                            <th>{{ trans('file.date') }}</th>
                            <th>{{ trans('file.Employee') }}</th>
                            <th>{{ trans('file.Clock-In') }}</th>
                            <th>{{ trans('file.Clock-Out') }}</th>
                            <th>{{ trans('file.Created By') }}</th>
                            <th>{{ trans('file.Time (Hours)') }}</th>
                            <th>{{ trans('file.Status') }}</th>
                            <th class="not-exported" style="border-radius: 0px 5px 5px 0px">{{ trans('file.action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lims_attendance_all as $key => $attendance)
                            <tr data-id="{{ $attendance->id }}">
                                <td>{{ $key }}</td>
                                <td>{{ date($general_setting->date_format, strtotime($attendance->date)) }}</td>
                                <td>{{ $attendance->employee->name }}</td>
                                <td>{{ $attendance->checkin }}</td>
                                <td>{{ $attendance->checkout }}</td>
                                <td>{{ $attendance->user->name ?? '' }}</td>
                                <td class="text-right text-bold">{{ $attendance->time }}</td>
                                @if($attendance->status == 'At Work')
                                    <td>
                                        <div class="badge badge-primary"> {{ $attendance->status }}</div>
                                    </td>
                                @elseif ($attendance->status == 'On-Time')
                                    <td>
                                        <div class="badge badge-success"> {{ $attendance->status }}</div>
                                    </td>
                                @else
                                    <td>
                                        <div class="badge badge-danger">{{ $attendance->status }}</div>
                                    </td>
                                @endif
                                <td>
                                    <div class="btn-group">
                                        {{ Form::open(['route' => ['attendance.destroy', $attendance->id], 'method' => 'DELETE']) }}
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirmDelete()"
                                            title="{{ trans('file.delete') }}"><i class="dripicons-trash"></i></button>
                                        {{ Form::close() }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </section>

    {{-- Filter --}}

    <div id="Filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal mt-5 fade text-left">
        <div role="document" class="modal-dialog">

            {!! Form::open(['route' => 'attendance.index', 'method' => 'get']) !!}

            <div class="modal-content">
                <div class="modal-header item-page">
                    {{-- top button --}}
                    <div class="col-md-12">
                        <div class="float-left brand-text mt-2">
                            <h3>{{ trans('file.Filter') }}</h3>
                        </div>
                        <div class="float-right">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="float-right">
                            <div class="form-group mr-2">
                                <button type="submit" class="btn btn-save"
                                    title="{{ trans('file.Use ctrl+s to save') }}" id="filter-btn">
                                    <i class="fa fa-filter mr-1" aria-hidden="true"></i>
                                    {{ trans('file.Filter') }}
                                </button>
                            </div>
                        </div>
                        <div class="float-right mr-2">
                            <div class="form-group">
                                <a href="{{ route('attendance.index') }}" class="btn btn-secondary"><i
                                        class="fa fa-power-off mr-1"></i>
                                    {{ trans('file.Reset') }}
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-body">
                    <div class="row mt-5 mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('file.Date Range') }}</strong> </label>
                                <div class="input-group">
                                    <input type="text" class="daterangepicker-field form-control"
                                        value="{{ $starting_date }} To {{ $ending_date }}" required />
                                    <input type="hidden" name="starting_date" value="{{ $starting_date }}" />
                                    <input type="hidden" name="ending_date" value="{{ $ending_date }}" />
                                </div>
                            </div>
                        </div>

                        {{-- Employee --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('file.Employee') }}</strong> </label>
                                <div class="input-group">
                                    <select id="employee_id" name="employee_id" class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="begins">
                                        <option value="0">{{ trans('file.All Employee') }}</option>
                                        @foreach ($lims_employee_list as $employee)
                                            @if ($employee->id == $employee_id)
                                                <option selected value="{{ $employee->id ?? null }}">
                                                    {{ $employee->name }}
                                                </option>
                                            @else
                                                <option value="{{ $employee->id ?? null }}">{{ $employee->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Created by --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('file.Created By') }}</strong> </label>
                                <div class="input-group">
                                    <select id="user_id" name="user_id" class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="begins">
                                        <option value="0">{{ trans('file.All User') }}</option>
                                        @foreach ($lims_user_list as $user)
                                            @if ($user->id == $user_id)
                                                <option selected value="{{ $user->id ?? null }}">{{ $user->name }}
                                                </option>
                                            @else
                                                <option value="{{ $user->id ?? null }}">{{ $user->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        {{-- Status --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('file.Status') }}</strong> </label>
                                <div class="input-group">
                                    <select id="status" name="status" class="selectpicker form-control"
                                        data-live-search="true" data-live-search-style="begins">
                                        <option value="0">{{ trans('file.All Status') }}</option>
                                        @foreach ($lims_status_attendence_list as $statusattendence)
                                            @if ($statusattendence->id == $status)
                                                <option selected value="{{ $statusattendence->id ?? null }}">
                                                    {{ $statusattendence->name }}
                                                </option>
                                            @else
                                                <option value="{{ $statusattendence->id ?? null }}">{{ $statusattendence->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.Add Attendance') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                    </p>
                    {!! Form::open(['route' => 'attendance.store', 'method' => 'post', 'files' => true]) !!}
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{ trans('file.Employee') }}</label><i class="fa fa-asterisk"></i>
                            <select class="form-control selectpicker" name="employee_id[]" required data-live-search="true"
                                data-live-search-style="begins" title="Select Employee..." multiple>
                                @foreach ($lims_employee_list as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('file.date') }}</label><i class="fa fa-asterisk"></i>
                            <input type="text" name="date" class="form-control date"
                                value="{{ date($general_setting->date_format) }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('file.CheckIn') }}</label><i class="fa fa-asterisk"></i>
                            <input type="text" id="checkin" name="checkin" class="form-control"
                                value="{{ $lims_hrm_setting_data->checkin }}" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{ trans('file.CheckOut') }}</label><i class="fa fa-asterisk"></i>
                            <input type="text" id="checkout" name="checkout" class="form-control"
                                value="{{ $lims_hrm_setting_data->checkout }}" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>{{ trans('file.Note') }}</label>
                            <textarea name="note" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ trans('file.submit') }}</button>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(".daterangepicker-field").daterangepicker({
            callback: function(startDate, endDate, period) {
                var starting_date = startDate.format('YYYY-MM-DD');
                var ending_date = endDate.format('YYYY-MM-DD');
                var title = starting_date + ' To ' + ending_date;
                $(this).val(title);
                $('input[name="starting_date"]').val(starting_date);
                $('input[name="ending_date"]').val(ending_date);
            }
        });

        $("ul#hrm").siblings('a').attr('aria-expanded', 'true');
        $("ul#hrm").addClass("show");
        $("ul#hrm #attendance-menu").addClass("active");

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

        var attendance_id = [];
        var all_permission = <?php echo json_encode($all_permission); ?>;
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var date = $('.date');
        date.datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });

        $('#checkin, #checkout').timepicker({
            'step': 15,
        });

        $(document).ready(function() {
            var table = $('#attendance-table').DataTable({
                "responsive": true,
                "fixedHeader": true,
                "order": [],
                'language': {
                    'lengthMenu': '_MENU_ {{ trans('file.records per page') }}',
                    "info": '<small>{{ trans('file.Showing') }} _START_ - _END_ (_TOTAL_)</small>',
                    "search": '{{ trans('file.Search') }}',
                    'paginate': {
                        'previous': '<i class="dripicons-chevron-left"></i>',
                        'next': '<i class="dripicons-chevron-right"></i>'
                    }
                },
                'columnDefs': [{
                        "orderable": false,
                        'targets': [0, 7]
                    },
                    {
                        'render': function(data, type, row, meta) {
                            if (type === 'display') {
                                data =
                                    '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                            }

                            return data;
                        },
                        'checkboxes': {
                            'selectRow': true,
                            'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                        },
                        'targets': [0]
                    }
                ],
                'select': {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                'lengthMenu': [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: '<"row"lfB>rtip',
                buttons: [{
                        extend: 'pdf',
                        text: '{{ trans('file.PDF') }}',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible',
                        }
                    },
                    {
                        extend: 'csv',
                        text: '{{ trans('file.CSV') }}',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible',
                        },
                    },
                    {
                        extend: 'print',
                        text: '{{ trans('file.Print') }}',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible',
                        },
                    },
                    {
                        text: '{{ trans('file.delete') }}',
                        className: 'buttons-delete',
                        action: function(e, dt, node, config) {
                            if (user_verified == '1') {
                                attendance_id.length = 0;
                                $(':checkbox:checked').each(function(i) {
                                    if (i) {
                                        attendance_id[i - 1] = $(this).closest('tr').data(
                                            'id');
                                    }
                                });
                                if (attendance_id.length && confirm(
                                        "Are you sure want to delete?")) {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'attendance/deletebyselection',
                                        data: {
                                            attendanceIdArray: attendance_id
                                        },
                                        success: function(data) {
                                            alert(data);
                                        }
                                    });
                                    dt.rows({
                                        page: 'current',
                                        selected: true
                                    }).remove().draw(false);
                                } else if (!attendance_id.length)
                                    alert('Nothing is selected!');
                            } else
                                alert('This feature is disable for demo!');
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '{{ trans('file.Column visibility') }}',
                        columns: ':gt(0)'
                    },
                ],
            });
        });
    </script>
@endsection
