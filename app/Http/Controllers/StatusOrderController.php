<?php

namespace App\Http\Controllers;

use App\Models\StatusOrder;
use App\Models\User;
use Illuminate\Http\Request;

class StatusOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stts_order = StatusOrder::all();
        return $stts_order;
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
            $stts_order = new StatusOrder();
            $stts_order->status_order = $request->input('status_order');
            $stts_order->save();

            return response()->json([
                'success'   => 201,
                'message'   => 'data berhasil disimpan',
                'data'      => $stts_order
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
        //
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
            $stts_order = StatusOrder::find($id);
            if ($stts_order) {
                $stts_order->status_order = $request->status_order ? $request->status_order : $stts_order->status_order;
                $stts_order->save();

                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil diupdate',
                    'data'      => $stts_order
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id status ' . $id . ' tidak ditemukan'
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
            $stts_order = StatusOrder::where('id', $id)->first();
            if ($stts_order) {
                $stts_order->delete();
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil dihapus',
                    'data'      => $stts_order
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id status order ' . $id . ' tidak ditemukan'
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
