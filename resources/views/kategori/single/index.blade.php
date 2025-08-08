@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="form-group mb-2">
                <a href="{{url('kategori')}}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card">
                <div class="card-header">Detail Kategori</div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Kode</th>
                                    <td>:</td>
                                    <td>{{$kategori->kode}}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>:</td>
                                    <td>{{$kategori->nama}}</td>
                                </tr>
                            </table>
                            <div class="mt-3">
                                <a class="btn btn-info" href="{{url('kategori/form/edit')}}/{{$kategori->id}}">Edit</a>
                                <form method="POST" action="{{url('kategori/delete')}}/{{$kategori->id}}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5>Master Items dalam Kategori Ini</h5>
                    @if($kategori->masterItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Jenis</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Supplier</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kategori->masterItems as $item)
                                    <tr>
                                        <td>{{$item->kode}}</td>
                                        <td>{{$item->nama}}</td>
                                        <td>{{$item->jenis}}</td>
                                        <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->harga_beli + ($item->harga_beli * $item->laba / 100), 0, ',', '.') }}</td>
                                        <td>{{$item->supplier}}</td>
                                        <td>
                                            <a href="{{url('master-items/view')}}/{{$item->kode}}" class="btn btn-primary btn-sm">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada Master Items yang terkait dengan kategori ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection
