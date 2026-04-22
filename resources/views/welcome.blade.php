@extends('layouts.app')

@section('content')
    <!-- Page header -->
    <header class="py-5 bg-light border-bottom mb-4">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">Welcome to Blog Home!</h1>
                <p class="lead mb-0">A Bootstrap 5 starter layout for your next blog homepage</p>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <!-- Featured post -->
                @forelse($news as $new)
                    <div class="card mb-4">
                        <a href="javascript:void(0)" onclick="showNewsModal({{ $new->id }})">
                            <img class="card-img-top" src="{{ asset('storage/news_images/' . $new->image) }}"
                                alt="{{ $new->title }}" style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body">
                            <div class="small text-muted">{{ $new->created_at->format('F d, Y') }}</div>
                            <h2 class="card-title">{{ $new->title }}</h2>
                            <p class="card-text">{{ Str::limit(strip_tags($new->content), 150) }}</p>
                            <a href="javascript:void(0)" class="btn btn-primary"
                                onclick="showNewsModal({{ $new->id }})">
                                Read more →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        Belum ada berita. Silahkan cek kembali nanti.
                    </div>
                @endforelse

                <!-- Recent Posts Row -->
                <div class="row">
                    @forelse($latestNews as $latest)
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <a href="javascript:void(0)" onclick="showNewsModal({{ $latest->id }})">
                                    <img class="card-img-top" src="{{ asset('storage/news_images/' . $latest->image) }}"
                                        alt="{{ $latest->title }}" style="height: 200px; object-fit: cover;">
                                </a>
                                <div class="card-body">
                                    <div class="small text-muted">{{ $latest->created_at->format('F d, Y') }}</div>
                                    <h2 class="card-title h4">{{ $latest->title }}</h2>
                                    <p class="card-text">{{ Str::limit(strip_tags($latest->content), 100) }}</p>
                                    <a href="javascript:void(0)" class="btn btn-primary"
                                        onclick="showNewsModal({{ $latest->id }})">
                                        Read more →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                Belum ada berita terbaru.
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if (method_exists($news, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $news->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories Widget -->
                <div class="card mb-4">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        @if (isset($categories) && $categories->count() > 0)
                            <div class="row">
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($categories->take(ceil($categories->count() / 2)) as $category)
                                            <li><a>{{ $category->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($categories->skip(ceil($categories->count() / 2)) as $category)
                                            <li><a>{{ $category->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada kategori</p>
                        @endif
                    </div>
                </div>

                <!-- Side Widget -->
                <div class="card mb-4">
                    <div class="card-header">Side Widget</div>
                    <div class="card-body">
                        You can put anything you want inside of these side widgets.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for News Detail -->
    <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="newsModalLabel">
                        <i class="bi bi-newspaper"></i> Detail Berita
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="newsModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat data...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showNewsModal(newsId) {
            // Tampilkan modal
            const modal = new bootstrap.Modal(document.getElementById('newsModal'));
            modal.show();

            // Tampilkan loading
            document.getElementById('newsModalBody').innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2">Memuat data...</p>
            </div>
        `;

            // Ambil data via AJAX
            $.ajax({
                url: `/news/${newsId}/json`,
                method: 'GET',
                success: function(response) {
                    let content = `
                    <div class="news-detail">
                        ${response.image ? `<img src="${response.image}" class="img-fluid rounded mb-4" alt="${response.title}">` : ''}
                        <h2 class="mb-3">${response.title}</h2>
                        <div class="text-muted mb-4">
                            <i class="bi bi-folder"></i> ${response.category} |
                            <i class="bi bi-calendar"></i> ${response.created_at}
                        </div>
                        <div class="news-content">
                            ${response.content}
                        </div>
                    </div>
                `;
                    document.getElementById('newsModalBody').innerHTML = content;
                },
                error: function(xhr) {
                    document.getElementById('newsModalBody').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle"></i>
                        Gagal memuat data berita. Silakan coba lagi.
                    </div>
                `;
                }
            });
        }
    </script>

    <style>
        .news-detail {
            line-height: 1.8;
        }

        .news-detail img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .news-content {
            font-size: 1rem;
        }

        .news-content p {
            margin-bottom: 1rem;
        }
    </style>
@endpush
