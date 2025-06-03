@extends('layouts.layout') {{-- Extends the new main layout --}}

@section('title', $article->title . ' - Nutriverse Blogs') {{-- Dynamic title for the page --}}

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Main Article Section --}}
            <section class="mb-5">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    @if ($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}"
                             class="card-img-top article-cover-image"
                             alt="{{ $article->title }}"
                             loading="lazy">
                    @else
                        <div class="article-cover-image bg-light text-muted d-flex align-items-center justify-content-center fs-3 rounded-top">
                            No Image Available
                        </div>
                    @endif

                    <div class="card-body p-5">
                        <div class="d-flex align-items-center text-muted small mb-3">
                            <i class="bi bi-person-fill me-2"></i> <span class="me-3">{{ $article->author }}</span>
                            <i class="bi bi-calendar-fill me-2"></i> <span>{{ $article->created_at->format('j M, Y') }}</span>
                        </div>
                        <h1 class="card-title fw-bold text-dark mb-4 display-5">{{ $article->title }}</h1>
                        <div class="article-content text-secondary lh-lg fs-5">
                            {!! $article->content !!} {{-- Render HTML content --}}
                        </div>

                        <hr class="my-5">

                        <a href="{{ url('/articles') }}" class="btn btn-outline-primary btn-lg rounded-pill">
                            <i class="bi bi-arrow-left me-2"></i> Kembali ke Blog
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- Other Articles (Related Articles) Section --}}
    <h2 class="text-center fw-bold text-dark mb-4 mt-5" data-aos="fade-up">Berita <span class="text-primary">Lainnya</span></h2>
    @if($articles->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($articles as $related)
                <div class="col" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="card h-100 shadow-hover border-0 rounded-3 overflow-hidden">
                        <div class="position-relative article-thumbnail-container">
                            @if ($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}"
                                     class="card-img-top article-thumbnail"
                                     alt="{{ $related->title }}"
                                     loading="lazy">
                            @else
                                <div class="article-thumbnail bg-light text-muted d-flex align-items-center justify-content-center fs-5 rounded-top">
                                    No Image Available
                                </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold text-dark mb-2">{{ $related->title }}</h5>
                            <div class="d-flex align-items-center mb-3 text-muted small">
                                <i class="bi bi-person-fill me-2"></i> <span class="me-3">{{ $related->author }}</span>
                                <i class="bi bi-calendar-fill me-2"></i> <span>{{ $related->created_at->format('j M, Y') }}</span>
                            </div>
                            <p class="card-text text-secondary mb-4 description-clamp">{{ Str::words(strip_tags($related->content), 25, '...') }}</p>
                            <div class="mt-auto">
                                <a href="{{ url('/articles/' . $related->id) }}"
                                   class="btn btn-outline-primary w-100 rounded-pill article-button">
                                    <i class="bi bi-book me-2"></i> Read More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-muted">Tidak ada artikel lain untuk ditampilkan.</p>
    @endif
</div>
@endsection

{{-- Custom Styles for this page --}}
@push('styles')
<style>
    /* Full article image sizing */
    .article-cover-image {
        width: 100%;
        height: 400px; /* Adjust height as needed */
        object-fit: cover;
        border-bottom: 5px solid var(--bs-primary); /* Add a subtle line */
    }
    .article-cover-image.bg-light {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #6c757d;
    }

    /* Styling for the main article content */
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
    .article-content p {
        margin-bottom: 1rem;
    }
    .article-content h1, .article-content h2, .article-content h3, .article-content h4, .article-content h5, .article-content h6 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
        color: #343a40;
    }
    .article-content ul, .article-content ol {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }
    .article-content li {
        margin-bottom: 0.5rem;
    }

    /* Related articles specific styles (copied from previous examples for consistency) */
    .shadow-hover {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }
    .shadow-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,.1) !important;
    }

    .article-thumbnail-container {
        height: 200px; /* Slightly smaller for related articles */
        overflow: hidden;
        position: relative;
    }
    .article-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .card:hover .article-thumbnail {
        transform: scale(1.05);
    }
    .article-thumbnail.bg-light {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: #6c757d;
    }

    .description-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 72px; /* Approx height for 3 lines of text */
    }

    .article-button {
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .article-button:hover {
        background-color: var(--bs-primary);
        color: white !important;
        border-color: var(--bs-primary);
    }
</style>
@endpush

{{-- No specific scripts needed for this page --}}
@push('scripts')

@endpush