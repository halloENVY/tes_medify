<form method="POST">
    @csrf
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group mb-3">
        <label>Kode Kategori</label>
        <input type="text" class="form-control" name="kode" required value="{{old('kode', $kategori->kode ?? '')}}">
        <small class="form-text text-muted">Kode unik untuk kategori ini.</small>
    </div>

    <div class="form-group mb-3">
        <label>Nama Kategori</label>
        <input type="text" class="form-control" name="nama" required value="{{old('nama', $kategori->nama ?? '')}}">
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>
