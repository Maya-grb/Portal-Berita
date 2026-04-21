@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Berita</h1>

    <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        {{-- Judul --}}
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="title" 
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Kategori --}}
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="category_id" 
                    class="form-control @error('category_id') is-invalid @enderror" required>
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Konten --}}
        <div class="mb-3">
            <label class="form-label">Konten</label>
            @error('content')
                <div class="text-danger small mb-1">{{ $message }}</div> 
            @enderror
            <textarea id="summernote" name="content" 
                      class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
        </div>

        {{-- Hidden input untuk nama file gambar --}}
        <input type="hidden" name="image" id="image" value="{{ old('image') }}">

        {{-- Tombol --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('news.index') }}" class="btn btn-secondary">Batal</a>
        </div>

    </form>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    $('#summernote').summernote({
        height: 300,
        lang: 'id-ID', // ✅ Bahasa Indonesia
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'italic', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'codeview']]
        ],
        callbacks: {
            onImageUpload: function(files) {
                uploadImage(files[0]);
            }
        }
    });
});

function uploadImage(file) {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    const maxSize = 2 * 1024 * 1024; // 2MB

    if (!allowedTypes.includes(file.type)) {
        alert('Format gambar tidak didukung. Gunakan JPG, PNG, GIF, atau WEBP.');
        return;
    }

    if (file.size > maxSize) {
        alert('Ukuran gambar maksimal 2MB.');
        return;
    }

    let formData = new FormData();
    formData.append("image", file);

    $.ajax({
        url: "{{ route('news.uploadImage') }}",
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        contentType: false,
        processData: false,
        // ✅ Tambah loading indicator
        beforeSend: function() {
            $('#summernote').summernote('disable');
        },
        success: function(response) {
            if (response.url) {
                $('#summernote').summernote('insertImage', response.url);
                $('#image').val(response.filename);
            }
        },
        error: function() {
            alert('Gagal mengupload gambar. Silakan coba lagi.');
        },
        // ✅ Re-enable editor setelah selesai
        complete: function() {
            $('#summernote').summernote('enable');
        }
    });
}
</script>
@endpush
@endsection