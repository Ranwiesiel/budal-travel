<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\StatusBus;
use App\Models\KategoriBus;
use Illuminate\Http\Request;

class DashboardBusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => "Kelola Bus - Dashboard",
            'background' => asset('/storage/img/bg/image-login-page.jpg'),
            'bus' => Bus::with(['kategori_bus', 'status_bus'])->paginate(10),
            'count' => Bus::count()
        ];

        return view('dashboard.bus.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => "Tambah Bus - Dashboard",
            'background' => asset('/storage/img/bg/image-login-page.jpg'),
            'kategori' => KategoriBus::all(),
            'status_bus' => StatusBus::all()
        ];

        return view('dashboard.bus.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "kapasitas_solar" => ["required", "numeric"],
            "jumlah_kursi" => ["required", "numeric", "min:2"],
            "kategori_kode" => "required",
            "kecepatan" => ["required", "numeric", "min:3"],
            "status_bus_kode" => "required",
            "harga_sewa" => ["required", "numeric", "min:7"],
            "nama_bus" => ["required", "max:50", "string"],
        ]);

        Bus::create($data);
        return redirect(route('dashboard.bus'))->with('success', 'Bus baru berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bus $bus)
    {
        $data = [
            'title' => "Edit Bus - Dashboard",
            'background' => asset('/storage/img/bg/image-login-page.jpg'),
            'kategori' => KategoriBus::all(),
            'status_bus' => StatusBus::all(),
            'bus' => $bus
        ];

        return view('dashboard.bus.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bus $bus)
    {
        $data = $request->validate([
            "kategori_kode" => "required",
            "kapasitas_solar" => ["required", "numeric"],
            "jumlah_kursi" => ["required", "numeric"],
            "status_bus_kode" => "required",
            "kecepatan" => ["required", "numeric", "min:3"],
            "harga_sewa" => ["required", "numeric"],
            "nama_bus" => ["required", "max:50", "string"],
        ]);

        $bus->update($data);
        return redirect(route('dashboard.bus'))->with('success', 'Bus berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bus $bus)
    {
        $bus->delete();
        return redirect(route('dashboard.bus'))->with('success', 'Bus berhasil dihapus');
    }
}