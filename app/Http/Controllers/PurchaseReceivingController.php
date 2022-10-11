<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Warehouse;
use App\Supplier;
use App\Product;
use App\Unit;
use App\Tax;
use App\Account;
use App\Purchase;
use App\ProductPurchase;
use App\Product_Warehouse;
use App\Payment;
use App\PaymentWithCheque;
use App\PaymentWithCreditCard;
use App\PosSetting;
use App\PurchaseReceiving;
use App\ProductPurchaseReceiving;
use DB;
use App\GeneralSetting;
use Stripe\Stripe;
use Auth;
use App\User;
use App\ProductVariant;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PurchaseReceivingController extends Controller
{
    public function index(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchases-index')) {
            if($request->input('warehouse_id'))
                $warehouse_id = $request->input('warehouse_id');
            else
                $warehouse_id = 0;

            if($request->input('starting_date')) {
                $starting_date = $request->input('starting_date');
                $ending_date = $request->input('ending_date');
            }
            else {
                $starting_date = date("Y-m-d", strtotime(date('Y-m-d', strtotime('-1 year', strtotime(date('Y-m-d') )))));
                $ending_date = date("Y-m-d");
            }
            $permissions = Role::findByName($role->name)->permissions;
            foreach ($permissions as $permission)
                $all_permission[] = $permission->name;
            if(empty($all_permission))
                $all_permission[] = 'dummy text';
            $lims_purchase_receiving_all = PurchaseReceiving::orderBy('id', 'desc')->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_account_list = Account::where('is_active', true)->get();
            $lims_supplier_list = Supplier::where('is_active', true)->get();

            return view('purchase_receiving.index', compact( 'lims_account_list', 'lims_warehouse_list', 'all_permission', 'lims_supplier_list', 'lims_purchase_receiving_all', 'warehouse_id', 'starting_date', 'ending_date'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function purchaseReceivingData(Request $request)
    {
        $columns = array(
            1 => 'created_at',
            2 => 'reference_no',
            5 => 'grand_total',
            6 => 'paid_amount',
        );

        $warehouse_id = $request->input('warehouse_id');
        if(Auth::user()->role_id > 2 && config('staff_access') == 'own')
            $totalData = Purchase::where('user_id', Auth::id())
                        ->whereDate('created_at', '>=' ,$request->input('starting_date'))
                        ->whereDate('created_at', '<=' ,$request->input('ending_date'))
                        ->count();
        elseif($warehouse_id != 0)
            $totalData = Purchase::where('warehouse_id', $warehouse_id)->whereDate('created_at', '>=' ,$request->input('starting_date'))->whereDate('created_at', '<=' ,$request->input('ending_date'))->count();
        else
            $totalData = Purchase::whereDate('created_at', '>=' ,$request->input('starting_date'))->whereDate('created_at', '<=' ,$request->input('ending_date'))->count();

        $totalFiltered = $totalData;

        if($request->input('length') != -1)
            $limit = $request->input('length');
        else
            $limit = $totalData;
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value'))) {
            if(Auth::user()->role_id > 2 && config('staff_access') == 'own')
                $purchases = Purchase::with('supplier', 'warehouse')->offset($start)
                            ->where('user_id', Auth::id())
                            ->whereDate('created_at', '>=' ,$request->input('starting_date'))
                            ->whereDate('created_at', '<=' ,$request->input('ending_date'))
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->get();
            elseif($warehouse_id != 0)
                $purchases = Purchase::with('supplier', 'warehouse')->offset($start)
                            ->where('warehouse_id', $warehouse_id)
                            ->whereDate('created_at', '>=' ,$request->input('starting_date'))
                            ->whereDate('created_at', '<=' ,$request->input('ending_date'))
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->get();
            else
                $purchases = Purchase::with('supplier', 'warehouse')->offset($start)
                            ->whereDate('created_at', '>=' ,$request->input('starting_date'))
                            ->whereDate('created_at', '<=' ,$request->input('ending_date'))
                            ->limit($limit)
                            ->orderBy($order, $dir)
                            ->get();
        }
        else
        {
            $search = $request->input('search.value');
            if(Auth::user()->role_id > 2 && config('staff_access') == 'own') {
                $purchases =  Purchase::select('purchases.*')
                            ->with('supplier', 'warehouse')
                            ->leftJoin('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
                            ->whereDate('purchases.created_at', '=' , date('Y-m-d', strtotime(str_replace('/', '-', $search))))
                            ->where('purchases.user_id', Auth::id())
                            ->orwhere([
                                ['purchases.reference_no', 'LIKE', "%{$search}%"],
                                ['purchases.user_id', Auth::id()]
                            ])
                            ->orwhere([
                                ['suppliers.name', 'LIKE', "%{$search}%"],
                                ['purchases.user_id', Auth::id()]
                            ])
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)->get();

                $totalFiltered = Purchase::
                            leftJoin('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
                            ->whereDate('purchases.created_at', '=' , date('Y-m-d', strtotime(str_replace('/', '-', $search))))
                            ->where('purchases.user_id', Auth::id())
                            ->orwhere([
                                ['purchases.reference_no', 'LIKE', "%{$search}%"],
                                ['purchases.user_id', Auth::id()]
                            ])
                            ->orwhere([
                                ['suppliers.name', 'LIKE', "%{$search}%"],
                                ['purchases.user_id', Auth::id()]
                            ])
                            ->count();
            }
            else {
                $purchases =  Purchase::select('purchases.*')
                            ->with('supplier', 'warehouse')
                            ->leftJoin('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
                            ->whereDate('purchases.created_at', '=' , date('Y-m-d', strtotime(str_replace('/', '-', $search))))
                            ->orwhere('purchases.reference_no', 'LIKE', "%{$search}%")
                            ->orwhere('suppliers.name', 'LIKE', "%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

                $totalFiltered = Purchase::
                                leftJoin('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
                                ->whereDate('purchases.created_at', '=' , date('Y-m-d', strtotime(str_replace('/', '-', $search))))
                                ->orwhere('purchases.reference_no', 'LIKE', "%{$search}%")
                                ->orwhere('suppliers.name', 'LIKE', "%{$search}%")
                                ->count();
            }
        }
        $data = array();
        if(!empty($purchases))
        {
            foreach ($purchases as $key=>$purchase)
            {
                $nestedData['id'] = $purchase->id;
                $nestedData['key'] = $key;
                $nestedData['date'] = date(config('date_format'), strtotime($purchase->created_at->toDateString()));
                $nestedData['reference_no'] = $purchase->reference_no;

                if($purchase->supplier_id) {
                    $supplier = $purchase->supplier;
                }
                else {
                    $supplier = new Supplier();
                }
                $nestedData['supplier'] = $supplier->name;
                if($purchase->status == 1){
                    $nestedData['purchase_status'] = '<div class="badge badge-success">'.trans('file.Recieved').'</div>';
                    $purchase_status = trans('file.Recieved');
                }
                elseif($purchase->status == 2){
                    $nestedData['purchase_status'] = '<div class="badge badge-success">'.trans('file.Partial').'</div>';
                    $purchase_status = trans('file.Partial');
                }
                elseif($purchase->status == 3){
                    $nestedData['purchase_status'] = '<div class="badge badge-danger">'.trans('file.Pending').'</div>';
                    $purchase_status = trans('file.Pending');
                }
                else{
                    $nestedData['purchase_status'] = '<div class="badge badge-danger">'.trans('file.Ordered').'</div>';
                    $purchase_status = trans('file.Ordered');
                }

                if($purchase->payment_status == 1)
                    $nestedData['payment_status'] = '<div class="badge badge-danger">'.trans('file.Due').'</div>';
                else
                    $nestedData['payment_status'] = '<div class="badge badge-success">'.trans('file.Paid').'</div>';

                $nestedData['grand_total'] = number_format($purchase->grand_total, 2);
                $nestedData['paid_amount'] = number_format($purchase->paid_amount, 2);
                $nestedData['due'] = number_format($purchase->grand_total - $purchase->paid_amount, 2);
                $nestedData['options'] = '<div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.trans("file.action").'
                              <span class="caret"></span>
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                    <button type="button" class="btn btn-link view"><i class="fa fa-eye"></i> '.trans('file.View').'</button>
                                </li>';
                if(in_array("purchases-edit", $request['all_permission']))
                    $nestedData['options'] .= '<li>
                        <a href="'.route('purchases.edit', $purchase->id).'" class="btn btn-link"><i class="dripicons-document-edit"></i> '.trans('file.edit').'</a>
                        </li>';
                $nestedData['options'] .=
                    '<li>
                        <button type="button" class="add-payment btn btn-link" data-id = "'.$purchase->id.'" data-toggle="modal" data-target="#add-payment"><i class="fa fa-plus"></i> '.trans('file.Add Payment').'</button>
                    </li>
                    <li>
                        <button type="button" class="get-payment btn btn-link" data-id = "'.$purchase->id.'"><i class="fa fa-money"></i> '.trans('file.View Payment').'</button>
                    </li>';
                if(in_array("purchases-delete", $request['all_permission']))
                    $nestedData['options'] .= \Form::open(["route" => ["purchases.destroy", $purchase->id], "method" => "DELETE"] ).'
                            <li>
                              <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> '.trans("file.delete").'</button>
                            </li>'.\Form::close().'
                        </ul>
                    </div>';

                // data for purchase details by one click
                $user = User::find($purchase->user_id);

                $nestedData['purchase'] = array( '[ "'.date(config('date_format'), strtotime($purchase->created_at->toDateString())).'"', ' "'.$purchase->reference_no.'"', ' "'.$purchase_status.'"',  ' "'.$purchase->id.'"', ' "'.$purchase->warehouse->name.'"', ' "'.$purchase->warehouse->phone.'"', ' "'.$purchase->warehouse->address.'"', ' "'.$supplier->name.'"', ' "'.$supplier->company_name.'"', ' "'.$supplier->email.'"', ' "'.$supplier->phone_number.'"', ' "'.$supplier->address.'"', ' "'.$supplier->city.'"', ' "'.$purchase->total_tax.'"', ' "'.$purchase->total_discount.'"', ' "'.$purchase->total_cost.'"', ' "'.$purchase->order_tax.'"', ' "'.$purchase->order_tax_rate.'"', ' "'.$purchase->order_discount.'"', ' "'.$purchase->shipping_cost.'"', ' "'.$purchase->grand_total.'"', ' "'.$purchase->paid_amount.'"', ' "'.preg_replace('/\s+/S', " ", $purchase->note).'"', ' "'.$user->name.'"', ' "'.$user->email.'"]'
                );
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

    public function productWithoutVariant()
    {
        return Product::ActiveStandard()->select('id', 'name', 'code')
                ->whereNull('is_variant')->get();
    }

    public function productWithVariant()
    {
        return Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->ActiveStandard()
                ->whereNotNull('is_variant')
                ->select('products.id', 'products.name', 'product_variants.item_code')
                ->orderBy('position')->get();
    }

    public function getPurchaseInfo($id){
        $product_by_ref_product = [];

        $product_by_ref_product['purchase'] = Purchase::find($id);
        $product_by_ref_product['product'] = ProductPurchase::where('purchase_id', '=', $id)
            ->join('products', 'products.id', '=', 'product_purchases.product_id')
            ->join('units', 'units.id', '=', 'products.unit_id')
            ->get(['products.name', 'products.code', 'units.unit_name', 'product_purchases.qty']);

        $product_by_ref_product['qty_sum'] = ProductPurchase::where('purchase_id', '=', $id)
            ->get(['qty'])->sum('qty');
        return response()->json($product_by_ref_product);
    }

    public function productPurchaseReceivingData($id)
    {
        $lims_product_purchase_data = ProductPurchaseReceiving::where('purchase_receiving_id', $id)->get();
        foreach ($lims_product_purchase_data as $key => $product_purchase_data) {
            $product = Product::find($product_purchase_data->product_id);
            $unit = Unit::find($product_purchase_data->purchase_unit_id);
            if($product_purchase_data->variant_id) {
                $lims_product_variant_data = ProductVariant::FindExactProduct($product->id, $product_purchase_data->variant_id)->select('item_code')->first();
                $product->code = $lims_product_variant_data->item_code;
            }
            $product_purchase[0][$key] = $product->name . ' [' . $product->code.']';
            $product_purchase[1][$key] = $product_purchase_data->qty;
            $product_purchase[2][$key] = $unit->unit_code;
            $product_purchase[3][$key] = $product_purchase_data->tax;
            $product_purchase[4][$key] = $product_purchase_data->tax_rate;
            $product_purchase[5][$key] = $product_purchase_data->discount;
            $product_purchase[6][$key] = $product_purchase_data->total;
        }
        return $product_purchase;
    }

    public function create()
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchases-add')){
            $lims_supplier_list = Supplier::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_purchase_list = Purchase::orderBy('id', 'desc')->get();
            $lims_tax_list = Tax::where('is_active', true)->get();
            $lims_product_list_without_variant = $this->productWithoutVariant();
            $lims_product_list_with_variant = $this->productWithVariant();
            $lims_product_ref_list = Purchase::orderBy('id', 'desc')->get(['id', 'reference_no']);

            return view('purchase_receiving.create', compact('lims_supplier_list', 'lims_warehouse_list', 'lims_tax_list', 'lims_purchase_list', 'lims_product_list_without_variant', 'lims_product_ref_list', 'lims_product_list_with_variant'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function store(Request $request)
    {
        $data = $request->except('document');
        //return dd($data);
        $data['reference_no'] = 'prr-' . date("Ymd") . '-'. date("his");
        $data['user_id'] = Auth::id();
        $data['purchase_id'] = $request->purchase_id;
        $data['purchase_reference_no'] = $request->purchase_refrence;
        $data['warehouse_id'] = $request->warehouse_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['purchase_status'] = $request->status;
        $data['note'] = $request->note;
        $multiFile = $request->file('documents');
        if ($multiFile) {
            $imageDb = [];
            foreach ($multiFile as $docfile) {
                $v = Validator::make(
                    [
                        'extension' => strtolower($docfile->getClientOriginalExtension()),
                    ],
                    [
                        'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                    ]
                );
                if ($v->fails()) return redirect()->back()->withErrors($v->errors());

                $documentName = $docfile->getClientOriginalName();
                $docfile->move(public_path('document/purchase-receiving'), $documentName);

                $imageDb[] = $documentName;
            }
            $imageDbUrl = implode(",", $imageDb);

            $data['documents'] =  $imageDbUrl;
        }
        PurchaseReceiving::create($data);
        $purchase_rcv_data = PurchaseReceiving::latest()->first();

        $purchase_data = ProductPurchase::where('purchase_id', '=', $request->purchase_refrence_id)
        ->join('products', 'products.id', '=', 'product_purchases.product_id')
        ->join('units', 'units.id', '=', 'products.unit_id')
        ->get(['products.id', 'products.name', 'products.code', 'products.is_variant', 'products.unit_id', 'units.unit_name', 'product_purchases.qty']);
        $product_purchase = [];

        foreach($purchase_data as $product) {
            $product_purchase['purchase_receiving_id'] = $purchase_rcv_data->id ;
            $product_purchase['product_id'] = $product->id;
            $product_purchase['name'] = $product->name;
            $product_purchase['code'] = $product->code;
            $product_purchase['qty'] = $product->qty;
            // $product_purchase['received'] = $product->id;
            $product_purchase['unit_id'] = $product->unit_id;

            if($product->is_variant) {
                $lims_product_variant_data = ProductVariant::select('id', 'variant_id', 'qty')->FindExactProductWithCode($lims_product_data->id, $product_code[$i])->first();
                $product_purchase['variant_id'] = $lims_product_variant_data->variant_id;
                //add quantity to product variant table
                $lims_product_variant_data->qty += $quantity;
                $lims_product_variant_data->save();
            }
            else {
                $product_purchase['variant_id'] = null;
            }
            ProductPurchaseReceiving::create($product_purchase);
        }

        return redirect('purchase_receiving')->with('message', 'Purchase Receiving created successfully');
    }

    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchases-edit')){
            $lims_supplier_list = Supplier::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_product_list_without_variant = $this->productWithoutVariant();
            $lims_product_list_with_variant = $this->productWithVariant();
            $lims_purchase_receiving_data = PurchaseReceiving::find($id);
            $lims_product_purchase_receiving_data = ProductPurchaseReceiving::where('purchase_receiving_id', $id)->get();

            return view('purchase_receiving.edit', compact('lims_warehouse_list', 'lims_supplier_list', 'lims_product_list_without_variant', 'lims_product_list_with_variant', 'lims_purchase_receiving_data', 'lims_product_purchase_receiving_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');

    }

    public function update(Request $request, $id)
    {
        $lims_purchase_receiving_data = PurchaseReceiving::find($id);
        $lims_purchase_receiving_data->status = $request->status;
        $lims_purchase_receiving_data->note = $request->note;
        $multiFile = $request->file('document');
        if ($multiFile) {
            $imageDb = [];
            foreach ($multiFile as $docfile) {
                $v = Validator::make(
                    [
                        'extension' => strtolower($docfile->getClientOriginalExtension()),
                    ],
                    [
                        'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                    ]
                );
                if ($v->fails()) return redirect()->back()->withErrors($v->errors());

                $documentName = 'document/purchase-receiving/' . $docfile->getClientOriginalName();
                $docfile->move(public_path('document/purchase-receiving/'), $documentName);

                $imageDb[] = $documentName;
            }
            $imageDbUrl = implode(",", $imageDb);

            $lims_purchase_receiving_data->documents = $imageDbUrl;
        }
        $lims_purchase_receiving_data->update();
        $purchase_rcv_data = PurchaseReceiving::latest()->first();

        $purchase_data = ProductPurchaseReceiving::where('purchase_receiving_id', '=', $id)->get();

        foreach ($purchase_data as $key => $product) {
            $product->qty = $request->qty[$key];
            $product->received = $request->recieved[$key];

            $product->update();
        }

        return redirect('purchase_receiving')->with('message', 'Purchase Receiving updated successfully');
    }

    public function destroy($id)
    {
        $lims_purchase_receiving_data = PurchaseReceiving::find($id);
        $lims_product_purchase_receiving_data = ProductPurchaseReceiving::where('purchase_receiving_id', $id)->get();
        foreach ($lims_product_purchase_receiving_data as $product_purchase_receiving_data) {
            $product_purchase_receiving_data->delete();
        }
        $lims_purchase_receiving_data->delete();
        return redirect('purchase_receiving')->with('not_permitted', 'Purchase Receiving deleted successfully');
    }

}
