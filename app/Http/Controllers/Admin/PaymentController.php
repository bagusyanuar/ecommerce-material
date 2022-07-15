<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Payment;

class PaymentController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Payment::with(['transaction.user.member', 'transaction.cart'])
            ->where('status', '=', 'menunggu')
            ->get();
        return view('admin.transaksi.pesanan.index')->with(['data' => $data]);
    }

    public function detail($id)
    {
        $data = Payment::with(['transaction.user.member', 'transaction.cart.product'])
            ->findOrFail($id);
        return view('admin.transaksi.pesanan.detail')->with(['data' => $data]);
    }
}
