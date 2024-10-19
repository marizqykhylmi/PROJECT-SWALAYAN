<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
// use App\Http\Controllers\Medicine;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("order.kasir.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicine = Medicine::all();
        return view("order.kasir.create", compact('medicine'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',   // Pastikan nama pelanggan tidak kosong
            'medicines' => 'required|array',  // Pastikan medicines adalah array
        ]);

        $arrayDistinct = array_count_values($request->medicines);

        $arrayAssocMedicine = [];

        foreach ($arrayDistinct as $id => $count) {

            $medicine = Medicine::where('id', $id)->first();
            $subPrice = $medicine['price'] * $count;
            $arrayItem = [
                "id" => $id,
                "name_medicine" => $medicine['name'],
                "qty" => $count,
                "price" => $medicine['price'],
                "sub_price" => $subPrice,
            ];
            array_push($arrayAssocMedicine, $arrayItem);
        }

        $totalPrice = 0;
        foreach ($arrayAssocMedicine as $item) {
            $totalPrice += (int)$item['sub_price'];
        }

        $priceWithPPN = $totalPrice + ($totalPrice * 0.01);

        $proses = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => json_encode($arrayAssocMedicine),
            'name_customer' => $request->name_customer,
            'total_price' => $priceWithPPN
        ]);
        

        if($proses) {
            $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
            return redirect()->route('kasir.order.print', $order['id']);
        } else {
            return redirect()->back()->with('failed', 'Gagal membuat pembelian. Silahkan coba kembali dengan data yang sesuai!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $order = Order::find($id);
    if (!$order) {
        return redirect()->back()->with('failed', 'Order tidak ditemukan!');
    }
    return view('order.kasir.print', compact('order'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
