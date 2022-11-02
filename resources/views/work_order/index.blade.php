@extends('layout.main')
@section('content')
@if (session()->has('message'))
    <div class="alert alert-success alert-dismissible text-center">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>{!! session()->get('message') !!}
    </div>
@endif
@if (session()->has('not_permitted'))
    <div class="alert alert-danger alert-dismissible text-center">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>{{ session()->get('not_permitted') }}
    </div>
@endif

<section>
    <!--- header section  --->
    <div class="row item-sticky">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Work Order')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            @if(in_array("quotes-add", $all_permission))
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#Filter" title="{{trans('file.Filter')}}"><i class="fa fa-filter mr-1"></i> {{trans('file.Filter')}}</button>
                            <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary"><i class="dripicons-copy mr-1"></i> {{trans('file.import')}}</a>
                            <a href="{{route('workorder.create')}}" class="btn buttons-add"><i class="fa fa-plus mr-1"></i> {{trans('file.add')}}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 float-right">
                        <div class="col-md-8 float-left">
                            <div class="form-group workorder-send">
                                <select required name="send_to" class="form-control" id="workorder__sendto">
                                    <option value="" disabled selected>Send To</option>
                                    <option value="Designer">{{trans('file.Designer')}}</option>
                                    <option value="Workshop">{{trans('file.Workshop')}}</option>
                                    <option value="Salesperson">{{trans('file.Salesperson')}}</option>
                                    <option value="Admin">{{trans('file.Admin')}}</option>
                                </select>
                                <button type="button" onclick="submitWorkOrderSendTo()" class="btn buttons-print" id="submit-button">{{trans('file.submit')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 float-right">
                        <div class="col-md-8 float-left">
                            <div class="form-group workorder-send">
                                <select name="work_order_status" class="form-control" id="workorder__status">
                                    <option value="" disabled selected>Status</option>
                                    <option value="2">{{trans('file.Pending')}}</option>
                                    <option value="1">{{trans('file.Completed')}}</option>
                                </select>
                                <button type="button" onclick="submitWorkOrderStatus()" class="btn buttons-print" id="submit-button">{{trans('file.submit')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- header section  --->

    <div class="table-responsive">
        <table id="wrokOrder-table" class="table workOrder-list" style="width: 100%">
            <thead>
                <tr>
                    <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                    <th>{{trans('file.id')}}</th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.File Preview')}}</th>
                    <th>{{trans('file.Warehouse')}}</th>
                    <th>{{trans('file.Types')}}</th>

                    @if(!in_array("hide-workorder-customer-index", $all_permission))
                        <th>{{trans('file.customer')}}</th>
                        <th>{{trans('file.Email')}}</th>
                        <th>{{trans('file.Phone Number')}}</th>
                    @endif

                    <th>{{trans('file.User')}}</th>
                    {{-- <th>{{trans('file.File Attached')}}</th> --}}
                    <th>{{trans('file.Note')}}</th>
                    <th>{{trans('file.Staff Note')}}</th>
                    <th>{{trans('file.Sales Ref')}}</th>
                    <th>{{trans('file.Priority')}}</th>
                    <th>{{trans('file.Stage')}}</th>
                    <th>{{trans('file.Order No.')}}</th>
                    <th>{{trans('file.Status')}}</th>
                    <th class="not-exported" style="border-radius: 0px 5px 5px 0px">{{trans('file.action')}}</th>
                </tr>
            </thead>
        </table>
    </div>
</section>

<div id="workOrder-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="container mt-3 pb-2 border-bottom">
                <div class="row">
                    <div class="col-md-3">
                        <button id="print-btn" type="button" class="btn btn-default btn-sm d-print-none" onclick="printWorkorder()"><i class="dripicons-print"></i> {{trans('file.Print')}}</button>
                        {{ Form::open(['route' => 'workorder.sendmail', 'method' => 'post', 'class' => 'sendmail-form'] ) }}
                            <input type="hidden" name="workorder_id" id="workorder-details-workorderid">
                            <button class="btn btn-default btn-sm d-print-none"><i class="dripicons-mail"></i> {{trans('file.Email')}}</button>
                        {{ Form::close() }}
                    </div>
                    <div class="col-md-6">
                        <h3 id="exampleModalLabel" class="modal-title text-center container-fluid">{{trans('file.Work Order')}}</h3>
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close d-print-none"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                </div>
            </div>

            <!--- quick view tab  --->
            <ul class="nav nav-tabs ml-4 mt-3 mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#tab-lines" role="tab" data-toggle="tab">{{trans('file.Lines')}}</a>
                  </li>
                <li class="nav-item">
                  <a class="nav-link" href="#tab-shipping" role="tab" data-toggle="tab">{{trans('file.Shipping')}}</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#tab-workflow" role="tab" data-toggle="tab">{{trans('file.Workflow')}}</a>
                </li>
            </ul>

            <!--- quick view data  --->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade show active" id="tab-lines">
                    <div id="workorder-content" class="modal-body"></div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered product-workorder-list">
                            <thead class="dark-blue"style="color: white!important;text-align:center;">
                                <th>{{trans('file.Image')}}</th>
                                <th>{{trans('file.name')}}</th>
                                <th>{{trans('file.Code')}}</th>
                                <th>{{trans('file.Category')}}</th>
                                <th>{{trans('file.Order Type')}}</th>
                                <th>{{trans('file.Color')}}</th>
                                <th>{{trans('file.Size')}}</th>
                                <th>{{trans('file.Quantity')}}</th>
                                <th>{{trans('file.Note')}}</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div id="workorder-footer" class="modal-body"></div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab-shipping">
                    Shipping
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab-workflow">
                    Workflow
                </div>
            </div>

        </div>
    </div>
</div>

<div id="workorder-img-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close d-print-none"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="modal-body">
                <embed id="workorder-embed-data" src="" type="" style="width: 100%; height: auto; min-height: 500px;">
            </div>
        </div>
    </div>
</div>

<!--- Filter --->

<div id="Filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal mt-5 fade text-left">
    <div role="document" class="modal-dialog">
        {!! Form::open(['route' => 'workorder.index', 'method' => 'get']) !!}
      <div class="modal-content">
        <div class="modal-header item-page">

        {{-- top button --}}
          <div class="col-md-12">
            <div class="float-left brand-text mt-2">
                <h3>{{trans('file.Filter')}}</h3>
            </div>
            <div class="float-right">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="float-right">
                <div class="form-group mr-2">
                    <button type="submit" class="btn btn-save" title="{{trans('file.Use ctrl+s to save')}}" id="filter-btn" type="submit"><i class="fa fa-filter mr-1" aria-hidden="true" ></i> {{trans('file.Filter')}}</button>

                </div>
            </div>
            <div class="float-right mr-2">
                <div class="form-group">
                    <a href="{{ route('workorder.index') }}" class="btn btn-secondary" onclick="AddProducts()"><i class="fa fa-power-off mr-1"></i> {{trans('file.Reset')}}</a>
                </div>
            </div>

          </div>

        </div>
        <div class="modal-body">
            <div class="row mt-5 mb-3">
                {{-- date range --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ trans('file.Date Range') }}</strong> </label>
                        <div class="input-group">
                            <input type="text" class="daterangepicker-field form-control" value="{{ date('d-M-Y', strtotime($starting_date)) }} To {{ date('d-M-Y', strtotime($ending_date)) }}" required />
                            <input type="hidden" name="starting_date" value="{{ $starting_date }}" />
                            <input type="hidden" name="ending_date" value="{{ $ending_date }}" />
                        </div>
                    </div>
                </div>

                  {{-- customer --}}
                  <div class="col-md-4">
                    <div class="form-group">
                        <label>{{trans('file.Customer')}}</strong> </label>
                        <div class="input-group">
                            <select id="customer_id" name="customer_id[]" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" multiple>
                                {{-- <option value="0">{{trans('file.All Customer')}}</option> --}}
                                @foreach($lims_customer_list as $customer)
                                    @if(is_array($customer_id))
                                        @if(in_array($customer->id, $customer_id))
                                            <option selected value="{{$customer->id}}">{{$customer->name}}</option>
                                        @else
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endif
                                    @elseif($customer->id == $customer_id)
                                        <option selected value="{{$customer->id}}">{{$customer->name}}</option>
                                    @else
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Order Type --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{trans('file.Order Type')}}</strong> </label>
                        <div class="input-group">
                            <select id="order_type" name="order_type[]" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" multiple>
                                @foreach($lims_ordertype_list as $ordertype)
                                    @if($order_type != null && in_array($ordertype->id, $order_type))
                                        <option selected value="{{$ordertype->id}}">{{$ordertype->order_type}}</option>
                                    @else
                                        <option value="{{$ordertype->id}}">{{$ordertype->order_type}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- warehouse --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{trans('file.Warehouse')}}</strong> </label>
                        <div class="input-group">
                            <select id="warehouse_id" name="warehouse_id[]" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" multiple>
                                @foreach($lims_warehouse_list as $warehouse)
                                    @if(is_array($warehouse_id))
                                        @if(in_array($warehouse->id, $warehouse_id))
                                            <option selected value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                        @else
                                            <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                        @endif
                                    @elseif($warehouse->id == $warehouse_id)
                                        <option selected value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                    @else
                                        <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
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


                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{trans('file.Priority')}}</label>
                        <select name="priority" class="selectpicker form-control">
                            <option value="0">All</option>
                            <option value="Regular" @if(request('priority') == 'Regular') selected @endif>Regular</option>
                            <option value="Urgent" @if(request('priority') == 'Urgent') selected @endif>Urgent</option>
                        </select>
                    </div>
                </div>



            </div>
        </div>
    </div>

    {!! Form::close() !!}

</div>


<script type="text/javascript">

    $("ul#quotation").siblings('a').attr('aria-expanded','true');
    $("ul#quotation").addClass("show");
    $("ul#quotation #quotation-list-menu").addClass("active");
    var all_permission = <?php echo json_encode($all_permission) ?>;
    var workorder_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

    let starting_date = $("input[name=starting_date]").val();
    let ending_date = $("input[name=ending_date]").val();
    let warehouse_id = $("#warehouse_id").val();
    let customer_id = $("#customer_id").val();
    let reference_no = $("#reference_no").val();
    let order_type = $("select[name=order_type]").val();
    let priority = $("select[name=priority]").val();

    window.addEventListener('keydown', function (event) {
        if (event.shiftKey && event.code === 'KeyA') {
            window.location.href = '/workorder/create';
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    $(document).on("click", "tr.workorder-link td:not(:first-child, :last-child)", function(e) {
        if(e.target.title == 'workorder-embed') {
            $('#workorder-embed-data').attr('src', e.target.src || e.target.value) ;
            $('#workorder-img-modal').modal('show');
        } else {
            let workorder = $(this).parent().data('workorder');
            workOrderDetails(workorder);
        }
    });

    $(".view").on("click", function(){
        var workOrder = $(this).parent().parent().parent().parent().parent().data('workOrder');
        workOrderDetails(workOrder);
    });

    function printWorkorder() {
        let divToPrint=document.getElementById('workOrder-details');
        let newWin=window.open('','Print-Window');
        newWin.document.open();
        newWin.document.write('<link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css"><style type="text/css">@media print {.modal-dialog { max-width: 1000px;} }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
        newWin.document.close();
        // setTimeout(() => newWin.close(), 10);
    }

    $('#wrokOrder-table').DataTable( {
        "responsive": false,
        "fixedHeader": true,
        "processing": true,
        "serverSide": true,
        "ajax":{
            url:"/workorder/json/data",
            data:{
                all_permission: all_permission,
                starting_date: starting_date,
                ending_date: ending_date,
                warehouse_id: warehouse_id,
                customer_id: customer_id,
                reference_no: reference_no,
                order_type: order_type,
                priority: priority,
            },
            dataType: "json",
            type:"post"
        },
        "createdRow": function( row, data, dataIndex ) {
            $(row).attr('title', data['id']);
            $(row).addClass('workorder-link');
            $(row).attr('data-workorder', JSON.stringify(data));
            if(data['work_order_status'] == 2 && data['priority'] == "Urgent") {
                $(row).attr('style', 'color: crimson');
            } else if(data['work_order_status'] == 0) {
                $(row).attr('style', 'color: black; font-style: italic');
            } else {
                $(row).attr('style', 'color: black');
            }
        },
        "columns": [
            {"data": "key"},
            {"data": "id"},
            {"data": "date"},
            {"data": "file_preview", "orderable": false},
            {"data": "warehouse_id"},
            {"data": "types", "orderable": false},

            @if(!in_array("hide-workorder-customer-index", $all_permission))
            {"data": "customer_name"},
            {"data": "customer_email"},
            {"data": "customer_phone"},
            @endif

            {"data": "user_id"},
            // {"data": "attachments", "orderable": false},
            {"data": "work_order_note"},
            {"data": "staff_note"},
            {"data": "sales_reference_no"},
            {"data": "priority"},
            {"data": "send_to"},
            {"data": "reference_no"},
            {"data": "status"},
            {"data": "actions", "orderable": false},
        ],
        'language': {
            'lengthMenu': '_MENU_ ',
            'info':      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            'search':  '{{trans("file.Search")}}',
            'paginate': {
                'previous': '<i class="dripicons-chevron-left"></i>',
                'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        order:[['1', 'desc']],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0]
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
                // text: '{{trans("file.PDF")}}',
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
                // text: '{{trans("file.CSV")}}',
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
                // text: '{{trans("file.Print")}}',
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
                    workorder_id.length = 0;
                    $(':checkbox:checked').each(function(i){
                        workorder_id[i] = $(this).closest('tr')[0].title;
                    });
                    if(workorder_id.length && confirm("Are you sure want to delete?")) {
                        $.ajax({
                            type:'POST',
                            url:'/workorder/deletebyselection',
                            data:{
                                workorderIdArray: workorder_id
                            },
                            success:function(data){
                                $('#wrokOrder-table').DataTable().ajax.reload();
                            }
                        });
                    } else if(!workorder_id.length) {
                        alert('Nothing is selected!');
                    }
                }
            },
            {
                extend: 'colvis',
                // text: '{{trans("file.Column visibility")}}',
                text: '<i class="fa fa-eye mr-1" aria-hidden="true"></i> {{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            },
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    });

    var workOrderDataId = [];
    $('#wrokOrder-table tbody').on('click', 'tr', function(e) {
        let checkbox = $(this).find('td:first :checkbox');
        setTimeout(() => {
            const id = this.title;
            if (checkbox[0].checked === true) {
                this.classList.add("selectedId");
                workOrderDataId.push(id);
            } else {
                this.classList.remove("selectedId");
                workOrderDataId = workOrderDataId.filter(e => e !== id)
            }
        }, 500);
    });

    function submitWorkOrderSendTo() {
        let ids = [...new Set(workOrderDataId)];
        const selectSendTo = document.getElementById('workorder__sendto').value;

        if(selectSendTo) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/workorder/postWorkOrderSendTo',
                data: {
                    _token: CSRF_TOKEN,
                    ids: ids,
                    send_to: selectSendTo,
                },
                type: "POST",
                success: function() {
                    // refresh the page
                    window.location.href = "/workorder/redirectWithSuccess";
                },
                error: function() {
                    alert('Something went wrong!');
                }
            });
        }
    }

    function submitWorkOrderStatus() {
        let ids = [...new Set(workOrderDataId)];
        const selectStatus = document.getElementById('workorder__status').value;

        if(selectStatus) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/workorder/postWorkOrderStatus',
                data: {
                    _token: CSRF_TOKEN,
                    ids: ids,
                    status: selectStatus,
                },
                type: "POST",
                success: function() {
                    // refresh the page
                    window.location.href = "/workorder/redirectWithSuccess";
                },
                error: function() {
                    alert('Something went wrong!');
                }
            });
        }
    }

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

    if(all_permission.indexOf("quotes-delete") == -1)
        $('.buttons-delete').addClass('d-none');


    function workOrderDetails(workorder){
        let col1 = `<strong>ID: </strong> ${workorder['id'] || ''}<br/>`;
        col1 += `<strong>Date: </strong> ${workorder['date'] || ''}<br/>`;
        col1 += `<strong>Order No: </strong> ${workorder['reference_no'] || ''}<br/>`;
        col1 += `<strong>Location: </strong> ${workorder['warehouse_id'] || ''}<br/>`;
        col1 += `<strong>Company: </strong> ${workorder['company'] || ''}<br/>`;
        col1 += `<strong>Status: </strong> ${workorder['status'] || ''}<br/><br/>`;

        let col2 = `<strong>Sales Reference ID: </strong> ${workorder['sales_reference_no'] || ''}<br/>`;
        col2 += `<strong>Send To: </strong> ${workorder['send_to'] || ''}<br/>`;

        @if(!in_array("hide-workorder-customer-index", $all_permission))
        col2 += `<strong>Customer: </strong> ${workorder['customer_name'] || ''}<br/>`;
        col2 += `<strong>Email: </strong> ${workorder['customer_email'] || ''}<br/>`;
        col2 += `<strong>Phone: </strong> ${workorder['customer_phone'] || ''}<br/>`;
        @endif

        let col3 = `<strong>Priority: </strong> ${workorder['priority'] || ''}<br/>`;
        col3 += `<strong>Delivery Location: </strong> ${workorder['delivery_location'] || ''}<br/>`;
        col3 += `<strong>Expected Delivery Date: </strong> ${workorder['expected_date'] || ''}<br/>`;
        col3 += `<strong>Stage: </strong> ${workorder['stage'] || ''}<br/>`;
        col3 += `<strong>Employee: </strong> ${workorder['employee'] || ''}<br/><br/>`;

        let html = `<div class="row">
            <div class="col-md-3">${col1}</div>
            <div class="col-md-5">${col2}</div>
            <div class="col-md-4">${col3}</div>
        </div>`;

        html += '<div class="row"><div class="col-12"><label>{{ trans('file.Files Attached') }}</label></div></div>';

        html += '<div class="row"><div class="col-12">';
        workorder['workorder_attachments']?.split(",").forEach(element => {
            html += `<a href="${element}" target="_blank"><embed src="${element}" class="product_image quickview_image" width="80" height="80" ></a>`;
        })
        html += '</div></div>'

        let table = '';
        workorder['products']?.forEach(element => {
            let td = `<td>
                <img src="{{ asset('/images/product/${element.product.image}') }}" alt="product image" class="product_image" width="80" height="80" />
            </td>`;
            td += `<td>${element.product.name || ''}</td>`;
            td += `<td>${element.product_code || ''}</td>`;
            td += `<td>${element.product.category.name || ''}</td>`;
            td += `<td>${element.ordertype.order_type || ''}</td>`;
            td += `<td>${element.color.color || ''}</td>`;
            td += `<td>${element.size.size || ''}</td>`;
            td += `<td>${element.product.qty || ''}</td>`;
            td += `<td>${element.product.note || ''}</td>`;
            table += `<tr>${td}</tr>`;
        });

        $("table.product-workorder-list tbody").append(table);

        let footer = `<p><strong>Work Order Note: </strong> ${workorder['work_order_note'] || ''}</p><br/>`;
        footer += `<p><strong>Staff Note: </strong> ${workorder['staff_note'] || ''}</p><br/>`;
        footer += `<strong>Created By: </strong> ${workorder['user_id'] || ''}`;

        $('#workorder-details-workorderid').val(workorder.id)
        $('#workorder-content').html(html);
        $('#workorder-footer').html(footer);
        $('#workOrder-details').modal('show');
    }

</script>
@endsection
