<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\StatusOrder;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order = Order::all();
        return $order;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //'id_user','name_user','id_product','name_product','qty_order','qty_product','amount', 'id_status_order'

        $productorder = Product::find($request->id_product);
        $user = User::find($request->id_user);
        if ($productorder) {
            $order = new Order();
            $order->id_user = $request->input('id_user');
            $order->name_user = $user->name;
            $order->id_product = $request->input('id_product');
            $order->name_product = $productorder->name_product;
            $order->qty_order = $request->input('qty_order');
            $order->qty_product_order = $request->input('qty_product_order');
            $order->amount = $request->qty_order * $productorder->price_product;
            $order->id_status_order = 1;
            $order->save();

            $status_order = StatusOrder::find($order->id_status_order);
            $hasilorder = ['chart_product' => $order, 'detail_product' => $productorder, 'status_order' => $status_order->status_order];

            if ($hasilorder) {
                $product = Product::where('id', $request->id_product)
                    ->update([
                        "qty_stok" => $productorder->qty_stok - $request->qty_order
                    ]);
            }

            return response()->json([
                'success'   => 201,
                'message'   => 'Order Berhasil',
                'data'      => $hasilorder
            ], 201);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id produk ' . $request->id_product . ' tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showbyiduser($id_user)
    {
        $orderproduct = Order::where('id_user', $id_user)->get();
        if ($orderproduct) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Data yang ditemukan',
                'data'      => $orderproduct
            ], 200);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id user ' . $id_user . ' tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $id_user)
    {
        $userorder = Order::find($id);
        return $userorder;
        $user = User::find($id_user);
        if ($user->role == 'admin') {
            $order = Order::find($id);
            if ($order) {
                $order->id_status_order = $request->id_status_order ? $request->id_status_order : $order->id_status_order;
                $order->save();

                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil diupdate',
                    'data'      => $order
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id order ' . $id . ' tidak ditemukan'
                ], 404);
            }
        }else {
            return response()->json([
                'status'    => 404,
                'message'   => 'maaf anda bukan admin'
            ], 404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
