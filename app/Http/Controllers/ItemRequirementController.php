<?php

namespace App\Http\Controllers;

use App\ItemRequirement;
use Illuminate\Http\Request;
use App\Customer;
use App\CustomerGroup;
use App\Supplier;
use App\Warehouse;
use App\Biller;
use App\Product;
use App\Unit;
use App\Tax;
use App\Account;
use App\Quotation;
use App\Delivery;
use App\PosSetting;
use App\SupplierQuotation;
use App\ProductItemRequirement;
use App\ProductQuotation;
use App\Product_Warehouse;
use App\ProductVariant;
use App\Variant;
use App\Status;
use DB;
use NumberToWords\NumberToWords;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class ItemRequirementController extends Controller
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
            $lims_item_requirment_all = ItemRequirement::orderBy('id', 'desc')->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_account_list = Account::where('is_active', true)->get();
            $lims_supplier_list = Supplier::where('is_active', true)->get();
            $lims_status_list = Status::all();

            return view('item_requirement.index', compact( 'lims_account_list', 'lims_warehouse_list', 'all_permission', 'lims_supplier_list', 'lims_item_requirment_all','lims_status_list', 'warehouse_id', 'starting_date', 'ending_date'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
    }

    public function getSelectedProducts(Request $request) {
        $products = array();
        foreach($request->ids as $id) {
            $product = Product::with('unit')->orderBy('id', 'desc')->where('id', $id)->get();

            array_push($products,$product);
        }
        return response()->json($products);
    }

    public function create()
    {

        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('quotes-add')){
            $lims_supplier_list = Supplier::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_tax_list = Tax::where('is_active', true)->get();
            $lims_product_list_without_variant = $this->productWithoutVariant();
            $lims_product_list_with_variant = $this->productWithVariant();
            // $lims_status_list = Status::where('id', '<', 4)->get();
            $lims_status_list = Status::where('id', 1)->get();
            $lims_product_list = Product::all();

            return view('item_requirement.create', compact('lims_supplier_list', 'lims_warehouse_list', 'lims_tax_list', 'lims_product_list_without_variant','lims_status_list', 'lims_product_list_with_variant', 'lims_product_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');
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

    public function getCustomerGroup($id)
    {
         $lims_customer_data = Customer::find($id);
         $lims_customer_group_data = CustomerGroup::find($lims_customer_data->customer_group_id);
         return $lims_customer_group_data->percentage;
    }

    public function getProduct($id)
    {
        $product_code = [];
        $product_name = [];
        $product_qty = [];
        $product_price = [];
        $product_data = [];

        //retrieve data of product without variant
        $lims_product_warehouse_data = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
        ->where([
            ['products.is_active', true],
            ['product_warehouse.warehouse_id', $id],
        ])->whereNull('product_warehouse.variant_id')->select('product_warehouse.*')->get();

        foreach ($lims_product_warehouse_data as $product_warehouse)
        {
            $product_qty[] = $product_warehouse->qty;
            $product_price[] = $product_warehouse->price;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $product_code[] =  $lims_product_data->code;
            $product_name[] = $lims_product_data->name;
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = null;
            $qty_list[] = null;
        }
        //retrieve data of product with variant
        $lims_product_warehouse_data = Product::join('product_warehouse', 'products.id', '=', 'product_warehouse.product_id')
        ->where([
            ['products.is_active', true],
            ['product_warehouse.warehouse_id', $id],
        ])->whereNotNull('product_warehouse.variant_id')->select('product_warehouse.*')->get();
        foreach ($lims_product_warehouse_data as $product_warehouse)
        {
            $product_qty[] = $product_warehouse->qty;
            $lims_product_data = Product::find($product_warehouse->product_id);
            $lims_product_variant_data = ProductVariant::select('item_code')->FindExactProduct($product_warehouse->product_id, $product_warehouse->variant_id)->first();
            $product_code[] =  $lims_product_variant_data->item_code;
            $product_name[] = $lims_product_data->name;
            $product_type[] = $lims_product_data->type;
            $product_id[] = $lims_product_data->id;
            $product_list[] = null;
            $qty_list[] = null;
        }
        //retrieve product data of digital and combo
        $lims_product_data = Product::whereNotIn('type', ['standard'])->where('is_active', true)->get();
        foreach ($lims_product_data as $product)
        {
            $product_qty[] = $product->qty;
            $lims_product_data = $product->id;
            $product_code[] =  $product->code;
            $product_name[] = $product->name;
            $product_type[] = $product->type;
            $product_id[] = $product->id;
            $product_list[] = $product->product_list;
            $qty_list[] = $product->qty_list;
        }
        $product_data = [$product_code, $product_name, $product_qty, $product_type, $product_id, $product_list, $qty_list, $product_price];
        return $product_data;
    }


    public function limsProductSearch(Request $request)
    {
        $todayDate = date('Y-m-d');
        $product_code = explode("(", $request['data']);
        $product_code[0] = rtrim($product_code[0], " ");
        $product_variant_id = null;
        $lims_product_data = Product::where('code', $product_code[0])->first();
        if(!$lims_product_data) {
            $lims_product_data = Product::join('product_variants', 'products.id', 'product_variants.product_id')
                ->select('products.*', 'product_variants.id as product_variant_id', 'product_variants.item_code', 'product_variants.additional_price')
                ->where('product_variants.item_code', $product_code[0])
                ->first();
            $product_variant_id = $lims_product_data->product_variant_id;
            $lims_product_data->code = $lims_product_data->item_code;
            $lims_product_data->price += $lims_product_data->additional_price;
        }
        $product[] = $lims_product_data->name;
        $product[] = $lims_product_data->code;
        if($lims_product_data->promotion && $todayDate <= $lims_product_data->last_date){
            $product[] = $lims_product_data->promotion_price;
        }
        else
            $product[] = $lims_product_data->price;

        if($lims_product_data->tax_id) {
            $lims_tax_data = Tax::find($lims_product_data->tax_id);
            $product[] = $lims_tax_data->rate;
            $product[] = $lims_tax_data->name;
        }
        else{
            $product[] = 0;
            $product[] = 'No Tax';
        }
        $product[] = $lims_product_data->tax_method;
        if($lims_product_data->type == 'standard'){
            $units = Unit::where("base_unit", $lims_product_data->unit_id)
                        ->orWhere('id', $lims_product_data->unit_id)
                        ->get();
            $unit_name = array();
            $unit_operator = array();
            $unit_operation_value = array();
            foreach ($units as $unit) {
                if($lims_product_data->sale_unit_id == $unit->id) {
                    array_unshift($unit_name, $unit->unit_name);
                    array_unshift($unit_operator, $unit->operator);
                    array_unshift($unit_operation_value, $unit->operation_value);
                }
                else {
                    $unit_name[]  = $unit->unit_name;
                    $unit_operator[] = $unit->operator;
                    $unit_operation_value[] = $unit->operation_value;
                }
            }

            $product[] = implode(",",$unit_name) . ',';
            $product[] = implode(",",$unit_operator) . ',';
            $product[] = implode(",",$unit_operation_value) . ',';
        }
        else {
            $product[] = 'n/a'. ',';
            $product[] = 'n/a'. ',';
            $product[] = 'n/a'. ',';
        }
        $product[] = $lims_product_data->id;
        $product[] = $product_variant_id;
        $product[] = $lims_product_data->promotion;
        return $product;
    }

    public function store(Request $request)
    {
        $data = $request->except('document');
        //return dd($data);
        $data['user_id'] = Auth::id();
        $data['workflow_status_id'] = true;
        $data['approval_status_id'] = true;
        if($request->itemRequirementIsConfirm) {
            $data['reference_no'] = 'irr-' . date("Ymd") . '-'. date("his");
        }
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

                $documentName = $docfile->getClientOriginalName();
                $docfile->move(public_path('document/item-requirements'), $documentName);

                $imageDb[] = $documentName;
            }
            $imageDbUrl = implode(",", $imageDb);

            $data['document'] = $imageDbUrl;
        }
        //return dd($data);
        ItemRequirement::create($data);

        $lims_purchase_data = ItemRequirement::latest()->first();
        $product_id = array_key_exists('product_id', $data) ? $data['product_id'] : [];
        $product_code = $data['product_code'];
        $qty = $data['qty'];
        // $recieved = $data['recieved'];
        // $purchase_unit = array_key_exists('purchase_unit', $data) ? $data['purchase_unit'] : [];
        $pnote = $data['pnote'];
        $product_purchase = [];

        foreach ($product_id as $i => $id) {
            // $lims_purchase_unit_data  = Unit::where('unit_name', $purchase_unit[$i])->first();


            $lims_product_data = Product::find($id);
            if($lims_product_data->is_variant??false) {
                $lims_product_variant_data = ProductVariant::select('id', 'variant_id', 'qty')->FindExactProductWithCode($lims_product_data->id, $product_code[$i])->first();
                $lims_product_warehouse_data = Product_Warehouse::where([
                    ['product_id', $id],
                    ['variant_id', $lims_product_variant_data->variant_id],
                    ['warehouse_id', $data['warehouse_id']]
                ])->first();
                $product_purchase['variant_id'] = $lims_product_variant_data->variant_id;
                //add quantity to product variant table
                $lims_product_variant_data->qty += $quantity;
                $lims_product_variant_data->save();
            }
            else {
                $product_purchase['variant_id'] = null;
                $lims_product_warehouse_data = Product_Warehouse::where([
                    ['product_id', $id],
                    ['warehouse_id', $data['warehouse_id'] ],
                ])->first();
            }
            //add quantity to product table
            $lims_product_data->qty = $lims_product_data->qty;
            $lims_product_data->save();
            //add quantity to warehouse
            if ($lims_product_warehouse_data) {
                $lims_product_warehouse_data->qty = $lims_product_warehouse_data->qty;
            }
            else {
                $lims_product_warehouse_data = new Product_Warehouse();
                $lims_product_warehouse_data->product_id = $id;
                $lims_product_warehouse_data->warehouse_id = $data['warehouse_id'];
                // $lims_product_warehouse_data->qty = $quantity;
                if($lims_product_data->is_variant)
                    $lims_product_warehouse_data->variant_id = $lims_product_variant_data->variant_id;
            }

            $lims_product_warehouse_data->save();

            $product_purchase['item_requirement_id'] = $lims_purchase_data->id ;
            $product_purchase['product_id'] = $id;
            $product_purchase['qty'] = $qty[$i];
            // $product_purchase['recieved'] = $recieved[$i];
            // $product_purchase['unit_id'] = $lims_purchase_unit_data->id;
            $product_purchase['pnote'] = $pnote[$i];
            ProductItemRequirement::create($product_purchase);
        }
        if($request->itemRequirementIsConfirm) {
            return redirect('item_requirement')->with('message', 'Item Requirement updated successfully');
        } else {
            // return redirect()->back()->with('message', 'Item Requirement updated successfully');
            return redirect()->route('item_requirement.edit', ['item_requirement' => $lims_purchase_data->id])->with('message', 'Record Saved Successfully');
        }

    }


    public function edit($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchases-edit')){
            $lims_supplier_list = Supplier::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_tax_list = Tax::where('is_active', true)->get();
            $lims_product_list_without_variant = $this->productWithoutVariant();
            $lims_product_list_with_variant = $this->productWithVariant();
            $lims_item_requirment_data = ItemRequirement::find($id);
            $lims_product_item_requirment_data = ProductItemRequirement::where('item_requirement_id', $id)->get();
            $lims_product_list = Product::all();
            $lims_status_list = Status::where('id', 1)->get();

            return view('item_requirement.edit', compact('lims_warehouse_list', 'lims_supplier_list', 'lims_product_list_without_variant', 'lims_product_list_with_variant', 'lims_tax_list', 'lims_item_requirment_data', 'lims_product_item_requirment_data', 'lims_product_list', 'lims_status_list'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');

    }

    public function view($id)
    {
        $role = Role::find(Auth::user()->role_id);
        if($role->hasPermissionTo('purchases-edit')){
            $lims_supplier_list = Supplier::where('is_active', true)->get();
            $lims_warehouse_list = Warehouse::where('is_active', true)->get();
            $lims_tax_list = Tax::where('is_active', true)->get();
            $lims_product_list_without_variant = $this->productWithoutVariant();
            $lims_product_list_with_variant = $this->productWithVariant();
            $lims_item_requirment_data = ItemRequirement::find($id);
            $lims_product_item_requirment_data = ProductItemRequirement::where('item_requirement_id', $id)->get();

            return view('item_requirement.view', compact('lims_warehouse_list', 'lims_supplier_list', 'lims_product_list_without_variant', 'lims_product_list_with_variant', 'lims_tax_list', 'lims_item_requirment_data', 'lims_product_item_requirment_data'));
        }
        else
            return redirect()->back()->with('not_permitted', 'Sorry! You are not allowed to access this module');

    }

    public function update(Request $request, $id)
    {
        $data = $request->except('document');
        $document = $request->document;
        if ($document) {
            $v = Validator::make(
                [
                    'extension' => strtolower($request->document->getClientOriginalExtension()),
                ],
                [
                    'extension' => 'in:jpg,jpeg,png,gif,pdf,csv,docx,xlsx,txt',
                ]
            );
            if ($v->fails())
                return redirect()->back()->withErrors($v->errors());

            $documentName = $document->getClientOriginalName();
            $document->move('/purchase/documents', $documentName);
            $data['document'] = $documentName;
        }

        $lims_purchase_data = ItemRequirement::find($id);

        if($request->itemRequirementIsConfirm) {
            if(!($lims_purchase_data->reference_no)) {
                $data['reference_no'] = 'irr-' . date("Ymd") . '-'. date("his");
            }
        }

        $lims_product_purchase_data = ProductItemRequirement::where('item_requirement_id', $id)->get();

        $product_id = $data['product_id'];
        $product_code = $data['product_code'];
        $qty = $data['qty'];

        $purchase_unit = $data['purchase_unit'];
        $pnote = $data['pnote'];
        $product_purchase = [];

        foreach ($lims_product_purchase_data as $product_purchase_data) {

            $old_recieved_value = $product_purchase_data->recieved;
            $lims_purchase_unit_data = Unit::find($product_purchase_data->purchase_unit_id);


            $lims_product_data = Product::find($product_purchase_data->product_id);
            if($lims_product_data->is_variant) {
                $lims_product_variant_data = ProductVariant::select('id', 'variant_id', 'qty')->FindExactProduct($lims_product_data->id, $product_purchase_data->variant_id)->first();
                $lims_product_warehouse_data = Product_Warehouse::where([
                    ['product_id', $lims_product_data->id],
                    ['variant_id', $product_purchase_data->variant_id],
                    ['warehouse_id', $lims_purchase_data->warehouse_id]
                ])->first();
                $lims_product_variant_data->qty -= $old_recieved_value;
                $lims_product_variant_data->save();
            }
            else {
                $lims_product_warehouse_data = Product_Warehouse::where([
                    ['product_id', $product_purchase_data->product_id],
                    ['warehouse_id', $lims_purchase_data->warehouse_id],
                    ])->first();
            }

            $lims_product_data->qty -= $old_recieved_value;
            $lims_product_warehouse_data->qty -= $old_recieved_value;
            $lims_product_warehouse_data->save();
            $lims_product_data->save();
            $product_purchase_data->delete();
        }

        foreach ($product_id as $key => $pro_id) {

            $lims_purchase_unit_data = Unit::where('unit_name', $purchase_unit[$key])->first();


            $lims_product_data = Product::find($pro_id);
            if($lims_product_data->is_variant) {
                $lims_product_variant_data = ProductVariant::select('id', 'variant_id', 'qty')->FindExactProductWithCode($pro_id, $product_code[$key])->first();
                $lims_product_warehouse_data = Product_Warehouse::where([
                    ['product_id', $pro_id],
                    ['variant_id', $lims_product_variant_data->variant_id],
                    ['warehouse_id', $data['warehouse_id']]
                ])->first();
                $product_purchase['variant_id'] = $lims_product_variant_data->variant_id;
                //add quantity to product variant table
                $lims_product_variant_data->qty += $new_recieved_value;
                $lims_product_variant_data->save();
            }
            else {
                $product_purchase['variant_id'] = null;
                $lims_product_warehouse_data = Product_Warehouse::where([
                    ['product_id', $pro_id],
                    ['warehouse_id', $data['warehouse_id'] ],
                ])->first();
            }



            $lims_product_data->save();

            $product_purchase['item_requirement_id'] = $id ;
            $product_purchase['product_id'] = $pro_id;
            $product_purchase['qty'] = $qty[$key];
            $product_purchase['purchase_unit_id'] = $lims_purchase_unit_data->id;
            $product_purchase['pnote'] = $pnote[$key];

            ProductItemRequirement::create($product_purchase);
        }

        $lims_purchase_data->update($data);
        if($request->itemRequirementIsConfirm) {
            return redirect('item_requirement')->with('message', 'Item Requirement updated successfully');
        } else {
            return redirect()->back()->with('message', 'Item Requirement updated successfully');
        }
    }

    public function destroy($id)
    {
        $lims_item_requirement_data = ItemRequirement::find($id);
        $lims_product_item_requirement_data = ProductItemRequirement::where('item_requirement_id', $id)->get();
        foreach ($lims_product_item_requirement_data as $product_item_requirement_data) {
            $product_item_requirement_data->delete();
        }
        $lims_item_requirement_data->delete();
        return redirect('item_requirement')->with('not_permitted', 'Item Requirements deleted successfully');
    }

}
