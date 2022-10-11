@extends('layout.main')
@section('content')
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
                        <h3>{{trans('file.Stock Adjustment')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#Filter" title="{{trans('file.Filter')}}"><i class="fa fa-filter mr-1"></i> {{trans('file.Filter')}}</button>
                            <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary"><i class="dripicons-copy mr-1"></i> {{trans('file.import')}}</a>
                            <a href="{{route('qty_adjustment.create')}}" class="btn buttons-add"><i class="fa fa-plus mr-1"></i> {{trans('file.add')}}</a>                          
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--- header section  --->

    <div class="table-responsive">
        <table id="adjustment-table" class="table purchase-list">
            <thead>
                <tr>
                    <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.reference')}}</th>
                    <th>{{trans('file.Warehouse')}}</th>
                    <th>{{trans('file.product')}}s</th>
                    <th>{{trans('file.Note')}}</th>
                    <th class="not-exported" style="border-radius: 0px 5px 5px 0px">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_adjustment_all as $key=>$adjustment)
                <tr data-id="{{$adjustment->id}}">
                    <td>{{$key}}</td>
                    <td>{{ date('d-m-Y', strtotime($adjustment->created_at->toDateString())) . ' '. $adjustment->created_at->toTimeString() }}</td>
                    <td>{{ $adjustment->reference_no }}</td>
                    <?php $warehouse = DB::table('warehouses')->find($adjustment->warehouse_id) ?>
                    <td>{{ $warehouse->name }}</td>
                    <td>
                    <?php
                    	$product_adjustment_data = DB::table('product_adjustments')->where('adjustment_id', $adjustment->id)->get();
                    	foreach ($product_adjustment_data as $key => $product_adjustment) {
                            if($product_adjustment->variant_id) {
                                $product = DB::table('products')
                                        ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                                        ->select('products.name','product_variants.item_code as code')
                                        ->where([
                                            ['product_id', $product_adjustment->product_id],
                                            ['variant_id', $product_adjustment->variant_id]
                                        ])->first();
                            }
                            else {
                                $product = DB::table('products')->select('name','code')->find($product_adjustment->product_id);
                            }

                    	 	if($key)
                    	 		echo '<br>';
                    	 	echo $product->name.' ['.$product->code.']';
                    	 }
                    ?>
                    </td>
                    <td>{{$adjustment->note}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}<span class="caret"></span><span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <a href="{{ route('qty_adjustment.edit', $adjustment->id) }}" class="btn btn-link"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a>
                                </li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['qty_adjustment.destroy', $adjustment->id], 'method' => 'DELETE'] ) }}
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
    $("ul#product").siblings('a').attr('aria-expanded','true');
    $("ul#product").addClass("show");
    $("ul#product #adjustment-list-menu").addClass("active");

    function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    var adjustment_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#adjustment-table').DataTable( {
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
                'targets': [0, 6]
            },
            {
                'checkboxes': {
                   'selectRow': true
                },
                'targets': 0
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
                footer:true
            },
            {
                extend: 'csv',
                text: '<i class="fa fa-file-excel-o mr-1" aria-hidden="true"></i> {{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
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
                footer:true
            },
            {
                text: '<i class="fa fa-trash mr-1" aria-hidden="true"></i> {{trans("file.delete")}}',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    if(user_verified == '1') {
                        adjustment_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                adjustment_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(adjustment_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'qty_adjustment/deletebyselection',
                                data:{
                                    adjustmentIdArray: adjustment_id
                                },
                                success:function(data){
                                    alert(data);
                                }
                            });
                            dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!adjustment_id.length)
                            alert('Nothing is selected!');
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
    } );
</script>
@endsection
