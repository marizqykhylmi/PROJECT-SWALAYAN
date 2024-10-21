<?php

namespace App\Http\Controllers;

use App\Models\swalayan;
use Illuminate\Http\Request;

class swalayanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $swalayans = swalayan::simplePaginate(10);
        return view('swalayan.index', compact('swalayans'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('swalayan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        swalayan::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data barang!');
    }

    /**
     * Display the specified resource.
     */
    public function show(swalayan $swalayan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $swalayan = swalayan::find($id);
        return view('swalayan.edit', compact('swalayan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, swalayan $swalayan, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required|string|max:50', // Sesuaikan dengan batasan panjang
            'price' => 'required|numeric',
            
        ]);
        

        swalayan::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            

        ]);

        return redirect()->route('swalayan.home')->with('success', 'Berhasil mengubah data barang!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(swalayan $swalayan, $id)
    {
        swalayan::where('id', $id)->delete();
        return redirect()->back()->with('deleted', 'Berhasil menghapus data barang!');
    }

    public function stock()
    {
        $swalayans = swalayan::orderBy('stock', 'ASC')->simplePaginate(10);
        return view('swalayan.stock', compact('swalayans'));
    }

    public function stockEdit($id)
    {
        $swalayan = swalayan::find($id);
        return response()->json($swalayan);
    }

    public function stockUpdate(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|numeric',
        ]);

        $swalayan = swalayan::find($id);

        if($request->stock <= $swalayan['stock']){
            return response()->json(['message' => 'Stok yang di input tidak boleh kurang dari stok sebelumnya'],400);
        }else{
            $swalayan->update(['stock' => $request->stock]);
            return response()->json(['message' => 'Stok berhasil diubah'],200);
        }
    }
}
