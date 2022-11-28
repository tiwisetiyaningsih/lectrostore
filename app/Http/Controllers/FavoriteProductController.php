<?php

namespace App\Http\Controllers;

use App\Models\FavoriteProduct;
use App\Models\User;
use Illuminate\Http\Request;

class FavoriteProductController extends Controller
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
        
        $favorite = FavoriteProduct::where('id_user', $request->id_user)->where('id_product', $request->id_product)->first();

        if ($favorite) {
            $unfavorite = FavoriteProduct::where('id_product', $request->id_product)->where('id_user', $request->id_user)->delete();

            if ($unfavorite) {
                return response()->json([
                    'massage' => 'success unfavorite product',
                ]);
            } else {
                return response()->json([
                    'massage' => 'failed',
                ]);
            }
        } else {
            $user = User::find($request->id_user);
            $favorite = new FavoriteProduct();
            $favorite->id_user = $request->input('id_user');
            $favorite->id_product = $request->input('id_product');
            $favorite->name_user = $user->name;
            $favorite->save();

            return response()->json([
                'success'   => 201,
                'message'   => 'success favorite product',
                'data'      => $favorite
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $favorite = FavoriteProduct::where('id_user', $id)->get();
        if ($favorite) {
            return response()->json([
                'massage' => 'Favorite Produk ditemukan',
                'data' => $favorite,
            ]);
        } else {
            return response()->json([
                'massage' => 'id user ' . $id . 'tidak ditemukan',
            ]);
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
    public function update(Request $request, $id)
    {
        //
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
