<?php

namespace App\Http\Controllers;

use App\Product;
use App\Variant;
use App\Warehouse;
use App\ShelfLocation;
use Illuminate\Http\Request;

class ShelfLocationController extends Controller
{
    public function index() {
        $shelfLocations = ShelfLocation::with('product')
            ->get();

        foreach($shelfLocations as $key => $shelfLocation) {
            if($shelfLocations[$key]['warehouse_id']) $shelfLocations[$key]['warehouse'] = Warehouse::findorfail($shelfLocations[$key]['warehouse_id']);
            if($shelfLocations[$key]['variant_id']) $shelfLocations[$key]['variant'] = Variant::findorfail($shelfLocations[$key]['variant_id']);
        }
        
        return view('shelf_location.index', compact('shelfLocations'));
    }

    public function create() {
        $lims_product_list = Product::all();

        return view('shelf_location.create', compact('lims_product_list'));
    }

    public function getSelectedProducts(Request $request) {
        $data['products'] = Product::with('unit', 'variant')
            ->findorfail($request->ids);

        $data['warehouses'] = Warehouse::where('is_active', true)->get();
        // $data['variant'] = Variant::all();

        return response()->json($data);
    }

    public function store(Request $request) {
        foreach($request->product_id as $key => $productId) {
            $data[$key]['product_id'] = $productId;
        }
        if($request->variant_id) {
            foreach($request->variant_id as $key => $variantId) {
                $data[$key]['variant_id'] = $variantId;
            }
        }
        if($request->warehouse_id) {
            foreach($request->warehouse_id as $key => $warehouseId) {
                $data[$key]['warehouse_id'] = $warehouseId;
            }
        }
        foreach($request->shelfA as $key => $shelfA) {
            $data[$key]['position_A'] = $shelfA;
        }
        foreach($request->shelfB as $key => $shelfB) {
            $data[$key]['position_B'] = $shelfB;
        }
        foreach($request->shelfC as $key => $shelfC) {
            $data[$key]['position_C'] = $shelfC;
        }
        foreach($request->shelfD as $key => $shelfD) {
            $data[$key]['position_D'] = $shelfD;
        }
        foreach($request->pnote as $key => $note) {
            $data[$key]['note'] = $note;
        }
        foreach($data as $item) {
            ShelfLocation::create($item);
        }
        
        return redirect()->route('product.shelf_location')->with('message', 'Shelf Location created successfully');
    }

    public function edit($id) {
        $shelfLocation = ShelfLocation::findorfail($id);
        if($shelfLocation['warehouse_id']) $shelfLocation['warehouse'] = Warehouse::findorfail($shelfLocation['warehouse_id']);
        if($shelfLocation['variant_id']) $shelfLocation['variant'] = Variant::findorfail($shelfLocation['variant_id']);

        $shelfLocation['warehouses'] = Warehouse::where('is_active', true)->get();
        $data = Product::with('variant')
            ->where('products.id', $shelfLocation->product_id)
            ->get();
        
        $shelfLocation['variants'] = $data[0]['variant'];

        return view('shelf_location.edit', compact('shelfLocation'));
    }

    public function update(Request $request, $id) {
        ShelfLocation::findorfail($id)->update([
            "warehouse_id" => $request->warehouse_id,
            "variant_id" => $request->variant_id,
            "position_A" => $request->shelfA,
            "position_B" => $request->shelfB,
            "position_C" => $request->shelfC,
            "position_D" => $request->shelfD,
            "note" => $request->pnote,
        ]);
        return redirect()->route('product.shelf_location')->with('message', 'Shelf Location updated successfully');
    }

    public function destroy($id) {
        ShelfLocation::findorfail($id)->delete();
        return redirect()->route('product.shelf_location')->with('message', 'Shelf Location deleted successfully');
    }


    public function importData(Request $request)
    {
        $upload=$request->file('file');
        $ext = pathinfo($upload->getClientOriginalName(), PATHINFO_EXTENSION);
        if($ext != 'csv')
            return redirect()->back()->with('message', 'Please upload a CSV file');

        $filePath=$upload->getRealPath();
        //open and read
        $file=fopen($filePath, 'r');
        $header= fgetcsv($file);
        $escapedHeader=[];
        //validate
        foreach ($header as $key => $value) {
            $lheader=strtolower($value);
            $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
            array_push($escapedHeader, $escapedItem);
        }
        //looping through other columns
        while($columns=fgetcsv($file))
        {
            foreach ($columns as $key => $value) {
                $value=preg_replace('/\D/','',$value);
            }
            $data= array_combine($escapedHeader, $columns);
            
            $warehouses = Warehouse::all();
            foreach($warehouses as $key=> $warehouse) {
                if($data['locationcode'] == $warehouse->code) $data['warehouseid'] = $warehouse->id;
            }

            $products = Product::all();
            foreach($products as $key=> $product) {
                if($data['productcode'] == $product->code) $data['productid'] = $product->id;
            }


            ShelfLocation::create([
                "product_id" => $data['productid'],
                "warehouse_id" => $data['warehouseid'] ?? null,
                "variant_id" => $data['variantid'] ?? null,
                "position_A" => $data['positiona'],
                "position_B" => $data['positionb'],
                "position_C" => $data['positionc'],
                "position_D" => $data['positiond'],
                "note" => $data['note'],
            ]); 
        }

        return redirect()->route('product.shelf_location')->with('message', 'Shelf Location Imported successfully');
    }

    
}
