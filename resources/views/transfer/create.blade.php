@extends('layout.main') @section('content')
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}
        </div>
    @endif
    <div id="alert"></div>
    <section class="forms">
        <div class="row item-sticky">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body item-page">
                        <div class="float-left brand-text mt-2 pl-4">
                            <h3>{{ trans('file.Add Transfer') }}</h3>
                        </div>
                        <div class="float-right mr-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary text-center" data-toggle="modal" data-target="#attachmentPopUp"><i class="fa fa-paperclip mr-2" aria-hidden="true"></i> {{ trans('file.Attachments') }} <span class="badge badge-danger notification-number" id="notification"></span></button>
                                <a href="{{ route('transfers.index') }}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{ trans('file.Cancel') }}</a>
                                <button type="button" id="submit-btn" class="btn btn-primary"><i class="fa fa-check mr-1"></i>{{ trans('file.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">
                            <p class="italic">
                                <small>{{ trans('file.The field labels marked with * are required input fields') }}.</small>
                            </p>
                            {!! Form::open(['route' => 'transfers.store', 'method' => 'post', 'files' => true, 'id' => 'transfer-form']) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('file.From Warehouse') }} *</label>
                                                <select required name="from_warehouse_id" class="selectpicker form-control"
                                                    data-live-search="true" data-live-search-style="begins"
                                                    title="Select warehouse...">
                                                    @foreach ($lims_warehouse_list as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('file.To Warehouse') }} *</label>
                                                <select required name="to_warehouse_id" class="selectpicker form-control"
                                                    data-live-search="true" data-live-search-style="begins"
                                                    title="Select warehouse...">
                                                    @foreach ($lims_warehouse_list as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('file.Status') }}</label>
                                                <select name="status" class="form-control selectpicker">
                                                    <option value="1">{{ trans('file.Completed') }}</option>
                                                    <option value="2">{{ trans('file.Pending') }}</option>
                                                    <option value="3">{{ trans('file.Sent') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <label>{{ trans('file.Select Product') }}</label>
                                            <div class="search-box input-group">
                                                <button type="button" class="btn btn-secondary btn-lg"><i
                                                        class="fa fa-barcode"></i></button>
                                                <input type="text" name="product_code_name" id="lims_productcodeSearch"
                                                    placeholder="Please type product code and select..."
                                                    class="form-control" />
                                                <button type="button" class="btn btn-secondary" data-toggle="modal"
                                                    data-target="#bulkProduct"
                                                    title="{{ trans('file.Add multiple products from list') }}">
                                                    <i class="fa fa-plus"></i> <i class="fa fa-bars"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-12">

                                            <h5>{{ trans('file.Order Table') }} *</h5>
                                            <div class="table-responsive mt-3">
                                                <table id="myTable" class="table table-hover order-list">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ trans('file.Image') }}</th>
                                                            <th>{{ trans('file.name') }}</th>
                                                            <th>{{ trans('file.Code') }}</th>
                                                            <th>{{ trans('file.Quantity') }}</th>
                                                            <th>{{ trans('file.Net Unit Cost') }}</th>
                                                            <th>{{ trans('file.Tax') }}</th>
                                                            <th>{{ trans('file.Subtotal') }}</th>
                                                            <th><i class="dripicons-trash"></i></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                    <tfoot class="tfoot active">
                                                        <th colspan="2">{{ trans('file.Total') }}</th>
                                                        <th id="total-qty">0</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th id="total-tax">0.00</th>
                                                        <th id="total">0.00</th>
                                                        <th></th>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="hidden" name="total_qty" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="hidden" name="total_discount" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="hidden" name="total_tax" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="hidden" name="total_cost" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="hidden" name="item" />
                                                <input type="hidden" name="order_tax" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <input type="hidden" name="grand_total" />
                                                <input type="hidden" name="paid_amount" value="0.00" />
                                                <input type="hidden" name="payment_status" value="1" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('file.Shipping Cost') }}</label>
                                                <input type="number" name="shipping_cost" class="form-control"
                                                    step="any" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{ trans('file.Attach Document') }}</label>
                                                <i class="dripicons-question" data-toggle="tooltip"
                                                    title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                                <input type="file" name="document" class="form-control" />
                                                <input type="hidden" name="document_id" id="documentId"
                                                    class="form-control my-2">
                                                @if ($errors->has('extension'))
                                                    <span>
                                                        <strong>{{ $errors->first('extension') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ trans('file.Note') }}</label>
                                                <textarea rows="5" class="form-control" name="note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="{{ trans('file.submit') }}"
                                            class="btn btn-primary" id="submit-button">
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <table class="table table-bordered table-condensed totals mt-3">
                <td><strong>{{ trans('file.Items') }}</strong>
                    <span class="pull-right" id="item">0.00</span>
                </td>
                <td><strong>{{ trans('file.Total') }}</strong>
                    <span class="pull-right" id="subtotal">0.00</span>
                </td>
                <td><strong>{{ trans('file.Shipping Cost') }}</strong>
                    <span class="pull-right" id="shipping_cost">0.00</span>
                </td>
                <td><strong>{{ trans('file.grand total') }}</strong>
                    <span class="pull-right" id="grand_total">0.00</span>
                </td>
            </table>
        </div>
        <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
            class="modal fade text-left">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="modal_header" class="modal-title"></h5>
                        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>{{ trans('file.Quantity') }}</label>
                                <input type="number" name="edit_qty" class="form-control" step="any">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('file.Unit Cost') }}</label>
                                <input type="number" name="edit_unit_cost" class="form-control" step="any">
                            </div>
                            <div class="form-group">
                                <label>{{ trans('file.Product Unit') }}</label>
                                <select name="edit_unit" class="form-control selectpicker">
                                </select>
                            </div>
                            <button type="button" name="update_btn"
                                class="btn btn-primary">{{ trans('file.update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                                                <img src="{{ asset('/images/product/' . $product->image) }}"
                                                    alt="product image" class="product_image" width="80"
                                                    height="80" />
                                            </td>
                                            <td>{{ $product->name }}</td>
                                            <td class="font-weight-bold">{{ $product->code }}</td>
                                            <td>{{ $product->category->name ?? '' }}</td>
                                            @if ($product->brand_id)
                                                <td>{{ $product->brand->title ?? '' }}</td>
                                            @else
                                                <td>N/A</td>
                                            @endif
                                            <td class="text-right">{{ $product->qty }}</td>
                                            @if ($product->unit_id)
                                                <td>{{ $product->unit->unit_code }}</td>
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

        {{-- Add Attachments --}}
        @include('multifile_management.partials.multifile_attachment_modal', [
            'route' => route('transfers.multifile.store'),
        ])
    </section>
    <script type="text/javascript">
        $("ul#transfer").siblings('a').attr('aria-expanded', 'true');
        $("ul#transfer").addClass("show");
        $("ul#transfer #transfer-create-menu").addClass("active");
        // array data depend on warehouse
        var lims_product_array = [];
        var product_code = [];
        var product_name = [];
        var product_qty = [];

        // array data with selection
        var product_cost = [];
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
        var row_product_cost;

        $('.selectpicker').selectpicker({
            style: 'btn-link',
        });

        $('[data-toggle="tooltip"]').tooltip();

        $('select[name="from_warehouse_id"]').on('change', function() {
            var id = $(this).val();
            $.get('getproduct/' + id, function(data) {
                lims_product_array = [];
                product_code = data[0];
                product_name = data[1];
                product_qty = data[2];
                $.each(product_code, function(index) {
                    lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
                });
            });
        });

        $('#lims_productcodeSearch').on('input', function() {
            var warehouse_id = $('select[name="from_warehouse_id"]').val();
            temp_data = $('#lims_productcodeSearch').val();

            if (!warehouse_id) {
                $('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
                alert('Please select Warehouse!');
            }
        });

        $("#myTable").on('click', '.plus', function() {
            rowindex = $(this).closest('tr').index();
            var qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val();

            if(!qty)
                qty = 1;
            else
                qty = parseFloat(qty) + 1;

            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
            checkQuantity(String(qty), true);
            localStorage.setItem("tbody-id", $("table.order-list tbody").html());
        });

        $("#myTable").on('click', '.minus', function() {
            rowindex = $(this).closest('tr').index();
            var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) - 1;
            if (qty > 0) {
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
            } else {
                qty = 1;
            }
            checkQuantity(String(qty), true);
        });

        $('#bulkproduct-table').DataTable({
            responsive: true,
            fixedHeader: {
                header: true,
                footer: true
            },
            "order": [],
            'language': {
                'lengthMenu': '_MENU_ {{trans("file.per page")}}',
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
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes" id="dt-checkbox-checked"><label></label></div>'
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
            buttons: [

            ],
            drawCallback: function() {
                // var api = this.api();
                // datatable_sum(api, false);
            }
        });

        $('#bulkproduct-table tbody').on('click', 'tr', function(e) {
            let checkbox = $(this).find('td:first :checkbox').trigger('click');
            setTimeout(() => {
                if (checkbox[0].checked === true) {
                    this.getElementsByClassName('id')[0].classList.add("selectedId");
                } else {
                    this.getElementsByClassName('id')[0].classList.remove("selectedId");
                }
            }, 500);
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

        //Change quantity
        $("#myTable").on('input', '.qty', function() {
            rowindex = $(this).closest('tr').index();
            checkQuantity($(this).val(), true);
        });

        //Delete product
        $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
            rowindex = $(this).closest('tr').index();
            product_cost.splice(rowindex, 1);
            tax_rate.splice(rowindex, 1);
            tax_name.splice(rowindex, 1);
            tax_method.splice(rowindex, 1);
            unit_name.splice(rowindex, 1);
            unit_operator.splice(rowindex, 1);
            unit_operation_value.splice(rowindex, 1);
            $(this).closest("tr").remove();
            calculateTotal();
        });

        //Edit product
        $("table.order-list").on("click", ".edit-product", function() {
            rowindex = $(this).closest('tr').index();
            edit();
        });

        //Update product
        $('button[name="update_btn"]').on("click", function() {
            var edit_qty = $('input[name="edit_qty"]').val();
            var edit_unit_cost = $('input[name="edit_unit_cost"]').val();

            var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
            var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex]
                .indexOf(","));

            if (row_unit_operator == '*') {
                product_cost[rowindex] = $('input[name="edit_unit_cost"]').val() / row_unit_operation_value;
            } else {
                product_cost[rowindex] = $('input[name="edit_unit_cost"]').val() * row_unit_operation_value;
            }

            var position = $('select[name="edit_unit"]').val();
            var temp_operator = temp_unit_operator[position];
            var temp_operation_value = temp_unit_operation_value[position];
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.purchase-unit').val(
                temp_unit_name[position]);
            temp_unit_name.splice(position, 1);
            temp_unit_operator.splice(position, 1);
            temp_unit_operation_value.splice(position, 1);

            temp_unit_name.unshift($('select[name="edit_unit"] option:selected').text());
            temp_unit_operator.unshift(temp_operator);
            temp_unit_operation_value.unshift(temp_operation_value);

            unit_name[rowindex] = temp_unit_name.toString() + ',';
            unit_operator[rowindex] = temp_unit_operator.toString() + ',';
            unit_operation_value[rowindex] = temp_unit_operation_value.toString() + ',';
            checkQuantity(edit_qty, false);
        });

        function AddProducts() {
            let selectedIds = document.getElementsByClassName('selectedId');
            let ids = [];
            for (let selectedId of selectedIds) {
                ids.push(selectedId.innerText);
            }
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/transfers/getSelectedProducts',
                data: {
                    _token: CSRF_TOKEN,
                    ids: ids,
                },
                type: "POST",
                success: function(jsonData) {
                    AddProductsToTable(jsonData);
                    $('#bulkProduct').modal('hide');
                },
                error: function() {
                    alert('Something went wrong!');
                }
            });
        }
        // global variable of data table id
        var transferProductsTableDataId = [];

        function hasDataOnTable(id) {
            for (let i = 0; i < transferProductsTableDataId.length; i++)
                if (transferProductsTableDataId[i] == id) return false;
            transferProductsTableDataId.push(id);
            return true;
        }

        function AddProductsToTable(products) {
            for (let product in products) {
                if (hasDataOnTable(products[product][0]['id'])) {
                    let imgSrc = window.location.protocol + '//' + window.location.hostname + ':' + window.location.port +
                        '/images/product/' + products[product][0]['image'];
                    let newRow = $("<tr>");
                    let cols = '';
                    cols += '<td> <img src="' + imgSrc + '" class="product_image" width="80" height="80"/> </td>';
                    cols += '<td>' + products[product][0]['name'] +
                        '<button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="dripicons-document-edit"></i></button></td>';
                    cols += '<td>' + products[product][0]['code'] + '</td>';
                    // cols +=
                    //     '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required/></td>';
                    cols += '<td class="col-sm-3"><div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-default minus"><span class="dripicons-minus"></span></button></span><input type="text" name="qty[]" class="form-control qty numkey input-number" step="any" required><span class="input-group-btn"><button type="button" class="btn btn-default plus"><span class="dripicons-plus"></span></button></span></div></td>';
                    cols += '<td class="net_unit_cost"></td>';
                    cols += '<td class="tax"></td>';
                    cols += '<td class="sub-total"></td>';
                    cols +=
                        '<td><button type="button" class="ibtnDel btn btn-md btn-danger">{{ trans('file.delete') }}</button></td>';
                    cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + products[product][0]
                        ['code'] + '"/>';
                    cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + products[product][0][
                        'id'
                    ] + '"/>';
                    if (products[product][0]['unit']) {
                        cols += '<input type="hidden" class="purchase-unit" name="purchase_unit[]" value="' + products[
                            product][0]['unit']['unit_name'] + '"/>';
                    } else {
                        cols += '<input type="hidden" class="purchase-unit" name="purchase_unit[]" value=""/>';
                    }
                    cols += '<input type="hidden" class="net_unit_cost" name="net_unit_cost[]" />';
                    if (products[product][0]['tax']) {
                        cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + products[product][0][
                            'tax'
                        ]['rate'] + '"/>';
                    } else {
                        cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value=""/>';
                    }
                    cols += '<input type="hidden" class="tax-value" name="tax[]" />';
                    cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';
                    newRow.append(cols);
                    $("table.order-list tbody").prepend(newRow);
                    rowindex = newRow.index();
                    product_cost.splice(rowindex, 0, parseFloat(products[product][0]['cost']));
                    if (products[product][0]['tax']) {
                        tax_rate.splice(rowindex, 0, parseFloat(products[product][0]['tax']['rate']));
                        tax_name.splice(rowindex, 0, products[product][0]['tax']['name'] + ',');
                        tax_method.splice(rowindex, 0, products[product][0]['tax_method'] + ',');
                    } else {
                        tax_rate.splice(rowindex, 0, 0.0);
                        tax_name.splice(rowindex, 0, '');
                        tax_method.splice(rowindex, 0, '');
                    }
                    if (products[product][0]['unit']) {
                        unit_name.splice(rowindex, 0, products[product][0]['unit']['unit_name'] + ',');
                        unit_operator.splice(rowindex, 0, products[product][0]['unit']['operator'] + ',');
                        unit_operation_value.splice(rowindex, 0, products[product][0]['unit']['operation_value'] + ',');
                    } else {
                        unit_name.splice(rowindex, 0, ',');
                        unit_operator.splice(rowindex, 0, ',');
                        unit_operation_value.splice(rowindex, 0, ',');
                    }
                    checkQuantity(1, true);
                }
            }

        }

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
                    if (flag && hasDataOnTable(data[9])) {
                        var newRow = $("<tr>");
                        var cols = '';
                        temp_unit_name = (data[6]).split(',');
                        cols += '<td> <img src="' + data[11] +
                            '" class="product_image" width="80" height="80"/> </td>';
                        cols += '<td>' + data[0] +
                            '<button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="dripicons-document-edit"></i></button></td>';
                        cols += '<td>' + data[1] + '</td>';
                        // cols +=
                        //     '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required/></td>';
                        cols += '<td class="col-sm-3"><div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-default minus"><span class="dripicons-minus"></span></button></span><input type="text" name="qty[]" class="form-control qty numkey input-number" step="any" required><span class="input-group-btn"><button type="button" class="btn btn-default plus"><span class="dripicons-plus"></span></button></span></div></td>';
                        cols += '<td class="net_unit_cost"></td>';
                        cols += '<td class="tax"></td>';
                        cols += '<td class="sub-total"></td>';
                        cols +=
                            '<td><button type="button" class="ioperatorbtnDel btn btn-md btn-danger">{{ trans('file.delete') }}</button></td>';
                        cols += '<input type="hidden" class="product-code" name="product_code[]" value="' +
                            data[1] + '"/>';
                        cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[
                            9] + '"/>';
                        cols += '<input type="hidden" class="purchase-unit" name="purchase_unit[]" value="' +
                            temp_unit_name[0] + '"/>';
                        cols += '<input type="hidden" class="net_unit_cost" name="net_unit_cost[]" />';
                        cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] +
                            '"/>';
                        cols += '<input type="hidden" class="tax-value" name="tax[]" />';
                        cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';

                        newRow.append(cols);
                        $("table.order-list tbody").prepend(newRow);
                        rowindex = newRow.index();
                        product_cost.splice(rowindex, 0, parseFloat(data[2]));
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

        function edit() {
            var row_product_name = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)')
                .text();
            var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(3)')
                .text();
            $('#modal_header').text(row_product_name + '(' + row_product_code + ')');

            var qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val();
            $('input[name="edit_qty"]').val(qty);

            unitConversion();
            $('input[name="edit_unit_cost"]').val(row_product_cost.toFixed(2));

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
        }

        function checkQuantity(purchase_qty, flag) {
            var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(3)')
                .text();
            var pos = product_code.indexOf(row_product_code);
            var operator = unit_operator[rowindex].split(',');
            var operation_value = unit_operation_value[rowindex].split(',');
            var total_qty = parseFloat($('#total-qty').text());
            if (operator[0] == '*')
                total_qty = purchase_qty * operation_value[0];
            else if (operator[0] == '/')
                total_qty = purchase_qty / operation_value[0];

            if (total_qty > parseFloat(product_qty[pos])) {
                alert('Quantity exceeds stock quantity!');
                if (flag) {
                    purchase_qty = purchase_qty.substring(0, purchase_qty.length - 1);
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(purchase_qty);
                } else {
                    edit();
                    return;
                }
            } else {
                $('#editModal').modal('hide');
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(purchase_qty);
            }
            calculateRowProductData(purchase_qty);
        }

        function calculateRowProductData(quantity) {
            unitConversion();
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val(tax_rate[rowindex]
                .toFixed(2));

            if (tax_method[rowindex] == 1) {
                var net_unit_cost = row_product_cost;
                var tax = 0;
                if (tax_rate[rowindex] != 0) {
                    tax = net_unit_cost * quantity * (tax_rate[rowindex] / 100);
                }
                var sub_total = (net_unit_cost * quantity) + tax;

                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(5)').text(net_unit_cost
                    .toFixed(2));
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').val(net_unit_cost
                    .toFixed(2));
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(6)').text(tax.toFixed(
                    2));
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(7)').text(sub_total
                    .toFixed(2));
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total
                    .toFixed(2));
            } else {

                var sub_total_unit = row_product_cost;
                var net_unit_cost = 0;
                var tax = 0;
                if (tax_rate[rowindex] != 0) {
                    net_unit_cost = (100 / (100 + tax_rate[rowindex])) * sub_total_unit;
                    tax = (sub_total_unit - net_unit_cost) * quantity;
                }
                var sub_total = sub_total_unit * quantity;

                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(5)').text(net_unit_cost
                    .toFixed(2));
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').val(net_unit_cost
                    .toFixed(2));
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(6)').text(tax.toFixed(
                    2));
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(7)').text(sub_total
                    .toFixed(2));
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total
                    .toFixed(2));
            }

            calculateTotal();
        }

        function unitConversion() {
            var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
            var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex].indexOf(
                ","));

            if (row_unit_operator == '*') {
                row_product_cost = product_cost[rowindex] * (row_unit_operation_value||1);
            } else {
                row_product_cost = product_cost[rowindex] / (row_unit_operation_value||1);
            }
        }

        function calculateTotal() {
            //Sum of quantity
            var total_qty = 0;
            $(".qty").each(function() {

                if ($(this).val() == '') {
                    total_qty += 0;
                } else {
                    total_qty += parseFloat($(this).val());
                }
            });
            $("#total-qty").text(total_qty);
            $('input[name="total_qty"]').val(total_qty);

            //Sum of tax
            var total_tax = 0;
            $(".tax").each(function() {
                total_tax += parseFloat($(this).text());
            });
            $("#total-tax").text(total_tax.toFixed(2));
            $('input[name="total_tax"]').val(total_tax.toFixed(2));

            //Sum of subtotal
            var total = 0;
            $(".sub-total").each(function() {
                total += parseFloat($(this).text());
            });
            $("#total").text(total.toFixed(2));
            $('input[name="total_cost"]').val(total.toFixed(2));

            calculateGrandTotal();
        }

        function calculateGrandTotal() {

            var item = $('table.order-list tbody tr:last').index();

            var total_qty = parseFloat($('#total-qty').text());
            var subtotal = parseFloat($('#total').text());
            var shipping_cost = parseFloat($('input[name="shipping_cost"]').val());

            if (!shipping_cost)
                shipping_cost = 0.00;

            item = ++item + '(' + total_qty + ')';

            var grand_total = (subtotal + shipping_cost);

            $('#item').text(item);
            $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
            $('#subtotal').text(subtotal.toFixed(2));
            $('#shipping_cost').text(shipping_cost.toFixed(2));
            $('#grand_total').text(grand_total.toFixed(2));
            $('input[name="grand_total"]').val(grand_total.toFixed(2));
        }

        $('input[name="shipping_cost"]').on("input", function() {
            calculateGrandTotal();
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

        $('#transfer-form').on('submit', function(e) {
            var rownumber = $('table.order-list tbody tr:last').index();
            if (rownumber < 0) {
                alert("Please insert product to order table!")
                e.preventDefault();
            }
            if ($('select[name="from_warehouse_id"]').val() == $('select[name="to_warehouse_id"]').val()) {
                alert('Both Warehouse can not be same!');
                e.preventDefault();
            }
        });
    </script>
@endsection
