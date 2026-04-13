@extends('admin.master')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('breadcrumb', 'Edit Kategori')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-header">
        <h5 class="card-title mb-0"><i class="bi bi-pencil-fill me-2 text-warning"></i>Form Edit Kategori</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
            <input type="text"
                   name="name"
                   id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $category->name) }}"
                   autofocus>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning">
            <i class="bi bi-save me-1"></i> Update
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