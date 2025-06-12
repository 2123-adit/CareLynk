@extends('layouts.admin')

@section('title', 'Tambah Kampanye')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2"><i class="bi bi-plus-circle"></i> Tambah Kampanye</h1>
    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.campaigns.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Kampanye</label>
                        <input type="text" 
                               class="form-control @error('judul') is-invalid @enderror" 
                               id="judul" 
                               name="judul" 
                               value="{{ old('judul') }}" 
                               required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" 
                                  name="deskripsi" 
                                  rows="5" 
                                  required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select @error('kategori') is-invalid @enderror" 
                                        id="kategori" 
                                        name="kategori" 
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Pendidikan" {{ old('kategori') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                    <option value="Kesehatan" {{ old('kategori') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                    <option value="Bencana" {{ old('kategori') == 'Bencana' ? 'selected' : '' }}>Bencana</option>
                                    <option value="Sosial" {{ old('kategori') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="target_donasi" class="form-label">Target Donasi (Rp)</label>
                                <input type="number" 
                                       class="form-control @error('target_donasi') is-invalid @enderror" 
                                       id="target_donasi" 
                                       name="target_donasi" 
                                       value="{{ old('target_donasi') }}" 
                                       min="1"
                                       required>
                                @error('target_donasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                        <input type="datetime-local" 
                               class="form-control @error('tanggal_berakhir') is-invalid @enderror" 
                               id="tanggal_berakhir" 
                               name="tanggal_berakhir" 
                               value="{{ old('tanggal_berakhir') }}" 
                               required>
                        @error('tanggal_berakhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Kampanye</label>
                        <input type="file" 
                               class="form-control @error('gambar') is-invalid @enderror" 
                               id="gambar" 
                               name="gambar" 
                               accept="image/*"
                               onchange="previewImage(this)">
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                    </div>

                    <div class="text-center">
                        <img id="imagePreview" 
                             src="#" 
                             alt="Preview" 
                             class="img-fluid rounded" 
                             style="display: none; max-height: 200px;">
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.campaigns.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Simpan Kampanye
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush