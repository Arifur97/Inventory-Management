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
                        <h3>{{trans('file.Work Order')}}</h3>
                    </div>
                    <div class="float-right mr-2">
                        <div class="form-group">
                            @if(in_array("quotes-add", $all_permission))
                            <button class="btn btn-secondary" data-toggle="modal" data-target="#Filter" title="{{trans('file.Filter')}}"><i class="fa fa-filter mr-1"></i> {{trans('file.Filter')}}</button>
                            <a href="#" data-toggle="modal" data-target="#importProduct" class="btn btn-primary"><i class="dripicons-copy mr-1"></i> {{trans('file.import')}}</a>
                            <a href="{{route('workorder.create')}}" class="btn buttons-add"><i class="fa fa-plus mr-1"></i> {{trans('file.add')}}</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3 float-right">
                        <div class="col-md-8 float-left">
                            <div class="form-group workorder-send">
                                <select required name="send_to" class="form-control" id="workorder__sendto">
                                    <option value="" disabled selected>Send To</option>
                                    <option value="Designer">{{trans('file.Designer')}}</option>
                                    <option value="Workshop">{{trans('file.Workshop')}}</option>
                                    <option value="Salesperson">{{trans('file.Salesperson')}}</option>
                                    <option value="Admin">{{trans('file.Admin')}}</option>
                                </select>
                                <button type="button" onclick="submitWorkOrderSendTo()" class="btn buttons-print" id="submit-button">{{trans('file.submit')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 float-right">
                        <div class="col-md-8 float-left">
                            <div class="form-group workorder-send">
                                <select name="work_order_status" class="form-control" id="workorder__status">
                                    <option value="" disabled selected>Status</option>
                                    <option value="2">{{trans('file.Pending')}}</option>
                                    <option value="1">{{trans('file.Completed')}}</option>
                                </select>
                                <button type="button" onclick="submitWorkOrderStatus()" class="btn buttons-print" id="submit-button">{{trans('file.submit')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--- header section  --->
    <div class="row p-4 d-none">
        <div class="col-md-12">
            <div class="col-md-6 float-left">
                <h3 class="ml-5">{{trans('file.Send To')}}</p>
                <div class="col-md-8 float-left">
                    <div class="form-group">
                        <select required name="send_to" class="form-control" id="workorder__sendto">
                            <option value="" disabled selected>Select Send To</option>
                            <option value="Designer">{{trans('file.Designer')}}</option>
                            <option value="Workshop">{{trans('file.Workshop')}}</option>
                            <option value="Salesperson">{{trans('file.Salesperson')}}</option>
                            <option value="Admin">{{trans('file.Admin')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 float-left">
                    <div class="form-group">
                        <button type="button" onclick="submitWorkOrderSendTo()" class="btn buttons-print" id="submit-button">{{trans('file.submit')}}</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 float-left">
                <h3 class="ml-5">{{trans('file.Work Order Status')}}</p>
                <div class="col-md-8 float-left">
                    <div class="form-group">
                        <select name="work_order_status" class="form-control" id="workorder__status">
                            <option value="2">{{trans('file.Pending')}}</option>
                            <option value="1">{{trans('file.Completed')}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 float-left">
                    <div class="form-group">
                        <button type="button" onclick="submitWorkOrderStatus()" class="btn buttons-print" id="submit-button">{{trans('file.submit')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="table-responsive">
        <table id="wrokOrder-table" class="table workOrder-list">
            <thead>
                <tr>
                    <th class="not-exported" style="border-radius: 5px 0px 0px 5px"></th>
                    <th>{{trans('file.id')}}</th>
                    <th>{{trans('file.reference')}}</th>
                    <th>{{trans('file.Date')}}</th>
                    <th>{{trans('file.Status')}}</th>
                    <th>{{trans('file.Warehouse')}}</th>
                    <th>{{trans('file.File Preview')}}</th>
                    <th>{{trans('file.Types')}}</th>
                    <th>{{trans('file.customer')}}</th>
                    <th>{{trans('file.Email')}}</th>
                    <th>{{trans('file.Phone Number')}}</th>
                    <th>{{trans('file.User')}}</th>
                    <th>{{trans('file.File Attached')}}</th>
                    <th>{{trans('file.Note')}}</th>
                    <th>{{trans('file.Staff Note')}}</th>
                    <th>{{trans('file.Sales Ref')}}</th>
                    <th>{{trans('file.Priority')}}</th>
                    <th>{{trans('file.Stage')}}</th>
                    <th class="not-exported" style="border-radius: 0px 5px 5px 0px">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_work_order_all as $key=>$work_order)
                <?php
                    if($work_order->work_order_status == 1){
                        $status = trans('file.Completed');
                    }
                    elseif ($work_order->work_order_status == 2) {
                        $status = trans('file.Pending');
                        }
                    else{
                        $status = trans('file.Draft');
                    }
                ?>

                @if($work_order->work_order_status == 1)
                    <tr class="workOrder-link" style="color: black;">
                        <td>{{$key}}</td>
                        <td class="id">{{ $work_order->id }}</td>
                        <td>{{ $work_order->reference_no ?? "" }}</td>
                        <td>{{ date($general_setting->date_format, strtotime($work_order->created_at->toDateString())) }}</td>
                        @if($work_order->work_order_status == 1)
                            <td><div class="badge badge-success">{{$status}}</div></td>
                        @elseif ($work_order->work_order_status == 2)
                            <td><div class="badge badge-black text-bold">{{$status}}</div></td>
                        @else
                            <td><div class="badge badge-primary text-bold">{{$status}}</div></td>
                        @endif
                        @if($work_order->warehouse_id)
                        <td>{{ $work_order->warehouse->name }}</td>
                        @else
                        <td>N/A</td>
                        @endif
                        <td>
                            @if ($work_order->documents ?? false)
                                <embed src="{{ explode(',', $work_order->documents->documents)[0] }}" type="" height="80" width="80" class="product_image">

                            @endif
                        </td>
                        <td>
                            @if ($work_order->order_type_tags ?? false)
                                {{ $work_order->order_type_tags }}
                            @endif
                        </td>
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->name }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->email }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->phone_number }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->user_id)
                            <td>{{ $work_order->user->name ?? '' }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        <td>
                            @if ($work_order->documents ?? false)
                                @foreach (explode(',', $work_order->documents->documents) as $li)
                                    @php
                                        $tempDoc = explode('/', $li);
                                    @endphp
                                    <ul>
                                        <li>
                                            <a href="{{ $li }}" target="_blank" class="attachment-index">{{ end($tempDoc) }}</a>
                                        </li>
                                    </ul>
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $work_order->work_order_note }}</td>
                        <td>{{ $work_order->staff_note }}</td>
                        <td>{{ $work_order->sales_reference_no }}</td>
                        <td>{{ $work_order->priority }}</td>
                        <td>{{ $work_order->send_to }}</td>

                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                    <li>
                                        <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i>  {{trans('file.View')}}</button>
                                    </li>
                                    @if(in_array("quotes-edit", $all_permission))
                                    <li>
                                        <a class="btn btn-link" href="{{ route('workorder.edit', $work_order->id) }}"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a></button>
                                    </li>
                                    @endif
                                    <li>
                                        <a class="btn btn-link" href="{{ route('quotation.create_sale', ['id' => $work_order->id]) }}"><i class="fa fa-shopping-cart"></i> {{trans('file.Create Sale')}}</a></button>
                                    </li>
                                    <li>
                                        <a class="btn btn-link" href="{{ route('quotation.create_purchase', ['id' => $work_order->id]) }}"><i class="fa fa-shopping-basket"></i> {{trans('file.Create Purchase')}}</a></button>
                                    </li>
                                    <li class="divider"></li>

                                    {{ Form::open(['route' => ['workorder.destroy', $work_order->id], 'method' => 'DELETE'] ) }}
                                    <li>
                                        <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                    </li>
                                    {{ Form::close() }}
                                </ul>
                            </div>
                        </td>

                    </tr>
                @elseif($work_order->work_order_status == 2 && $work_order->priority == "Urgent" )
                    <tr class="workOrder-link text-bold" style="color: crimson" >
                        <td>{{$key}}</td>
                        <td class="id">{{ $work_order->id }}</td>
                        <td>{{ $work_order->reference_no ?? "" }}</td>
                        <td>{{ date($general_setting->date_format, strtotime($work_order->created_at->toDateString())) }}</td>

                        @if($work_order->work_order_status == 1)
                            <td><div class="badge badge-success">{{$status}}</div></td>
                        @elseif ($work_order->work_order_status == 2)
                            <td><div class="badge badge-danger text-bold">{{$status}}</div></td>
                        @else
                            <td><div class="badge badge-primary text-bold">{{$status}}</div></td>
                        @endif

                        @if($work_order->warehouse_id)
                        <td>{{ $work_order->warehouse->name }}</td>
                        @else
                        <td>N/A</td>
                        @endif
                        <td>
                            @if ($work_order->documents ?? false)
                                <embed src="{{ explode(',', $work_order->documents->documents)[0] }}" type="" height="80" width="80" class="product_image">
                            @endif
                        </td>
                        <td>
                            @if ($work_order->order_type_tags ?? false)
                                {{ $work_order->order_type_tags }}
                            @endif
                        </td>
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->name }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->email }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->phone_number }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->user_id)
                            <td>{{ $work_order->user->name ?? '' }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        <td>
                            @if ($work_order->documents ?? false)
                            @foreach (explode(',', $work_order->documents->documents) as $li)
                                @php
                                    $tempDoc = explode('/', $li);
                                @endphp
                                <ul>
                                    <li>
                                        <a href="{{ $li }}" target="_blank" class="attachment-index">{{ end($tempDoc) }}</a>
                                    </li>
                                </ul>
                            @endforeach
                            @endif
                        </td>
                        <td>{{ $work_order->work_order_note }}</td>
                        <td>{{ $work_order->staff_note }}</td>
                        <td>{{ $work_order->sales_reference_no }}</td>
                        <td>{{ $work_order->priority }}</td>
                        <td>{{ $work_order->send_to }}</td>

                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                    <li>
                                        <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i>  {{trans('file.View')}}</button>
                                    </li>
                                    @if(in_array("quotes-edit", $all_permission))
                                    <li>
                                        <a class="btn btn-link" href="{{ route('workorder.edit', $work_order->id) }}"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a></button>
                                    </li>
                                    @endif
                                    <li>
                                        <a class="btn btn-link" href="{{ route('quotation.create_sale', ['id' => $work_order->id]) }}"><i class="fa fa-shopping-cart"></i> {{trans('file.Create Sale')}}</a></button>
                                    </li>
                                    <li>
                                        <a class="btn btn-link" href="{{ route('quotation.create_purchase', ['id' => $work_order->id]) }}"><i class="fa fa-shopping-basket"></i> {{trans('file.Create Purchase')}}</a></button>
                                    </li>
                                    <li class="divider"></li>

                                    {{ Form::open(['route' => ['workorder.destroy', $work_order->id], 'method' => 'DELETE'] ) }}
                                    <li>
                                        <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                    </li>
                                    {{ Form::close() }}
                                </ul>
                            </div>
                        </td>
                    </tr>
                @elseif($work_order->work_order_status == 0)
                    <tr class="workOrder-link font-italic" style="color: black;">
                        <td>{{$key}}</td>
                        <td class="id">{{ $work_order->id }}</td>
                        <td>{{ $work_order->reference_no ?? "" }}</td>
                        <td>{{ date($general_setting->date_format, strtotime($work_order->created_at->toDateString())) }}</td>

                        @if($work_order->work_order_status == 1)
                            <td><div class="badge badge-success">{{$status}}</div></td>
                        @elseif ($work_order->work_order_status == 2)
                            <td><div class="badge badge-black text-bold">{{$status}}</div></td>
                        @else
                            <td><div class="badge badge-primary text-bold">{{$status}}</div></td>
                        @endif

                        @if($work_order->warehouse_id)
                        <td>{{ $work_order->warehouse->name }}</td>
                        @else
                        <td>N/A</td>
                        @endif

                        <td>
                            @if ($work_order->documents ?? false)
                                <embed src="{{ URL::to(explode(',', $work_order->documents->documents)[0]) }}" type="" height="80" width="80" class="product_image">
                            @endif
                        </td>
                        <td>
                            @if ($work_order->order_type_tags ?? false)
                                {{ $work_order->order_type_tags }}
                            @endif
                        </td>
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->name }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->email }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->phone_number }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->user_id)
                            <td>{{ $work_order->user->name ?? '' }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        <td>
                            @if ($work_order->documents ?? false)
                            @foreach (explode(',', $work_order->documents->documents) as $li)
                                @php
                                    $tempDoc = explode('/', $li);
                                @endphp
                                <ul>
                                    <li>
                                        <a href="{{ $li }}" target="_blank" class="attachment-index">{{ end($tempDoc) }}</a>
                                    </li>
                                </ul>
                            @endforeach
                            @endif
                        </td>
                        <td>{{ $work_order->work_order_note }}</td>
                        <td>{{ $work_order->staff_note }}</td>
                        <td>{{ $work_order->sales_reference_no }}</td>
                        <td>{{ $work_order->priority }}</td>
                        <td>{{ $work_order->send_to }}</td>

                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                    <li>
                                        <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i>  {{trans('file.View')}}</button>
                                    </li>
                                    @if(in_array("quotes-edit", $all_permission))
                                    <li>
                                        <a class="btn btn-link" href="{{ route('workorder.edit', $work_order->id) }}"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a></button>
                                    </li>
                                    @endif
                                    <li>
                                        <a class="btn btn-link" href="{{ route('quotation.create_sale', ['id' => $work_order->id]) }}"><i class="fa fa-shopping-cart"></i> {{trans('file.Create Sale')}}</a></button>
                                    </li>
                                    <li>
                                        <a class="btn btn-link" href="{{ route('quotation.create_purchase', ['id' => $work_order->id]) }}"><i class="fa fa-shopping-basket"></i> {{trans('file.Create Purchase')}}</a></button>
                                    </li>
                                    <li class="divider"></li>

                                    {{ Form::open(['route' => ['workorder.destroy', $work_order->id], 'method' => 'DELETE'] ) }}
                                    <li>
                                        <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                    </li>
                                    {{ Form::close() }}
                                </ul>
                            </div>
                        </td>
                    </tr>
                @else
                    <tr class="workOrder-link text-bold" style="color: black;">
                        <td>{{$key}}</td>
                        <td class="id">{{ $work_order->id }}</td>
                        <td>{{ $work_order->reference_no ?? "" }}</td>
                        <td>{{ date($general_setting->date_format, strtotime($work_order->created_at->toDateString())) }}</td>

                        @if($work_order->work_order_status == 1)
                            <td><div class="badge badge-success">{{$status}}</div></td>
                        @elseif ($work_order->work_order_status == 2)
                            <td><div class="badge badge-pending text-bold">{{$status}}</div></td>
                        @else
                            <td><div class="badge badge-primary text-bold">{{$status}}</div></td>
                        @endif

                        @if($work_order->warehouse_id)
                        <td>{{ $work_order->warehouse->name }}</td>
                        @else
                        <td>N/A</td>
                        @endif

                        <td>
                            @if ($work_order->documents ?? false)
                                <embed src="{{ URL::to(explode(',', $work_order->documents->documents)[0]) }}" type="" height="80" width="80" class="product_image">
                            @endif
                        </td>
                        <td>
                            @if ($work_order->order_type_tags ?? false)
                                {{ $work_order->order_type_tags }}
                            @endif
                        </td>
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->name }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->email }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->customer_id)
                            <td>{{ $work_order->customer->phone_number }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        @if($work_order->user_id)
                            <td>{{ $work_order->user->name ?? '' }}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        <td>
                            @if ($work_order->documents ?? false)
                            @foreach (explode(',', $work_order->documents->documents) as $li)
                                @php
                                    $tempDoc = explode('/', $li);
                                @endphp
                                <ul>
                                    <li>
                                        <a href="{{ $li }}" target="_blank" class="attachment-index">{{ end($tempDoc) }}</a>
                                    </li>
                                </ul>
                            @endforeach
                            @endif
                        </td>
                        <td>{{ $work_order->work_order_note }}</td>
                        <td>{{ $work_order->staff_note }}</td>
                        <td>{{ $work_order->sales_reference_no }}</td>
                        <td>{{ $work_order->priority }}</td>
                        <td>{{ $work_order->send_to }}</td>

                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                    <li>
                                        <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i>  {{trans('file.View')}}</button>
                                    </li>
                                    @if(in_array("quotes-edit", $all_permission))
                                    <li>
                                        <a class="btn btn-link" href="{{ route('workorder.edit', $work_order->id) }}"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}</a></button>
                                    </li>
                                    @endif
                                    <li>
                                        <a class="btn btn-link" href="{{ route('quotation.create_sale', ['id' => $work_order->id]) }}"><i class="fa fa-shopping-cart"></i> {{trans('file.Create Sale')}}</a></button>
                                    </li>
                                    <li>
                                        <a class="btn btn-link" href="{{ route('quotation.create_purchase', ['id' => $work_order->id]) }}"><i class="fa fa-shopping-basket"></i> {{trans('file.Create Purchase')}}</a></button>
                                    </li>
                                    <li class="divider"></li>

                                    {{ Form::open(['route' => ['workorder.destroy', $work_order->id], 'method' => 'DELETE'] ) }}
                                    <li>
                                        <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                    </li>
                                    {{ Form::close() }}
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endif

                @endforeach
            </tbody>
        </table>
    </div>
