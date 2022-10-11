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
                        <h3>{{trans('file.Purchase Receiving')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            @if(in_array("purchases-add", $all_permission))
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#Filter" title="{{trans('file.Filter')}}"><i class="fa fa-filter mr-1"></i> {{trans('file.Filter')}}</button>
                            <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary"><i class="dripicons-copy mr-1"></i> {{trans('file.import')}}</a>
                            <a href="{{route('purchase_receiving.create')}}" class="btn buttons-add"><i class="fa fa-plus mr-1"></i> {{trans('file.add')}}</a>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- header section  --->

    <div class="table-responsive">
        <table id="purchase_receiving_table" class="table purchase-list" style="width: 100%">
            <thead>
                <tr>
                    <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.reference')}}</th>
                    <th>{{trans('file.Purchase ID')}}</th>
                    <th>{{trans('file.Purchase Ref No')}}</th>
                    <th>{{trans('file.Warehouse')}}</th>
                    <th>{{trans('file.Supplier')}}</th>
                    <th>{{trans('file.Purchase Status')}}</th>
                    <th class="not-exported" style="border-radius: 0px 5px 5px 0px">{{trans('file.action')}}</th>
                </tr>
            </thead>

            <tbody>
                @foreach($lims_purchase_receiving_all as $key=>$purchase_receiving)

                <tr class="workOrder-link" data-workOrder='["{{date($general_setting->date_format, strtotime($purchase_receiving->created_at->toDateString()))}}", "{{$purchase_receiving->reference_no}}", "{{$purchase_receiving->id}}", "{{$purchase_receiving->note}}"]'>
                    <td>{{$key}}</td>
                    <td>{{ date($general_setting->date_format, strtotime($purchase_receiving->created_at->toDateString())) }}</td>
                    <td>{{ $purchase_receiving->reference_no }}</td>
                    <td>{{ $purchase_receiving->purchase_id }}</td>
                    <td>{{ $purchase_receiving->purchase_reference_no }}</td>

                    @if($purchase_receiving->warehouse_id)
                    <td>{{ $purchase_receiving->warehouse->name }}</td>
                    @endif

                    @if($purchase_receiving->warehouse_id)
                    <td>{{ $purchase_receiving->supplier->name }}</td>
                    @endif

                    @if($purchase_receiving->status == 1)
                        <td><div class="badge badge-success">Recieved</div></td>
                    @elseif($purchase_receiving->status == 2)
                        <td><div class="badge badge-primary">Partial</div></td>
                    @elseif($purchase_receiving->status == 3)
                        <td><div class="badge badge-danger">Pending</div></td>
                    @elseif($purchase_receiving->status == 4)
                        <td><div class="badge badge-bule">Ordered</div></td>
                    @endif

                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i>  {{trans('file.View')}}</button>
                                </li>
                                @if(in_array("quotes-edit", $all_permission))
                                <li>
                                    <a class="btn btn-link" href="{{ route('purchase_receiving.edit', $purchase_receiving->id) }}"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a></button>
                                </li>
                                @endif
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['purchase_receiving.destroy', $purchase_receiving->id], 'method' => 'DELETE'] ) }}
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

<div id="purchase-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="container mt-3 pb-2 border-bottom">
            {{--  smartivy work  --}}

            <div class="row">


                <div class="col-md-12">
                    <div class="col-md-9 float-left">
                        <button id="print-btn" type="button" class="btn btn-default btn-sm d-print-none"><i class="dripicons-print"></i> {{trans('file.Print')}}</button>
                    {{ Form::open(['route' => 'quotation.sendmail', 'method' => 'post', 'class' => 'sendmail-form'] ) }}
                        <input type="hidden" name="quotation_id">
                        <button class="btn btn-default btn-sm d-print-none"><i class="dripicons-mail"></i> {{trans('file.Email')}}</button>
                    {{ Form::close() }}
                    </div>
                    <div class="col-md-3 float-left">
                        <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close d-print-none"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                </div>
            </div>



            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="col-md-7 float-left">
                        <h3 id="exampleModalLabel" class="modal-title container-fluid">
                            <img style="width: 50%" src="{{asset('public/images/CompanyLogoHeaderTemplate.png') }}">
                        </h3>
                    </div>

                    <div class="col-md-5 float-left text-right">
                        <span class="mt-3" style="font-size: 28px;font-weight:bold; text-transform: uppercase">{{trans('file.Purchase Details')}}</span>
                    </div>
                </div>
            </div>
        </div>
            <div id="purchase-content" class="modal-body"></div>
            <br>
            <table class="table table-bordered product-purchase-list">
                <thead class="dark-blue"style="color: white!important;text-align:center;">
                    <th style="color:  white!important;">#</th>
                    <th style="color:  white!important;">{{trans('file.product')}}</th>
                    <th style="color:  white!important;">Qty</th>
                    <th style="color:  white!important;">{{trans('file.Unit Price')}}</th>
                    {{-- <th style="color:  white!important;">{{trans('file.Tax')}}</th> --}}
                    {{-- <th style="color:  white!important;">{{trans('file.Discount')}}</th> --}}
                    <th style="color:  white!important;">{{trans('file.Subtotal')}}</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="purchase-footer" class="modal-body"></div>
      </div>
    </div>
