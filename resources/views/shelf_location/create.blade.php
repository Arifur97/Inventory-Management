@extends('layout.main')
@section('content')
@if (session()->has('not_permitted'))
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close"
            data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<section class="forms">
    <div>
        {!! Form::open(['route' => 'products.shelf_store', 'method' => 'post', 'files' => true, 'id' => 'purchase-form']) !!}
        <div class="row ">
            <div class="col-md-12 item-sticky">
                <div class="card ">
                    <div class="card-body item-page">
                        <div class="float-left brand-text mt-2 pl-4">
                            <h3>{{trans('file.Add Shelf Location')}}</h3>
                        </div>
                        <div class="float-right mr-2">
                            <div class="form-group">
                                <a href="{{route('product.shelf_location')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
                                <button type="submit" id="submit-btn" class="btn btn-primary"><i class="fa fa-check mr-1"></i>{{trans('file.submit')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-12 mt-2">
                                        <label>{{ trans('file.Select Product') }}</label>
                                        <div class="search-box input-group">
                                            <button type="button" class="btn btn-secondary"><i
                                                    class="fa fa-barcode"></i></button>
                                            <input type="text" name="product_code_name" id="lims_productcodeSearch"
                                                placeholder="Please type product code and select..."
                                                class="form-control" />

                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#bulkProduct" title="{{ trans('file.Add multiple products from list') }}"><i class="fa fa-plus"></i> <i class="fa fa-bars"></i></button>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <h5>{{ trans('file.Order Table') }}<i class="fa fa-asterisk"></i></h5>
                                            <div class="table-responsive mt-3">
                                                <table id="myTable" class="table table-hover order-list">
                                                    <thead>
                                                        <tr>
                                                            <th style="border-radius: 5px 0px 0px 5px">
                                                                {{ trans('file.Image') }}
                                                            </th>
                                                            <th>{{ trans('file.name') }}</th>
                                                            <th>{{ trans('file.Code') }}</th>
                                                            <th>{{ trans('file.Unit') }}</th>
                                                            <th>{{ trans('file.Warehouse') }}</th>
                                                            <th>{{ trans('file.Variant') }}</th>
                                                            <th>{{ trans('file.Shelf A') }}</th>
                                                            <th>{{ trans('file.Shelf B') }}</th>
                                                            <th>{{ trans('file.Shelf C') }}</th>
                                                            <th>{{ trans('file.Shelf D') }}</th>
                                                            <th>{{ trans('file.Note') }}</th>
                                                            <th>{{ trans('file.action') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="displayProducts">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>


    {{-- Add Bulk Products --}}
    <div id="bulkProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header item-page">
                    <div class="col-md-12">
                        <div class="float-left brand-text mt-2">
                            <h3>{{ trans('file.Add Multiple Products') }}</h3>
                        </div>
                        <div class="float-right">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="float-right">
                            <div class="form-group">
                                <button type="button" class="btn btn-save"
                                    title="{{ trans('file.Use ctrl+s to save') }}" onclick="AddProducts()"><i
                                        class="fa fa-plus mr-1" aria-hidden="true"></i>
                                    {{ trans('file.Add Products') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="bulkproduct-table" class="table quotation-list">
                            <thead>
                                <tr>
                                    <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                                    <th>{{ trans('file.Image') }}</th>
                                    <th>{{ trans('file.name') }}</th>
                                    <th>{{ trans('file.Code') }}</th>
                                    <th>{{ trans('file.category') }}</th>
                                    <th>{{ trans('file.Brand') }}</th>
                                    <th class="text-right">{{ trans('file.Stock Available') }}</th>
                                    <th style="border-radius: 0px 5px 5px 0px">{{ trans('file.Unit') }}</th>
                                    <th class="d-none">{{ trans('file.ID') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lims_product_list as $key => $product)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>
                                            <img src="{{ asset("/images/product/$product->image") }}"
                                                alt="product image" class="product_image" width="80" height="80" />
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td class="font-weight-bold">{{ $product->code }}</td>
                                        <td>{{ $product->category->name ?? '' }}</td>
                                        {{-- <td></td> --}}
                                        @if ($product->brand_id)
                                            <td>{{ $product->brand->title ?? '' }}</td>
                                            {{-- <td></td> --}}
                                        @else
                                            <td>N/A</td>
                                        @endif
                                        <td class="text-right">{{ $product->qty }}</td>
                                        @if ($product->unit_id)
                                            <td>{{ $product->unit->unit_code }}</td>
                                            {{-- <td></td> --}}
                                        @else
                                            <td>N/A</td>
                                        @endif
                                        <td class="d-none id">{{ $product->id }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
    <script type="text/javascript">
        $("ul#product").siblings('a').attr('aria-expanded', 'true');
        $("ul#product").addClass("show");
        $("ul#product #shelflocation-create-menu").addClass("active");

        // array data depend on warehouse
        var product_code = [];
        var product_name = [];
        var product_qty = [];

        // array data with selection
        var product_cost = [];
        var product_discount = [];
        var tax_rate = [];
        var tax_name = [];
        var tax_method = [];
        var unit_name = [];
        var unit_operator = [];
        var unit_operation_value = [];

        // temporary array
        var temp_unit_name = [];
        var temp_unit_operator = [];
        var temp_unit_operation_value = [];

        var rowindex;
        var customer_group_rate;
        var row_product_cost;

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


        var lims_productcodeSearch = $('#lims_productcodeSearch');
        lims_productcodeSearch.autocomplete({
            source: function(request, response) {
                var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
                response($.grep(lims_product_array, function(item) {
                    return matcher.test(item);
                }));
            },
            response: function(event, ui) {
                if (ui.content.length == 1) {
                    var data = ui.content[0].value;
                    $(this).autocomplete("close");
                    productSearch(data);
                };
            },
            select: function(event, ui) {
                var data = ui.item.value;
                productSearch(data);
            }
        });

        $('body').on('focus', ".expired-date", function() {
            $(this).datepicker({
                format: "yyyy-mm-dd",
                startDate: "<?php echo date('Y-m-d', strtotime('+ 1 days')); ?>",
                autoclose: true,
                todayHighlight: true
            });
        });

        $('#bulkproduct-table tbody').on('click', 'tr', function(e) {
            var checkbox = $(this).find('td:first :checkbox').trigger('click');
            setTimeout(() => {
                if (checkbox[0].checked === true) {
                    this.getElementsByClassName('id')[0].classList.add("selectedId");
                } else {
                    this.getElementsByClassName('id')[0].classList.remove("selectedId");
                }
            }, 500);
        });

        function AddProducts() {
            let selectedIds = document.getElementsByClassName('selectedId');
            let ids = [];
            for (let selectedId of selectedIds) {
                ids.push(selectedId.innerText);
            }
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/products/getSelectedProducts',
                data: {
                    _token: CSRF_TOKEN,
                    ids: ids,
                },
                type: "POST",
                success: function(jsonData) {
                    console.log(jsonData);
                    AddProductsToTable(jsonData);
                    $('#bulkProduct').modal('hide');
                },
                error: function() {
                    alert('Something went wrong!');
                }
            });
        }
        // global variable of data table id
        var shelfLocationTableDataId = [];

        function hasDataOnTable(id) {
            for (let i = 0; i < shelfLocationTableDataId.length; i++)
                if (shelfLocationTableDataId[i] == id) return false;
            shelfLocationTableDataId.push(id);
            return true;
        }

        function AddProductsToTable(data) {
            console.log(data);
            for (let product in data['products']) {
                console.log(product);
                if (hasDataOnTable(data['products'][product]['id'])) {
                    let imgSrc = window.location.protocol + '//' + window.location.hostname + '/' + window.location.port +
                        '/images/product/' + data['products'][product]['image'];
                    let newRow = $("<tr>");
                    let cols = '';
                    pos = product_code.indexOf(product.code);
                    cols += '<td> <img src="' + imgSrc + '" class="product_image" width="80" height="80"/> </td>';
                    cols += '<td>' + data['products'][product]['name'] + '</td>';
                    cols += '<td>' + data['products'][product]['code'] + '</td>';
                    cols += '<td>' + data['products'][product]['unit']['unit_name'] + '</td>';
                    cols += '<td>';

                    cols += '<select name="warehouse_id[]" class="form-control" required>';
                    cols += '<option disabled selected>Select</option>';
                    data['warehouses'].forEach(e => {
                        cols += `<option value="${e.id}">${e.name}</option>`;
                    });
                    cols += '</select>';
                    cols += '</td>';
                    cols += '<td>';
                    cols += '<select name="variant_id[]" class="form-control" required>';
                    cols += '<option disabled selected>Select</option>';
                    data['products'][product]['variant'].forEach(e => {
                        cols += `<option value="${e.id}">${e.name}</option>`;
                    });
                    cols += '</select>';
                    cols += '</td>';
                    cols += '<td><input type="text" class="form-control" name="shelfA[]"/></td>';
                    cols += '<td><input type="text" class="form-control" name="shelfB[]"/></td>';
                    cols += '<td><input type="text" class="form-control" name="shelfC[]"/></td>';
                    cols += '<td><input type="text" class="form-control" name="shelfD[]"/></td>';
                    cols += '<td><input type="text" class="form-control" name="pnote[]"/></td>';
                    cols +=
                        '<td><button type="button" onclick="removeProductTableItem(this);" class="ibtnDel btn btn-md btn-danger"><i class="dripicons-trash"></i></button></td>';
                    cols += '<input type="hidden" class="form-control" name="product_id[]" value="' + data['products'][product][
                        'id'
                    ] + '"/>';

                    newRow.append(cols);
                    $("table.order-list tbody").prepend(newRow);
                }
            }

        }

        function removeProductTableItem(qty) {
            var td = event.target.parentNode;
            var tr = td.parentNode.parentNode;
            tr.parentNode.removeChild(tr);
        }


        $('#bulkproduct-table').DataTable({
            responsive: true,
            fixedHeader: {
                header: true,
                footer: true
            },
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
            'columnDefs': [{
                    "orderable": false,
                    'targets': []
                },
                {
                    'render': function(data, type, row, meta) {
                        if (type === 'display') {
                            data =
                                '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                    // 'checkboxes': {
                    //     'selectRow': true,
                    //     'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes" id="dt-checkbox-checked"><label></label></div>'
                    // },
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
            buttons: [

            ],
            drawCallback: function() {
                // var api = this.api();
                // datatable_sum(api, false);
            }
        });

        //Delete product
        $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
            rowindex = $(this).closest('tr').index();
            product_cost.splice(rowindex, 1);
            product_discount.splice(rowindex, 1);
            tax_rate.splice(rowindex, 1);
            tax_name.splice(rowindex, 1);
            tax_method.splice(rowindex, 1);
            unit_name.splice(rowindex, 1);
            unit_operator.splice(rowindex, 1);
            unit_operation_value.splice(rowindex, 1);
            console.log(product_cost);
            $(this).closest("tr").remove();
            calculateTotal();
        });

        //Edit product
        $("table.order-list").on("click", ".edit-product", function() {
            rowindex = $(this).closest('tr').index();
            var row_product_name = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
                'td:nth-child(1)').text();
            var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find(
                'td:nth-child(2)').text();
            $('#modal-header').text(row_product_name + '(' + row_product_code + ')');

            var qty = $(this).closest('tr').find('.qty').val();
            $('input[name="edit_qty"]').val(qty);

            $('input[name="edit_discount"]').val(parseFloat(product_discount[rowindex]).toFixed(2));

            unitConversion();
            $('input[name="edit_unit_cost"]').val(row_product_cost.toFixed(2));

            $('select[name="edit_tax_rate"]').val(pos);

            temp_unit_name = (unit_name[rowindex]).split(',');
            temp_unit_name.pop();
            temp_unit_operator = (unit_operator[rowindex]).split(',');
            temp_unit_operator.pop();
            temp_unit_operation_value = (unit_operation_value[rowindex]).split(',');
            temp_unit_operation_value.pop();
            $('select[name="edit_unit"]').empty();
            $.each(temp_unit_name, function(key, value) {
                $('select[name="edit_unit"]').append('<option value="' + key + '">' + value + '</option>');
            });
            $('.selectpicker').selectpicker('refresh');
        });

        //Update product
        function productSearch(data) {
            $.ajax({
                type: 'GET',
                url: 'lims_product_search',
                data: {
                    data: data
                },
                success: function(data) {
                    var flag = 1;
                    $(".product-code").each(function(i) {
                        if ($(this).val() == data[1]) {
                            rowindex = i;
                            var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex +
                                1) + ') .qty').val()) + 1;
                            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(
                                qty);
                            checkQuantity(String(qty), true);
                            flag = 0;
                        }
                    });
                    $("input[name='product_code_name']").val('');
                    if (flag) {
                        var newRow = $("<tr>");
                        var cols = '';
                        pos = product_code.indexOf(data[1]);
                        temp_unit_name = (data[6]).split(',');
                        cols += '<td> <img src="' + window.location.protocol + '//' + window.location.hostname +
                            '/' + window.location.port + '/images/product/' + data[22] +
                            '" class="product_image"/> </td>';
                        cols += '<td>' + data[0] + '</td>';
                        cols += '<td>' + data[1] + '</td>';
                        cols +=
                            '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required/></td>';
                        if (data[12]) {
                            cols += '<td><input type="text" class="form-control batch-no" value="' + batch_no[
                                    pos] +
                                '" required/> <input type="hidden" class="product-batch-id" name="product_batch_id[]" value="' +
                                product_batch_id[pos] + '"/> </td>';
                        } else {
                            cols +=
                                '<td><input type="text" class="form-control batch-no" disabled/> <input type="hidden" class="product-batch-id" name="product_batch_id[]"/> </td>';
                        }

                        cols += '<td class="net_unit_price text-right"></td>';
                        cols += '<td class="discount text-right">0.00</td>';
                        cols += '<td class="tax text-right"></td>';
                        cols += '<td class="sub-total text-right"></td>';
                        cols +=
                            '<td><button type="button" class="edit-product btn btn-primary" data-toggle="modal" data-target="#editModal"><i class="dripicons-document-edit"></i></button> <button type="button" class="ibtnDel btn btn-md btn-danger"><i class="dripicons-trash"></i></button></td>';
                        cols += '<input type="hidden" class="product-code" name="product_code[]" value="' +
                            data[1] + '"/>';
                        cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[
                            9] + '"/>';
                        cols += '<input type="hidden" class="sale-unit" name="sale_unit[]" value="' +
                            temp_unit_name[0] + '"/>';
                        cols += '<input type="hidden" class="net_unit_price" name="net_unit_price[]" />';
                        cols += '<input type="hidden" class="discount-value" name="discount[]" />';
                        cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] +
                            '"/>';
                        cols += '<input type="hidden" class="tax-value" name="tax[]" />';
                        cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';

                        newRow.append(cols);
                        $("table.order-list tbody").prepend(newRow);
                        rowindex = newRow.index();

                        if (!data[11] && product_warehouse_price[pos]) {
                            product_price.splice(rowindex, 0, parseFloat(product_warehouse_price[pos] *
                                currency['exchange_rate']) + parseFloat(product_warehouse_price[pos] *
                                currency['exchange_rate'] * customer_group_rate));
                        } else {
                            product_price.splice(rowindex, 0, parseFloat(data[2] * currency['exchange_rate']) +
                                parseFloat(data[2] * currency['exchange_rate'] * customer_group_rate));
                        }
                        product_discount.splice(rowindex, 0, '0.00');
                        tax_rate.splice(rowindex, 0, parseFloat(data[3]));
                        tax_name.splice(rowindex, 0, data[4]);
                        tax_method.splice(rowindex, 0, data[5]);
                        unit_name.splice(rowindex, 0, data[6]);
                        unit_operator.splice(rowindex, 0, data[7]);
                        unit_operation_value.splice(rowindex, 0, data[8]);
                        checkQuantity(1, true);
                    }
                }
            });
        }

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
