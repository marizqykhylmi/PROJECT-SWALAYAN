<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
// use App\Http\Controllers\swalayan;
use App\Models\swalayan;
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
        $swalayan = swalayan::all();
        return view("order.kasir.create", compact('swalayan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',   // Pastikan nama pelanggan tidak kosong
            'swalayans' => 'required|array',  // Pastikan swalayans adalah array
        ]);

        $arrayDistinct = array_count_values($request->swalayans);

        $arrayAssocswalayan = [];

        foreach ($arrayDistinct as $id => $count) {

            $swalayan = swalayan::where('id', $id)->first();
            $subPrice = $swalayan['price'] * $count;
            $arrayItem = [
                "id" => $id,
                "name_swalayan" => $swalayan['name'],
                "qty" => $count,
                "price" => $swalayan['price'],
                "sub_price" => $subPrice,
            ];
            array_push($arrayAssocswalayan, $arrayItem);
        }

        $totalPrice = 0;
        foreach ($arrayAssocswalayan as $item) {
            $totalPrice += (int)$item['sub_price'];
        }

        $priceWithPPN = $totalPrice + ($totalPrice * 0.01);

        $proses = Order::create([
            'user_id' => Auth::user()->id,
            'swalayans' => json_encode($arrayAssocswalayan),
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
