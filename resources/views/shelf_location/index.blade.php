@extends('layout.main')
@section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

    <!--- header section  --->

    <div class="row ">
        <div class="col-md-12 item-sticky">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Shelf Location')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#Filter" title="{{trans('file.Filter')}}"><i class="fa fa-filter mr-1"></i> {{trans('file.Filter')}}</button>
                            <a href="#" data-toggle="modal" data-target="#importShelf" class="btn btn-primary"><i class="dripicons-copy mr-1"></i> {{trans('file.import')}}</a>
                            <a href="{{route('product.shelf_location.create')}}" class="btn buttons-add"><i class="fa fa-plus mr-1"></i> {{trans('file.add')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--- header section  --->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive mt-3">
                    <table id="shelfLocationTable" class="table table-hover order-list">
                        <thead>
                            <tr>
                                <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                                <th>{{ trans('file.id') }}</th>
                                <th>{{ trans('file.Image') }}</th>
                                <th>{{ trans('file.name') }}</th>
                                <th>{{ trans('file.Code') }}</th>
                                <th>{{ trans('file.Unit') }}</th>
                                <th>{{ trans('file.Variant') }}</th>
                                <th>{{ trans('file.Warehouse') }}</th>
                                <th>{{ trans('file.Shelf A') }}</th>
                                <th>{{ trans('file.Shelf B') }}</th>
                                <th>{{ trans('file.Shelf C') }}</th>
                                <th>{{ trans('file.Shelf D') }}</th>
                                <th>{{ trans('file.Note') }}</th>
                                <th>{{ trans('file.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shelfLocations as $shelfLocation)
                                <tr>
                                    <td></td>
                                    <td>{{ $shelfLocation->id }}</td>
                                    <td>
                                        {{-- <img src="{{ asset('images/product' . $shelfLocation->product->image) }}" alt="product image" class="product_image" width="80" height="80" /> --}}
                                            <img src="{{ asset('/images/product/' . $shelfLocation->product->image) }}" alt="product image" class="product_image" width="80" height="80" />
                                    </td>
                                    <td>{{ $shelfLocation->product->name }}</td>
                                    <td>{{ $shelfLocation->product->code }}</td>
                                    <td>{{ $shelfLocation->product->unit->unit_name }}</td>
                                    @if($shelfLocation->variant_id)
                                    <td>{{ $shelfLocation->variant->name }}</td>
                                    @else
                                    <td>N/A</td>
                                    @endif
                                    <td>{{ $shelfLocation->warehouse->code ?? '' }}</td>
                                    <td>
                                        {{ $shelfLocation->position_A }}
                                    </td>
                                    <td>
                                        {{ $shelfLocation->position_B }}
                                    </td>
                                    <td>
                                        {{ $shelfLocation->position_C }}
                                    </td>
                                    <td>
                                        {{ $shelfLocation->position_D }}
                                    </td>
                                    <td>
                                        {{ $shelfLocation->note }}
                                    </td>
                                    <td>
                                        <a href="{{ route('product.shelf_location.edit', ['id' => $shelfLocation->id]) }}"><button type="button" class="ibtnDel btn btn-md btn-primary"><i class="dripicons-document-edit"></i></button>
                                        </a>
                                        <a href="{{ route('product.shelf_location.destroy', ['id' => $shelfLocation->id]) }}" onclick="return confirm('are you sure? you want to delete this!')"> <button type="button" class="ibtnDel btn btn-md btn-danger"><i class="dripicons-trash"></i></button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="importShelf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'product.shelf_location.import', 'method' => 'post', 'files' => true]) !!}
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">Import Product</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic">
                        <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small></p>
                    <p>{{ trans('file.The correct column order is') }} (product_code*, variant_name*, location_code*, position_A, position_B, position_C,
                    position_D, note)
                        {{ trans('file.and you must follow this') }}.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('file.Upload CSV File') }} *</label>
                                {{ Form::file('file', ['class' => 'form-control', 'required']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label> {{trans('file.Sample File')}}</label>
                                <a href="/public/sample_file/sample_shelf_location.csv" class="btn btn-info btn-block btn-md"><i class="dripicons-download"></i>  {{trans('file.Download')}}</a>
                            </div>
                        </div>
                    </div>
                    {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $("ul#product").siblings('a').attr('aria-expanded', 'true');
        $("ul#product").addClass("show");
        $("ul#product #shelflocation-create-menu").addClass("active");

        $('.selectpicker').selectpicker({
            style: 'btn-link',
        });

        $('[data-toggle="tooltip"]').tooltip();


        // Date Picker
        var date = $('.date');
        date.datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });

        $('body').on('focus', ".expired-date", function() {
            $(this).datepicker({
                format: "yyyy-mm-dd",
                startDate: "<?php echo date('Y-m-d', strtotime('+ 1 days')); ?>",
                autoclose: true,
                todayHighlight: true
            });
        });

        $('#shelfLocationTable').DataTable({
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
                    'targets': [0, 8]
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
                    // text: '{{ trans('file.PDF') }}',
                    text: '<i class="fa fa-file-pdf-o mr-1" aria-hidden="true"></i> {{ trans('file.PDF') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum(dt, true);
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, config);
                        datatable_sum(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    // text: '{{ trans('file.CSV') }}',
                    text: '<i class="fa fa-file-excel-o mr-1" aria-hidden="true"></i> {{ trans('file.CSV') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum(dt, true);
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, config);
                        datatable_sum(dt, false);
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    // text: '{{ trans('file.Print') }}',
                    text: '<i class="fa fa-print mr-1" aria-hidden="true"></i> {{ trans('file.Print') }}',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    action: function(e, dt, button, config) {
                        datatable_sum(dt, true);
                        $.fn.dataTable.ext.buttons.print.action.call(this, e, dt, button, config);
                        datatable_sum(dt, false);
                    },
                    footer: true
                },
                {
                    text: '<i class="fa fa-trash mr-1" aria-hidden="true"></i> {{ trans('file.delete') }}',
                    className: 'buttons-delete',
                    action: function(e, dt, node, config) {
                        if (user_verified == '1') {
                            quotation_id.length = 0;
                            $(':checkbox:checked').each(function(i) {
                                if (i) {
                                    var quotation = $(this).closest('tr').data('quotation');
                                    quotation_id[i - 1] = quotation[13];
                                }
                            });
                            if (quotation_id.length && confirm("Are you sure want to delete?")) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'quotations/deletebyselection',
                                    data: {
                                        quotationIdArray: quotation_id
                                    },
                                    success: function(data) {
                                        alert(data);
                                        dt.rows({
                                            page: 'current',
                                            selected: true
                                        }).remove().draw(false);
                                    }
                                });

                            } else if (!quotation_id.length)
                                alert('Nothing is selected!');
                        } else
                            alert('This feature is disable for demo!');
                    }
                },
                {
                    extend: 'colvis',
                    text: '<i class="fa fa-eye mr-1" aria-hidden="true"></i> {{ trans('file.Column visibility') }}',
                    columns: ':gt(0)'
                },
            ],
            drawCallback: function() {}
        });

        $(window).keydown(function(e) {
            if (e.which == 13) {
                var $targ = $(e.target);
                if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
                    var focusNext = false;
                    $(this).find(":input:visible:not([disabled],[readonly]), a").each(function() {
                        if (this === e.target) {
                            focusNext = true;
                        } else if (focusNext) {
                            $(this).focus();
                            return false;
                        }
                    });
                    return false;
                }
            }
        });
    </script>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
@endsection
