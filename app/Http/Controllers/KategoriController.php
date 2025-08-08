<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategori.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = Kategori::query();

        if (!empty($kode)) {
            $data_search = $data_search->where('kode', 'LIKE', '%' . $kode . '%');
        }
        
        if (!empty($nama)) {
            $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        }

        $data_search = $data_search->select('id', 'kode', 'nama')
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
            $kategori = [];
        } else {
            $kategori = Kategori::find($id);
        }
        $data['kategori'] = $kategori;
        $data['method'] = $method;
        return view('kategori.form.index', $data);
    }

    public function singleView($id)
    {
        $kategori = Kategori::with(['masterItems' => function($query) {
            $query->select('id', 'kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier');
        }])->find($id);
        
        if (!$kategori) {
            return redirect('kategori')->with('error', 'Kategori tidak ditemukan!');
        }
        $data['kategori'] = $kategori;
        return view('kategori.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        // Validate the request
        $rules = [
            'nama' => 'required|string|max:255',
        ];
        
        // Handle kode validation differently for create vs edit
        if ($method == 'new') {
            $rules['kode'] = 'required|string|max:50|unique:kategoris,kode,NULL,id,deleted_at,NULL';
        } else {
            $rules['kode'] = 'required|string|max:50|unique:kategoris,kode,' . $id . ',id,deleted_at,NULL';
        }
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        if ($method == 'new') {
            $kategori = new Kategori;
        } else {
            $kategori = Kategori::find($id);
            if (!$kategori) {
                return redirect('kategori')->with('error', 'Kategori tidak ditemukan!');
            }
        }

        $kategori->nama = $request->nama;
        
        // Handle kode assignment with duplicate prevention
        $inputKode = $request->kode;
        
        // Check if kode exists in soft deleted records
        $softDeletedKategori = Kategori::withTrashed()
                                     ->where('kode', $inputKode)
                                     ->whereNotNull('deleted_at')
                                     ->when($method == 'edit', function($query) use ($id) {
                                         return $query->where('id', '!=', $id);
                                     })
                                     ->first();
        
        if ($softDeletedKategori) {
            // If it's a restore request, restore the soft deleted record
            if ($request->has('restore_deleted') && $request->restore_deleted == '1') {
                $softDeletedKategori->restore();
                $softDeletedKategori->nama = $request->nama;
                $softDeletedKategori->save();
                
                return redirect('kategori')->with('success', 'Data dengan kode "' . $inputKode . '" berhasil dipulihkan dan diperbarui!');
            }
            
            return redirect()->back()
                           ->withErrors(['kode' => 'Data dengan code yang anda cari sudah dihapus. Gunakan kode lain atau hubungi administrator untuk memulihkan data.'])
                           ->withInput();
        }
        
        // Check if kode already exists in active records (excluding current record for edit)
        $existingKategori = Kategori::where('kode', $inputKode)
                                  ->when($method == 'edit', function($query) use ($id) {
                                      return $query->where('id', '!=', $id);
                                  })
                                  ->first();
        
        if ($existingKategori) {
            // Generate unique kode by appending number
            $baseKode = $inputKode;
            $counter = 1;
            
            do {
                $newKode = $baseKode . '_' . $counter;
                $existingKategori = Kategori::where('kode', $newKode)
                                          ->when($method == 'edit', function($query) use ($id) {
                                              return $query->where('id', '!=', $id);
                                          })
                                          ->first();
                $counter++;
            } while ($existingKategori);
            
            $kategori->kode = $newKode;
            $successMessage = 'Kategori berhasil disimpan! Kode "' . $inputKode . '" sudah ada, sehingga diubah menjadi "' . $newKode . '".';
        } else {
            $kategori->kode = $inputKode;
            $successMessage = 'Kategori berhasil disimpan!';
        }
        
        try {
            $kategori->save();
            return redirect('kategori')->with('success', $successMessage);
        } catch (\Exception $e) {
            return redirect()->back()
                           ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan kategori: ' . $e->getMessage()])
                           ->withInput();
        }
    }

    public function delete($id)
    {
        try {
            $kategori = Kategori::with('masterItems')->find($id);
            
            if (!$kategori) {
                if (request()->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Kategori tidak ditemukan!'], 404);
                }
                return redirect('kategori')->with('error', 'Kategori tidak ditemukan!');
            }
            
            // Detach all related master items before deleting
            $kategori->masterItems()->detach();
            
            // Force delete (since we're using soft deletes)
            $kategori->delete();
            
            if (request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus!']);
            }
            return redirect('kategori')->with('success', 'Kategori berhasil dihapus!');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage()], 500);
            }
            return redirect('kategori')->with('error', 'Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage());
        }
    }
}
