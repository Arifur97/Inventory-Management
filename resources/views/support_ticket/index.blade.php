@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<section>
    <!--- header section  --->
    <div class="row item-sticky">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Support Ticket')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#Filter" title="{{trans('file.Filter')}}"><i class="fa fa-filter mr-1"></i> {{trans('file.Filter')}}</button>
                            <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary"><i class="dripicons-copy mr-1"></i> {{trans('file.import')}}</a>
                            <a href="{{route('support_ticket.create')}}" class="btn buttons-add"><i class="fa fa-plus mr-1"></i> {{trans('file.add')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- header section  --->

    <div class="table-responsive">
        <table id="supportTicket-table" class="table supportTicket-list">
            <thead>
                <tr>
                    <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                    <th>{{trans('file.id')}}</th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.reference')}}</th>
                    <th>{{trans('file.Category')}}</th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Department')}}</th>
                    <th>{{trans('file.Employee')}}</th>
                    <th>{{trans('file.Priority')}}</th>
                    <th>{{trans('file.Subject')}}</th>
                    <th>{{trans('file.User Note')}}</th>
                    <th>{{trans('file.Support Note')}}</th>
                    <th>{{trans('file.Description')}}</th>
                    <th>{{trans('file.User')}}</th>
                    <th>{{trans('file.Status')}}</th>
                    <th class="not-exported" style="border-radius: 0px 5px 5px 0px">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lims_SupportTicket_list as $SupportTicket)
                    <?php
                        if($SupportTicket->status == 1)
                            $status = trans('file.Completed');
                        else
                            $status = trans('file.Pending');
                    ?>
                    <tr>
                        <td></td>
                        <td>{{ $SupportTicket->id }}</td>
                        <td>{{ date($general_setting->date_format, strtotime($SupportTicket->date)) }}</td>
                        <td>{{ $SupportTicket->reference_no ?? "" }}</td>
                        <td>{{ $SupportTicket->category_support->name ?? "" }}</td>
                        <td>{{ $SupportTicket->company->name ?? "" }}</td>
                        <td>{{ $SupportTicket->department->name ?? "" }}</td>
                        <td>{{ $SupportTicket->employee->name ?? "" }}</td>
                        <td>{{ $SupportTicket->priority }}</td>
                        <td>{{ $SupportTicket->subject }}</td>
                        <td>{{ $SupportTicket->user_note }}</td>
                        <td>{{ $SupportTicket->support_note }}</td>
                        <td>{{ $SupportTicket->description }}</td>
                        <td>{{ $SupportTicket->user->name ?? "" }}</td>
                        @if($SupportTicket->status == 1)
                            <td><div class="badge badge-success">{{$status}}</div></td>
                        @else
                            <td><div class="badge badge-danger text-bold">{{$status}}</div></td>
                        @endif
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                    <li>
                                        <a class="btn btn-link" href="{{ route('support_ticket.edit', $SupportTicket->id) }}"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a></button>
                                    </li>
                                    <li class="divider"></li>
                                    {{ Form::open(['route' => ['support_ticket.destroy', $SupportTicket->id], 'method' => 'DELETE'] ) }}
                                    <li>
                                        <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                    </li>
                                    {{ Form::close() }}
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</section>

<script type="text/javascript">

    $("ul#quotation").siblings('a').attr('aria-expanded','true');
    $("ul#quotation").addClass("show");
    $("ul#quotation #quotation-list-menu").addClass("active");

    var quotation_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

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

    $("tr.workOrder-linkquotation-link td:not(:first-child, :last-child)").on("click", function(){
        var workOrder = $(this).parent().data('workOrder');
        workOrderDetails(workOrder);
    });

    $(".view").on("click", function(){
        var workOrder = $(this).parent().parent().parent().parent().parent().data('workOrder');
        workOrderDetails(workOrder);
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('workOrder-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css"><style type="text/css">@media print {.modal-dialog { max-width: 1000px;} }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    $('#supportTicket-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ ',
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
                'targets': [0, 15]
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                    }

                   return data;
                },
                // 'checkboxes': {
                //    'selectRow': true,
                //    'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                // },
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
                // text: '{{trans("file.delete")}}',
                text: '<i class="fa fa-trash mr-1" aria-hidden="true"></i> {{trans("file.delete")}}',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    if(user_verified == '1') {
                        quotation_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                var quotation = $(this).closest('tr').data('quotation');
                                quotation_id[i-1] = quotation[13];
                            }
                        });
                        if(quotation_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'quotations/deletebyselection',
                                data:{
                                    quotationIdArray: quotation_id
                                },
                                success:function(data){
                                    alert(data);
                                    dt.rows({ page: 'current', selected: true }).remove().draw(false);
                                }
                            });

                        }
                        else if(!quotation_id.length)
                            alert('Nothing is selected!');
                    }
                    else
                        alert('This feature is disable for demo!');
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
    } );


    var workOrderDataId = [];
    $('#wrokOrder-table tbody').on('click', 'tr', function(e) {
        let checkbox = $(this).find('td:first :checkbox').trigger('click');
        setTimeout(() => {
            const id = this.getElementsByClassName('id')[0].innerText;
            if (checkbox[0].checked === true) {
                this.getElementsByClassName('id')[0].classList.add("selectedId");
                workOrderDataId.push(id);
            } else {
                this.getElementsByClassName('id')[0].classList.remove("selectedId");
                workOrderDataId = workOrderDataId.filter(e => e !== id)
            }
        }, 500);
    });

    function submitWorkOrderSendTo() {
        let ids = workOrderDataId;
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
        let ids = workOrderDataId;
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

    function workOrderDetails(workOrder){
        $('input[name="work_order_id"]').val(workOrder[13]);

        {{--  smartivy work  --}}

        var htmltext = '<div class="row"><div class="col-md-6 light-blue-border"><div class="col-md-12 p-1 dark-blue"><strong class="pl-2 text-white">{{trans("file.To")}}:</strong></div><span class="ml-2">'+workOrder[9]+'<br>'+workOrder[10]+'<br>'+workOrder[11]+'<br>'+workOrder[12]+'<br></span></div><div class="col-md-6"><div class="light-blue-border"><strong class="dark-blue d-block p-1 pl-2 text-white">{{trans("file.Date")}}:</strong>'+workOrder[0]+'<br/></div><br/><div class="light-blue-border"><strong class="dark-blue d-block p-1 pl-2 text-white">{{trans("file.reference")}}: </strong>'+workOrder[1] +'</div></div></div>';
        $.get('workorder/product_workOder/' + workOrder[13], function(data){
            $(".product-workOrder-list tbody").remove();
            var name_code = data[0];
            var qty = data[1];
            var unit_code = data[2];
            var tax = data[3];
            var tax_rate = data[4];
            var discount = data[5];
            var subtotal = data[6];
            var newBody = $("<tbody>");
            $.each(name_code, function(index){
                var newRow = $("<tr>");
                var cols = '';
                cols += '<td style="text-align:center;"><strong>' + (index+1) + '</strong></td>';
                cols += '<td>' + name_code[index] + '</td>';
                cols += '<td style="text-align:center;">' + qty[index] + ' ' + unit_code[index] + '</td>';
                cols += '<td style="text-align:right;">' + parseFloat(subtotal[index] / qty[index]).toFixed(2) + '</td>';
                {{-- cols += '<td>' + tax[index] + '(' + tax_rate[index] + '%)' + '</td>'; --}}
                {{-- cols += '<td>' + discount[index] + '</td>'; --}}
                cols += '<td style="text-align:right;">' + subtotal[index] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);
            });

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=2><strong>{{trans("file.Total")}}:</strong></td>';
            cols += '<td style="text-align:center;">' + workOrder[14] + '</td>';
            cols += '<td style="text-align:right;">' + workOrder[15] + '</td>';
            cols += '<td style="text-align:right;">' + workOrder[16] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Order Tax")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + workOrder[17] + '(' + workOrder[18] + '%)' + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Order Discount")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + workOrder[19] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Shipping Cost")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + workOrder[20] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4 style="font-weight:bold; font-size: 20px"><strong >{{trans("file.grand total")}}:</strong></td>';
            cols += '<td style="font-weight:bold; font-size: 22px;text-align:right;">' + workOrder[21] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            $("table.product-workOrder-list").append(newBody);
        });



        var htmlfooter = '<strong class="dark-blue d-block p-1 pl-2 text-white">{{trans("file.Note")}}: </strong>'+workOrder[22] +'<br/><br/><br/><br/>';
        $('#quotation-content').html(htmltext);
        $('#quotation-footer').html(htmlfooter);
        $('#workOrder-details').modal('show');
    }
</script>
@endsection
