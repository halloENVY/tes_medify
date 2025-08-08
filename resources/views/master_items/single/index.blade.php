@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('master-items')}}" class="btn btn-secondary">Kembali ke Daftar Item</a>
            </div>
            <div class="card">
                <div class="card-header">Master Item</div>

                <div class="card-body">
                    <table>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{$data->nama}}</td>
                        </tr>
                        <tr>
                            <th>Harga Beli</th>
                            <td>:</td>
                            <td>{{$data->harga_beli}}</td>
                        </tr>
                        <tr>
                            <th>Laba</th>
                            <td>:</td>
                            <td>{{$data->laba}}</td>
                        </tr>
                        <tr>
                            <th>Harga Jual</th>
                            <td>:</td>
                            <td>{{$data->harga_beli + $data->harga_beli * $data->laba / 100 }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>:</td>
                            <td>{{$data->supplier}}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>:</td>
                            <td>{{$data->jenis}}</td>
                        </tr>
                        @if($data->foto)
                        <tr>
                            <th>Foto</th>
                            <td>:</td>
                            <td>
                                <img src="{{ asset('storage/' . $data->foto) }}" alt="{{ $data->nama }}" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th>Kategori</th>
                            <td>:</td>
                            <td>
                                @if($data->kategoris && $data->kategoris->count() > 0)
                                    @foreach($data->kategoris as $kategori)
                                        <span class="badge bg-primary me-1">{{ $kategori->nama }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">Tidak ada kategori</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                    <a class="btn btn-info" href="{{url('master-items/form/edit')}}/{{$data->id}}">Edit</a>
                    <form method="POST" action="{{url('master-items/delete')}}/{{$data->id}}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection