@extends('admin.master')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')
@section('breadcrumb', 'Tambah Kategori')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header">
        <h5 class="card-title mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Form Tambah Kategori</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('categories.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text"
                   name="name"
                   id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}"
                   placeholder="Contoh: Teknologi, Olahraga, Politik..."
                   autofocus>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
            <i class="bi bi-save me-1"></i> Simpan
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
              <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection