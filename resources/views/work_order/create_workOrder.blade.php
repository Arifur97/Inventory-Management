@extends('layout.main') @section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<section class="forms">

    <!--- header section  --->

    <div class="row ">
        <div class="col-md-12 item-sticky">
            <div class="card ">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Add Work Order')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <a href="{{route('workorder.index')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
                            <button type="button" id="submit-btn" class="btn btn-primary"><i class="fa fa-check mr-1"></i>{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--- header section  --->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => 'workorder.store', 'method' => 'post', 'files' => true, 'class' => 'payment-form']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label> {{trans('file.Sales Reference ID')}}</label>
                                            <input name="sales_reference_no" type="text" class="form-control" value="{{ $lims_sale_data->reference_no }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3 d-none">
                                        <div class="form-group">

                                            <label> {{trans('file.Sales ID')}}</label>
                                            <input name="sale_id" type="text" class="form-control" value="{{ $lims_sale_data->id }}" readonly>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.customer')}}</label><i class="fa fa-asterisk"></i>
                                            <input type="hidden" name="customer_id_hidden" value="{{ $lims_sale_data->customer_id }}" />
                                            <select required name="customer_id" class="selectpicker form-control" data-live-search="true" id="customer-id" data-live-search-style="begins" title="Select customer...">
                                                @foreach($lims_customer_list as $customer)
                                                <option value="{{$customer->id}}">{{$customer->name . ' (' . $customer->phone_number . ')'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Warehouse')}}</label><i class="fa fa-asterisk"></i>
                                            <input type="hidden" name="warehouse_id_hidden" value="{{$lims_sale_data->warehouse_id}}" />
                                            <select required name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select warehouse...">
                                                @foreach($lims_warehouse_list as $warehouse)
                                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Priority')}}</label>
                                            <select name="priority" class="selectpicker form-control">
                                                <option value="Regular">{{trans('file.Regular')}}</option>
                                                <option value="Urgent">{{trans('file.Urgent')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Expected Delivery Date')}}</label>
                                            <input class="form-control" name="expected_date" type="date" value="<?= date('Y-m-d', time()); ?>" />

                                        </div>
                                    </div>



                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Date')}} </label>
                                            <input name="date" type="text" class="form-control" value="{{ $lims_sale_data->created_at}}" readonly>

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.Stage')}} </label>
                                            <input type="text" value="Salesperson" name="stage" class="form-control" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{trans('file.User id')}}</label>
                                            <input type="text" value="{{ucfirst(Auth::user()->name)}}" name="user_name" class="form-control" readonly/>
                                            <input type="text" value="{{ucfirst(Auth::user()->id)}}" name="user_id" class="form-control d-none" readonly/>
                                        </div>
                                    </div>




                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label>{{trans('file.Select Product')}}</label>
                                        <div class="search-box input-group">
                                            <button type="button" class="btn btn-secondary btn-lg"><i class="fa fa-barcode"></i></button>
                                            <input type="text" name="product_code_name" id="lims_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12">
                                        <h5>{{trans('file.Order Table')}}<i class="fa fa-asterisk"></i></h5>
                                        <div class="table-responsive mt-3">
                                            <table id="myTable" class="table table-hover order-list">
                                                <thead>
                                                    <tr>
                                                        <th>{{trans('file.name')}}</th>
                                                        <th>{{trans('file.Code')}}</th>
                                                        <th>{{trans('file.Category')}}</th>
                                                        <th>{{trans('file.Order Type')}}</th>
                                                        <th>{{trans('file.Color')}}</th>
                                                        <th>{{trans('file.Size')}}</th>
                                                        <th>{{trans('file.Quantity')}}</th>
                                                        <th>{{trans('file.Description')}}</th>
                                                        <th><i class="dripicons-trash"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($lims_product_sale_data as $product_sale)
                                                    <tr>
                                                    <?php
                                                        $product_data = DB::table('products')->find($product_sale->product_id);
                                                    ?>
                                                        <td>{{$product_data->name}} <input type="hidden" class="product-type" value="{{$product_data->type}}" /></td>
                                                        <td><input class="code" name="product_code[]" value="{{$product_data->code}}" readonly/></td>
                                                        <td class="d-none"><input name="work_order_unit_id[]" value="{{$product_data->sale_unit_id}}" readonly/></td>


                                                        <td></td>
                                                        <td>
                                                                {{--  <input type="hidden" name="order_type_hidden" value="{{$lims_ordertype_list->id}}" />  --}}
                                                                <select name="order_type[]" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Order Type...">
                                                                    @foreach($lims_ordertype_list as $oder_type)
                                                                    <option value="{{$oder_type->id}}">{{$oder_type->order_type}}</option>
                                                                    @endforeach
                                                                </select>
                                                        </td>

                                                        <td>
                                                            {{--  <input type="hidden" name="color_hidden" value="{{$lims_color_list->id}}" />  --}}
                                                            <select name="color[]" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Color...">
                                                                @foreach($lims_color_list as $color)
                                                                <option value="{{$color->id}}">{{$color->color}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            {{--  <input type="hidden" name="size_hidden" value="{{$lims_size_list->id}}" />  --}}
                                                            <select name="size[]" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Size...">
                                                                @foreach($lims_size_list as $size)
                                                                <option value="{{$size->id}}">{{$size->size}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="number" class="form-control qty" name="qty[]" value="{{$product_sale->qty}}" step="any" required/>
                                                        </td>
                                                        <td>
                                                            <textarea value="Description" class="form-control" name="description[]" placeholder="Description" rows="5" cols="100"></textarea>
                                                        </td>
                                                        <td><button type="button" class="ibtnDel btn btn-md btn-danger">{{trans("file.delete")}}</button></td>




                                                        <input type="hidden" name="product_id[]" value="{{$product_data->id}}"/>
                                                        <input type="hidden" class="sale-unit" name="sale_unit[]" value="{{$unit_name ?? ''}}"/>

                                                    </tr>


                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                    <div class="form-group">
                                            <label>{{trans('file.Attach Document')}}</label> <i class="dripicons-question" data-toggle="tooltip" title="Only jpg, jpeg, png, gif, pdf, csv, docx, xlsx and txt file is supported"></i>
                                            <input type="file" multiple name="document[]" class="form-control" onchange="selectMultipleFile(this);">
                                            @if($errors->has('extension'))
                                                <span>
                                                   <strong>{{ $errors->first('extension') }}</strong>
                                                </span>
                                            @endif
                                            <div id="selectedFile"></div>

                                            <script>
                                                let filename = [];
                                                function showFileName() {
                                                    for(var i = 0; i < filename.length; i++) {
                                                        $('#selectedFile').append(
                                                            '<div class="col-md-8 float-left"><a target="_blank" href="#">' + filename[i].name + '</a></div> <div class="col-md-4 float-left"><i class="dripicons-trash" onclick="removeMyTableFile(' + i + ')"></i><div">'
                                                        )
                                                    }
                                                }
                                                function selectMultipleFile(file) {
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
                                            </script>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <div id="fileList"></div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('file.Work Order Status')}}</label><i class="fa fa-asterisk"></i>
                                            <select name="work_order_status" class="form-control">
                                                <option value="2">{{trans('file.Pending')}}</option>
                                                <option value="1">{{trans('file.Completed')}}</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('file.Send To')}}</label><i class="fa fa-asterisk"></i>
                                            <select required name="send_to" class="form-control">
                                                <option disabled selected>Select Send To</option>
                                                <option value="Designer">{{trans('file.Designer')}}</option>
                                                <option value="Workshop">{{trans('file.Workshop')}}</option>
                                                <option value="Salesperson">{{trans('file.Salesperson')}}</option>
                                                <option value="Admin">{{trans('file.Admin')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('file.Work Order Note')}}</label>
                                            <textarea rows="5" class="form-control" name="work_order_note"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('file.Staff Note')}}</label>
                                            <textarea rows="5" class="form-control" name="staff_note"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="{{trans('file.submit')}}" class="btn buttons-print" id="submit-button">
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>