</section>

<div id="workOrder-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog">
      <div class="modal-content">
        <div class="container mt-3 pb-2 border-bottom">
            {{--  Infinity ERP work  --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-9 float-left">
                        <button id="print-btn" type="button" class="btn btn-default btn-sm d-print-none"><i class="dripicons-print"></i> {{trans('file.Print')}}</button>
                    {{ Form::open(['route' => 'quotation.sendmail', 'method' => 'post', 'class' => 'sendmail-form'] ) }}
                        <input type="hidden" name="workorder_id">
                        <button class="btn btn-default btn-sm d-print-none"><i class="dripicons-mail"></i> {{trans('file.Email')}}</button>
                    {{ Form::close() }}
                    </div>
                    <div class="col-md-3 float-left">
                        <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close" class="close d-print-none"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="col-md-7 float-left">
                        <h3 id="exampleModalLabel" class="modal-title container-fluid">
                            <img style="width: 50%" src="{{asset('public/images/CompanyLogoHeaderTemplate.png') }}">
                        </h3>
                    </div>

                    <div class="col-md-5 float-left text-right">
                        <span class="mt-3" style="font-size: 28px;font-weight:bold; text-transform: uppercase">{{trans('file.Quotation Details')}}</span>
                    </div>
                </div>
            </div>
        </div>
            <div id="quotation-content" class="modal-body">
            </div>
            <br>
            <table class="table table-bordered product-workOrder-list">
                <thead class="dark-blue"style="color: white!important;text-align:center;">
                    <th style="color:  white!important;">#</th>
                    <th style="color:  white!important;">{{trans('file.product')}}</th>
                    <th style="color:  white!important;">Qty</th>
                    <th style="color:  white!important;">{{trans('file.Unit Price')}}</th>
                    {{-- <th style="color:  white!important;">{{trans('file.Tax')}}</th> --}}
                    {{-- <th style="color:  white!important;">{{trans('file.Discount')}}</th> --}}
                    <th style="color:  white!important;">{{trans('file.Subtotal')}}</th>
                </thead>
                <tbody>
                </tbody>
            </table>
            <div id="quotation-footer" class="modal-body"></div>
      </div>
    </div>
</div>

<!--- Filter --->

<div id="Filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal mt-5 fade text-left">
    <div role="document" class="modal-dialog">
        {!! Form::open(['route' => 'workorder.index', 'method' => 'get']) !!}
      <div class="modal-content">
        <div class="modal-header item-page">

        {{-- top button --}}
          <div class="col-md-12">
            <div class="float-left brand-text mt-2">
                <h3>{{trans('file.Filter')}}</h3>
            </div>
            <div class="float-right">
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
            </div>
            <div class="float-right">
                <div class="form-group mr-2">
                    <button type="submit" class="btn btn-save" title="{{trans('file.Use ctrl+s to save')}}" id="filter-btn" type="submit"><i class="fa fa-filter mr-1" aria-hidden="true" ></i> {{trans('file.Filter')}}</button>

                </div>
            </div>
            <div class="float-right mr-2">
                <div class="form-group">
                    <a href="{{ route('workorder.index') }}" class="btn btn-secondary" onclick="AddProducts()"><i class="fa fa-power-off mr-1"></i> {{trans('file.Reset')}}</a>
                </div>
            </div>

          </div>

        </div>
        <div class="modal-body">
            <div class="row mt-5 mb-3">
                {{-- date range --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ trans('file.Date Range') }}</strong> </label>
                        <div class="input-group">
                            <input type="text" class="daterangepicker-field form-control" value="{{ date('d-M-Y', strtotime($starting_date)) }} To {{ date('d-M-Y', strtotime($ending_date)) }}" required />
                            <input type="hidden" name="starting_date" value="{{ $starting_date }}" />
                            <input type="hidden" name="ending_date" value="{{ $ending_date }}" />
                        </div>
                    </div>
                </div>

                  {{-- customer --}}
                  <div class="col-md-4">
                    <div class="form-group">
                        <label>{{trans('file.Customer')}}</strong> </label>
                        <div class="input-group">
                            <select id="customer_id" name="customer_id[]" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" multiple>
                                {{-- <option value="0">{{trans('file.All Customer')}}</option> --}}
                                @foreach($lims_customer_list as $customer)
                                    @if(is_array($customer_id))
                                        @if(in_array($customer->id, $customer_id))
                                            <option selected value="{{$customer->id}}">{{$customer->name}}</option>
                                        @else
                                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                                        @endif
                                    @elseif($customer->id == $customer_id)
                                        <option selected value="{{$customer->id}}">{{$customer->name}}</option>
                                    @else
                                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Order Type --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{trans('file.Order Type')}}</strong> </label>
                        <div class="input-group">
                            <select id="order_type" name="order_type[]" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" multiple>
                                @foreach($lims_ordertype_list as $ordertype)
                                    @if($order_type != null && in_array($ordertype->id, $order_type))
                                        <option selected value="{{$ordertype->id}}">{{$ordertype->order_type}}</option>
                                    @else
                                        <option value="{{$ordertype->id}}">{{$ordertype->order_type}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- warehouse --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{trans('file.Warehouse')}}</strong> </label>
                        <div class="input-group">
                            <select id="warehouse_id" name="warehouse_id[]" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" multiple>
                                @foreach($lims_warehouse_list as $warehouse)
                                    @if(is_array($warehouse_id))
                                        @if(in_array($warehouse->id, $warehouse_id))
                                            <option selected value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                        @else
                                            <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                        @endif
                                    @elseif($warehouse->id == $warehouse_id)
                                        <option selected value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                    @else
                                        <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
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


                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{trans('file.Priority')}}</label>
                        <select name="priority" class="selectpicker form-control">
                            <option value="0">All</option>
                            <option value="Regular" @if(request('priority') == 'Regular') selected @endif>Regular</option>
                            <option value="Urgent" @if(request('priority') == 'Urgent') selected @endif>Urgent</option>
                        </select>
                    </div>
                </div>



            </div>
        </div>
    </div>

    {!! Form::close() !!}

