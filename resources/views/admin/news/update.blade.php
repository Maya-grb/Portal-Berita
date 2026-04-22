@extends('admin.master')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')
@section('breadcrumb', 'Edit Berita')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pencil-square me-2 text-warning"></i> Form Edit Berita
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Judul --}}
                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">
                            Judul <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               id="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $news->title) }}"
                               placeholder="Masukkan judul berita"
                               autofocus>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold">
                            Kategori <span class="text-danger">*</span>
                        </label>
                        <select name="category_id"
                                id="category_id"
                                class="form-select @error('category_id') is-invalid @enderror">
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

                    {{-- Gambar Saat Ini --}}
                    @if($news->image)
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Gambar Saat Ini</label>
                        <div class="mt-2">
                            <img src="{{ asset('storage/news_images/' . $news->image) }}" 
                                 alt="Current Image" 
                                 class="img-thumbnail" 
                                 style="max-height: 150px">
                        </div>
                        <div class="form-check mt-2">
                            <input type="checkbox" 
                                   name="delete_image" 
                                   id="delete_image" 
                                   class="form-check-input" 
                                   value="1">
                            <label for="delete_image" class="form-check-label text-danger">
                                <i class="bi bi-trash me-1"></i> Hapus gambar ini
                            </label>
                        </div>
                    </div>
                    @endif

                    {{-- Konten --}}
                    <div class="mb-3">
                        <label for="summernote" class="form-label fw-semibold">
                            Konten <span class="text-danger">*</span>
                        </label>
                        @error('content')
                            <div class="text-danger small mb-1">{{ $message }}</div>
                        @enderror
                        <textarea id="summernote"
                                  name="content"
                                  class="form-control @error('content') is-invalid @enderror">{{ old('content', $news->content) }}</textarea>
                    </div>

                    {{-- Hidden input untuk nama file gambar --}}
                    <input type="hidden" name="image" id="image" value="{{ old('image', $news->image) }}">

                    {{-- Tombol --}}
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update
                        </button>
                        <a href="{{ route('news.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 400,
            lang: 'id-ID',
            placeholder: 'Tulis konten berita di sini...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    uploadImage(files[0]);
                }
            }
        });

        // Jika checkbox hapus gambar dicentang, kosongkan hidden input
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
        const maxSize = 2 * 1024 * 1024; // 2MB

        if (!allowedTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Format gambar tidak didukung. Gunakan JPG, PNG, GIF, atau WEBP.'
            });
            return;
        }

        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Ukuran gambar maksimal 2MB.'
            });
            return;
        }

        let formData = new FormData();
        formData.append("image", file);

        // Tampilkan loading
        Swal.fire({
            title: 'Mengupload...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('news.uploadImage') }}",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.close();
                if (response.url) {
                    $('#summernote').summernote('insertImage', response.url);
                    $('#image').val(response.filename);
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Gambar berhasil diupload',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal mengupload gambar. Silakan coba lagi.'
                });
            }
        });
    }
</script>
@endpush