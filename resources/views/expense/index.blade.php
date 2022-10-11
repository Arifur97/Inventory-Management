@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<section>
    <!--- header section  --->
    <div class="row ">
        <div class="col-md-12 item-sticky">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Expense')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#Filter" title="{{trans('file.Filter')}}"><i class="fa fa-filter mr-1"></i> {{trans('file.Filter')}}</button>

                            <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary"><i class="dripicons-copy mr-1"></i> {{trans('file.import')}}</a>

                            <a href="{{route('expenses.create')}}" class="btn buttons-add"><i class="fa fa-plus mr-1"></i> {{trans('file.add')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- header section  --->
    <div class="table-responsive">
        <table id="expense-table" class="table">
            <thead>
                <tr>
                    <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.reference')}} No</th>
                    <th>{{trans('file.Warehouse')}}</th>
                    <th>{{trans('file.category')}}</th>
                    <th>{{trans('file.User')}}</th>
                    <th class="text-right">{{trans('file.Amount')}}</th>
                    <th>{{trans('file.Description')}}</th>
                    <th class="not-exported" style="border-radius: 0px 5px 5px 0px">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_expense_all as $key=>$expense)

                <tr data-id="{{$expense->id}}">
                    <td>{{$key}}</td>
                    <td>{{ date($general_setting->date_format, strtotime($expense->created_at)) }}</td>
                    <td>{{ $expense->reference_no }}</td>
                    <td>{{ $expense->warehouse->name }}</td>
                    <td>{{ $expense->expenseCategory->name }}</td>
                    <td>{{ $expense->user->name ?? '' }}</td>
                    <td class="grand-total text-right">{{ number_format((float)$expense->amount, 2, '.', '') }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                @if(in_array("expenses-edit", $all_permission))
                                <li>
                                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-link"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a>
                                </li>
                                @endif
                                @if(in_array("expenses-delete", $all_permission))
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['expenses.destroy', $expense->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="tfoot active">
                <th></th>
                <th>{{trans('file.Total')}}</th>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-right"></th>
                <th></th>
                <th></th>
            </tfoot>
        </table>
    </div>
</section>


    {{-- Filter --}}

    <div id="Filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal mt-5 fade text-left">
        <div role="document" class="modal-dialog">

            {!! Form::open(['route' => 'expenses.index', 'method' => 'get']) !!}

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
                                <a href="{{ route('expenses.index') }}" class="btn btn-secondary"><i
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

                        {{-- warehouse --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{trans('file.Warehouse')}}</strong> </label>
                                <div class="input-group">
                                    <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                        <option value="0">{{trans('file.All Warehouse')}}</option>
                                        @foreach($lims_warehouse_list as $warehouse)
                                            @if($warehouse->id == $warehouse_id)
                                                <option selected value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                            @else
                                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Category --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{trans('file.Category')}}</strong> </label>
                                <div class="input-group">
                                    <select id="expense_category_id" name="expense_category_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                        <option value="0">{{trans('file.All Category')}}</option>
                                        @foreach($lims_category_list as $category)
                                            @if($category->id == $expense_category_id)
                                                <option selected value="{{$category->id}}">{{$category->name}}</option>
                                            @else
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Reference No --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{trans('file.Reference No')}}</strong> </label>
                                <div class="input-group">
                                    <input id="reference_no" type="text" name="reference_no" placeholder="Please type reference no..." class="form-control" value="{{ $reference_no??'' }}" />
                                </div>
                            </div>
                        </div>

                        {{-- User --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{trans('file.User')}}</strong> </label>
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


                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

<script type="text/javascript">

    $("ul#expense").siblings('a').attr('aria-expanded','true');
    $("ul#expense").addClass("show");
    $("ul#expense #exp-list-menu").addClass("active");

    var expense_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;
    var all_permission = <?php echo json_encode($all_permission) ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    $(document).ready(function() {
        $(document).on('click', 'button.open-Editexpense_categoryDialog', function() {
            var url = "expenses/";
            var id = $(this).data('id').toString();
            url = url.concat(id).concat("/edit");
            $.get(url, function(data) {
                $('#editModal #reference').text(data['reference_no']);
                $("#editModal select[name='warehouse_id']").val(data['warehouse_id']);
                $("#editModal select[name='expense_category_id']").val(data['expense_category_id']);
                $("#editModal select[name='account_id']").val(data['account_id']);
                $("#editModal input[name='amount']").val(data['amount']);
                $("#editModal input[name='expense_id']").val(data['id']);
                $("#editModal textarea[name='note']").val(data['note']);
                $('.selectpicker').selectpicker('refresh');
            });
        });
    });

function confirmDelete() {
    if (confirm("Are you sure want to delete?")) {
        return true;
    }
    return false;
}

    $('#expense-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 8]
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
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
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [
            {
                extend: 'pdf',
                text: '<i class="fa fa-file-pdf-o mr-1" aria-hidden="true"></i> {{trans("file.PDF")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'csv',
                text: '<i class="fa fa-file-excel-o mr-1" aria-hidden="true"></i> {{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print mr-1" aria-hidden="true"></i> {{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                action: function(e, dt, button, config) {
                    datatable_sum(dt, true);
                    $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                    datatable_sum(dt, false);
                },
                footer:true
            },
            {
                text: '<i class="fa fa-trash mr-1" aria-hidden="true"></i> {{trans("file.delete")}}',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    if(user_verified == '1') {
                        expense_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                expense_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(expense_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'expenses/deletebyselection',
                                data:{
                                    expenseIdArray: expense_id
                                },
                                success:function(data){
                                    alert(data);
                                }
                            });
                            dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!expense_id.length)
                            alert('No expense is selected!');
                    }
                    else
                        alert('This feature is disable for demo!');
                }
            },
            {
                extend: 'colvis',
                text: '<i class="fa fa-eye mr-1" aria-hidden="true"></i> {{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            },
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

    if(all_permission.indexOf("expenses-delete") == -1)
        $('.buttons-delete').addClass('d-none');

</script>
@endsection
