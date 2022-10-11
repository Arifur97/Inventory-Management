@extends('layout.main') @section('content')
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

    <section>
        <!--- header section  --->
        <div class="row item-sticky">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body item-page">
                        <div class="float-left brand-text mt-2 pl-4">
                            <h3>{{trans('file.Sale')}}</h3>
                        </div>
                        <div class="float-right mr-2">
                            <div class="form-group">
                                @if(in_array("sales-add", $all_permission))
                                <button class="btn btn-secondary" data-toggle="modal" data-target="#Filter" title="{{trans('file.Filter')}}"><i class="fa fa-filter mr-1"></i> {{trans('file.Filter')}}</button>

                                <a href="{{url('sales/sale_by_csv')}}" class="btn btn-primary"><i class="dripicons-copy mr-1"></i> {{trans('file.import')}}</a>

                                <a href="{{route('sales.create')}}" class="btn buttons-add"><i class="fa fa-plus mr-1"></i> {{trans('file.add')}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--- header section  --->
        <div class="table-responsive">
            <table id="sale-table" class="table sale-list" style="width: 100%">
                <thead>
                    <tr>
                        <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                        <th>{{trans('file.Date')}}</th>
                        <th>{{trans('file.reference')}}</th>
                        <th>{{trans('file.customer')}}</th>
                        <th>{{trans('file.Warehouse')}}</th>
                        <th>{{trans('file.User')}}</th>
                        <th class="text-right">{{trans('file.grand total')}}</th>
                        <th class="text-right">{{trans('file.Paid')}}</th>
                        <th class="text-right">{{trans('file.Due')}}</th>
                        <th>{{trans('file.Payment Status')}}</th>
                        <th>{{trans('file.Status')}}</th>
                        <th class="not-exported" style="border-radius: 0px 5px 5px 0px">{{trans('file.action')}}</th>
                    </tr>
                </thead>

                <tfoot class="tfoot active">
                    <th></th>
                    <th>{{trans('file.Total')}}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th class="text-right"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tfoot>
            </table>
        </div>
    </section>

    <div id="sale-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal mt-5 fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="container mt-3 pb-2 border-bottom">
                    <div class="row">
                        <div class="col-md-3">
                            <button id="print-btn" type="button" class="btn btn-default btn-sm d-print-none"><i class="dripicons-print"></i> {{trans('file.Print')}}</button>

                            {{ Form::open(['route' => 'sale.sendmail', 'method' => 'post', 'class' => 'sendmail-form'] ) }}
                                <input type="hidden" name="sale_id">
                                <button class="btn btn-default btn-sm d-print-none"><i class="dripicons-mail"></i> {{trans('file.Email')}}</button>
                            {{ Form::close() }}
                        </div>
                        <div class="col-md-6">
                            <h3 id="exampleModalLabel" class="modal-title text-center container-fluid">{{$general_setting->site_title}}</h3>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close d-print-none"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="col-md-12 text-center">
                            <i style="font-size: 15px;">{{trans('file.Sale Details')}}</i>
                        </div>
                    </div>
                </div>
                <div id="sale-content" class="modal-body">
                </div>
                <br>
                <table class="table table-bordered product-sale-list">
                    <thead>
                        <th>#</th>
                        <th>{{trans('file.product')}}</th>
                        <th>{{trans('file.Batch No')}}</th>
                        <th>{{trans('file.Qty')}}</th>
                        <th>{{trans('file.Unit')}}</th>
                        <th>{{trans('file.Unit Price')}}</th>
                        <th>{{trans('file.Tax')}}</th>
                        <th>{{trans('file.Discount')}}</th>
                        <th>{{trans('file.Subtotal')}}</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div id="sale-footer" class="modal-body"></div>
            </div>
        </div>
    </div>

    <div id="view-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal mt-5 fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.All')}} {{trans('file.Payment')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover payment-list">
                        <thead>
                            <tr>
                                <th>{{trans('file.date')}}</th>
                                <th>{{trans('file.reference')}}</th>
                                <th>{{trans('file.Account')}}</th>
                                <th>{{trans('file.Amount')}}</th>
                                <th>{{trans('file.Paid By')}}</th>
                                <th>{{trans('file.action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal mt-5 fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Add Payment')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'sale.add-payment', 'method' => 'post', 'files' => true, 'class' => 'payment-form' ]) !!}
                        <div class="row">
                            <input type="hidden" name="balance">
                            <div class="col-md-6">
                                <label>{{trans('file.Recieved Amount')}}</label><i class="fa fa-asterisk"></i>
                                <input type="text" name="paying_amount" class="form-control numkey" step="any" required>
                            </div>
                            <div class="col-md-6">
                                <label>{{trans('file.Paying Amount')}}</label><i class="fa fa-asterisk"></i>
                                <input type="text" id="amount" name="amount" class="form-control"  step="any" required>
                            </div>
                            <div class="col-md-6 mt-1">
                                <label>{{trans('file.Change')}} : </label>
                                <p class="change ml-2">0.00</p>
                            </div>
                            <div class="col-md-6 mt-1">
                                <label>{{trans('file.Paid By')}}</label>
                                <select name="paid_by_id" class="form-control">
                                    <option value="1">Cash</option>
                                    <option value="2">Gift Card</option>
                                    <option value="3">Credit Card</option>
                                    <option value="4">Cheque</option>
                                    <option value="5">Paypal</option>
                                    <option value="6">Deposit</option>
                                    @if($lims_reward_point_setting_data->is_active??false)
                                    <option value="7">Points</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="gift-card form-group">
                            <label> {{trans('file.Gift Card')}}</label><i class="fa fa-asterisk"></i>
                            <select id="gift_card_id" name="gift_card_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Gift Card...">
                                @php
                                    $balance = [];
                                    $expired_date = [];
                                @endphp
                                @foreach($lims_gift_card_list as $gift_card)
                                <?php
                                    $balance[$gift_card->id] = $gift_card->amount - $gift_card->expense;
                                    $expired_date[$gift_card->id] = $gift_card->expired_date;
                                ?>
                                    <option value="{{$gift_card->id}}">{{$gift_card->card_no}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <div class="card-element" class="form-control">
                            </div>
                            <div class="card-errors" role="alert"></div>
                        </div>
                        <div id="cheque">
                            <div class="form-group">
                                <label>{{trans('file.Cheque Number')}}</label><i class="fa fa-asterisk"></i>
                                <input type="text" name="cheque_no" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label> {{trans('file.Account')}}</label>
                            <select class="form-control selectpicker" name="account_id">
                            @foreach($lims_account_list as $account)
                                @if($account->is_default)
                                <option selected value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                                @else
                                <option value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{trans('file.Payment Note')}}</label>
                            <textarea rows="3" class="form-control" name="payment_note"></textarea>
                        </div>

                        <input type="hidden" name="sale_id">

                        <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div id="edit-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal mt-5 fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Update Payment')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'sale.update-payment', 'method' => 'post', 'class' => 'payment-form' ]) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <label>{{trans('file.Recieved Amount')}}</label><i class="fa fa-asterisk"></i>
                                <input type="text" name="edit_paying_amount" class="form-control numkey"  step="any" required>
                            </div>
                            <div class="col-md-6">
                                <label>{{trans('file.Paying Amount')}}</label><i class="fa fa-asterisk"></i>
                                <input type="text" name="edit_amount" class="form-control"  step="any" required>
                            </div>
                            <div class="col-md-6 mt-1">
                                <label>{{trans('file.Change')}} : </label>
                                <p class="change ml-2">0.00</p>
                            </div>
                            <div class="col-md-6 mt-1">
                                <label>{{trans('file.Paid By')}}</label>
                                <select name="edit_paid_by_id" class="form-control selectpicker">
                                    <option value="1">Cash</option>
                                    <option value="2">Gift Card</option>
                                    <option value="3">Credit Card</option>
                                    <option value="4">Cheque</option>
                                    <option value="5">Paypal</option>
                                    <option value="6">Deposit</option>
                                    @if($lims_reward_point_setting_data->is_active??false)
                                    <option value="7">Points</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="gift-card form-group">
                            <label> {{trans('file.Gift Card')}}</label><i class="fa fa-asterisk"></i>
                            <select id="gift_card_id" name="gift_card_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Gift Card...">
                                @foreach($lims_gift_card_list as $gift_card)
                                    <option value="{{$gift_card->id}}">{{$gift_card->card_no}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <div class="card-element" class="form-control">
                            </div>
                            <div class="card-errors" role="alert"></div>
                        </div>
                        <div id="edit-cheque">
                            <div class="form-group">
                                <label>{{trans('file.Cheque Number')}}</label><i class="fa fa-asterisk"></i>
                                <input type="text" name="edit_cheque_no" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label> {{trans('file.Account')}}</label>
                            <select class="form-control selectpicker" name="account_id">
                            @foreach($lims_account_list as $account)
                                <option value="{{$account->id}}">{{$account->name}} [{{$account->account_no}}]</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>{{trans('file.Payment Note')}}</label>
                            <textarea rows="3" class="form-control" name="edit_payment_note"></textarea>
                        </div>

                        <input type="hidden" name="payment_id">

                        <button type="submit" class="btn btn-primary">{{trans('file.update')}}</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <div id="add-delivery" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal mt-5 fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Add Delivery')}}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'delivery.store', 'method' => 'post', 'files' => true]) !!}
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Delivery Reference')}}</label>
                            <p id="dr"></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Sale Reference')}}</label>
                            <p id="sr"></p>
                        </div>
                        <div class="col-md-12 form-group">
                            <label>{{trans('file.Status')}}</label><i class="fa fa-asterisk"></i>
                            <select name="status" required class="form-control selectpicker">
                                <option value="1">{{trans('file.Packing')}}</option>
                                <option value="2">{{trans('file.Delivering')}}</option>
                                <option value="3">{{trans('file.Delivered')}}</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-2 form-group">
                            <label>{{trans('file.Delivered By')}}</label>
                            <input type="text" name="delivered_by" class="form-control">
                        </div>
                        <div class="col-md-6 mt-2 form-group">
                            <label>{{trans('file.Recieved By')}} </label>
                            <input type="text" name="recieved_by" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{trans('file.customer')}}</label><i class="fa fa-asterisk"></i>
                            <p id="customer"></p>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Attach File')}}</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Address')}}</label><i class="fa fa-asterisk"></i>
                            <textarea rows="3" name="address" class="form-control" required></textarea>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>{{trans('file.Note')}}</label>
                            <textarea rows="3" name="note" class="form-control"></textarea>
                        </div>
                    </div>
                    <input type="hidden" name="reference_no">
                    <input type="hidden" name="sale_id">
                    <button type="submit" class="btn btn-primary">{{trans('file.submit')}}</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


    {{-- Filter --}}

    <div id="Filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal mt-5 fade text-left">
        <div role="document" class="modal-dialog">

            {!! Form::open(['route' => 'sales.index', 'method' => 'get']) !!}

            <div class="modal-content">
                <div class="modal-header item-page">
                    {{-- top button --}}
                    <div class="col-md-12">
                        <div class="float-left brand-text mt-2">
                            <h3>{{ trans('file.Filter') }}</h3>
                        </div>
                        <div class="float-right">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                    aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="float-right">
                            <div class="form-group mr-2">
                                <button type="submit" class="btn btn-save"
                                    title="{{ trans('file.Use ctrl+s to save') }}" id="filter-btn">
                                    <i class="fa fa-filter mr-1" aria-hidden="true"></i>
                                    {{ trans('file.Filter') }}
                                </button>
                            </div>
                        </div>
                        <div class="float-right mr-2">
                            <div class="form-group">
                                <a href="{{ route('sales.index') }}" class="btn btn-secondary"><i
                                        class="fa fa-power-off mr-1"></i>
                                    {{ trans('file.Reset') }}
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-body">
                    <div class="row mt-5 mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('file.Date Range') }}</strong> </label>
                                <div class="input-group">
                                    <input type="text" class="daterangepicker-field form-control"
                                        value="{{ $starting_date }} To {{ $ending_date }}" required />
                                    <input type="hidden" name="starting_date" value="{{ $starting_date }}" />
                                    <input type="hidden" name="ending_date" value="{{ $ending_date }}" />
                                </div>
                            </div>
                        </div>

                        {{-- warehouse --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{trans('file.Warehouse')}}</strong> </label>
                                <div class="input-group">
                                    <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                        <option value="0">{{trans('file.All Warehouse')}}</option>
                                        @foreach($lims_warehouse_list as $warehouse)
                                            @if($warehouse->id == $warehouse_id)
                                                <option selected value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                            @else
                                                <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Customer --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{trans('file.Customer')}}</strong> </label>
                                <div class="input-group">
                                    <select id="customer_id" name="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                        <option value="0">{{trans('file.All Customer')}}</option>
                                        @foreach($lims_customer_list as $customer)
                                            @if($customer->id == $customer_id)
                                                <option selected value="{{$customer->id}}">{{$customer->name}}</option>
                                            @else
                                                <option value="{{$customer->id}}">{{$customer->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Reference No --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{trans('file.Reference No')}}</strong> </label>
                                <div class="input-group">
                                    <input id="reference_no" type="text" name="reference_no" placeholder="Please type reference no..." class="form-control" value="{{ $reference_no??'' }}" />
                                </div>
                            </div>
                        </div>

                        {{-- user --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{trans('file.User')}}</strong> </label>
                                <div class="input-group">
                                    <select id="user_id" name="user_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                        <option value="0">{{trans('file.All User')}}</option>
                                        @foreach($lims_user_list as $user)
                                            @if($user->id == $user_id)
                                                <option selected value="{{$user->id}}">{{$user->name}}</option>
                                            @else
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- payment status --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{trans('file.Payment Status')}}</strong> </label>
                                <div class="input-group">
                                    <select id="payment_status" name="payment_status" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                        <option value="0">{{trans('file.All Payment Status')}}</option>
                                        @foreach($lims_payment_status_list as $payment_status_list)
                                            @if($payment_status_list->id == $payment_status)
                                                <option selected value="{{$payment_status_list->id}}">{{$payment_status_list->name}}</option>
                                            @else
                                                <option value="{{$payment_status_list->id}}">{{$payment_status_list->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- status --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{trans('file.Status')}}</strong> </label>
                                <div class="input-group">
                                    <select id="sale_status" name="sale_status" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                        <option value="0">{{trans('file.All Status')}}</option>
                                        @foreach($lims_status_list as $sale_status_list)
                                            @if($sale_status_list->id == $sale_status)
                                                <option selected value="{{$sale_status_list->id}}">{{$sale_status_list->name}}</option>
                                            @else
                                                <option value="{{$sale_status_list->id}}">{{$sale_status_list->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

<script type="text/javascript">

    $("ul#sale").siblings('a').attr('aria-expanded','true');
    $("ul#sale").addClass("show");
    $("ul#sale #sale-list-menu").addClass("active");
    var public_key = <?php echo json_encode($lims_pos_setting_data->stripe_public_key) ?>;
    var all_permission = <?php echo json_encode($all_permission) ?>;
    var reward_point_setting = <?php echo json_encode($lims_reward_point_setting_data) ?>;
    var sale_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    var balance = <?php echo json_encode($balance) ?>;
    var expired_date = <?php echo json_encode($expired_date) ?>;
    var current_date = <?php echo json_encode(date("Y-m-d")) ?>;
    var payment_date = [];
    var payment_reference = [];
    var paid_amount = [];
    var paying_method = [];
    var payment_id = [];
    var payment_note = [];
    var account = [];
    var deposit;

    $(".gift-card").hide();
    $(".card-element").hide();
    $("#cheque").hide();
    $('#view-payment').modal('hide');

    $(document).on("click", "tr.sale-link td:not(:first-child, :last-child)", function() {
        var sale = $(this).parent().data('sale');
        saleDetails(sale);
    });

    $(document).on("click", ".view", function(){
        var sale = $(this).parent().parent().parent().parent().parent().data('sale');
        saleDetails(sale);
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('sale-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css"><style type="text/css">@media print {.modal-dialog { max-width: 1000px;} }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    $(document).on("click", "table.sale-list tbody .add-payment", function() {
        $("#cheque").hide();
        $(".gift-card").hide();
        $(".card-element").hide();
        $('select[name="paid_by_id"]').val(1);
        $('.selectpicker').selectpicker('refresh');
        rowindex = $(this).closest('tr').index();
        deposit = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.deposit').val();
        var sale_id = $(this).data('id').toString();
        var balance = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(10)').text();
        balance = parseFloat(balance.replace(/,/g, ''));
        $('input[name="paying_amount"]').val(balance);
        $('#add-payment input[name="balance"]').val(balance);
        $('input[name="amount"]').val(balance);
        $('input[name="sale_id"]').val(sale_id);
    });

    $(document).on("click", "table.sale-list tbody .get-payment", function(event) {
        rowindex = $(this).closest('tr').index();
        deposit = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.deposit').val();
        var id = $(this).data('id').toString();
        $.get('sales/getpayment/' + id, function(data) {
            $(".payment-list tbody").remove();
            var newBody = $("<tbody>");
            payment_date  = data[0];
            payment_reference = data[1];
            paid_amount = data[2];
            paying_method = data[3];
            payment_id = data[4];
            payment_note = data[5];
            cheque_no = data[6];
            gift_card_id = data[7];
            change = data[8];
            paying_amount = data[9];
            account_name = data[10];
            account_id = data[11];

            $.each(payment_date, function(index){
                var newRow = $("<tr>");
                var cols = '';

                cols += '<td>' + payment_date[index] + '</td>';
                cols += '<td>' + payment_reference[index] + '</td>';
                cols += '<td>' + account_name[index] + '</td>';
                cols += '<td>' + paid_amount[index] + '</td>';
                cols += '<td>' + paying_method[index] + '</td>';
                if(paying_method[index] != 'Paypal')
                    cols += '<td><div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans("file.action")}}<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu"><li><button type="button" class="btn btn-link edit-btn" data-id="' + payment_id[index] +'" data-clicked=false data-toggle="modal" data-target="#edit-payment"><i class="dripicons-document-edit"></i> {{trans("file.edit")}}</button></li><li class="divider"></li>{{ Form::open(['route' => 'sale.delete-payment', 'method' => 'post'] ) }}<li><input type="hidden" name="id" value="' + payment_id[index] + '" /> <button type="submit" class="btn btn-link" onclick="return confirmPaymentDelete()"><i class="dripicons-trash"></i> {{trans("file.delete")}}</button></li>{{ Form::close() }}</ul></div></td>';
                else
                    cols += '<td><div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans("file.action")}}<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">{{ Form::open(['route' => 'sale.delete-payment', 'method' => 'post'] ) }}<li>Demo</li><li><input type="hidden" name="id" value="' + payment_id[index] + '" /> <button type="submit" class="btn btn-link" onclick="return confirmPaymentDelete()"><i class="dripicons-trash"></i> {{trans("file.delete")}}</button></li>{{ Form::close() }}</ul></div></td>';

                newRow.append(cols);
                newBody.append(newRow);
                $("table.payment-list").append(newBody);
            });
            $('#view-payment').modal('show');
        });
    });

    $("table.payment-list").on("click", ".edit-btn", function(event) {
        $(".edit-btn").attr('data-clicked', true);
        $(".card-element").hide();
        $("#edit-cheque").hide();
        $('.gift-card').hide();
        $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', false);
        var id = $(this).data('id').toString();
        $.each(payment_id, function(index){
            if(payment_id[index] == parseFloat(id)){
                $('input[name="payment_id"]').val(payment_id[index]);
                $('#edit-payment select[name="account_id"]').val(account_id[index]);
                if(paying_method[index] == 'Cash')
                    $('select[name="edit_paid_by_id"]').val(1);
                else if(paying_method[index] == 'Gift Card'){
                    $('select[name="edit_paid_by_id"]').val(2);
                    $('#edit-payment select[name="gift_card_id"]').val(gift_card_id[index]);
                    $('.gift-card').show();
                    $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', true);
                }
                else if(paying_method[index] == 'Credit Card'){
                    $('select[name="edit_paid_by_id"]').val(3);
                    $.getScript( "public/vendor/stripe/checkout.js" );
                    $(".card-element").show();
                    $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', true);
                }
                else if(paying_method[index] == 'Cheque'){
                    $('select[name="edit_paid_by_id"]').val(4);
                    $("#edit-cheque").show();
                    $('input[name="edit_cheque_no"]').val(cheque_no[index]);
                    $('input[name="edit_cheque_no"]').attr('required', true);
                }
                else if(paying_method[index] == 'Deposit')
                    $('select[name="edit_paid_by_id"]').val(6);
                else if(paying_method[index] == 'Points'){
                    $('select[name="edit_paid_by_id"]').val(7);
                }

                $('.selectpicker').selectpicker('refresh');
                $("#payment_reference").html(payment_reference[index]);
                $('input[name="edit_paying_amount"]').val(paying_amount[index]);
                $('#edit-payment .change').text(change[index]);
                $('input[name="edit_amount"]').val(paid_amount[index]);
                $('textarea[name="edit_payment_note"]').val(payment_note[index]);
                return false;
            }
        });
        $('#view-payment').modal('hide');
    });

    $('select[name="paid_by_id"]').on("change", function() {
        var id = $(this).val();
        $('input[name="cheque_no"]').attr('required', false);
        $('#add-payment select[name="gift_card_id"]').attr('required', false);
        $(".payment-form").off("submit");
        if(id == 2){
            $(".gift-card").show();
            $(".card-element").hide();
            $("#cheque").hide();
            $('#add-payment select[name="gift_card_id"]').attr('required', true);
        }
        else if (id == 3) {
            $.getScript( "public/vendor/stripe/checkout.js" );
            $(".card-element").show();
            $(".gift-card").hide();
            $("#cheque").hide();
        } else if (id == 4) {
            $("#cheque").show();
            $(".gift-card").hide();
            $(".card-element").hide();
            $('input[name="cheque_no"]').attr('required', true);
        } else if (id == 5) {
            $(".card-element").hide();
            $(".gift-card").hide();
            $("#cheque").hide();
        } else {
            $(".card-element").hide();
            $(".gift-card").hide();
            $("#cheque").hide();
            if(id == 6){
                if($('#add-payment input[name="amount"]').val() > parseFloat(deposit))
                    alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
            }
            else if(id==7) {
                pointCalculation($('#add-payment input[name="amount"]').val());
            }
        }
    });

    $('#add-payment select[name="gift_card_id"]').on("change", function() {
        var id = $(this).val();
        if(expired_date[id] < current_date)
            alert('This card is expired!');
        else if($('#add-payment input[name="amount"]').val() > balance[id]){
            alert('Amount exceeds card balance! Gift Card balance: '+ balance[id]);
        }
    });

    $('input[name="paying_amount"]').on("input", function() {
        $(".change").text(parseFloat( $(this).val() - $('input[name="amount"]').val() ).toFixed(2));
    });

    $('input[name="amount"]').on("input", function() {
        if( $(this).val() > parseFloat($('input[name="paying_amount"]').val()) ) {
            alert('Paying amount cannot be bigger than recieved amount');
            $(this).val('');
        }
        else if( $(this).val() > parseFloat($('input[name="balance"]').val()) ) {
            alert('Paying amount cannot be bigger than due amount');
            $(this).val('');
        }
        $(".change").text(parseFloat($('input[name="paying_amount"]').val() - $(this).val()).toFixed(2));
        var id = $('#add-payment select[name="paid_by_id"]').val();
        var amount = $(this).val();
        if(id == 2){
            id = $('#add-payment select[name="gift_card_id"]').val();
            if(amount > balance[id])
                alert('Amount exceeds card balance! Gift Card balance: '+ balance[id]);
        }
        else if(id == 6){
            if(amount > parseFloat(deposit))
                alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
        }
        else if(id==7) {
            pointCalculation(amount);
        }
    });

    $('select[name="edit_paid_by_id"]').on("change", function() {
        var id = $(this).val();
        $('input[name="edit_cheque_no"]').attr('required', false);
        $('#edit-payment select[name="gift_card_id"]').attr('required', false);
        $(".payment-form").off("submit");
        if(id == 2){
            $(".card-element").hide();
            $("#edit-cheque").hide();
            $('.gift-card').show();
            $('#edit-payment select[name="gift_card_id"]').attr('required', true);
        }
        else if (id == 3) {
            $(".edit-btn").attr('data-clicked', true);
            $.getScript( "public/vendor/stripe/checkout.js" );
            $(".card-element").show();
            $("#edit-cheque").hide();
            $('.gift-card').hide();
        } else if (id == 4) {
            $("#edit-cheque").show();
            $(".card-element").hide();
            $('.gift-card').hide();
            $('input[name="edit_cheque_no"]').attr('required', true);
        } else {
            $(".card-element").hide();
            $("#edit-cheque").hide();
            $('.gift-card').hide();
            if(id == 6) {
                if($('input[name="edit_amount"]').val() > parseFloat(deposit))
                    alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
            }
            else if(id==7) {
                pointCalculation($('input[name="edit_amount"]').val());
            }
        }
    });

    $('#edit-payment select[name="gift_card_id"]').on("change", function() {
        var id = $(this).val();
        if(expired_date[id] < current_date)
            alert('This card is expired!');
        else if($('#edit-payment input[name="edit_amount"]').val() > balance[id])
            alert('Amount exceeds card balance! Gift Card balance: '+ balance[id]);
    });

    $('input[name="edit_paying_amount"]').on("input", function() {
        $(".change").text(parseFloat( $(this).val() - $('input[name="edit_amount"]').val() ).toFixed(2));
    });

    $('input[name="edit_amount"]').on("input", function() {
        if( $(this).val() > parseFloat($('input[name="edit_paying_amount"]').val()) ) {
            alert('Paying amount cannot be bigger than recieved amount');
            $(this).val('');
        }
        $(".change").text(parseFloat($('input[name="edit_paying_amount"]').val() - $(this).val()).toFixed(2));
        var amount = $(this).val();
        var id = $('#edit-payment select[name="gift_card_id"]').val();
        if(amount > balance[id]){
            alert('Amount exceeds card balance! Gift Card balance: '+ balance[id]);
        }
        var id = $('#edit-payment select[name="edit_paid_by_id"]').val();
        if(id == 6){
            if(amount > parseFloat(deposit))
                alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
        }
        else if(id==7) {
            pointCalculation(amount);
        }
    });

    $(document).on("click", "table.sale-list tbody .add-delivery", function(event) {
        var id = $(this).data('id').toString();
        $.get('delivery/create/'+id, function(data) {
            $('#dr').text(data[0]);
            $('#sr').text(data[1]);

            $('select[name="status"]').val(data[2]);
            $('.selectpicker').selectpicker('refresh');
            $('input[name="delivered_by"]').val(data[3]);
            $('input[name="recieved_by"]').val(data[4]);
            $('#customer').text(data[5]);
            $('textarea[name="address"]').val(data[6]);
            $('textarea[name="note"]').val(data[7]);
            $('input[name="reference_no"]').val(data[0]);
            $('input[name="sale_id"]').val(id);
            $('#add-delivery').modal('show');
        });
    });

    function pointCalculation(amount) {
        availablePoints = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.points').val();
        required_point = Math.ceil(amount / reward_point_setting['per_point_amount']);
        if(required_point > availablePoints) {
          alert('Customer does not have sufficient points. Available points: '+availablePoints+'. Required points: '+required_point);
        }
    }

    var starting_date = $("input[name=starting_date]").val();
    var ending_date = $("input[name=ending_date]").val();
    var warehouse_id = $("#warehouse_id").val();
    var customer_id = $("#customer_id").val();
    var reference_no = $("#reference_no").val();
    var user_id = $("#user_id").val();
    var payment_status = $("#payment_status").val();
    var sale_status = $("#sale_status").val();

    $('#sale-table').DataTable( {
        "responsive": true,
        "fixedHeader": true,
        "processing": true,
        "serverSide": true,
        "ajax":{
            url:"/sales/sale-data",
            data:{
                all_permission: all_permission,
                starting_date: starting_date,
                ending_date: ending_date,
                warehouse_id: warehouse_id,
                customer_id: customer_id,
                reference_no: reference_no,
                user_id: user_id,
                payment_status: payment_status,
                sale_status: sale_status
            },
            dataType: "json",
            type:"post"
        },
        "createdRow": function( row, data, dataIndex ) {
            //alert(data);
            $(row).addClass('sale-link');
            $(row).attr('data-sale', data['sale']);
        },
        "columns": [
            {"data": "key"},
            {"data": "date"},
            {"data": "reference_no"},
            {"data": "customer"},
            {"data": "warehouse"},
            {"data": "user"},
            {"data": "grand_total"},
            {"data": "paid_amount"},
            {"data": "due"},
            {"data": "payment_status"},
            {"data": "sale_status"},
            {"data": "options"},
        ],
        'language': {

            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        order:[['1', 'desc']],
        'columnDefs': [
            {
                "orderable": false,
                'targets': [0, 11]
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
                text: '{{trans("file.PDF")}}',
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
                text: '{{trans("file.CSV")}}',
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
                text: '{{trans("file.Print")}}',
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
                text: '{{trans("file.delete")}}',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    if(user_verified == '1') {
                        sale_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                var sale = $(this).closest('tr').data('sale');
                                sale_id[i-1] = sale[13];
                            }
                        });
                        if(sale_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'sales/deletebyselection',
                                data:{
                                    saleIdArray: sale_id
                                },
                                success:function(data){
                                    alert(data);
                                    //dt.rows({ page: 'current', selected: true }).deselect();
                                    dt.rows({ page: 'current', selected: true }).remove().draw(false);
                                }
                            });
                        }
                        else if(!sale_id.length)
                            alert('Nothing is selected!');
                    }
                    else
                        alert('This feature is disable for demo!');
                }
            },
            {
                extend: 'colvis',
                text: '{{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            },
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 6 ).footer() ).html(dt_selector.cells( rows, 6, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
            $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

    function saleDetails(sale){
        $("#sale-details input[name='sale_id']").val(sale[13]);

        var htmltext = '<strong>{{trans("file.Date")}}: </strong>'+sale[0]+'<br><strong>{{trans("file.reference")}}: </strong>'+sale[1]+'<br><strong>{{trans("file.Warehouse")}}: </strong>'+sale[27]+'<br><strong>{{trans("file.Sale Status")}}: </strong>'+sale[2]+'<br><br><div class="row"><div class="col-md-6"><strong>{{trans("file.From")}}:</strong><br>'+sale[3]+'<br>'+sale[4]+'<br>'+sale[5]+'<br>'+sale[6]+'<br>'+sale[7]+'<br>'+sale[8]+'</div><div class="col-md-6"><div class="float-right"><strong>{{trans("file.To")}}:</strong><br>'+sale[9]+'<br>'+sale[10]+'<br>'+sale[11]+'<br>'+sale[12]+'</div></div></div>';
        $.get('sales/product_sale/' + sale[13], function(data){
            $(".product-sale-list tbody").remove();
            var name_code = data[0];
            var qty = data[1];
            var unit_code = data[2];
            var tax = data[3];
            var tax_rate = data[4];
            var discount = data[5];
            var subtotal = data[6];
            var batch_no = data[7];
            var newBody = $("<tbody>");
            $.each(name_code, function(index){
                var newRow = $("<tr>");
                var cols = '';
                cols += '<td><strong>' + (index+1) + '</strong></td>';
                cols += '<td>' + name_code[index] + '</td>';
                cols += '<td>' + batch_no[index] + '</td>';
                cols += '<td>' + qty[index] + '</td>';
                cols += '<td>' + unit_code[index] + '</td>';
                cols += '<td>' + parseFloat(subtotal[index] / qty[index]).toFixed(2) + '</td>';
                cols += '<td>' + tax[index] + '(' + tax_rate[index] + '%)' + '</td>';
                cols += '<td>' + discount[index] + '</td>';
                cols += '<td>' + subtotal[index] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);
            });

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=6><strong>{{trans("file.Total")}}:</strong></td>';
            cols += '<td>' + sale[14] + '</td>';
            cols += '<td>' + sale[15] + '</td>';
            cols += '<td>' + sale[16] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=8><strong>{{trans("file.Order Tax")}}:</strong></td>';
            cols += '<td>' + sale[17] + '(' + sale[18] + '%)' + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=8><strong>{{trans("file.Order Discount")}}:</strong></td>';
            cols += '<td>' + sale[19] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);
            if(sale[28]) {
                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan=8><strong>{{trans("file.Coupon Discount")}} ['+sale[28]+']:</strong></td>';
                cols += '<td>' + sale[29] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);
            }

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=8><strong>{{trans("file.Shipping Cost")}}:</strong></td>';
            cols += '<td>' + sale[20] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=8><strong>{{trans("file.grand total")}}:</strong></td>';
            cols += '<td>' + sale[21] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=8><strong>{{trans("file.Paid Amount")}}:</strong></td>';
            cols += '<td>' + sale[22] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=8><strong>{{trans("file.Due")}}:</strong></td>';
            cols += '<td>' + parseFloat(sale[21] - sale[22]).toFixed(2) + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            $("table.product-sale-list").append(newBody);
        });
        var htmlfooter = '<p><strong>{{trans("file.Sale Note")}}:</strong> '+sale[23]+'</p><p><strong>{{trans("file.Staff Note")}}:</strong> '+sale[24]+'</p><strong>{{trans("file.Created By")}}:</strong><br>'+sale[25]+'<br>'+sale[26];
        $('#sale-content').html(htmltext);
        $('#sale-footer').html(htmlfooter);
        $('#sale-details').modal('show');
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

    if(all_permission.indexOf("sales-delete") == -1)
        $('.buttons-delete').addClass('d-none');

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

    function confirmPaymentDelete() {
        if (confirm("Are you sure want to delete? If you delete this money will be refunded.")) {
            return true;
        }
        return false;
    }

</script>
@endsection

@section('scripts')
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>

@endsection