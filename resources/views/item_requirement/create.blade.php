@extends('layout.main') @section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif


<section class="forms">
    {!! Form::open(['route' => 'item_requirement.store', 'method' => 'post', 'files' => true, 'id' => 'purchase-form',]) !!}
    <div>
        <div class="row item-sticky">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-body item-page">
                        <div class="float-left brand-text mt-2 pl-4">
                            <h3>{{trans('file.Add Item Requirement')}}</h3>
                        </div>
                        <div class="float-right mr-2">
                            <a href="{{route('item_requirement.index')}}">
                                <button type="button" data-dismiss="modal" aria-label="Close" class="close" data-toggle="tooltip" title="{{trans('file.Use ctrl+q to quit')}}"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                            </a>

                        </div>
                        <div class="float-right mr-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-save" id="submit-btn" data-toggle="tooltip" title="{{trans('file.Use ctrl+s to save')}}"><i class="fa fa-floppy-o mr-2" aria-hidden="true"></i> {{trans('file.Save')}}</button>
                            </div>
                        </div>
                        <div class="float-right mr-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="submit-btn"><i class="fa fa-check-square-o mr-2" aria-hidden="true"></i> {{trans('file.Confirm')}}</button>
                            </div>
                        </div>
                        <div class="float-right mr-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary text-center" data-toggle="modal" data-target="#attachmentPopUp"><i class="fa fa-paperclip mr-2" aria-hidden="true"></i> {{trans('file.Attachments')}} <span class="badge badge-danger notification-number" id="notification"></span></button>
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
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.date')}}</label><i class="fa fa-asterisk"></i>
                                            <input type="text" name="date" class="form-control date" value="{{date($general_setting->date_format)}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Warehouse')}}</label><i class="fa fa-asterisk"></i>
                                            <select required name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select warehouse...">
                                                @foreach($lims_warehouse_list as $warehouse)
                                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Stage')}} </label>
                                            <select name="stage" class="form-control">
                                                <option value="1">{{trans('file.Purchase Executive')}}</option>
                                                <option value="2">{{trans('file.Salesperson')}}</option>
                                                <option value="3">{{trans('file.Admin')}}</option>
                                                <option value="4">{{trans('file.Ordered')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Status')}}</label>


                                            @foreach($lims_status_list as $form_status)
                                                <input type="text" name="form_status_id" class="form-control text" value="{{ $form_status->name }}" readonly required>
                                            @endforeach

                                            {{-- <select required name="form_status_id" class="selectpicker form-control">
                                                @foreach($lims_status_list as $form_status)
                                                <option value="{{$form_status->id}}">{{$form_status->name}}</option>
                                                @endforeach
                                            </select> --}}
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 mt-2">
                                    <label>{{trans('file.Select Product')}}</label>
                                    <div class="search-box input-group">
                                        <button class="btn btn-secondary"><i class="fa fa-barcode"></i></button>
                                        <input type="text" name="product_code_name" id="lims_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                        <div>
                                            <button class="btn btn-secondary" data-toggle="modal" data-target="#bulkProduct" title="{{trans('file.Add multiple products from list')}}"><i class= "fa fa-plus"></i>  <i class="fa fa-bars"></i></button>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5>{{trans('file.Order Table')}}<i class="fa fa-asterisk"></i></h5>
                                        <div class="table-responsive mt-3">
                                            <table id="myTable" class="table table-hover order-list">
                                                <thead>
                                                    <tr>
                                                        <th style="border-radius: 5px 0px 0px 5px">{{trans('file.Image')}}</th>
                                                        <th>{{trans('file.name')}}</th>
                                                        <th>{{trans('file.Code')}}</th>
                                                        <th>{{trans('file.Unit')}}</th>
                                                        <th>{{trans('file.Quantity')}}</th>
                                                        <th class="recieved-product-qty d-none text-right">{{trans('file.Recieved')}}</th>
                                                        <th>{{trans('file.Note')}}</th>
                                                        <th style="border-radius: 0px 5px 5px 0px">{{trans('file.action')}}</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="displayProducts">
                                                </tbody>
                                                <tfoot class="tfoot active">
                                                    <th colspan="2">{{trans('file.Total')}}</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="text-right" id="total-qty">0</th>
                                                    <th class="recieved-product-qty d-none text-right"></th>
                                                    <th class="text-right"></th>
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

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>{{trans('file.Note')}}</label>
                                            <textarea rows="5" class="form-control" name="note"></textarea>
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
        <table class="table table-bordered table-condensed totals">
            <td><strong>{{trans('file.Items')}}</strong>
                <span class="pull-right" id="item">0.00</span>
            </td>
         </table>
    </div>


    {{-- Add Attachments --}}

    <div id="attachmentPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">

          <div class="modal-content">

            <div class="modal-header item-page mb-4">
              <div class="col-md-12">
                <div class="float-left brand-text mt-2">
                    <h3>{{trans('file.Attachments')}}</h3>
                </div>
                <div class="float-right">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                <div class="float-right">
                    <div class="form-group">
                        <button type="submit" class="btn btn-save" data-dismiss="modal" aria-label="Close" class="close" title="{{trans('file.Use ctrl+s to save')}}" onclick="AddProducts()"><i class="fa fa-floppy-o mr-1" aria-hidden="true" ></i> {{trans('file.Save')}}</button>
                    </div>
                </div>
              </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{trans('file.Attach Document')}}</label> <i class="dripicons-question" data-toggle="tooltip" title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                            <input type="file" multiple name="document[]" class="form-control mb-4" onchange="selectMultipleFile(this);">
                            @if($errors->has('extension'))
                                <span>
                                   <strong>{{ $errors->first('extension') }}</strong>
                                </span>
                            @endif

                            <label>{{trans('file.Documents Attached')}}</label>

                            <div id="selectedFile" class="mb-4"></div>

                            <script>
                                var selectedFileNode = document.getElementById("selectedFile");
                                let filename = [];
                                var data   = new FormData();
                                function showFileName() {
                                    for(var i = 0; i < filename.length; i++) {
                                        $('#selectedFile').append(
                                            '<div class="col-md-10 float-left"><a class="document-text" onclick="viewfile(this, ' + i + ');">' + filename[i].name + '</a></div> <div class="col-md-2 float-left"><i class="dripicons-trash" onclick="removeMyTableFile(' + i + ')"></i><div">'
                                        )
                                    }
                                    document.getElementById("notification").innerHTML = filename.length;
                                }


                                function viewfile(item, i) {
                                    const reader = new FileReader();
                                    reader.addEventListener('load', function () {
                                        item.setAttribute('href', this.result)
                                        debugBase64(this.result)
                                    })

                                    reader.readAsDataURL(filename[i]);
                                }

                                function debugBase64(base64URL){
                                    var win = window.open();
                                    win.document.write('<iframe src="' + base64URL  + '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>');
                                }

                                function selectMultipleFile(file) {
                                    selectedFileNode.innerHTML = '';
                                    var files = $(file)[0].files;
                                    for (var i = 0; i < files.length; i++) {
                                        filename.push(files[i]);
                                    }
                                    showFileName();
                                }

                                function removeMyTableFile(i) {
                                    var parent = document.getElementById('selectedFile');
                                    while (parent.firstChild) {
                                        parent.removeChild(parent.firstChild);
                                    }
                                    filename.splice(i, 1);
                                    showFileName();
                                }

                                function removeExistingFileName(existfilename) {
                                    alert("{{trans('file.Are you sure to delete the attachment?')}}");
                                    existfilename.parentElement.parentElement.remove()
                                }

                            </script>
                        </div>
                    </div>
                </div>
            </div>

          </div>
        </div>
    </div>



    {{-- Add Bulk Products --}}

    <div id="bulkProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">

          <div class="modal-content">

            <div class="modal-header item-page">
              <div class="col-md-12">
                <div class="float-left brand-text mt-2">
                    <h3>{{trans('file.Add Multiple Products')}}</h3>
                </div>
                <div class="float-right">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                <div class="float-right">
                    <div class="form-group">
                        <button type="submit" class="btn btn-save" title="{{trans('file.Use ctrl+s to save')}}" onclick="AddProducts()"><i class="fa fa-plus mr-1" aria-hidden="true" ></i> {{trans('file.Add Products')}}</button>
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
                                <th>{{trans('file.Image')}}</th>
                                <th>{{trans('file.name')}}</th>
                                <th>{{trans('file.Code')}}</th>
                                <th>{{trans('file.category')}}</th>
                                <th>{{trans('file.Brand')}}</th>
                                <th class="text-right">{{trans('file.Stock Available')}}</th>
                                <th style="border-radius: 0px 5px 5px 0px">{{trans('file.Unit')}}</th>
                                <th class="d-none">{{trans('file.ID')}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($lims_product_list as $key=>$product)
                            <tr>
                                <td>{{$key}}</td>
                                <td><img src="{{asset("/images/product/$product->image") }}" alt="product image" class="product_image" width="80" height="80"/></td>
                                <td>{{ $product->name }}</td>
                                <td class="font-weight-bold">{{ $product->code }}</td>
                                <td>{{ $product->category->name }}</td>
                                {{-- <td></td> --}}
                                @if($product->brand_id)
                                <td>{{ $product->brand->title }}</td>
                                {{-- <td></td> --}}
                                @else
                                <td>N/A</td>
                                @endif
                                <td class="text-right">{{ $product->qty }}</td>
                                @if($product->unit_id)
                                <td>{{ $product->unit->unit_code }}</td>
                                {{-- <td></td> --}}
                                @else
                                <td>N/A</td>
                                @endif
                                <td class="d-none id">{{$product->id}}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

          </div>
        </div>
    </div>

    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modal-header" class="modal-title"></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>{{trans('file.Quantity')}}</label>
                            <input type="number" name="edit_qty" class="form-control" step="any">
                        </div>
                        <div class="form-group">
                            <label>{{trans('file.Unit Discount')}}</label>
                            <input type="number" name="edit_discount" class="form-control" step="any">
                        </div>
                        <div class="form-group">
                            <label>{{trans('file.Unit Cost')}}</label>
                            <input type="number" name="edit_unit_cost" class="form-control" step="any">
                        </div>
                        <?php
                $tax_name_all[] = 'No Tax';
                $tax_rate_all[] = 0;
                foreach($lims_tax_list as $tax) {
                    $tax_name_all[] = $tax->name;
                    $tax_rate_all[] = $tax->rate;
                }
            ?>
                            <div class="form-group">
                                <label>{{trans('file.Tax Rate')}}</label>
                                <select name="edit_tax_rate" class="form-control selectpicker">
                                    @foreach($tax_name_all as $key => $name)
                                    <option value="{{$key}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{trans('file.Product Unit')}}</label>
                                <select name="edit_unit" class="form-control selectpicker">
                                </select>
                            </div>
                            <button type="button" name="update_btn" class="btn btn-primary">{{trans('file.update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">

    $("ul#purchase").siblings('a').attr('aria-expanded','true');
    $("ul#purchase").addClass("show");
    $("ul#purchase #purchase-create-menu").addClass("active");

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


    <?php $productArray = []; ?>
    var lims_product_code = [
        @foreach($lims_product_list_without_variant as $product)
            <?php
                $productArray[] = htmlspecialchars($product->code . ' (' . $product->name . ')');
            ?>
        @endforeach
        @foreach($lims_product_list_with_variant as $product)
            <?php
                $productArray[] = htmlspecialchars($product->item_code . ' (' . $product->name . ')');
            ?>
        @endforeach
            <?php
            echo  '"'.implode('","', $productArray).'"';
            ?>
    ];

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
                $(this).autocomplete( "close" );
                productSearch(data);
            };
        },
        select: function(event, ui) {
            var data = ui.item.value;
            productSearch(data);
        }
    });

    $('body').on('focus',".expired-date", function() {
        $(this).datepicker({
            format: "yyyy-mm-dd",
            startDate: "<?php echo date("Y-m-d", strtotime('+ 1 days')) ?>",
            autoclose: true,
            todayHighlight: true
        });
    });

    $('#bulkproduct-table tbody').on('click', 'tr', function(e) {
        //  e.stopPropagation();
        // console.log(this.getElementsByClassName('id')[0].innerText);
        var checkbox = $(this).find('td:first :checkbox').trigger('click');
        // var checkbox = $(this).find(':checkbox');
        setTimeout(() => {
        //     console.log(checkbox);
        // console.log(checkbox[0].checked);
            if (checkbox[0].checked === true) {
                // console.log('Checked');
                this.getElementsByClassName('id')[0].classList.add("selectedId");
            } else {
                // console.log('Unchecked');
                this.getElementsByClassName('id')[0].classList.remove("selectedId");
            }

         }, 500);
    });

    function AddProducts() {
        var selectedIds = document.getElementsByClassName('selectedId');
        var ids = [];
        for(var selectedId of selectedIds) {
            // console.log(selectedId.innerText);
            ids.push(selectedId.innerText);
        }
        console.log(ids);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax ({
            url: '/item_requirement/getSelectedProducts',
            data: {_token: CSRF_TOKEN, ids: ids},
            type: "POST",
            // dataType: "json",
            // contentType: "application/json",
            success: function (jsonData) {
                // Success callback
                console.log(jsonData);
                AddProductsToTable(jsonData);
                // alert("sucess");
                $('#bulkProduct').modal('hide');
            },
            error: function() {
                //any error to be handled
            }
        });

    }
    // global variable of data table id
    let itemRequirementTableDataId = [];
    function hasDataOnTable(id) {
        for(let i = 0; i < itemRequirementTableDataId.length; i++) {
            if(itemRequirementTableDataId[i] == id) {
                return false;
            }
        }
        itemRequirementTableDataId.push(id);
        return true;
    }
    
    function AddProductsToTable(products) {
        for(var product in products) {
            if(hasDataOnTable(products[product][0]['id'])) {
                var newRow = $("<tr>");
                var cols = '';
                pos = product_code.indexOf(product.code);
                // temp_unit_name = (data[6]).split(',');
                cols += '<td> <img src="' + window.location.protocol + '//' + window.location.hostname + '/' + window.location.port + '/images/product/' + products[product][0]['image'] +'" class="product_image"/> </td>';
                cols += '<td>' + products[product][0]['name'] + '</td>';
                cols += '<td>' + products[product][0]['code'] + '</td>';
                cols += '<td>' + products[product][0]['unit']['unit_name'] + '</td>';
                cols += '<td class="col-sm-3">';
                cols += '<div class="input-group">';
                cols += '<span class="input-group-btn"><button type="button" class="btn btn-default minus" onclick="minusProductTableQty('+ 'product' + products[product][0]['id'] +');"><span class="dripicons-minus"></span></button></span>';
                cols += '<input type="text" id="product'+ products[product][0]['id'] +'" name="qty[]" class="form-control qty numkey input-number"  value="1" step="any" required>';
                cols += '<span class="input-group-btn"><button type="button" class="btn btn-default plus" onclick="plusProductTableQty('+ 'product' + products[product][0]['id'] +');"><span class="dripicons-plus"></span></button></span>';
                cols += '</div>';
                cols += '</td>';
                cols += '<td><input type="text" class="form-control" name="pnote[]"/></td>';
                cols += '<td><button type="button" onclick="removeProductTableItem(this);" class="ibtnDel btn btn-md btn-danger"><i class="dripicons-trash"></i></button></td>';
                cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + products[product][0]['code'] + '"/>';
                cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + products[product][0]['id'] + '"/>';
                cols += '<input type="hidden" class="sale-unit" name="sale_unit[]" value=""/>'; //value = temp_unit_name[0]
                cols += '<input type="hidden" class="net_unit_price" name="net_unit_price[]" />';
                cols += '<input type="hidden" class="discount-value" name="discount[]" />';
                cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] + '"/>';
                cols += '<input type="hidden" class="tax-value" name="tax[]" />';
                cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';

                newRow.append(cols);
                $("table.order-list tbody").prepend(newRow);
            }
        }

    }

    function minusProductTableQty(item) {
        var chunk = item.value;
        if(chunk > 0) {
            chunk--;
            item.value = chunk;
        }
    }
    function plusProductTableQty(item) {
        var chunk = item.value;
        chunk++;
        item.value = chunk;
    }

    function removeProductTableItem(qty) {
        var td = event.target.parentNode;
        var tr = td.parentNode.parentNode;
        tr.parentNode.removeChild(tr);
    }


    bulkproduct = $('#bulkproduct-table').DataTable( {
        responsive: true,
        fixedHeader: {
            header: true,
            footer: true
        },
        "order": [],
        'language': {
            'lengthMenu': 'MENU {{trans("file.records per page")}}',
             "info":      '<small>{{trans("file.Showing")}} START - END (TOTAL)</small>',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': []
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
                   'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes" id="dt-checkbox-checked"><label></label></div>'
                },
                'targets': [0]
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [

        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

function saveItemRequirement() {
    let form = document.getElementById("purchase-form");
    for(var i=0; i < form.elements.length; i++){
      if(form.elements[i].value === '' && form.elements[i].hasAttribute('required')){
        alert('There are some required fields!');
        return false;
      }
    }
    form.submit();
}

function confirmItemRequirement() {
    let form = document.getElementById("purchase-form");
    for(var i=0; i < form.elements.length; i++){
      if(form.elements[i].value === '' && form.elements[i].hasAttribute('required')){
        alert('There are some required fields!');
        return false;
      }
    }
    $('input[name="itemRequirementIsConfirm"]').val(true);
    form.submit();
}


//Change quantity
$("#myTable").on('input', '.qty', function() {
    rowindex = $(this).closest('tr').index();
    if($(this).val() < 1 && $(this).val() != '') {
      $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(1);
      alert("Quantity can't be less than 1");
    }
    checkQuantity($(this).val(), true);
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
    var row_product_name = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(1)').text();
    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
    $('#modal-header').text(row_product_name + '(' + row_product_code + ')');

    var qty = $(this).closest('tr').find('.qty').val();
    $('input[name="edit_qty"]').val(qty);

    $('input[name="edit_discount"]').val(parseFloat(product_discount[rowindex]).toFixed(2));

    unitConversion();
    $('input[name="edit_unit_cost"]').val(row_product_cost.toFixed(2));

    var tax_name_all = <?php echo json_encode($tax_name_all) ?>;
    var pos = tax_name_all.indexOf(tax_name[rowindex]);
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
$('button[name="update_btn"]').on("click", function() {
    var edit_discount = $('input[name="edit_discount"]').val();
    var edit_qty = $('input[name="edit_qty"]').val();
    var edit_unit_cost = $('input[name="edit_unit_cost"]').val();

    if (parseFloat(edit_discount) > parseFloat(edit_unit_cost)) {
        alert('Invalid Discount Input!');
        return;
    }

    if(edit_qty < 1) {
        $('input[name="edit_qty"]').val(1);
        edit_qty = 1;
        alert("Quantity can't be less than 1");
    }

    var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
    var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex].indexOf(","));
    row_unit_operation_value = parseFloat(row_unit_operation_value);
    var tax_rate_all = <?php echo json_encode($tax_rate_all) ?>;


    tax_rate[rowindex] = parseFloat(tax_rate_all[$('select[name="edit_tax_rate"]').val()]);
    tax_name[rowindex] = $('select[name="edit_tax_rate"] option:selected').text();


    if (row_unit_operator == '*') {
        product_cost[rowindex] = $('input[name="edit_unit_cost"]').val() / row_unit_operation_value;
    } else {
        product_cost[rowindex] = $('input[name="edit_unit_cost"]').val() * row_unit_operation_value;
    }

    product_discount[rowindex] = $('input[name="edit_discount"]').val();
    var position = $('select[name="edit_unit"]').val();
    var temp_operator = temp_unit_operator[position];
    var temp_operation_value = temp_unit_operation_value[position];
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.purchase-unit').val(temp_unit_name[position]);
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

function productSearch(data) {
    $.ajax({
        type: 'GET',
        url: 'lims_product_search',
        data: {
            data: data,
            return: data
        },
        success: function(data) {
            var flag = 1;
            $(".product-code").each(function(i) {
                if ($(this).val() == data[1]) {
                    rowindex = i;
                    var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) + 1;
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                    checkQuantity(String(qty), true);
                    flag = 0;
                }
            });
            $("input[name='product_code_name']").val('');
            if(flag){
                var newRow = $("<tr>");
                var cols = '';
                pos = product_code.indexOf(data[1]);
                temp_unit_name = (data[6]).split(',');
                cols += '<td> <img src="' + window.location.protocol + '//' + window.location.hostname + '/' + window.location.port + '/images/product/' + data[22] +'" class="product_image"/> </td>';
                cols += '<td>' + data[0] + '</td>';
                cols += '<td>' + data[1] + '</td>';
                cols += '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required/></td>';
                if(data[12]) {
                    cols += '<td><input type="text" class="form-control batch-no" value="'+batch_no[pos]+'" required/> <input type="hidden" class="product-batch-id" name="product_batch_id[]" value="'+product_batch_id[pos]+'"/> </td>';
                }
                else {
                    cols += '<td><input type="text" class="form-control batch-no" disabled/> <input type="hidden" class="product-batch-id" name="product_batch_id[]"/> </td>';
                }

                cols += '<td class="net_unit_price text-right"></td>';
                cols += '<td class="discount text-right">0.00</td>';
                cols += '<td class="tax text-right"></td>';
                cols += '<td class="sub-total text-right"></td>';
                cols += '<td><button type="button" class="edit-product btn btn-primary" data-toggle="modal" data-target="#editModal"><i class="dripicons-document-edit"></i></button> <button type="button" class="ibtnDel btn btn-md btn-danger"><i class="dripicons-trash"></i></button></td>';
                cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data[1] + '"/>';
                cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[9] + '"/>';
                cols += '<input type="hidden" class="sale-unit" name="sale_unit[]" value="' + temp_unit_name[0] + '"/>';
                cols += '<input type="hidden" class="net_unit_price" name="net_unit_price[]" />';
                cols += '<input type="hidden" class="discount-value" name="discount[]" />';
                cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] + '"/>';
                cols += '<input type="hidden" class="tax-value" name="tax[]" />';
                cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';


                newRow.append(cols);
                $("table.order-list tbody").prepend(newRow);
                rowindex = newRow.index();

                if(!data[11] && product_warehouse_price[pos]) {
                    product_price.splice(rowindex, 0, parseFloat(product_warehouse_price[pos] * currency['exchange_rate']) + parseFloat(product_warehouse_price[pos] * currency['exchange_rate'] * customer_group_rate));
                }
                else {
                    product_price.splice(rowindex, 0, parseFloat(data[2] * currency['exchange_rate']) + parseFloat(data[2] * currency['exchange_rate'] * customer_group_rate));
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



function checkQuantity(purchase_qty, flag) {
    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
    var pos = product_code.indexOf(row_product_code);
    var operator = unit_operator[rowindex].split(',');
    var operation_value = unit_operation_value[rowindex].split(',');
    if(operator[0] == '*')
        total_qty = purchase_qty * operation_value[0];
    else if(operator[0] == '/')
        total_qty = purchase_qty / operation_value[0];

    $('#editModal').modal('hide');
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(purchase_qty);
    var status = $('select[name="status"]').val();
    if(status == '1' || status == '2' )
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.recieved').val(purchase_qty);
    calculateRowProductData(purchase_qty);
}

function calculateRowProductData(quantity) {
    unitConversion();
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount').text((product_discount[rowindex] * quantity).toFixed(2));
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount-value').val((product_discount[rowindex] * quantity).toFixed(2));
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val(tax_rate[rowindex].toFixed(2));

    if (tax_method[rowindex] == 1) {
        var net_unit_cost = row_product_cost - product_discount[rowindex];
        var tax = net_unit_cost * quantity * (tax_rate[rowindex] / 100);
        var sub_total = (net_unit_cost * quantity) + tax;

        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').text(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').val(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax').text(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').text(sub_total.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));
    } else {
        var sub_total_unit = row_product_cost - product_discount[rowindex];
        var net_unit_cost = (100 / (100 + tax_rate[rowindex])) * sub_total_unit;
        var tax = (sub_total_unit - net_unit_cost) * quantity;
        var sub_total = sub_total_unit * quantity;

        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').text(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_cost').val(net_unit_cost.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax').text(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').text(sub_total.toFixed(2));
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));
    }

    calculateTotal();
}

function unitConversion() {
    var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
    var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex].indexOf(","));
    row_unit_operation_value = parseFloat(row_unit_operation_value);
    if (row_unit_operator == '*') {
        row_product_cost = product_cost[rowindex] * row_unit_operation_value;
    } else {
        row_product_cost = product_cost[rowindex] / row_unit_operation_value;
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

    //Sum of discount
    var total_discount = 0;
    $(".discount").each(function() {
        total_discount += parseFloat($(this).text());
    });
    $("#total-discount").text(total_discount.toFixed(2));
    $('input[name="total_discount"]').val(total_discount.toFixed(2));

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
    var order_tax = parseFloat($('select[name="order_tax_rate"]').val());
    var order_discount = parseFloat($('input[name="order_discount"]').val());
    var shipping_cost = parseFloat($('input[name="shipping_cost"]').val());

    if (!order_discount)
        order_discount = 0.00;
    if (!shipping_cost)
        shipping_cost = 0.00;

    item = ++item + '(' + total_qty + ')';
    order_tax = (subtotal - order_discount) * (order_tax / 100);
    var grand_total = (subtotal + order_tax + shipping_cost) - order_discount;

    $('#item').text(item);
    $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
    $('#subtotal').text(subtotal.toFixed(2));
    $('#order_tax').text(order_tax.toFixed(2));
    $('input[name="order_tax"]').val(order_tax.toFixed(2));
    $('#order_discount').text(order_discount.toFixed(2));
    $('#shipping_cost').text(shipping_cost.toFixed(2));
    $('#grand_total').text(grand_total.toFixed(2));
    $('input[name="grand_total"]').val(grand_total.toFixed(2));
}

$('input[name="order_discount"]').on("input", function() {
    calculateGrandTotal();
});

$('input[name="shipping_cost"]').on("input", function() {
    calculateGrandTotal();
});

$('select[name="order_tax_rate"]').on("change", function() {
    calculateGrandTotal();
});

$(window).keydown(function(e){
    if (e.which == 13) {
        var $targ = $(e.target);
        if (!$targ.is("textarea") && !$targ.is(":button,:submit")) {
            var focusNext = false;
            $(this).find(":input:visible:not([disabled],[readonly]), a").each(function(){
                if (this === e.target) {
                    focusNext = true;
                }
                else if (focusNext){
                    $(this).focus();
                    return false;
                }
            });
            return false;
        }
    }
});

$('#purchase-form').on('submit',function(e){
    var rownumber = $('table.order-list tbody tr:last').index();
    if (rownumber < 0) {
        alert("Please insert product to order table!")
        e.preventDefault();
    }

    else if($('select[name="status"]').val() != 1)
    {
        flag = 0;
        $(".qty").each(function() {
            rowindex = $(this).closest('tr').index();
            quantity =  $(this).val();
            recieved = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.recieved').val();

            if(quantity != recieved){
                flag = 1;
                return false;
            }
        });
        if(!flag){
            alert('Quantity and Recieved value is same! Please Change Purchase Status or Recieved value');
            e.preventDefault();
        }
    }
    else
        $(".batch-no, .expired-date").prop('disabled', false);
});
</script>
@endsection @section('scripts')
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

@endsection
