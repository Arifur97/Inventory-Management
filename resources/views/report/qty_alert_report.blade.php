@extends('layout.main') @section('content')

<section class="forms">

    <!--- header section  --->

    <div class="row item-sticky">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Product Quantity Alert')}}</h3>
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


    <div class="table-responsive mb-4">
        <table id="report-table" class="table table-hover" style="width: 100%">
            <thead>
                <tr>
                    <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                    <th>{{trans('file.Image')}}</th>
                    <th>{{trans('file.Product Name')}}</th>
                    <th>{{trans('file.Product Code')}}</th>
                    <th>{{trans('file.Quantity')}}</th>
                    <th style="border-radius: 0px 5px 5px 0px">{{trans('file.Alert Quantity')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_product_data as $key=>$product)
                <tr>
                    <td>{{$key}}</td>
                    <td>
                    <?php
                        $images = explode(",", $product->image);
                        $product->base_image = $images[0];
                    ?>
                        <!-- <img src="{{url('/images/product',$product->base_image)}}" height="80" width="80"> -->
                        <img src="{{url('/images/product',$product->base_image)}}" class="product_image" alt="product image" width="80" height="80"/>
                    </td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->code}}</td>
                    <td>{{number_format((float)($product->qty), 2, '.', '')}}</td>
                    <td>{{number_format((float)($product->alert_quantity), 2, '.', '')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #qtyAlert-report-menu").addClass("active");

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
                text: '<i class="fa fa-file-pdf-o mr-1" aria-hidden="true"></i> {{trans("file.PDF")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                text: '<i class="fa fa-file-excel-o mr-1" aria-hidden="true"></i> {{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print mr-1" aria-hidden="true"></i> {{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'colvis',
                text: '<i class="fa fa-eye mr-1" aria-hidden="true"></i> {{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            }
        ],
    } );

</script>
@endsection
