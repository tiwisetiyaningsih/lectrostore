<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $productchart = Product::find($request->id_product);
        $user = User::find($request->id_user);
        if ($productchart) {
            $chart = new Chart();
            $chart->id_user = $request->input('id_user');
            $chart->name_user = $user->name;
            $chart->id_product = $request->input('id_product');
            $chart->name_product = $productchart->name_product;
            $chart->qty_order = $request->input('qty_order');
            $chart->amount = $request->qty_order * $productchart->price_product;
            $chart->save();

            $hasilpost = ['chart_product' => $chart, 'detail_product' => $productchart];

            return response()->json([
                'success'   => 201,
                'message'   => 'produk berhasil ditambahan ke keranjang',
                'data'      => $hasilpost
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
        $chartproduct = Chart::where('id_user', $id_user)->get();
        if ($chartproduct) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Data yang ditemukan',
                'data'      => $chartproduct
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
        $user = User::find($id_user);
        $product = Chart::find($id);
        if ($user->id == $product->id_user) {
            $chartproduct = Chart::where('id', $id)->first();
            $productchart = Product::find($chartproduct->id_product);
            if ($chartproduct) {
                $chartproduct->qty_order = $request->qty_order ? $request->qty_order : $chartproduct->qty_order;
                $chartproduct->amount = $request->qty_order ? $request->qty_order * $productchart->price_product : $chartproduct->amount;
                $chartproduct->save();
                return response()->json([
                    'status'    => 200,
                    'message'   => 'data berhasil diupdate',
                    'data'      => $chartproduct
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id' . $chartproduct . 'tidak ditemukan'
                ], 404);
            }
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'maaf ini bukan produk yang ada di keranjang anda'
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $id_user)
    {
        $user = User::find($id_user);
        $product = Chart::find($id);
        if ($user->id == $product->id_user) {
            $chartproduct = Chart::where('id', $id)->first();
            if ($chartproduct) {
                $chartproduct->delete();
                return response()->json([
                    'status'    => 200,
                    'message'   => 'produk ini dihapus dari keranjang anda',
                    'data'      => $chartproduct
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id' . $chartproduct . 'tidak ditemukan'
                ], 404);
            }
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'maaf ini bukan produk yang ada di keranjang anda'
            ], 401);
        }
    }
}
