@extends('layout.main')
@section('content')
<section class="forms">
    
    <!--- header section  --->

    <div class="row item-sticky">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.All Customer Due Report')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">                            
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#Filter" title="{{trans('file.Filter')}}"><i class="fa fa-filter mr-1"></i> {{trans('file.Filter')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--- header section  --->
   
    <div class="table-responsive">
        <table id="report-table" class="table table-hover" style="width: 100%">
            <thead>
                <tr>
                    <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                    <th>{{trans('file.id')}}</th>
                    <th>{{trans('file.Customer')}}</th>
                    <th>{{trans('file.Company')}}</th>
                    <th>{{trans('file.Sales')}}</th>
                    <th>{{trans('file.Return')}}</th>
                    <th>{{trans('file.Total')}}</th>
                    <th>{{trans('file.Paid')}}</th>
                    <th style="border-radius: 0px 5px 5px 0px" class="text-right">{{trans('file.Balance')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chunk as $li)
                    <tr>
                        <td></td>
                        <td>{{ $li['customer']['id'] }}</td>
                        <td>{{ $li['customer']['name'] }}</td>
                        <td>{{ $li['customer']['company_name'] }}</td>
                        <td class="text-right">{{ $li['sale'] }}</td>
                        <td class="text-right">{{ $li['return'] }}</td>
                        <td class="text-right">{{ $li['sale'] - $li['return'] }}</td>
                        <td class="text-right">{{ $li['paid'] }}</td>
                        <td class="grand-total text-right">{{ number_format($li['sale'] - $li['return'] - $li['paid'], 2) }}</td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <th></th>
                <th>Total</th>
                <th></th>
                <th></th>
                <th class="text-right">0</th>
                <th class="text-right">0</th>
                <th class="text-right">0</th>
                <th class="text-right">0</th>
                <th class="text-right">0</th>
            </tfoot>
        </table>
    </div>
</section>


<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #purchase-report-menu").addClass("active");

    $('#warehouse_id').val($('input[name="warehouse_id_hidden"]').val());
    $('.selectpicker').selectpicker('refresh');

    $('#report-table').DataTable( {
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
                'targets': 0
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
                    columns: ':visible:not(.not-exported)',
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
                    columns: ':visible:not(.not-exported)',
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
                text: '<i class="fa fa-print mr-1" aria-hidden="true"></i>  {{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:not(.not-exported)',
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
                extend: 'colvis',
                // text: '{{trans("file.Column visibility")}}',
                text: '<i class="fa fa-eye mr-1" aria-hidden="true"></i>  {{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            }
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 4 ).footer() ).html(dt_selector.cells( rows, 4, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.cells( rows, 5, { page: 'current' } ).data().sum());
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum());
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum());
            $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 4 ).footer() ).html(dt_selector.column( 4, {page:'current'} ).data().sum().toFixed(2));
            $( dt_selector.column( 5 ).footer() ).html(dt_selector.column( 5, {page:'current'} ).data().sum());
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.column( 6, {page:'current'} ).data().sum());
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.column( 7, {page:'current'} ).data().sum());
            $( dt_selector.column( 8 ).footer() ).html(dt_selector.column( 8, {page:'current'} ).data().sum().toFixed(2));
        }
    }
</script>
@endsection
