@extends('admin.master')

@section('title', 'Data Kategori')
@section('page-title', 'Kategori Berita')
@section('breadcrumb', 'Kategori')

@section('content')
    <h1 class="mb-4">Daftar Berita</h1>
    <a href="{{ route('news.create') }}" class="btn btn-primary mb-3">Tambah Berita</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 30%">Judul</th>
                    <th style="width: 15%">Kategori</th>
                    <th style="width: 20%">Gambar</th>
                    <th style="width: 15%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($news as $index => $item)
                    <tr>
                        <td>{{ $news->firstItem() + $index }}</td>
                        <td class="text-start">{{ $item->title }}</td>
                        <td>{{ $item->category->name ?? '-' }}</td>
                        <td>
                            @if($item->image)
                                <img src="{{ asset('storage/news_images/' . $item->image) }}" width="100" class="img-thumbnail">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('news.edit', $item->id) }}" class="btn btn-info btn-sm">Edit</a>
                            <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada berita.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $news->links() }}
@endsection