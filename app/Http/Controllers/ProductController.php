<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all products
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
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
     * Store a newly created resource in storage.
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

        if (Product::insert($products) == 1) {
            return ["message" => true];
        }

        return ["message" => false];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateMany(Request $request)
    {
        $data = $request->all();
        foreach ($data as $prod => $val) {
            $product = Product::find($val['id']);
            if(!$product->update($val)) {
                return [['message' => false], ['id', $val['id']]];
            }
        }
        return ['message' => true];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Product::destroy($id)){
            return ['message' => true];
        }
        return ['message' => false];
    }
}
