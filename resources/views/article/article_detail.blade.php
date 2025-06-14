@extends('layouts.layout') {{-- Extends the main layout --}}

@section('title', $article->title . ' - Nutriverse Blogs') {{-- Dynamic page title --}}

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Main Article Section --}}
            <section class="mb-5">
                <div class="card nutri-article-card shadow-lg border-0 rounded-4 overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                    @if ($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}"
                             class="card-img-top article-cover-image"
                             alt="{{ $article->title }}"
                             loading="lazy">
                    @else
                        <div class="article-cover-image bg-nutri-light-alt text-nutri-secondary d-flex align-items-center justify-content-center fs-3 rounded-top">
                            <i class="bi bi-image me-2"></i> No Image Available
                        </div>
                    @endif

                    <div class="card-body p-5 p-md-5 p-lg-5">
                        <div class="d-flex align-items-center text-nutri-secondary small mb-3">
                            <i class="bi bi-person-fill me-2"></i> <span class="me-3">{{ $article->author }}</span>
                            <i class="bi bi-calendar-fill me-2"></i> <span>{{ $article->created_at->format('j M, Y') }}</span>
                        </div>
                        <h1 class="card-title fw-bold text-nutri-primary mb-4 display-5">{{ $article->title }}</h1>
                        <div class="article-content text-secondary lh-lg fs-5">
                            {!! $article->content !!} {{-- Renders HTML content --}}
                        </div>

                        <hr class="my-5 nutri-divider-small">

                        <a href="{{ url('/articles') }}" class="btn btn-outline-nutri btn-lg rounded-pill">
                            <i class="bi bi-arrow-left me-2"></i> Back to Blog
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- Other Articles (Related Articles) Section --}}
    <h2 class="text-center fw-bold text-nutri-primary mb-4 mt-5" data-aos="fade-up">More <span class="text-nutri-accent">Articles</span></h2>
    @if($articles->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($articles as $related)
                <div class="col" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="card h-100 nutri-card shadow-sm border-0 rounded-4 overflow-hidden">
                        <div class="position-relative nutri-thumbnail-wrapper">
                            @if ($related->image)
                                <img src="{{ asset('storage/' . $related->image) }}"
                                     class="card-img-top nutri-thumbnail"
                                     alt="{{ $related->title }}"
                                     loading="lazy">
                            @else
                                <div class="nutri-thumbnail bg-nutri-light-alt text-nutri-secondary d-flex align-items-center justify-content-center fs-5 rounded-top">
                                    <i class="bi bi-image me-2"></i> No Image Available
                                </div>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold text-nutri-primary mb-2">{{ $related->title }}</h5>
                            <div class="d-flex align-items-center mb-3 text-nutri-secondary small">
                                <i class="bi bi-person-circle me-2"></i> <span class="me-3">{{ $related->author }}</span>
                                <i class="bi bi-calendar-event me-2"></i> <span>{{ $related->created_at->format('j M, Y') }}</span>
                            </div>
                            <p class="card-text text-nutri-secondary mb-4 nutri-description-clamp">{{ Str::words(strip_tags($related->content), 25, '...') }}</p>
                            <div class="mt-auto">
                                <a href="{{ url('/articles/' . $related->id) }}"
                                   class="btn btn-outline-nutri w-100 rounded-pill nutri-read-more-btn">
                                    <i class="bi bi-arrow-right-circle-fill me-2"></i> Read More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-nutri-secondary fs-5 mt-4">No other articles to display.</p>
    @endif
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    /* --- Custom Nutriverse Green Palette --- */
    :root {
        --nutri-primary: #28a745; /* A vibrant, modern green */
        --nutri-secondary: #495057; /* Darker grey for body text, better contrast */
        --nutri-accent: #20c997; /* A refreshing teal-green accent */
        --nutri-light: #e6f7ed; /* Very light green, soft background */
        --nutri-light-alt: #f0fdf7; /* Even lighter for input backgrounds */
        --nutri-dark-hover: #1e7e34; /* Darker primary for hover */
        --nutri-shadow-green: rgba(40, 167, 69, 0.25); /* Subtle shadow for green elements */
        --nutri-card-shadow: rgba(0, 0, 0, 0.08); /* Lighter card shadow */
    }

    body {
        background-color: var(--nutri-light);
        font-family: 'Poppins', sans-serif;
        color: var(--nutri-secondary);
        line-height: 1.7;
    }

    /* --- Text Colors --- */
    .text-nutri-primary { color: var(--nutri-primary) !important; }
    .text-nutri-secondary { color: var(--nutri-secondary) !important; }
    .text-nutri-accent { color: var(--nutri-accent) !important; }

    /* --- Article Card Styling (Main Article) --- */
    .nutri-article-card {
        box-shadow: 0 15px 45px rgba(0,0,0,0.1) !important;
        background-color: #fff;
        border: none;
        border-radius: 1.5rem !important; /* More pronounced rounded corners */
        overflow: hidden;
    }

    /* Full article image sizing */
    .article-cover-image {
        width: 100%;
        height: 450px; /* Increased height for prominence */
        object-fit: cover;
        border-bottom: 8px solid var(--nutri-primary); /* Thicker, primary color border */
        transition: transform 0.5s ease-in-out; /* Add transition for image hover */
    }
    .nutri-article-card:hover .article-cover-image {
        transform: scale(1.02); /* Slight zoom on image hover */
    }
    .article-cover-image.bg-nutri-light-alt {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem; /* Larger "No Image" text */
        color: var(--nutri-secondary);
        background-color: var(--nutri-light-alt) !important;
    }
    .article-cover-image.bg-nutri-light-alt i {
        font-size: 4rem; /* Larger icon */
        opacity: 0.7;
    }

    /* Styling for the main article content */
    .article-content {
        color: #333; /* Slightly darker text for readability */
        font-size: 1.15rem; /* Slightly larger base font size */
        line-height: 1.8; /* Improved line height */
    }
    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 1rem; /* More rounded image corners */
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1); /* Soft shadow for inline images */
    }
    .article-content p {
        margin-bottom: 1.2rem;
    }
    .article-content h1, .article-content h2, .article-content h3, .article-content h4, .article-content h5, .article-content h6 {
        margin-top: 2.5rem; /* More spacing above headings */
        margin-bottom: 1.2rem;
        font-weight: 700;
        color: var(--nutri-primary); /* Headings in primary color */
        font-family: 'Montserrat', sans-serif; /* Consistent heading font */
    }
    .article-content h1 { font-size: 2.8rem; }
    .article-content h2 { font-size: 2.2rem; }
    .article-content h3 { font-size: 1.8rem; }
    .article-content ul, .article-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem; /* More indent for lists */
    }
    .article-content li {
        margin-bottom: 0.7rem;
        line-height: 1.6;
    }
    .article-content strong {
        color: var(--nutri-dark-hover); /* Make strong text stand out */
    }

    /* Custom Horizontal Divider for main article */
    .nutri-divider-small {
        border: 0;
        height: 3px;
        background-image: linear-gradient(to right, transparent, var(--nutri-accent), transparent);
        margin-top: 3rem;
        margin-bottom: 3rem;
        border-radius: 50%;
        opacity: 0.7;
    }

    /* --- Buttons --- */
    .btn-outline-nutri {
        font-weight: 600;
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        border-color: var(--nutri-primary);
        color: var(--nutri-primary);
        padding: 0.9rem 2rem;
        font-size: 1.1rem;
        position: relative;
        overflow: hidden;
        z-index: 1;
        border-width: 2px; /* Thicker border */
    }
    .btn-outline-nutri:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(90deg, var(--nutri-primary) 0%, var(--nutri-accent) 100%);
        transition: all 0.4s ease;
        z-index: -1;
    }
    .btn-outline-nutri:hover:before {
        width: 100%;
    }
    .btn-outline-nutri:hover {
        color: white !important;
        border-color: var(--nutri-primary);
        box-shadow: 0 8px 20px var(--nutri-shadow-green);
        transform: translateY(-3px);
    }

    /* --- Related Articles Specific Styles (Consistent with Blog List) --- */
    .nutri-card {
        transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 15px 40px var(--nutri-card-shadow) !important;
        background-color: #fff;
        border: none;
        border-radius: 1.2rem;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .nutri-card:hover {
        transform: translateY(-20px);
        box-shadow: 0 2.5rem 5rem rgba(0,0,0,.15) !important;
    }

    .nutri-thumbnail-wrapper {
        height: 220px; /* Slightly adjusted height for related articles */
        overflow: hidden;
        position: relative;
        border-bottom: 5px solid var(--nutri-accent);
        background-color: var(--nutri-light-alt);
    }
    .nutri-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .nutri-card:hover .nutri-thumbnail {
        transform: scale(1.15);
    }
    .nutri-thumbnail.bg-nutri-light-alt {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--nutri-secondary);
    }
    .nutri-thumbnail.bg-nutri-light-alt i {
        font-size: 3rem;
        opacity: 0.7;
    }

    .nutri-description-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 100px;
        line-height: 1.8;
        font-size: 1.05rem;
        color: #666;
    }

    .nutri-read-more-btn {
        font-weight: 600;
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        border-color: var(--nutri-primary);
        color: var(--nutri-primary);
        padding: 0.9rem 2rem;
        font-size: 1.1rem;
        position: relative;
        overflow: hidden;
        z-index: 1;
        border-width: 2px;
    }
    .nutri-read-more-btn:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(90deg, var(--nutri-primary) 0%, var(--nutri-accent) 100%);
        transition: all 0.4s ease;
        z-index: -1;
    }
    .nutri-read-more-btn:hover:before {
        width: 100%;
    }
    .nutri-read-more-btn:hover {
        color: white !important;
        border-color: var(--nutri-primary);
        box-shadow: 0 8px 20px var(--nutri-shadow-green);
        transform: translateY(-3px);
    }
</style>

{{-- AOS (Animate On Scroll) initialization --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 1200,
            once: true,
            easing: 'ease-in-out',
            delay: 50,
        });
    });
</script>
@endsection