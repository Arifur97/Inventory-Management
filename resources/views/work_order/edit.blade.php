@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<section class="forms">
    {!! Form::open(['route' => ['workorder.update', $lims_workOrder_data->id], 'method' => 'put', 'files' => true, 'id' => 'payment-form']) !!}
    <!--- header section  --->
    <div class="row item-sticky">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body item-page">
                    <div class="float-left brand-text mt-2 pl-4">
                        <h3>{{trans('file.Update Work Order')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            <button type="button" class="btn btn-primary text-center" data-toggle="modal" data-target="#attachmentPopUp"><i class="fa fa-paperclip mr-2" aria-hidden="true"></i> {{ trans('file.Attachments') }} <span class="badge badge-danger notification-number" id="notification"></span></button>
                            <a href="{{route('workorder.index')}}" class="btn buttons-add"><i class="fa fa-times mr-1"></i> {{trans('file.Cancel')}}</a>
                            @if ($lims_workOrder_data->work_order_status == '2')
                                <button type="button" id="draft-btn" class="btn btn-primary" onclick="handleFormSubmit()"><i class="fa fa-floppy-o mr-1"></i>{{trans('file.Save')}}</button>
                            @elseif ($lims_workOrder_data->work_order_status == '1')
                                <button type="button" id="draft-btn" class="btn btn-primary" onclick="handleFormSubmit('confirm')"><i class="fa fa-floppy-o mr-1"></i>{{trans('file.Save')}}</button>
                            @else
                                <button type="button" id="draft-btn" class="btn btn-primary" onclick="handleFormSubmit('save')"><i class="fa fa-floppy-o mr-1"></i>{{trans('file.Save')}}</button>
                                <button type="button" id="submit-btn" class="btn btn-primary" onclick="handleFormSubmit()"><i class="fa fa-check mr-1"></i>{{trans('file.Confirm')}}</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- header section  --->

    <ul class="nav nav-tabs ml-4 mt-3 mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#tab-lines" role="tab" data-toggle="tab">{{trans('file.Lines')}}</a>
          </li>
        <li class="nav-item">
          <a class="nav-link" href="#tab-shipping" role="tab" data-toggle="tab">{{trans('file.Shipping')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#tab-workflow" role="tab" data-toggle="tab">{{trans('file.Workflow')}}</a>
        </li>
    </ul>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade show active" id="tab-lines">
                        <div class="card">
                            <div class="card-body">
                                <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{trans('file.Date')}} </label>
                                                    <input name="date" type="text" class="form-control" value="{{ $lims_workOrder_data->date}}" readonly>
                                                </div>
                                            </div>

                                            @if(!in_array("hide-workorder-customer-index", $all_permission))
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{trans('file.customer')}}</label><i class="fa fa-asterisk"></i>
                                                    <input type="hidden" name="customer_id_hidden" value="{{ $lims_workOrder_data->customer_id }}" />
                                                    <select required id="customer_id" name="customer_id" class="selectpicker form-control" data-live-search="true" id="customer-id" title="Select customer..."
                                                    @if(($lims_workOrder_data->work_order_status ?? 0) == 1) disabled @endif>
                                                        @foreach($lims_customer_list as $customer)
                                                        <option value="{{$customer->id}}">{{$customer->name}} &#32; {{$customer->phone_number}} &#32; {{$customer->email}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @endif

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{trans('file.Warehouse')}}</label><i class="fa fa-asterisk"></i>
                                                    <input type="hidden" name="warehouse_id_hidden" value="{{$lims_workOrder_data->warehouse_id}}" />
                                                    <select required name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select warehouse..."
                                                    @if(($lims_workOrder_data->work_order_status ?? 0) == 1) disabled @endif>
                                                        @foreach($lims_warehouse_list as $warehouse)
                                                        <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{trans('file.Priority')}}</label><i class="fa fa-asterisk"></i>
                                                    <input type="hidden" name="priority_hidden" value="{{$lims_workOrder_data->priority}}" />
                                                    <select name="priority" class="form-control"
                                                    @if(($lims_workOrder_data->work_order_status ?? 0) == 1) disabled @endif>
                                                        <option value="Regular">{{trans('file.Regular')}}</option>
                                                        <option value="Urgent">{{trans('file.Urgent')}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{trans('file.Delivery Location')}}</label><i class="fa fa-asterisk"></i>
                                                    <input type="hidden" name="delivery_location_id_hidden" value="{{$lims_workOrder_data->delivery_location_id}}" />
                                                    <select required name="delivery_location_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Delivery warehouse..."
                                                    @if(($lims_workOrder_data->work_order_status ?? 0) == 1) disabled @endif>
                                                        @foreach($lims_warehouse_list as $warehouse)
                                                        <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{trans('file.reference')}}</label>
                                                    <p><strong>{{ $lims_workOrder_data->reference_no }}</strong></p>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{trans('file.Expected Delivery Date')}}</label>
                                                    <input id="currentDate" value="{{ $lims_workOrder_data->expected_date }}" type="text" class="form-control" name="expected_date" @if(($lims_workOrder_data->work_order_status ?? 0) == 1) readonly @endif />
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <label>{{trans('file.Stage')}} </label>
                                                <input type="text"  value="{{ $lims_workOrder_data->stage}}" name="stage" class="form-control" readonly/>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{trans('file.User id')}}</label><i class="fa fa-asterisk"></i>
                                                    <input type="text" class="form-control"value="{{$lims_workOrder_data->user->name??''}}" readonly/>
                                                    <input type="hidden" name="user_id" class="form-control"value="{{$lims_workOrder_data->user_id}}" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{trans('file.Company')}}</label><i class="fa fa-asterisk"></i>
                                                    <input type="text" class="form-control"value="{{$lims_workOrder_data->company->name??''}}" readonly />
                                                    <input type="hidden" name="company_id" class="form-control"value="{{$lims_workOrder_data->company_id}}" />
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{trans('file.Sales Reference ID')}}</label>
                                                    <p><strong>{{ $lims_workOrder_data->sales_reference_no }}</strong></p>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>{{trans('file.Send To')}}</label><i class="fa fa-asterisk"></i>
                                                    <input type="hidden" name="send_to_hidden" value="{{$lims_workOrder_data->send_to}}" />
                                                    <select name="send_to" class="form-control" @if(($lims_workOrder_data->work_order_status ?? 0) == 1) disabled @endif>
                                                        <option value="Designer">Designer</option>
                                                        <option value="Workshop">Workshop</option>
                                                        <option value="Salesperson">Salesperson</option>
                                                        <option value="Admin">Admin</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        @if(($lims_workOrder_data->work_order_status ?? 0) != 1)
                                            <div class="row mt-3">
                                                <div class="col-md-12">
                                                    <label>{{trans('file.Select Product')}}</label>
                                                    <div class="search-box input-group">
                                                        <button type="button" class="btn btn-secondary btn-lg"><i class="fa fa-barcode"></i></button>
                                                        <input type="text" name="product_code_name" id="lims_productcodeSearch" placeholder="Please type product code and select..." class="form-control" />
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#bulkProduct" title="{{ trans('file.Add multiple products from list') }}"> <i class="fa fa-plus"></i> <i class="fa fa-bars"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif


                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <h5>{{trans('file.Order Table')}}<i class="fa fa-asterisk"></i></h5>
                                                <div class="table-responsive mt-3">
                                                    <table id="myTable" class="table table-hover order-list">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ trans('file.Image') }}</th>
                                                                <th>{{trans('file.name')}}</th>
                                                                <th>{{trans('file.Description')}}</th>
                                                                <th>{{trans('file.Code')}}</th>
                                                                <th>{{trans('file.Category')}}</th>
                                                                <th>{{trans('file.Order Type')}}</th>
                                                                <th>{{trans('file.Color')}}</th>
                                                                <th>{{trans('file.Size')}}</th>
                                                                <th>{{trans('file.Quantity')}}</th>
                                                                <th>{{trans('file.Note')}}</th>
                                                                <th><i class="dripicons-trash"></i></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($lims_product_workOrder_data as $product_workOrder)
                                                            <input type="hidden" name="data_product_id_hidden[]"
                                                                class="data_product_id_hidden"
                                                                value="{{ $product_workOrder->product_id }}">
                                                            <tr>
                                                                <?php
                                                                    $product_data = App\Product::With('category')->find($product_workOrder->product_id);
                                                                    $product_size = DB::table('sizes')->find($product_workOrder->id);
                                                                    if($product_workOrder->variant_id) {
                                                                        $product_variant_data = \App\ProductVariant::select('id', 'item_code')->FindExactProduct($product_data->id, $product_workOrder->variant_id)->first();
                                                                        $product_variant_id = $product_variant_data->id;
                                                                        $product_data->code = $product_variant_data->item_code;
                                                                        $product_data->category = $product_variant_data->category_id;
                                                                    }
                                                                    else
                                                                        $product_variant_id = null;
                                                                    $customer = DB::table('customers')->find($lims_workOrder_data->customer_id);
                                                                    $customer_group = DB::table('customer_groups')->find($customer->customer_group_id);
                                                                ?>

                                                                <td>
                                                                    <img src="{{ asset('/images/product/' . $product_data->image) }}" alt="product image" class="product_image" width="80"
                                                                    height="80" />
                                                                </td>
                                                                <td>{{$product_data->name}} </td>
                                                                <td>
                                                                    <textarea class="form-control qty" name="description[]"> {{$product_workOrder->description}} </textarea>
                                                                </td>
                                                                <td><input name="product_code[]" class="form-control" value="{{$product_data->code}}" readonly></td>
                                                                <td>{{$product_data->category->name??''}}</td>
                                                                <td class="d-none"><input name="work_order_unit_id[]" value="{{$product_data->sale_unit_id}}" readonly/></td>
                                                                <td>
                                                                    <select class="form-control" name="order_type[]">
                                                                        @if(count($lims_ordertype_list) > 0)
                                                                            @foreach($lims_ordertype_list as $order_type)
                                                                            <option value="{{ $order_type->id }}" {{ old('order_type', $product_workOrder->order_type) == $order_type->id ? 'selected' : '' }}>{{ $order_type->order_type }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control" name="color[]">
                                                                        @if(count($lims_color_list) > 0)
                                                                            @foreach($lims_color_list as $color)
                                                                            <option value="{{ $color->id }}" {{ old('color', $product_workOrder->color) == $color->id ? 'selected' : '' }}>{{ $color->color }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select class="form-control" name="size[]">
                                                                        @if(count($lims_size_list) > 0)
                                                                            @foreach($lims_size_list as $size)
                                                                            <option value="{{ $size->id }}" {{ old('size', $product_workOrder->size) == $size->id ? 'selected' : '' }}>{{ $size->size }}</option>
                                                                            @endforeach
                                                                        @endif
                                                                    </select>
                                                                </td>

                                                                <td class="col-sm-3">
                                                                    <div class="input-group">
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-default minus"><span class="dripicons-minus"></span></button>
                                                                        </span>
                                                                        <input type="text" name="qty[]" class="form-control quantity numkey input-number" value="{{$product_workOrder->qty}}" step="any" required>
                                                                        <span class="input-group-btn">
                                                                            <button type="button" class="btn btn-default plus"><span class="dripicons-plus"></span></button>
                                                                        </span>
                                                                    </div>
                                                                </td>


                                                                <td><input type="text" class="form-control" name="note[]" value="{{$product_workOrder->note}}" /></td>
                                                                <td><button type="button" class="ibtnDel btn btn-md btn-danger">{{trans("file.delete")}}</button></td>
                                                                <input type="hidden" class="product-id" name="product_id[]" value="{{$product_data->id}}"/>
                                                                <input type="hidden" name="product_variant_id[]" value="{{$product_variant_id}}"/>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" id="work_order_status" name="work_order_status" value="{{$lims_workOrder_data->work_order_status}}">
                                            </div>

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('file.Work Order Note')}}</label>
                                                    <textarea rows="5" class="form-control" name="work_order_note">{{ $lims_workOrder_data->work_order_note }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('file.Staff Note')}}</label>
                                                    <textarea rows="5" class="form-control" name="staff_note">{{ $lims_workOrder_data->staff_note }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="button" value="{{trans('file.submit')}}" class="btn buttons-print" id="submit-button" onclick="handleFormSubmit()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 mb-4">
                            <table class="table table-bordered table-condensed totals">
                                <td><strong>{{trans('file.Items')}}</strong>
                                    <span class="pull-right" id="item">0.00</span>
                                </td>
                            </table>
                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="tab-shipping">
                        Shipping
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="tab-workflow">
                        Workflow
                    </div>
                </div>

            </div>
        </div>
    </div>



    @include('multifile_management.partials.attachment_modal', [
        'edit' => true,
        'documents' => $lims_workOrder_data->documents,
    ])
    {!! Form::close() !!}


    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="modal_header" class="modal-title"></h5>
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
                            <label>{{trans('file.Unit Price')}}</label>
                            <input type="number" name="edit_unit_price" class="form-control" step="any">
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
                            <div id="edit_unit" class="form-group">
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

     <!-- bulk product -->
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
                             <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span  aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                         </div>
                         <div class="float-right">
                             <div class="form-group">
                                 <button type="button" class="btn btn-save" title="{{ trans('file.Use ctrl+s to save') }}" onclick="AddProducts()"><i class="fa fa-plus mr-1" aria-hidden="true"></i> {{ trans('file.Add Products') }} </button>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-body">
                    <div class="mb-4">
                        <ul class="nav nav-tabs  mt-3" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="workorder" data-toggle="tab" href="#workorder_form" role="tab" aria-controls="workorder" aria-selected="true">Work Order</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="all" data-toggle="tab" href="#all_form" role="tab" aria-controls="ALL" aria-selected="false">All</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="workorder_form" role="tabpanel" aria-labelledby="workorder">
                            <div class="fancyformcontainer">
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
                                                @if($product->workorder == 1)
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
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="all_form" role="tabpanel" aria-labelledby="All">
                            <div class="table-responsive">
                                <table id="bulkproduct-table2" class="table quotation-list">
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
         </div>
     </div>

</section>

<script type="text/javascript">

    // Ctrl+S and Cmd+S trigger Save button click
    $(document).keydown(function(e) {
        if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey))
        {
            e.preventDefault();
            // alert("Ctrl-s pressed");
            $("#draft-btn").trigger('click');
            return false;
        }
        return true;
    });

    $(document).keydown(function(e) {
        if (event.shiftKey && event.code === 'KeyS') {
            e.preventDefault();
            // alert("Ctrl-s pressed");
            $("#draft-btn").trigger('click');
            return false;
        }
    });

    window.addEventListener('keydown', function (event) {
        if (event.shiftKey && event.code === 'KeyQ') {
            window.location.href = '/workorder';
        }
    });


    $("#myTable").on('click', '.plus', function() {
        rowindex = $(this).closest('tr').index();
        var qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .quantity').val();

        if(!qty)
            qty = 1;
        else
            qty = parseFloat(qty) + 1;

        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .quantity').val(qty);
        checkQuantity(String(qty), true);
        localStorage.setItem("tbody-id", $("table.order-list tbody").html());
    });

    $("#myTable").on('click', '.minus', function() {
        rowindex = $(this).closest('tr').index();
        var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .quantity').val()) - 1;
        if (qty > 0) {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .quantity').val(qty);
        } else {
            qty = 1;
        }
        checkQuantity(String(qty), true);
    });

    $("ul#quotation").siblings('a').attr('aria-expanded','true');
    $("ul#quotation").addClass("show");

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
    var order_type = [];
    var color = [];
    var size = [];
    var description = [];
    var tax_method = [];
    var unit_name = [];
    var unit_operator = [];
    var unit_operation_value = [];

    // temporary array
    var temp_unit_name = [];
    var temp_unit_operator = [];
    var temp_unit_operation_value = [];

    var exist_code = [];
    var exist_qty = [];
    var rowindex;
    var customer_group_rate;
    var row_product_price;
    var pos;
    var currency = <?php echo json_encode($currency) ?>;

    var rownumber = $('table.order-list tbody tr:last').index();
    $('select[name="customer_id"]').val($('input[name="customer_id_hidden"]').val());
    $('select[name="warehouse_id"]').val($('input[name="warehouse_id_hidden"]').val());
    $('select[name="delivery_location_id"]').val($('input[name="delivery_location_id_hidden"]').val());
    $('select[name="work_order_status"]').val($('input[name="work_order_status_hidden"]').val());
    $('select[name="send_to"]').val($('input[name="send_to_hidden"]').val());
    $('select[name="priority"]').val($('input[name="priority_hidden"]').val());

    $('[data-toggle="tooltip"]').tooltip();

    $('select[name="warehouse_id"]').on('change', function() {
        var id = $(this).val();
        $('select[name="delivery_location_id"]').val(id);
        $('.selectpicker').selectpicker('refresh');
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
        product_price.splice(rowindex, 1);
        product_discount.splice(rowindex, 1);
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
    //update product
    $('button[name="update_btn"]').on("click", function() {
        var edit_discount = $('input[name="edit_discount"]').val();
        var edit_qty = $('input[name="edit_qty"]').val();
        var edit_unit_price = $('input[name="edit_unit_price"]').val();

        if (parseFloat(edit_discount) > parseFloat(edit_unit_price)) {
            alert('Invalid Discount Input!');
            return;
        }

        if(edit_qty < 1) {
            $('input[name="edit_qty"]').val(1);
            edit_qty = 1;
            alert("Quantity can't be less than 1");
        }

        var tax_rate_all = <?php echo json_encode($tax_rate_all) ?>;
        tax_rate[rowindex] = parseFloat(tax_rate_all[$('select[name="edit_tax_rate"]').val()]);
        tax_name[rowindex] = $('select[name="edit_tax_rate"] option:selected').text();
        if(product_type[pos] == 'standard'){
            var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
            var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex].indexOf(","));


            if (row_unit_operator == '*') {
                product_price[rowindex] = $('input[name="edit_unit_price"]').val() / row_unit_operation_value;
            } else {
                product_price[rowindex] = $('input[name="edit_unit_price"]').val() * row_unit_operation_value;
            }


            var position = $('select[name="edit_unit"]').val();
            var temp_operator = temp_unit_operator[position];
            var temp_operation_value = temp_unit_operation_value[position];
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sale-unit').val(temp_unit_name[position]);
            temp_unit_name.splice(position, 1);
            temp_unit_operator.splice(position, 1);
            temp_unit_operation_value.splice(position, 1);

            temp_unit_name.unshift($('select[name="edit_unit"] option:selected').text());
            temp_unit_operator.unshift(temp_operator);
            temp_unit_operation_value.unshift(temp_operation_value);

            unit_name[rowindex] = temp_unit_name.toString() + ',';
            unit_operator[rowindex] = temp_unit_operator.toString() + ',';
            unit_operation_value[rowindex] = temp_unit_operation_value.toString() + ',';
        }
        product_discount[rowindex] = $('input[name="edit_discount"]').val();
        checkQuantity(edit_qty, false);
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

    $('#bulkproduct-table2').DataTable({
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

    // table all select
    var saleProductsBulkDataId = [];
    $('#bulkproduct-table tbody').on('click', 'tr', function(e) {
        let checkbox = $(this).find('td:first :checkbox').trigger('click');
        setTimeout(() => {
            const id = this.getElementsByClassName('id')[0].innerText;
            if (checkbox[0].checked === true) {
                this.getElementsByClassName('id')[0].classList.add("selectedId");
                saleProductsBulkDataId.push(id);
            } else {
                this.getElementsByClassName('id')[0].classList.remove("selectedId");
                saleProductsBulkDataId = saleProductsBulkDataId.filter(e => e !== id)
            }
        }, 500);
    });

    var saleProductsBulkDataId = [];
    $('#bulkproduct-table2 tbody').on('click', 'tr', function(e) {
        let checkbox = $(this).find('td:first :checkbox').trigger('click');
        setTimeout(() => {
            const id = this.getElementsByClassName('id')[0].innerText;
            if (checkbox[0].checked === true) {
                this.getElementsByClassName('id')[0].classList.add("selectedId");
                saleProductsBulkDataId.push(id);
            } else {
                this.getElementsByClassName('id')[0].classList.remove("selectedId");
                saleProductsBulkDataId = saleProductsBulkDataId.filter(e => e !== id)
            }
        }, 500);
    });

    function AddProducts() {
        // table product select
        let ids = saleProductsBulkDataId;

        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: '/workorder/getSelectedProducts',
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
    var saleProductsTableDataId = [];

    function hasDataOnTable(id) {
        for (let i = 0; i < saleProductsTableDataId.length; i++)
            if (saleProductsTableDataId[i] == id) return false;
        saleProductsTableDataId.push(id);
        return true;
    }

    function removeDataFromTable(id) {
        for (let i = 0; i < saleProductsTableDataId.length; i++) {
            if (saleProductsTableDataId[i] == id) {
                saleProductsTableDataId[i] = -1;
                return true;
            }
        }
        return true;
    }

    function setDataOnBulkProduct() {
        const data = document.getElementsByClassName('data_product_id_hidden');
        for (let i = 0; i < data.length; i++) {
            hasDataOnTable(data[i].value);
        }
    }
    setDataOnBulkProduct();

    function AddProductsToTable(products) {
        for (let product in products) {
            if (hasDataOnTable(products[product]['id'])) {
                let imgSrc = window.location.protocol + '//' + window.location.hostname + ':' + window.location.port +
                    '/images/product/' + products[product]['image'];
                let newRow = $("<tr>");
                let cols = '';
                cols += '<td> <img src="' + imgSrc + '" class="product_image" width="80" height="80"/> </td>';
                cols += '<td>' + products[product]['name'] +
                    '<button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="dripicons-document-edit"></i></button></td>';
                cols += '<td class="description"><textarea name="description[]" class="form-control"></textarea></td>';
                cols += '<td>' + products[product]['code'] + '</td>';
                cols += '<td>' + products[product]['category']['name'] ?? '' + '</td>';
                // order type
                cols += '<td>';
                cols += '<select name="order_type[]" class="form-control" required>';
                products[product]['p_ordertype'].forEach(e => {
                    cols += `<option value="${e.id}">${e.order_type}</option>`;
                });
                cols += '</select>';
                cols += '</td>';
                // color
                cols += '<td>';
                cols += '<select name="color[]" class="form-control" required>';
                products[product]['p_color'].forEach(e => {
                    cols += `<option value="${e.id}">${e.color}</option>`;
                });
                cols += '</select>';
                cols += '</td>';
                // size
                cols += '<td>';
                cols += '<select name="size[]" class="form-control" required>';
                products[product]['p_size'].forEach(e => {
                    cols += `<option value="${e.id}">${e.size}</option>`;
                });
                cols += '</select>';
                cols += '</td>';
                // cols += '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required/></td>';

                cols += '<td>';
                cols += '<div class="input-group">';
                cols += '<span class="input-group-btn"><button type="button" class="btn btn-default minus" onclick="minusProductTableQty('+ 'product' + products[product]['id'] +');"><span class="dripicons-minus"></span></button></span>';
                cols += '<input type="text" id="product'+ products[product]['id'] +'" name="qty[]" class="form-control qty numkey input-number"  value="1" step="any" required>';
                cols += '<span class="input-group-btn"><button type="button" class="btn btn-default plus" onclick="plusProductTableQty('+ 'product' + products[product]['id'] +');"><span class="dripicons-plus"></span></button></span>';
                cols += '</div>';
                cols += '</td>';

                cols += '<td><input type="text" class="form-control" name="note[]"/></td>';
                cols += '<td class="d-none net_unit_cost"></td>';
                cols += '<td class="d-none tax"></td>';
                cols += '<td class="d-none sub-total"></td>';
                cols +=
                    '<td><button type="button" class="ibtnDel btn btn-md btn-danger">{{ trans('file.delete') }}</button></td>';
                cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + products[product]
                    ['code'] + '"/>';
                cols += '<input type="hidden" class="product-code" name="work_order_unit_id[]" value="' + products[product]
                ['unit_id'] + '"/>';
                cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + products[product][
                    'id'
                ] + '"/>';
                newRow.append(cols);
                $("table.order-list tbody").prepend(newRow);
                rowindex = newRow.index();
                checkQuantity(1, true);
            }
        }

    }

    function handleFormSubmit(type) {
        if(type == 'save') {
            document.getElementById("work_order_status").value = "0";
        } else if(type =='confirm') {
            document.getElementById("work_order_status").value = "1";
        } else {
            document.getElementById("work_order_status").value = "2";
        }
        let form = document.getElementById("payment-form");
        if(form.checkValidity()) {
            form.submit();
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

    $('#quotation-form').on('submit',function(e){
        var rownumber = $('table.order-list tbody tr:last').index();
        if (rownumber < 0) {
            alert("Please insert product to order table!")
            e.preventDefault();
        }
    });

    function productSearch(data) {
        $.ajax({
            type: 'GET',
            url: '../lims_product_search',
            data: {
                data: data
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
                if (flag) {
                    var newRow = $("<tr>");
                    var cols = '';
                    temp_unit_name = (data[6]).split(',');
                    cols += '<td>' + data[0] + '<button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"> <i class="dripicons-document-edit"></i></button></td>';
                    cols += '<td>' + data[1] + '</td>';
                    cols += '<td><input type="number" class="form-control qty" name="qty[]" value="1" step="any" required/></td>';
                    cols += '<td class="net_unit_price"></td>';
                    cols += '<td class="discount">0.00</td>';
                    cols += '<td class="tax"></td>';
                    cols += '<td class="sub-total"></td>';
                    cols += '<td><button type="button" class="ibtnDel btn btn-md btn-danger">{{trans("file.delete")}}</button></td>';
                    cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data[1] + '"/>';
                    cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[9] + '"/>';
                    cols += '<input type="hidden" name="product_variant_id[]" value="' + data[10] + '"/>';
                    cols += '<input type="hidden" class="sale-unit" name="sale_unit[]" value="' + temp_unit_name[0] + '"/>';
                    cols += '<input type="hidden" class="net_unit_price" name="net_unit_price[]" />';
                    cols += '<input type="hidden" class="discount-value" name="discount[]" />';
                    cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] + '"/>';
                    cols += '<input type="hidden" class="tax-value" name="tax[]" />';
                    cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';

                    newRow.append(cols);
                    $("table.order-list tbody").prepend(newRow);
                    rowindex = newRow.index();
                    pos = product_code.indexOf(data[1]);
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

    function edit(){
        var row_product_name = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(1)').text();
        var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
        $('#modal_header').text(row_product_name + '(' + row_product_code + ')');

        var qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val();
        $('input[name="edit_qty"]').val(qty) ;

        $('input[name="edit_discount"]').val(parseFloat(product_discount[rowindex]).toFixed(2));

        var tax_name_all = <?php echo json_encode($tax_name_all) ?>;
        pos = tax_name_all.indexOf(tax_name[rowindex]);
        $('select[name="edit_tax_rate"]').val(pos);

        pos = product_code.indexOf(row_product_code);
        if(product_type[pos] == 'standard'){
            unitConversion();
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
            $("#edit_unit").show();
        }
        else{
            row_product_price = product_price[rowindex];
            $("#edit_unit").hide();
        }
        $('input[name="edit_unit_price"]').val(row_product_price.toFixed(2));
        $('.selectpicker').selectpicker('refresh');
    }

    function checkQuantity(sale_qty, flag) {
        var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(2)').text();
        pos = product_code.indexOf(row_product_code);

        if(product_type[pos] == 'standard'){
            var operator = unit_operator[rowindex].split(',');
            var operation_value = unit_operation_value[rowindex].split(',');
            if(operator[0] == '*')
                total_qty = sale_qty * operation_value[0];
            else if(operator[0] == '/')
                total_qty = sale_qty / operation_value[0];
            if (total_qty > parseFloat(product_qty[pos])) {
                alert('Quantity exceeds stock quantity!');
                if (flag) {
                    sale_qty = sale_qty.substring(0, sale_qty.length - 1);
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
                }
                else {
                    edit();
                    return;
                }
            }
        }
        else if(product_type[pos] == 'combo'){
            child_id = product_list[pos].split(',');
            child_qty = qty_list[pos].split(',');
            $(child_id).each(function(index) {
                var position = product_id.indexOf(parseInt(child_id[index]));
                if( parseFloat(sale_qty * child_qty[index]) > product_qty[position] ) {
                    alert('Quantity exceeds stock quantity!');
                    if (flag) {
                        sale_qty = sale_qty.substring(0, sale_qty.length - 1);
                        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
                    }
                    else {
                        edit();
                        flag = true;
                        return false;
                    }
                }
            });
        }

        if(!flag){
            $('#editModal').modal('hide');
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
        }

    }

</script>
@endsection
