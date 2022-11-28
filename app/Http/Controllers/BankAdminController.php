<?php

namespace App\Http\Controllers;

use App\Models\BankAdmin;
use App\Models\User;
use Illuminate\Http\Request;

class BankAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank = BankAdmin::all();
        return $bank;
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
            $bank = new BankAdmin();
            $bank->bank_name = $request->input('bank_name');
            $bank->norek_bank = $request->input('norek_bank');
            $bank->save();

            return response()->json([
                'success'   => 201,
                'message'   => 'data berhasil disimpan',
                'data'      => $bank
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
        $bank = BankAdmin::find($id);
        if ($bank) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Data yang ditemukan',
                'data'      => $bank
            ], 200);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id bank ' . $id . ' tidak ditemukan'
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
            $bank = BankAdmin::find($id);
            if ($bank) {
                $bank->bank_name = $request->bank_name ? $request->bank_name : $bank->bank_name;
                $bank->norek_bank = $request->norek_bank ? $request->norek_bank : $bank->norek_bank;
                $bank->save();

                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil diupdate',
                    'data'      => $bank
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id bank ' . $id . ' tidak ditemukan'
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
            $bank = BankAdmin::where('id', $id)->first();
            if ($bank) {
                $bank->delete();
                return response()->json([
                    'status'    => 200,
                    'message'   => 'Data berhasil dihapus',
                    'data'      => $bank
                ], 200);
            } else {
                return response()->json([
                    'status'    => 404,
                    'message'   => 'id bank ' . $id . ' tidak ditemukan'
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
