<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        if (!empty($kode)) {
            $data_search = $data_search->where('kode', $kode);
        }
        
        if (!empty($nama)) {
            $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        }
        
        // Fix price filter logic
        if (!empty($hargamin) && !empty($hargamax)) {
            // Both min and max provided
            $data_search = $data_search->where('harga_beli', '>=', $hargamin)
                                     ->where('harga_beli', '<=', $hargamax);
        } elseif (!empty($hargamin)) {
            // Only min provided
            $data_search = $data_search->where('harga_beli', '>=', $hargamin);
        } elseif (!empty($hargamax)) {
            // Only max provided
            $data_search = $data_search->where('harga_beli', '<=', $hargamax);
        }

        $data_search = $data_search->with(['kategoris:id,nama,kode'])
                                   ->select('id', 'kode', 'nama', 'foto', 'jenis', 'harga_beli', 'laba', 'supplier')
                                   ->orderBy('id')
                                   ->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = MasterItem::with('kategoris')->find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        $data['kategoris'] = Kategori::orderBy('nama')->get();
        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('kategoris')->where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        // Validate the request
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_beli' => 'required|integer',
            'laba' => 'required|integer',
            'supplier' => 'required|string',
            'jenis' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategoris' => 'nullable|array',
            'kategoris.*' => 'exists:kategoris,id'
        ]);

        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        // Handle image upload
        if ($request->hasFile('foto')) {
            // Delete old image if updating
            if ($method == 'edit' && $data_item->foto) {
                Storage::disk('public')->delete($data_item->foto);
            }
            
            // Store new image
            $imagePath = $request->file('foto')->store('master_items', 'public');
            $data_item->foto = $imagePath;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;
        $data_item->save();

        // Sync kategoris (many-to-many relationship)
        if ($request->has('kategoris')) {
            $data_item->kategoris()->sync($request->kategoris);
        } else {
            $data_item->kategoris()->detach();
        }

        return redirect('master-items')->with('success', 'Master Item berhasil disimpan!');
    }

    public function delete($id)
    {
        try {
            $item = MasterItem::with('kategoris')->find($id);
            
            if (!$item) {
                if (request()->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Master Item tidak ditemukan!'], 404);
                }
                return redirect('master-items')->with('error', 'Master Item tidak ditemukan!');
            }
            
            // Delete associated image if exists
            if ($item->foto) {
                Storage::disk('public')->delete($item->foto);
            }
            
            // Detach all related kategoris before deleting
            $item->kategoris()->detach();
            
            $item->delete();
            
            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Master Item berhasil dihapus!']);
            }
            return redirect('master-items')->with('success', 'Master Item berhasil dihapus!');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus item: ' . $e->getMessage()], 500);
            }
            return redirect('master-items')->with('error', 'Terjadi kesalahan saat menghapus item: ' . $e->getMessage());
        }
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }
}
