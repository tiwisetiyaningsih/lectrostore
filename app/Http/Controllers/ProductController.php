<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return $product;
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
            // 
            $image_product = $request->image_product;
            $image = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $image_product));

            //
            $image_name = "image-product-file-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
            $filename = $image_name . '.' . 'jpg';
            //rename file name with random number
            $path = public_path('data_image_product/');
            //image uploading folder path
            file_put_contents($path . $filename, $image);

            // 
            $post_image = 'data_image_product/' . $filename; 

            $product = new Product();
            $product->id_category = $request->input('id_category');
            $product->name_product = $request->input('name_product');
            $product->image_product = $post_image;
            $product->size_product = $request->input('size_product');
            $product->desc_product = $request->input('desc_product');
            $product->price_product = $request->input('price_product');
            $product->qty_stok = $request->input('qty_stok');
            $product->save();

            $cat_product = ProductCategory::where('id', $request->id_category)->first();

            return response()->json([
                'success'   => 201,
                'message'   => 'data berhasil disimpan',
                'data'      => $product, 'category_product' => $cat_product->category_name
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
        $product = Product::where('id_category', $id)->orderBy('updated_at', 'DESC')
        ->get();
        if ($product) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Data yang ditemukan',
                'data'      => $product
            ], 200);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id produk ' . $id . ' tidak ditemukan'
            ], 404);
        }
    }
    public function searchproduct($name_product)
    {
        return response()->json([
            'message' => 'Data yang ditemukan',
            'data' => Product::orderBy('created_at', 'DESC')
                ->where('name_product', 'LIKE', '%' . $name_product . '%')
                ->get()
        ], 200);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showbyid($id)
    {
        $product = Product::where('id', $id)->orderBy('updated_at', 'DESC')
        ->get();
        if ($product) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Data yang ditemukan',
                'data'      => $product
            ], 200);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id produk ' . $id . ' tidak ditemukan'
            ], 404);
        }
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
            $product = Product::find($id);
            if ($product) {
                if ($request->image_product != '') {
                    $image_product = $request->image_product;
                    $image = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $image_product));

                    //
                    $image_name = "image-product-file-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
                    $filename = $image_name . '.' . 'jpg';
                    //rename file name with random number
                    $path = public_path('data_image_product/');
                    //image uploading folder path
                    file_put_contents($path . $filename, $image);

                    // 
                    $post_image = 'data_image_product/' . $filename;

                    $product->id_category = $request->id_category ? $request->id_category : $product->id_category;
                    $product->name_product = $request->name_product ? $request->name_product : $product->name_product;
                    $product->image_product = $post_image ? $post_image : $product->image_product;
                    $product->size_product = $request->size_product ? $request->size_product : $product->size_product;
                    $product->price_product = $request->price_product ? $request->price_product : $product->price_product;
                    $product->qty_stok = $request->qty_stok ? $request->qty_stok : $product->qty_stok;
                    $product->save();
                } else {
                    $product->id_category = $request->id_category ? $request->id_category : $product->id_category;
                    $product->name_product = $request->name_product ? $request->name_product : $product->name_product;
                    $product->image_product = $product->image_product;
                    $product->size_product = $request->size_product ? $request->size_product : $product->size_product;
                    $product->price_product = $request->price_product ? $request->price_product : $product->price_product;
                    $product->qty_stok = $request->qty_stok ? $request->qty_stok : $product->qty_stok;
                    $product->save();
                }

                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil diupdate',
                    'data'      => $product
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id produk ' . $id . ' tidak ditemukan'
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
            $product = Product::where('id', $id)->first();
            if ($product) {
                $product->delete();
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil dihapus',
                    'data'      => $product
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id produk ' . $id . ' tidak ditemukan'
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
