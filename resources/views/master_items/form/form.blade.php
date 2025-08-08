<form method="POST" enctype="multipart/form-data">
    @csrf
    @if($method == 'edit')
    <div class="form-group">
        <label>Kode Barang</label>
        <input type="text" class="form-control" name="kode_barang" required readonly value="{{$item->kode ?? ''}}">
    </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required  value="{{$item->nama ?? ''}}">
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required  value="{{$item->harga_beli ?? ''}}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required  value="{{$item->laba ?? ''}}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if($selected == 'E Commurz') selected @endif>E Commurz</option>
            <option @if($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if($selected == '') selected @endif value="">--Pilih--</option>
            <option @if($selected == 'Obat') selected @endif>Obat</option>
            <option @if($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if($selected == 'Matkes') selected @endif>Matkes</option>
            <option @if($selected == 'Umum') selected @endif>Umum</option>
            <option @if($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    <div class="form-group">
        <label>Foto</label>
        <input type="file" class="form-control" name="foto" accept="image/*">
        @if(isset($item->foto) && $item->foto)
            <div class="mt-2">
                <small class="text-muted">Foto saat ini:</small><br>
                <img src="{{ asset('storage/' . $item->foto) }}" alt="Current Image" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
            </div>
        @endif
        <small class="form-text text-muted">Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 2MB.</small>
    </div>

    <div class="form-group">
        <label>Kategori</label>
        <div class="row">
            @if(isset($kategoris) && $kategoris->count() > 0)
                @foreach($kategoris as $kategori)
                    <div class="col-md-4 mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="kategoris[]" value="{{ $kategori->id }}" id="kategori_{{ $kategori->id }}"
                                @if(isset($item->kategoris) && $item->kategoris->contains($kategori->id)) checked @endif>
                            <label class="form-check-label" for="kategori_{{ $kategori->id }}">
                                {{ $kategori->nama }} ({{ $kategori->kode }})
                            </label>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info">
                        <small>Belum ada kategori yang tersedia. <a href="{{ url('kategori/form/new') }}" target="_blank">Buat kategori baru</a></small>
                    </div>
                </div>
            @endif
        </div>
        <small class="form-text text-muted">Pilih satu atau lebih kategori untuk item ini.</small>
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>