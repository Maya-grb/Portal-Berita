@extends('admin.master')

@section('title', 'Data Kategori')
@section('page-title', 'Kategori Berita')
@section('breadcrumb', 'Kategori')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0"><i class="bi bi-tags-fill me-2 text-primary"></i>Daftar Kategori</h5>
        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
        </a>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0">
          <thead class="table-dark">
            <tr>
              <th width="60" class="text-center">No</th>
              <th>Nama Kategori</th>
              <th width="160" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $category)
            <tr>
              <td class="text-center">{{ $loop->iteration }}</td>
              <td>{{ $category->name }}</td>
              <td class="text-center">
                <div class="d-flex justify-content-center gap-2">
                  <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-fill"></i> Edit
                  </a>
                  <form id="delete-form-{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $category->id }}')">
                      <i class="bi bi-trash-fill"></i> Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="3" class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                Belum ada data kategori.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Yakin ingin menghapus?',
    text: 'Data kategori tidak bisa dikembalikan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('delete-form-' + id).submit();
    }
  });
}
</script>
@endpush