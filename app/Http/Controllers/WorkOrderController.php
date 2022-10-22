<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Customer;
use App\CustomerGroup;
use App\Warehouse;
use App\Biller;
use App\Product;
use App\Unit;
use App\Tax;
use App\Sale;
use Carbon\Carbon;
use App\Attachments;
use App\Document;
use App\Product_Sale;
use App\Product_Warehouse;
use App\Account;
use App\User;
use App\ProductVariant;
use App\Color;
use App\WorkOrder;
use App\ProductWorkOrder;
use App\FormName;
use DB;
use App\GeneralSetting;
use Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use App\Ordertype;
use App\Size;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchases-index')) {

            if($request->input('warehouse_id')) $warehouse_id = $request->input('warehouse_id');
            else $warehouse_id = null;

            if($request->input('customer_id')) $customer_id = $request->input('customer_id');
            else $customer_id = null;

            if($request->input('order_type')) $order_type = $request->input('order_type');
            else $order_type = null;

            if($request->input('reference_no')) $reference_no = $request->input('reference_no');
            else $reference_no = null;

            if($request->input('starting_date')) {
                $starting_date = $request->input('starting_date');
                $ending_date = $request->input('ending_date');
            }
            else {
                $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d') )))));
                $ending_date = date("Y-m-d");
            }

            if($request->input('priority')) $priority = $request->input('priority');
            else $priority = null;

            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';

            $lims_ordertype_list = Ordertype::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_account_list = Account::where('is_active', true)->get();
            $lims_customer_list = Customer::all();
            return view('work_order.index', compact( 'lims_account_list', 'lims_warehouse_list', 'lims_customer_list', 'all_permission', 'warehouse_id', 'starting_date', 'ending_date', 'customer_id', 'lims_ordertype_list', 'order_type'));
        }

        return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');    
    }

    public function workOrderData(Request $request)
    {
        // this array are using for sorting datatable
        $columns = array(
            1 => 'id',
            2 => 'reference_no',
            3 => 'created_at',
            4 => 'work_order_status',
            5 => 'warehouse',
            8 => 'customer_name',
            9 => 'customer_email',
            10 => 'customer_phone',
            11 => 'user',
            13 => 'work_order_note',
            14 => 'staff_note',
            15 => 'sales_reference_no',
            16 => 'priority',
            17 => 'send_to',
        );

        if($request->input('warehouse_id')) $warehouse_id = $request->input('warehouse_id');
        else $warehouse_id = null;

        if($request->input('customer_id')) $customer_id = $request->input('customer_id');
        else $customer_id = null;

        if($request->input('order_type')) $order_type = $request->input('order_type');
        else $order_type = null;

        if($request->input('reference_no')) $reference_no = $request->input('reference_no');
        else $reference_no = null;

        if($request->input('starting_date')) {
            $starting_date = $request->input('starting_date');
            $ending_date = $request->input('ending_date');
        }
        else {
            $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d') )))));
            $ending_date = date("Y-m-d");
        }

        if($request->input('priority')) $priority = $request->input('priority');
        else $priority = null;

        $lims_work_order = WorkOrder::with('warehouse', 'customer', 'documents', 'products', 'user', 'company');
        
        $totalData = $lims_work_order->count();

        $totalFiltered = $totalData;
        if($request->input('length') != -1)
            $limit = $request->input('length');
        else
            $limit = $totalData;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search = $request->input('search.value');
        $lims_work_order_all = $lims_work_order
            ->whereDate('created_at', '>=', $starting_date)
            ->whereDate('created_at', '<=', $ending_date)
            ->when($warehouse_id != null, function ($q) use ($warehouse_id) {
                return $q->where('warehouse_id', $warehouse_id);
            })
            ->when($customer_id != null, function ($q) use ($customer_id) {
                return $q->whereIn('customer_id', $customer_id);
            })
            ->when($reference_no != null, function ($q) use ($reference_no) {
                return $q->where('reference_no', 'LIKE', "%{$reference_no}%");
            })
            ->when($priority != null, function ($q) use ($priority) {
                return $q->where('priority', '=', $priority);
            })
            ->when($order_type != null, function ($q) use ($order_type) {
                return $q->whereHas('products', function($query) use ($order_type) {
                    return $query->whereIn('order_type', $order_type);
                });
            })
            ->when(!empty($search), function ($query) use ($search) {
                return $query->whereHas('customer', function($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orwhere('email', 'LIKE', "%{$search}%")
                            ->orwhere('phone_number', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('user', function($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('warehouse', function($q) use ($search) {
                        $q->where('name', 'LIKE', "%{$search}%");
                    })
                    ->orwhere('id', 'LIKE', "%{$search}%")
                    ->orwhere('reference_no', 'LIKE', "%{$search}%")
                    ->orwhere('created_at', 'LIKE', "%{$search}%")
                    ->orwhere('work_order_note', 'LIKE', "%{$search}%")
                    ->orwhere('staff_note', 'LIKE', "%{$search}%")
                    ->orwhere('sales_reference_no', 'LIKE', "%{$search}%")
                    ->orwhere('priority', 'LIKE', "%{$search}%")
                    ->orwhere('send_to', 'LIKE', "%{$search}%");
            })
            ->offset($start)
            ->limit($limit)
            ->when($order != null, function ($query) use ($order, $dir) {
                switch ($order) {
                    case 'customer_name':
                        return $query->orderBy(
                            Customer::select('name')
                                ->whereColumn('customer_id', 'customers.id')
                                ->orderBy('name'),
                            $dir
                        );
                        break;
                    case 'customer_email':
                        return $query->orderBy(
                            Customer::select('name')
                                ->whereColumn('customer_id', 'customers.id')
                                ->orderBy('email'),
                            $dir
                        );
                        break;
                    case 'customer_phone':
                        return $query->orderBy(
                            Customer::select('name')
                                ->whereColumn('customer_id', 'customers.id')
                                ->orderBy('phone_number'),
                            $dir
                        );
                        break;
                    case 'warehouse':
                        return $query->orderBy(
                            Warehouse::select('name')
                                ->whereColumn('warehouse_id', 'warehouses.id')
                                ->orderBy('name'),
                            $dir
                        );
                        break;
                    case 'user':
                        return $query->orderBy(
                            User::select('name')
                                ->whereColumn('user_id', 'users.id')
                                ->orderBy('name'),
                            $dir
                        );
                        break;
                    
                    default:
                        return $query->orderBy($order, $dir);
                        break;
                }
            })
            ->get();

        $data = [];
        if(!empty($lims_work_order_all)) {
            foreach ($lims_work_order_all as $key => $value) {
                $nestedData['key'] = $key;
                $nestedData['id'] = $value->id;
                $nestedData['reference_no'] = $value->reference_no ?? '';
                $nestedData['date'] = date(config('date_format'), strtotime($value->created_at->toDateString()));
                
                // work order status
                $nestedData['work_order_status'] = $value->work_order_status;
                if($value->work_order_status == 1) {
                    $nestedData['status'] =  '<div class="badge badge-success">'. trans('file.Completed') .'</div>';
                } elseif ($value->work_order_status == 2) {
                    $nestedData['status'] =  '<div class="badge badge-danger text-bold">'. trans('file.Pending') .'</div>';
                } else {
                    $nestedData['status'] =  '<div class="badge badge-primary text-bold">'. trans('file.Draft') .'</div>';
                }

                // warehouse id
                if($value->warehouse_id ?? false) {
                    $nestedData['warehouse_id'] = $value->warehouse->name;
                } else {
                    $nestedData['warehouse_id'] = 'N/A';
                }

                // file preview
                if($value->documents ?? false) {
                    $temp_file_preview = explode(',', $value->documents->documents)[0];
                    $nestedData['file_preview'] = '<embed src="'. $temp_file_preview .'" type="" height="80" width="80" class="product_image" title="workorder-embed">';
                } else {
                    $nestedData['file_preview'] = '';
                }

                // types
                if($value->order_type_tags ?? false) {
                    $nestedData['types'] = $value->order_type_tags;
                } else{
                    $nestedData['types'] = '';
                }

                // customer name
                if($value->customer_id ?? false) {
                    $nestedData['customer_name'] = $value->customer->name;
                } else {
                    $nestedData['customer_name'] = 'N/A';
                }

                // customer email
                if($value->customer_id ?? false) {
                    $nestedData['customer_email'] = $value->customer->email;
                } else {
                    $nestedData['customer_email'] = 'N/A';
                }

                // customer phone
                if($value->customer_id ?? false) {
                    $nestedData['customer_phone'] = $value->customer->phone_number;
                } else {
                    $nestedData['customer_phone'] = 'N/A';
                }

                // user name
                if($value->user_id ?? false) {
                    $nestedData['user_id'] = $value->user->name;
                } else {
                    $nestedData['user_id'] = 'N/A';
                }

                // attachments
                if($value->documents ?? false) {
                    $workorder_attachments = '';
                    foreach (explode(',', $value->documents->documents) as $li) {
                        $temp_workorder_doc = explode('/', $li);
                        $workorder_attachments .= '<li><a href="'. $li .'" target="_blank" class="attachment-index">'. end($temp_workorder_doc) .'</a></li>';
                    }
                    $nestedData['attachments'] = '<ul>'. $workorder_attachments .'</ul>';
                    $nestedData['workorder_attachments'] = $value->documents->documents;
                } else {
                    $nestedData['attachments'] = '';
                    $nestedData['workorder_attachments'] = '';
                }

                if($value->company ?? false) {
                    $nestedData['company'] = $value->company->name;
                } else {
                    $nestedData['company'] = '';
                }

                if($value->user ?? false) {
                    $nestedData['employee'] = $value->user->name;
                } else {
                    $nestedData['employee'] = '';
                }

                if($value->stage ?? false) {
                    $nestedData['stage'] = $value->stage;
                } else {
                    $nestedData['stage'] = '';
                }

                if($value->expected_date ?? false) {
                    $nestedData['expected_date'] = $value->expected_date;
                } else {
                    $nestedData['expected_date'] = '';
                }

                if($value->delivery_location_id ?? false) {
                    $nestedData['delivery_location'] = Warehouse::findorfail($value->delivery_location_id)->name ?? '';
                } else {
                    $nestedData['delivery_location'] = '';
                }

                $nestedData['work_order_note'] = $value->work_order_note;
                $nestedData['staff_note'] = $value->staff_note;
                $nestedData['sales_reference_no'] = $value->sales_reference_no;
                $nestedData['priority'] = $value->priority;
                $nestedData['send_to'] = $value->send_to;

                // actions
                $action_btn = '<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>';

                $action_dropdown_view = '<li>
                        <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> '. trans('file.View') .'</button>
                    </li>';
                $action_dropdown_edit = '<li>
                        <a class="btn btn-link" href="'. route('workorder.edit', $value->id) .'">
                        <i class="dripicons-document-edit"></i> '.trans('file.edit') .'</a></button>
                    </li>';
                $action_dropdown_create_sale = '<li>
                        <a class="btn btn-link" href="'. route('quotation.create_sale', ['id' => $value->id]) .'"><i class="fa fa-shopping-cart"></i> '. trans('file.Create Sale') .'</a></button>
                    </li>';
                $action_dropdown_create_purchase = '<li>
                        <a class="btn btn-link" href="'. route('quotation.create_purchase', ['id' => $value->id]) .'"><i class="fa fa-shopping-basket"></i> '. trans('file.Create Purchase') .'</a></button>
                    </li>';
                $action_dropdown_destroy = \Form::open(['route' => ['workorder.destroy', $value->id], 'method' => 'DELETE'] );
                $action_dropdown_destroy .= '<li><button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> ';
                $action_dropdown_destroy .= trans('file.delete');
                $action_dropdown_destroy .= '</button></li>';
                $action_dropdown_destroy .= \Form::close();

                $action_dropdowns = '<ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">';
                $action_dropdowns .= $action_dropdown_view;
                $action_dropdowns .= $action_dropdown_edit;
                $action_dropdowns .= $action_dropdown_create_sale;
                $action_dropdowns .= $action_dropdown_create_purchase;
                $action_dropdowns .= '<li class="divider"></li>';
                $action_dropdowns .= $action_dropdown_destroy;
                $action_dropdowns .= '</ul>';

                $action_btn .= $action_dropdowns;

                $nestedData['actions'] = '<div class="btn-group">'. $action_btn . '</div>';

                $nestedData['products'] = ProductWorkOrder::with('product', 'ordertype', 'color', 'size')->where('work_order_id', $value->id)->get();


                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function create()
    {
        $lims_product_list = Product::all();
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('sales-add')){
            $lims_customer_list = Customer::where('is_active', true)->orderBy('created_at', 'desc')->get();
            if(Auth::user()->role_id > 2) {
                $lims_warehouse_list = Warehouse::where([
                    ['is_active', true],
                    ['id', Auth::user()->warehouse_id]
                ])->get();
            }
            else {
                $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            }
            $lims_tax_list = Tax::where('is_active', true)->get();
            $lims_customer_group_all = CustomerGroup::where('is_active', true)->get();
            return view('work_order.create',compact('lims_customer_list', 'lims_warehouse_list', 'lims_tax_list', 'lims_product_list', 'lims_customer_group_all'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function create_workOrder($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('sales-edit')){
            $lims_customer_list = Customer::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_biller_list = Biller::where('is_active', true)->get();
            $lims_tax_list = Tax::where('is_active', true)->get();
            $lims_ordertype_list = Ordertype::where('is_active', true)->get();
            $lims_color_list = Color::where('is_active', true)->get();
            $lims_size_list = Size::where('is_active', true)->get();
            $lims_sale_data = Sale::find($id);
            $lims_product_sale_data = Product_Sale::where('sale_id', $id)->get();
            // $lims_product_sale_data = Product::where('sale_id', $id)->get();
            return view('work_order.create_workOrder',compact('lims_customer_list', 'lims_warehouse_list', 'lims_biller_list', 'lims_tax_list', 'lims_ordertype_list', 'lims_color_list', 'lims_size_list', 'lims_sale_data','lims_product_sale_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');

    }

    public function getSelectedProducts(Request $request) {
        $products = array();
        $lims_ordertype_list = Ordertype::where('is_active', true)->get();
        $lims_color_list = Color::where('is_active', true)->get();
        $lims_size_list = Size::where('is_active', true)->get();

        foreach($request->ids as $id) {
            $data = Product::with('unit', 'tax', 'category')
                ->orderBy('id', 'desc')
                ->where('id', $id)
                ->get()
                ->first();

            $data['p_ordertype'] = $lims_ordertype_list;
            $data['p_color'] = $lims_color_list;
            $data['p_size'] = $lims_size_list;

            array_push($products, $data);
        }

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $yeardate = Carbon::now()->format('y');
        $work_order_form_name = FormName::findorfail(FormName::workOrderId());
        $work_order_ref_seq = sprintf("%05d", $work_order_form_name->reference_no_latest);

        $folder_name = $work_order_form_name->name ?? 'Work Order';
        if($data['work_order_status'] == '0') {
            $data['reference_no'] = '';
            $attachmentsId = $this->storeAttachments($request, $data['reference_no'], $folder_name);
        } else {
            $data['reference_no'] = $work_order_form_name->reference_no_prefix  . '-' . $yeardate . $work_order_ref_seq;

            $attachmentsId = $this->storeAttachments($request, $data['reference_no'], $folder_name);

            $work_order_form_name->reference_no_latest += $work_order_form_name->reference_no_sequence;
            $work_order_form_name->update();
        }

        $data['document'] = $attachmentsId;
        $lims_sale_data = WorkOrder::create($data);
        $lims_customer_data = Customer::find($data['customer_id']);

        $product_id = $data['product_id'];
        $product_code = $data['product_code'];
        $work_order_unit_id = $data['work_order_unit_id'];
        $qty = $data['qty'];
        $order_type = $data['order_type'];
        $color = $data['color'];
        $size = $data['size'];
        $description = $data['description'];
        $note = $data['note'];
        $product_sale = [];

        //product save for product_work_order
        foreach ($product_id as $i => $id) {
            $lims_product_data = Product::where('id', $id)->first();
            $product_sale['variant_id'] = null;
            if($lims_product_data->type == 'combo'){
                $product_list = explode(",", $lims_product_data->product_list);
                $qty_list = explode(",", $lims_product_data->qty_list);
                $price_list = explode(",", $lims_product_data->price_list);

                foreach ($product_list as $key=>$child_id) {
                    $child_data = Product::find($child_id);
                    $child_warehouse_data = Product_Warehouse::where([
                        ['product_id', $child_id],
                        ['warehouse_id', $data['warehouse_id'] ],
                        ])->first();

                    $child_data->qty -= $qty[$i] * $qty_list[$key];
                    $child_warehouse_data->qty -= $qty[$i] * $qty_list[$key];

                    $child_data->save();
                    $child_warehouse_data->save();
                }
            }

            $product_sale['work_order_id'] = $lims_sale_data->id ;
            $product_sale['product_id'] = $id;
            $product_sale['qty'] = $mail_data['qty'][$i] = $qty[$i];
            $product_sale['product_code'] = $product_code[$i];
            $product_sale['work_order_unit_id'] = $work_order_unit_id[$i];
            $product_sale['color'] = $color[$i];
            $product_sale['size'] = $size[$i];
            $product_sale['order_type'] = $order_type[$i];
            $product_sale['description'] = $description[$i];
            $product_sale['note'] = $note[$i];
            ProductWorkOrder::create($product_sale);

        }
        if($data['work_order_status'] == '0') {
            return redirect()->route('workorder.edit', ['workorder' => $lims_sale_data->id])
                ->with('message', 'Saved successfully');
        }
        return redirect('/workorder')->with('message', 'Work order confirmed successfully');
    }

    public function storeCustomer(Request $request)
    {
        $this->validate($request, [
            'phone_number' => [
                'max:255',
                    Rule::unique('customers')->where(function ($query) {
                    return $query->where('is_active', 1);
                }),
            ],
        ]);
        $lims_customer_data = $request->all();
        $lims_customer_data['is_active'] = true;

        //creating user if given user access
        if(isset($lims_customer_data['user'])) {
            $this->validate($request, [
                'name' => [
                    'max:255',
                        Rule::unique('users')->where(function ($query) {
                        return $query->where('is_deleted', false);
                    }),
                ],
                'email' => [
                    'email',
                    'max:255',
                        Rule::unique('users')->where(function ($query) {
                        return $query->where('is_deleted', false);
                    }),
                ],
            ]);

            $lims_customer_data['phone'] = $lims_customer_data['phone_number'];
            $lims_customer_data['role_id'] = 5;
            $lims_customer_data['is_deleted'] = false;
            $lims_customer_data['password'] = bcrypt($lims_customer_data['password']);
            $user = User::create($lims_customer_data);
            $lims_customer_data['user_id'] = $user->id;
            $message = 'Customer and user created successfully';
        }
        else {
            $message = 'Customer created successfully';
        }

        $lims_customer_data['name'] = $lims_customer_data['customer_name'];

        if($lims_customer_data['email']) {
            try{
                Mail::send( 'mail.customer_create', $lims_customer_data, function( $message ) use ($lims_customer_data)
                {
                    $message->to( $lims_customer_data['email'] )->subject( 'New Customer' );
                });
            }
            catch(\Exception $e){
                $message = 'Customer created successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }
        }

        Customer::create($lims_customer_data);
        return redirect('/workorder/create')->with('create_message', $message);
    }

    public function productWorkOrderData($id)
    {
        $lims_product_workOrder_data = ProductWorkOrder::where('work_order_id', $id)->get();
        foreach ($lims_product_workOrder_data as $key => $product_workOrder_data) {
            $product = Product::find($product_workOrder_data->product_id);
            if($product_workOrder_data->variant_id) {
                $lims_product_variant_data = ProductVariant::select('item_code')->FindExactProduct($product_workOrder_data->product_id, $product_workOrder_data->variant_id)->first();
                $product->code = $lims_product_variant_data->item_code;
            }
            if($product_workOrder_data->sale_unit_id){
                $unit_data = Unit::find($product_workOrder_data->sale_unit_id);
                $unit = $unit_data->unit_code;
            }
            else
                $unit = '';

            $product_workOrder[0][$key] = $product->name . ' [' . $product->code . ']';
            $product_qproduct_workOrderuotation[1][$key] = $product_workOrder_data->qty;
            $product_quproduct_workOrderotation[2][$key] = $unit;
            $product_quproduct_workOrderotation[3][$key] = $product_workOrder_data->tax;
            $product_workOrder[4][$key] = $product_workOrder_data->tax_rate;
            $product_workOrder[5][$key] = $product_workOrder_data->discount;
            $product_workOrder[6][$key] = $product_workOrder_data->total;
        }
        return $product_workOrder;
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('quotes-edit')){
            $lims_customer_list = Customer::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_tax_list = Tax::where('is_active', true)->get();
            $lims_ordertype_list = Ordertype::all();
            $lims_color_list = Color::all();
            $lims_size_list = Size::all();
            $lims_product_list = Product::all();
            $lims_workOrder_data = WorkOrder::with('documents', 'user', 'company')->find($id);
            $lims_product_workOrder_data = ProductWorkOrder::where('work_order_id', $id)->get();
            return view('work_order.edit',compact('lims_customer_list', 'lims_warehouse_list', 'lims_tax_list', 'lims_workOrder_data', 'lims_ordertype_list', 'lims_color_list', 'lims_size_list', 'lims_product_workOrder_data', 'lims_product_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('document');
        $lims_work_order_data = WorkOrder::find($id);

        if($data['work_order_status'] == '0' || $lims_work_order_data->work_order_status == '2') {
            $redirectStatus = true;
        } else {
            $redirectStatus = false;
        }

        $yeardate = Carbon::now()->format('y');
        $work_order_form_name = FormName::findorfail(FormName::workOrderId());
        $work_order_ref_seq = sprintf("%05d", $work_order_form_name->reference_no_latest);

        $folder_name = $work_order_form_name->name ?? 'Work Order';
        if($data['work_order_status'] != 0 && $lims_work_order_data->reference_no == '') {
            $data['reference_no'] = $work_order_form_name->reference_no_prefix  . '-' . $yeardate . $work_order_ref_seq;
            $attachmentsId = $this->updateAttachments(
                $request,
                $data['reference_no'],
                $folder_name,
                $data['old_attachments'],
                $lims_work_order_data->document,
            );

            $work_order_form_name->reference_no_latest += $work_order_form_name->reference_no_sequence;
            $work_order_form_name->update();
        } else {
            $attachmentsId = $this->updateAttachments(
                $request,
                $lims_work_order_data->reference_no,
                $folder_name,
                $data['old_attachments'],
                $lims_work_order_data->document,
            );
        }

        $lims_work_order_data->document = $lims_work_order_data->document ?? $attachmentsId;
        $lims_product_sale_data = ProductWorkOrder::where('work_order_id', $id)->get();
        $product_id = $data['product_id'];
        $product_code = $data['product_code'];
        $product_variant_id = $data['product_variant_id'];
        $qty = $data['qty'];
        $order_type = $data['order_type'];
        $color = $data['color'];
        $size = $data['size'];
        $description = $data['description'];
        $note = $data['note'];
        $old_product_id = [];
        $product_sale = [];
        foreach ($lims_product_sale_data as  $key => $product_sale_data) {
            $old_product_id[] = $product_sale_data->product_id;
            $old_product_variant_id[] = null;
            $lims_product_data = Product::find($product_sale_data->product_id);

            if( ($lims_work_order_data->sale_status == 1) && ($lims_product_data->type == 'combo') ) {
                $product_list = explode(",", $lims_product_data->product_list);
                $qty_list = explode(",", $lims_product_data->qty_list);

                foreach ($product_list as $index=>$child_id) {
                    $child_data = Product::find($child_id);
                    $child_warehouse_data = Product_Warehouse::where([
                        ['product_id', $child_id],
                        ['warehouse_id', $lims_work_order_data->warehouse_id ],
                        ])->first();

                    $child_data->qty += $product_sale_data->qty * $qty_list[$index];
                    $child_warehouse_data->qty += $product_sale_data->qty * $qty_list[$index];

                    $child_data->save();
                    $child_warehouse_data->save();
                }
            }

            $product_sale['work_order_id'] = $id ;
            $product_sale['product_id'] = $product_id[$key];
            $product_sale['qty'] = $mail_data['qty'][$key] = $qty[$key];
            $product_sale['product_code'] = $product_code[$key];
            $product_sale['order_type'] = $order_type[$key];
            $product_sale['color'] = $color[$key];
            $product_sale['size'] = $size[$key];
            $product_sale['description'] = $description[$key];
            $product_sale['note'] = $note[$key];

            if($product_sale['work_order_id'] && in_array($product_code[$key], $product_code)) {
                ProductWorkOrder::updateOrCreate([
                    ['product_id', $product_sale['product_id']],
                    ['product_code', $product_sale['product_code']],
                    ['work_order_id', $id]
                ], $product_sale);
            }
            elseif( $product_sale['product_code'] === null && (in_array($product_id, $old_product_id)) ) {
                ProductWorkOrder::updateOrCreate([
                    ['work_order_id', $id],
                    ['product_id', $product_sale['product_id']]
                ], $product_sale);
            }
            else
                productWorkOrder::create($product_sale);
        }

        $lims_work_order_data->update($data);
        $lims_customer_data = Customer::find($data['customer_id_hidden']);
        $message = 'Work Order updated successfully';
        if($redirectStatus) {
            return redirect()->back()->with('message', 'Saved successfully');
        }
        return redirect('workorder')->with('message', $message);
    }

    public function deleteBySelection(Request $request)
    {
        $workorder_id = $request['workorderIdArray'];
        foreach ($workorder_id as $id) {
            $lims_workorder_data = WorkOrder::find($id);
            $lims_product_workorder_data = ProductWorkOrder::where('work_order_id', $id)->get();
            foreach ($lims_product_workorder_data as $product_workorder_data) {
                $product_workorder_data->delete();
            }
            $lims_workorder_data->delete();
        }
        return redirect('workorder')->with('not_permitted', 'Work Order deleted successfully');
    }

    public function destroy($id)
    {
        $lims_work_order_data = WorkOrder::find($id);
        $documents = explode(',', $lims_work_order_data->docs);
        try {
            foreach($documents as $document) {
                unlink(public_path($document));
            }
        } catch (\Exception $e) {

        }
        $lims_product_work_order_data = ProductWorkOrder::where('work_order_id', $id)->get();
        foreach ($lims_product_work_order_data as $lims_work_order_data_item) {
            $lims_work_order_data_item->delete();
        }
        $lims_work_order_data->delete();
        return redirect('workorder')->with('not_permitted', 'Work Order deleted successfully');
    }

    public function storeAttachments(Request $request, $reference_no, $folder_name) {
        $documents = $request->file('documents');
        try {
            foreach ($documents as $document) {
                $validator = Validator::make(
                    ['extension' => strtolower($document->getClientOriginalExtension())],
                    ['extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt']
                );
                if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());
            }
            $doc = Attachments::store($documents, 'App\WorkOrder', $folder_name, $reference_no);
            return $doc->id;
        } catch(\Exception $e) {
            return null;
        }
    }

    public function updateAttachments(Request $request, $reference_no, $folder_name, $oldDocs = null, $attachmentsId = null) {
        $documents = $request->file('documents');
        try {
            if($documents) {
                foreach ($documents as $document) {
                    $validator = Validator::make(
                        ['extension' => strtolower($document->getClientOriginalExtension())],
                        ['extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt']
                    );
                    if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());
                }
            }
            $doc = Attachments::docUpdate(
                $documents,
                'App\WorkOrder',
                $oldDocs,
                $attachmentsId,
                $folder_name,
                $reference_no,
                $request->old_remove_attachments ?? '',
            );
            return $doc->id;
        } catch(\Exception $e) {
            return null;
        }
    }

    public function postWorkOrderSendTo(Request $request) {
        foreach($request->ids as $id) {
            $workorder = WorkOrder::find($id);
            $workorder->send_to = $request->send_to;
            $workorder->update();
        }
        return response()->json(['success' => true]);
    }

    public function postWorkOrderStatus(Request $request) {
        foreach($request->ids as $id) {
            $workorder = WorkOrder::find($id);
            $workorder->work_order_status = $request->status;
            $workorder->update();
        }
        return response()->json(['success' => true]);
    }

    public function redirectWithSuccess() {
        $message = 'Work Order updated successfully';
        return redirect()->back()->with('message', $message);
    }

    public function sendMail(Request $request)
    {
        $data = $request->all();
        $lims_workorder_data = WorkOrder::with('warehouse', 'customer', 'documents', 'products', 'user', 'company')
            ->find($data['workorder_id']);
        $lims_product_workorder_data = $lims_workorder_data->products ?? [];
        $lims_customer_data = Customer::find($lims_workorder_data->customer_id);
        if($lims_customer_data->email) {
            //collecting mail data
            $mail_data['email'] = $lims_customer_data->email;
            $mail_data['reference_no'] = $lims_workorder_data->reference_no;

            foreach ($lims_product_workorder_data as $key => $product_workorder_data) {
                $lims_product_data = Product::find($product_workorder_data->product_id);
                if($product_workorder_data->variant_id) {
                    $variant_data = Variant::find($product_workorder_data->variant_id);
                    $mail_data['products'][$key] = $lims_product_data->name . ' [' . $variant_data->name . ']';
                }
                else
                    $mail_data['products'][$key] = $lims_product_data->name;
                if($product_workorder_data->sale_unit_id){
                    $lims_unit_data = Unit::find($product_workorder_data->sale_unit_id);
                    $mail_data['unit'][$key] = $lims_unit_data->unit_code;
                }
                else
                    $mail_data['unit'][$key] = '';

                $mail_data['qty'][$key] = $product_workorder_data->qty;
                // $mail_data['total'][$key] = $product_workorder_data->total;
            }


            try{
                Mail::send( 'mail.quotation_details', $mail_data, function( $message ) use ($mail_data)
                {
                    $message->to( $mail_data['email'] )->subject( 'Quotation Details' );
                });
                $message = 'Mail sent successfully';
            }
            catch(\Exception $e){
                $message = 'Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }
        }
        else
            $message = 'Customer doesnt have email!';

        return redirect()->back()->with('message', $message);
    }

}
