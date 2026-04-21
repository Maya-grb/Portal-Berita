@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Edit Berita</h1>

    <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        {{-- Judul --}}
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" name="title"
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $news->title) }}" required>
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
                        {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>
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
                      class="form-control @error('content') is-invalid @enderror">{{ old('content', $news->content) }}</textarea>
        </div>

        {{-- Preview gambar saat ini --}}
        @if($news->image)
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label><br>
                <img src="{{ asset('storage/news_images/' . $news->image) }}"
                     width="200" class="img-thumbnail mb-2"><br>
                <div class="form-check">
                    <input type="checkbox" name="delete_image" id="delete_image"
                           class="form-check-input" value="1">
                    <label for="delete_image" class="form-check-label text-danger">
                        Hapus gambar ini
                    </label>
                </div>
            </div>
        @endif

        {{-- Hidden input untuk nama file gambar --}}
        <input type="hidden" name="image" id="image" value="{{ old('image', $news->image) }}">

        {{-- Tombol --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('news.index') }}" class="btn btn-secondary">Batal</a>
        </div>

    </form>

@push('scripts')
<script>
$(document).ready(function () {
    $('#summernote').summernote({
        height: 300,
        lang: 'id-ID',
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

    // ✅ Jika checkbox hapus gambar dicentang, kosongkan hidden input
    $('#delete_image').on('change', function() {
        if ($(this).is(':checked')) {
            $('#image').val('');
        } else {
            $('#image').val('{{ $news->image }}');
        }
    });
});

function uploadImage(file) {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    const maxSize = 2 * 1024 * 1024;

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
        complete: function() {
            $('#summernote').summernote('enable');
        }
    });
}
</script>
@endpush
@endsection