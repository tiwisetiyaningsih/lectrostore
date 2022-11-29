<?php

namespace App\Http\Controllers;

use App\Models\BankAdmin;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payment = Payment::all();
        return $payment;
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
        $user = User::find($request->id_user);
        if ($user->role == 'user') {

            $bukti_payment = $request->bukti_payment;
            $image = base64_decode(preg_replace('#^data:image/jpeg;base64,#i', '', $bukti_payment));

            //
            $image_name = "bukti-payment-file-" . date('Y-m-d-') . md5(uniqid(rand(), true)); // image name generating with random number with 32 characters
            $filename = $image_name . '.' . 'jpg';
            //rename file name with random number
            $path = public_path('data_bukti_payment/');
            //image uploading folder path
            file_put_contents($path . $filename, $image);

            // 
            $post_image = 'data_bukti_payment/' . $filename;

            $bank = BankAdmin::find($request->id_bank);
            $order = Order::find($request->id_order);
            $payment = new Payment();
            $payment->id_bank = $request->input('id_bank');
            $payment->id_user = $request->input('id_user');
            $payment->name_user = $user->name;
            $payment->bank_name = $bank->bank_name;
            $payment->id_order = $request->input('id_order');
            $payment->amount = $order->amount;
            $payment->bukti_payment = $post_image;
            $payment->save();

            if ($payment) {
                $order = Order::where('id', $request->id_order)
                    ->update([
                        "id_status_order" => 2
                    ]);
            }

            return response()->json([
                'success'   => 201,
                'message'   => 'data payment berhasil disimpan',
                'data'      => $payment
            ], 201);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'maaf anda bukan user yang dimaksud'
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
        $payment = Payment::find($id);
        if ($payment) {
            return response()->json([
                'status'    => 200,
                'message'   => 'Data yang ditemukan',
                'data'      => $payment
            ], 200);
        } else {
            return response()->json([
                'status'    => 404,
                'message'   => 'id payment ' . $id . ' tidak ditemukan'
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
