<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catproduct = ProductCategory::all();
        return $catproduct;
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
    public function store(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->role == 'admin') {
            $catproduct = new ProductCategory();
            $catproduct->category_name = $request->input('category_name');
            $catproduct->save();

            return response()->json([
                'success'   => 201,
                'message'   => 'data berhasil disimpan',
                'data'      => $catproduct
            ], 201);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'maaf anda bukan admin'
            ], 404);
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
        $catproduct = ProductCategory::find($id);
        if ($catproduct) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Data yang ditemukan',
                'data'      => $catproduct
            ], 200);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id kategori produk ' . $id . ' tidak ditemukan'
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
        if ($user->role == 'admin') {
            $catproduct = ProductCategory::find($id);
            if ($catproduct) {
                $catproduct->category_name = $request->category_name ? $request->category_name : $catproduct->category_name;
                $catproduct->save();

                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil diupdate',
                    'data'      => $catproduct
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id kategori produk ' . $id . ' tidak ditemukan'
                ], 404);
            }
        } else {
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
    public function destroy($id, $id_user)
    {
        $user = User::find($id_user);
        if ($user->role == 'admin') {
            $catproduct = ProductCategory::where('id', $id)->first();
            if ($catproduct) {
                $catproduct->delete();
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil dihapus',
                    'data'      => $catproduct
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id kategori produk ' . $id . ' tidak ditemukan'
                ], 404);
            }
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'maaf anda bukan admin'
            ], 404);
        }
    }
}