<script>
    updateList = function() {
        var input = document.getElementById('file');
        var output = document.getElementById('fileList');

        var children = "";
        for (var i = 0; i < input.files.length; ++i) {
            children += '<p href=\"#\" data-fileid=\"" class="pip"> <i class="fa fa-trash mr-1 remove" aria-hidden="true"></i>' + input.files.item(i).name + '</p>';

        }
        output.innerHTML = '<ul>'+children+'</ul>';
        $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
    }
    $(document).ready( function() {
        var now = new Date();

        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var today = now.getFullYear()+"-"+(month)+"-"+(day) ;


       $('#datePicker').val(today);
    });

</script>
<script type="text/javascript">

    // array data depend on warehouse
    var lims_product_array = [];
    var product_code = [];
    var product_name = [];
    var product_qty = [];
    var product_type = [];
    var product_id = [];
    var product_list = [];
    var qty_list = [];

    // array data with selection
    var product_discount = [];
    var unit_name = [];


    var exist_type = [];
    var exist_code = [];
    var exist_qty = [];
    var rowindex;
    var customer_group_rate;

    var role_id = <?php echo json_encode(Auth::user()->role_id)?>;

    var rownumber = $('table.order-list tbody tr:last').index();



    //assigning value
    $('select[name="customer_id"]').val($('input[name="customer_id_hidden"]').val());
    $('select[name="warehouse_id"]').val($('input[name="warehouse_id_hidden"]').val());
    $('select[name="biller_id"]').val($('input[name="biller_id_hidden"]').val());
    $('select[name="sale_status"]').val($('input[name="sale_status_hidden"]').val());
    $('select[name="order_tax_rate"]').val($('input[name="order_tax_rate_hidden"]').val());
    $('select[name="order_type"]').val($('input[name="order_type_hidden"]').val());
    $('select[name="color"]').val($('input[name="color_hidden"]').val());
    $('select[name="size"]').val($('input[name="size_hidden"]').val());


    $('#item').text($('input[name="item"]').val() + '(' + $('input[name="total_qty"]').val() + ')');


    var id = $('select[name="customer_id"]').val();
    $.get('../getcustomergroup/' + id, function(data) {
        customer_group_rate = (data / 100);
    });

    var id = $('select[name="warehouse_id"]').val();
    $.get('../getproduct/' + id, function(data) {
        lims_product_array = [];
        product_code = data[0];
        product_name = data[1];
        product_qty = data[2];
        product_type = data[3];
        product_id = data[4];
        product_list = data[5];
        qty_list = data[6];
        product_warehouse_price = data[7];

        $.each(product_code, function(index) {
            if(exist_code.includes(product_code[index])) {
                pos = exist_code.indexOf(product_code[index]);
                product_qty[index] = product_qty[index] + exist_qty[pos];
                exist_code.splice(pos, 1);
                exist_qty.splice(pos, 1);
            }
            lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
        });
        $.each(exist_code, function(index) {
            product_type.push(exist_type[index]);
            product_code.push(exist_code[index]);
            product_qty.push(exist_qty[index]);
        });
    });

    isCashRegisterAvailable(id);

    $('select[name="customer_id"]').on('change', function() {
        var id = $(this).val();
        $.get('../getcustomergroup/' + id, function(data) {
            customer_group_rate = (data / 100);
        });
    });

    $('select[name="warehouse_id"]').on('change', function() {
        var id = $(this).val();
        $.get('../getproduct/' + id, function(data) {
            lims_product_array = [];
            product_code = data[0];
            product_name = data[1];
            product_qty = data[2];
            product_type = data[3];
            product_id = data[4];
            product_list = data[5];
            qty_list = data[6];
            product_warehouse_price = data[7];
            $.each(product_code, function(index) {
                lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
            });
        });
        isCashRegisterAvailable(id);
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
    //Change quantity
    $("#myTable").on('input', '.qty', function() {
        rowindex = $(this).closest('tr').index();
        if($(this).val() < 1 && $(this).val() != '') {
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(1);
        alert("Quantity can't be less than 1");
        }
        checkQuantity($(this).val(), true);
    });


    //Delete product
    $("table.order-list tbody").on("click", ".ibtnDel", function(event) {
        rowindex = $(this).closest('tr').index();
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


</script>
@endsection @section('scripts')
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

@endsection