</div>

<script type="text/javascript">

    $(".daterangepicker-field").daterangepicker({
      callback: function(startDate, endDate, period){
        var starting_date = startDate.format('YYYY-MM-DD');
        var ending_date = endDate.format('YYYY-MM-DD');
        var title = starting_date + ' To ' + ending_date;
        $(this).val(title);
        $('input[name="starting_date"]').val(starting_date);
        $('input[name="ending_date"]').val(ending_date);
      }
    });

    $('.selectpicker').selectpicker('refresh');

    $("ul#purchase").siblings('a').attr('aria-expanded','true');
    $("ul#purchase").addClass("show");
    $("ul#purchase #purchase-list-menu").addClass("active");



    var purchase_id = [];
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

    $(document).on("click", "tr.purchase-link td:not(:first-child, :last-child)", function(){
        var purchase = $(this).parent().data('purchase');
        purchaseDetails(purchase);
    });

    $(document).on("click", ".view", function(){
        var purchase = $(this).parent().parent().parent().parent().parent().data('purchase');
        purchaseDetails(purchase);
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('purchase-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css"><style type="text/css">@media print {.modal-dialog { max-width: 1000px;} }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    $(document).on("click", "table.purchase-list tbody .add-payment", function(event) {
        $("#cheque").hide();
        $(".card-element").hide();
        $('select[name="paid_by_id"]').val(1);
        rowindex = $(this).closest('tr').index();
        var purchase_id = $(this).data('id').toString();
        var balance = $('table.purchase-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(8)').text();
        balance = parseFloat(balance.replace(/,/g, ''));
        $('input[name="amount"]').val(balance);
        $('input[name="balance"]').val(balance);
        $('input[name="paying_amount"]').val(balance);
        $('input[name="purchase_id"]').val(purchase_id);
    });

    $(document).on("click", "table.purchase-list tbody .get-payment", function(event) {
        var id = $(this).data('id').toString();
        $.get('purchases/getpayment/' + id, function(data) {
            $(".payment-list tbody").remove();
            var newBody = $("<tbody>");
            payment_date  = data[0];
            payment_reference = data[1];
            paid_amount = data[2];
            paying_method = data[3];
            payment_id = data[4];
            payment_note = data[5];
            cheque_no = data[6];
            change = data[7];
            paying_amount = data[8];
            account_name = data[9];
            account_id = data[10];

            $.each(payment_date, function(index){
                var newRow = $("<tr>");
                var cols = '';

                cols += '<td>' + payment_date[index] + '</td>';
                cols += '<td>' + payment_reference[index] + '</td>';
                cols += '<td>' + account_name[index] + '</td>';
                cols += '<td>' + paid_amount[index] + '</td>';
                cols += '<td>' + paying_method[index] + '</td>';
                cols += '<td><div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu"><li><button type="button" class="btn btn-link edit-btn" data-id="' + payment_id[index] +'" data-clicked=false data-toggle="modal" data-target="#edit-payment"><i class="dripicons-document-edit"></i> Edit</button></li><li class="divider"></li>{{ Form::open(['route' => 'purchase.delete-payment', 'method' => 'post'] ) }}<li><input type="hidden" name="id" value="' + payment_id[index] + '" /> <button type="submit" class="btn btn-link" onclick="return confirmDeletePayment()"><i class="dripicons-trash"></i> Delete</button></li>{{ Form::close() }}</ul></div></td>'
                newRow.append(cols);
                newBody.append(newRow);
                $("table.payment-list").append(newBody);
            });
            $('#view-payment').modal('show');
        });
    });

    $(document).on("click", "table.payment-list .edit-btn", function(event) {
        $(".edit-btn").attr('data-clicked', true);
        $(".card-element").hide();
        $("#edit-cheque").hide();
        $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', false);
        var id = $(this).data('id').toString();
        $.each(payment_id, function(index){
            if(payment_id[index] == parseFloat(id)){
                $('input[name="payment_id"]').val(payment_id[index]);
                $('#edit-payment select[name="account_id"]').val(account_id[index]);
                if(paying_method[index] == 'Cash')
                    $('select[name="edit_paid_by_id"]').val(1);
                else if(paying_method[index] == 'Credit Card'){
                    $('select[name="edit_paid_by_id"]').val(3);
                    $.getScript( "public/vendor/stripe/checkout.js" );
                    $(".card-element").show();
                    $("#edit-cheque").hide();
                    $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', true);
                }
                else{
                    $('select[name="edit_paid_by_id"]').val(4);
                    $("#edit-cheque").show();
                    $('input[name="edit_cheque_no"]').val(cheque_no[index]);
                    $('input[name="edit_cheque_no"]').attr('required', true);
                }
                $('input[name="edit_date"]').val(payment_date[index]);
                $("#payment_reference").html(payment_reference[index]);
                $('input[name="edit_amount"]').val(paid_amount[index]);
                $('input[name="edit_paying_amount"]').val(paying_amount[index]);
                $('.change').text(change[index]);
                $('textarea[name="edit_payment_note"]').val(payment_note[index]);
                return false;
            }
        });
        $('.selectpicker').selectpicker('refresh');
        $('#view-payment').modal('hide');
    });


    $('#purchase_receiving_table').DataTable( {
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

    function purchaseDetails(purchase){

        var htmltext = '<div class="row"><div class="col-md-6 light-blue-border"><div class="col-md-12 p-1 dark-blue"><strong class="pl-2 text-white">{{trans("file.To")}}:</strong></div><span class="ml-2">'+purchase[9]+'<br>'+purchase[10]+'<br>'+purchase[11]+'<br>'+purchase[12]+'<br></span></div><div class="col-md-6"><div class="light-blue-border"><strong class="dark-blue d-block p-1 pl-2 text-white">{{trans("file.Date")}}:</strong>'+purchase[0]+'<br/></div><br/><div class="light-blue-border"><strong class="dark-blue d-block p-1 pl-2 text-white">{{trans("file.reference")}}: </strong>'+purchase[1] +'</div></div></div>';


        $.get('purchase_receiving/product_purchase_receiving/' + purchase[3], function(data){
            $(".product-purchase-list tbody").remove();
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
            cols += '<td style="text-align:center;">' + purchase[13] + '</td>';
            cols += '<td style="text-align:right;">' + purchase[14] + '</td>';
            cols += '<td style="text-align:right;">' + purchase[15] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Order Tax")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + purchase[16] + '(' + purchase[17] + '%)' + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Order Discount")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + purchase[18] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Shipping Cost")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + purchase[19] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.grand total")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + purchase[20] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Paid Amount")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + purchase[21] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Due")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + (purchase[20] - purchase[21]) + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

             $("table.product-purchase-list").append(newBody);
        });

        var htmlfooter = '<p><strong class="dark-blue d-block p-1 pl-2 text-white">{{trans("file.Note")}}:</strong> '+purchase[22]+'</p><strong class="dark-blue d-block p-1 pl-2 text-white">{{trans("file.Created By")}}:</strong><br>'+purchase[23]+'<br>'+purchase[24];

        $('#purchase-content').html(htmltext);
        $('#purchase-footer').html(htmlfooter);
        $('#purchase-details').modal('show');
    }

    $(document).on('submit', '.payment-form', function(e) {
        if( $('input[name="paying_amount"]').val() < parseFloat($('#amount').val()) ) {
            alert('Paying amount cannot be bigger than recieved amount');
            $('input[name="amount"]').val('');
            $(".change").text(parseFloat( $('input[name="paying_amount"]').val() - $('#amount').val() ).toFixed(2));
            e.preventDefault();
        }
        else if( $('input[name="edit_paying_amount"]').val() < parseFloat($('input[name="edit_amount"]').val()) ) {
            alert('Paying amount cannot be bigger than recieved amount');
            $('input[name="edit_amount"]').val('');
            $(".change").text(parseFloat( $('input[name="edit_paying_amount"]').val() - $('input[name="edit_amount"]').val() ).toFixed(2));
            e.preventDefault();
        }

        $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', false);
    });

    if(all_permission.indexOf("purchases-delete") == -1)
        $('.buttons-delete').addClass('d-none');


</script>
@endsection @section('scripts')
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

@endsection