</div>


<script type="text/javascript">

    $("ul#quotation").siblings('a').attr('aria-expanded','true');
    $("ul#quotation").addClass("show");
    $("ul#quotation #quotation-list-menu").addClass("active");
    var all_permission = <?php echo json_encode($all_permission) ?>;
    var workorder_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

    window.addEventListener('keydown', function (event) {
        if (event.shiftKey && event.code === 'KeyA') {
            window.location.href = '/workorder/create';
        }
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

	function confirmDelete() {
        if (confirm("Are you sure want to delete?")) {
            return true;
        }
        return false;
    }

    $("tr.workOrder-linkquotation-link td:not(:first-child, :last-child)").on("click", function(){
        var workOrder = $(this).parent().data('workOrder');
        workOrderDetails(workOrder);
    });

    $(".view").on("click", function(){
        var workOrder = $(this).parent().parent().parent().parent().parent().data('workOrder');
        workOrderDetails(workOrder);
    });

    $("#print-btn").on("click", function(){
          var divToPrint=document.getElementById('workOrder-details');
          var newWin=window.open('','Print-Window');
          newWin.document.open();
          newWin.document.write('<link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css"><style type="text/css">@media print {.modal-dialog { max-width: 1000px;} }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
          newWin.document.close();
          setTimeout(function(){newWin.close();},10);
    });

    $('#wrokOrder-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ ',
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
                'targets': [0, 17]
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                    }

                   return data;
                },
                // 'checkboxes': {
                //    'selectRow': true,
                //    'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                // },
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
                // text: '{{trans("file.CSV")}}',
                text: '<i class="fa fa-file-excel-o mr-1" aria-hidden="true"></i> {{trans("file.CSV")}}',
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
                // text: '{{trans("file.Print")}}',
                text: '<i class="fa fa-print mr-1" aria-hidden="true"></i> {{trans("file.Print")}}',
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
                text: '<i class="fa fa-trash mr-1" aria-hidden="true"></i> {{trans("file.delete")}}',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    if(user_verified == '1') {
                        workorder_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                workorder_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(workorder_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'workorder/deletebyselection',
                                data:{
                                    workorderIdArray: workorder_id
                                },
                                success:function(data){
                                    alert(data);
                                }
                            });
                            dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!workorder_id.length)
                            alert('Nothing is selected!');
                    }
                    else
                        alert('This feature is disable for demo!');
                }
            },
            {
                extend: 'colvis',
                // text: '{{trans("file.Column visibility")}}',
                text: '<i class="fa fa-eye mr-1" aria-hidden="true"></i> {{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            },
        ],
        drawCallback: function () {
            var api = this.api();
            datatable_sum(api, false);
        }
    } );

    var workOrderDataId = [];
    $('#wrokOrder-table tbody').on('click', 'tr', function(e) {
        let checkbox = $(this).find('td:first :checkbox').trigger('click');
        setTimeout(() => {
            const id = this.getElementsByClassName('id')[0].innerText;
            if (checkbox[0].checked === true) {
                this.getElementsByClassName('id')[0].classList.add("selectedId");
                workOrderDataId.push(id);
            } else {
                this.getElementsByClassName('id')[0].classList.remove("selectedId");
                workOrderDataId = workOrderDataId.filter(e => e !== id)
            }
        }, 500);
    });

    function submitWorkOrderSendTo() {
        let ids = workOrderDataId;
        const selectSendTo = document.getElementById('workorder__sendto').value;

        if(selectSendTo) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/workorder/postWorkOrderSendTo',
                data: {
                    _token: CSRF_TOKEN,
                    ids: ids,
                    send_to: selectSendTo,
                },
                type: "POST",
                success: function() {
                    // refresh the page
                    window.location.href = "/workorder/redirectWithSuccess";
                },
                error: function() {
                    alert('Something went wrong!');
                }
            });
        }
    }

    function submitWorkOrderStatus() {
        let ids = workOrderDataId;
        const selectStatus = document.getElementById('workorder__status').value;

        if(selectStatus) {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/workorder/postWorkOrderStatus',
                data: {
                    _token: CSRF_TOKEN,
                    ids: ids,
                    status: selectStatus,
                },
                type: "POST",
                success: function() {
                    // refresh the page
                    window.location.href = "/workorder/redirectWithSuccess";
                },
                error: function() {
                    alert('Something went wrong!');
                }
            });
        }
    }

    function datatable_sum(dt_selector, is_calling_first) {
        if (dt_selector.rows( '.selected' ).any() && is_calling_first) {
            var rows = dt_selector.rows( '.selected' ).indexes();

            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
        }
        else {
            $( dt_selector.column( 7 ).footer() ).html(dt_selector.cells( rows, 7, { page: 'current' } ).data().sum().toFixed(2));
        }
    }

    if(all_permission.indexOf("quotes-delete") == -1)
        $('.buttons-delete').addClass('d-none');

    function workOrderDetails(workOrder){
        $('input[name="work_order_id"]').val(workOrder[13]);

        var htmltext = '<div class="row"><div class="col-md-6 light-blue-border"><div class="col-md-12 p-1 dark-blue"><strong class="pl-2 text-white">{{trans("file.To")}}:</strong></div><span class="ml-2">'+workOrder[9]+'<br>'+workOrder[10]+'<br>'+workOrder[11]+'<br>'+workOrder[12]+'<br></span></div><div class="col-md-6"><div class="light-blue-border"><strong class="dark-blue d-block p-1 pl-2 text-white">{{trans("file.Date")}}:</strong>'+workOrder[0]+'<br/></div><br/><div class="light-blue-border"><strong class="dark-blue d-block p-1 pl-2 text-white">{{trans("file.reference")}}: </strong>'+workOrder[1] +'</div></div></div>';
        $.get('workorder/product_workOder/' + workOrder[13], function(data){
            $(".product-workOrder-list tbody").remove();
            var name_code = data[0];
            var qty = data[1];
            var unit_code = data[2];
            var tax = data[3];
            var tax_rate = data[4];
            var discount = data[5];
            var subtotal = data[6];
            var newBody = $("<tbody>");
            $.each(name_code, function(index){
                var newRow = $("<tr>");
                var cols = '';
                cols += '<td style="text-align:center;"><strong>' + (index+1) + '</strong></td>';
                cols += '<td>' + name_code[index] + '</td>';
                cols += '<td style="text-align:center;">' + qty[index] + ' ' + unit_code[index] + '</td>';
                cols += '<td style="text-align:right;">' + parseFloat(subtotal[index] / qty[index]).toFixed(2) + '</td>';
                {{-- cols += '<td>' + tax[index] + '(' + tax_rate[index] + '%)' + '</td>'; --}}
                {{-- cols += '<td>' + discount[index] + '</td>'; --}}
                cols += '<td style="text-align:right;">' + subtotal[index] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);
            });

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=2><strong>{{trans("file.Total")}}:</strong></td>';
            cols += '<td style="text-align:center;">' + workOrder[14] + '</td>';
            cols += '<td style="text-align:right;">' + workOrder[15] + '</td>';
            cols += '<td style="text-align:right;">' + workOrder[16] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Order Tax")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + workOrder[17] + '(' + workOrder[18] + '%)' + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Order Discount")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + workOrder[19] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4><strong>{{trans("file.Shipping Cost")}}:</strong></td>';
            cols += '<td style="text-align:right;">' + workOrder[20] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            var newRow = $("<tr>");
            cols = '';
            cols += '<td colspan=4 style="font-weight:bold; font-size: 20px"><strong >{{trans("file.grand total")}}:</strong></td>';
            cols += '<td style="font-weight:bold; font-size: 22px;text-align:right;">' + workOrder[21] + '</td>';
            newRow.append(cols);
            newBody.append(newRow);

            $("table.product-workOrder-list").append(newBody);
        });

        var htmlfooter = '<strong class="dark-blue d-block p-1 pl-2 text-white">{{trans("file.Note")}}: </strong>'+workOrder[22] +'<br/><br/><br/><br/>';
        $('#quotation-content').html(htmltext);
        $('#quotation-footer').html(htmlfooter);
        $('#workOrder-details').modal('show');
    }
</script>
@endsection
