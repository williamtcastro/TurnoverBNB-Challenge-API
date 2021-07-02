<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\ProductHistory;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store the specified new product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        return Product::create($request->all());
    }

    /**
     * Store the many specified new products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMany(Request $request)
    {
        $timestamp = Carbon::now('utc')->toDateTimeString();

        $products = [];
        $data = $request->all();

        foreach ($data as $prod => $values) {

            $product = [
                'name' => $values['name'],
                'quantity' => $values['quantity'],
                'price' => $values['price'],
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];

            array_push($products, $product);
        }

        if (Product::insert($products)) {
            return ["message" => true];
        }

        return response(['message' => false], 500);
    }

    /**
     * Display the specified product and its quantity history.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if ($product != null) {
            $productHistory = Product::find($id)->quantity_history;
            $product->quantity_history = $productHistory;
        } else {
            return response(['message' => false], 400);
        }
        return $product;
    }

    /**
     * Update the specified products at the same time.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateMany(Request $request)
    {
        $data = $request->all();
        foreach ($data as $prod => $val) {
            $productId = $val['id'];
            $product = Product::find($productId);
            if (array_key_exists('quantity', $val)) {
                if ($product['quantity'] != $val['quantity'])
                    ProductHistory::create([
                        'product_id' => $productId,
                        'quantity' => $product['quantity']
                    ]);
            }
            if (!$product->update($val)) {
                return response([['message' => false], ['id', $productId]], 500);
            }
        }
        return ['message' => true];
    }

    /**
     * Update the specified product.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $data = $request->all();
        if (array_key_exists('quantity', $data)) {
            if ($product['quantity'] != $data['quantity'])
                ProductHistory::create([
                    'product_id' => $id,
                    'quantity' => $product['quantity']
                ]);
        }
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified product from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Product::destroy($id)) {
            return ['message' => true];
        }
        return response(['message' => false], 400);
    }

    /**
     * Remove the specified product from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $ids)
    {
        if (Product::destroy($ids->all())) {
            return ['message' => true];
        }
        return response(['message' => false], 400);
    }
}
