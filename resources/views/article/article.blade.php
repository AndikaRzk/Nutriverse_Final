@extends('layouts.layout') {{-- Pastikan ini mengarah ke file layout utama Anda --}}

@section('title', 'Nutriverse Insights - Healthy Living Blogs')

@section('content')
<div class="container py-5">
    {{-- Hero Section for Search and Introduction --}}
    <div class="row justify-content-center mb-5 mt-5">
        <div class="col-md-10 col-lg-9">
            <div class="text-center mb-5" data-aos="fade-up" data-aos-once="true">
                <h1 class="display-3 fw-bolder text-nutri-primary mb-3 animate__animated animate__fadeInDown">Explore Our <span class="text-nutri-accent">Nutriverse</span> Insights</h1>
                <p class="lead text-nutri-secondary px-lg-5 animate__animated animate__fadeInUp animate__delay-1s">
                    Dive into our latest articles on **health, nutrition, and well-being**. Discover expert insights, practical tips, and daily inspiration for a healthier, happier you!
                </p>
            </div>
            <form action="{{ url('/articles') }}" method="GET" class="nutri-search-form shadow-lg rounded-pill p-2 bg-white position-relative" data-aos="fade-up" data-aos-delay="200" data-aos-once="true">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 rounded-start-pill ps-4 py-3" placeholder="Search articles by title, author, or content...">
                    <button class="btn btn-nutri-search rounded-end-pill pe-4" type="submit">
                        <i class="bi bi-search me-2"></i> Search
                    </button>
                </div>
            </form>

            {{-- Create Article Button (visible only for consultants) --}}
            @auth('consultants')
                <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="300" data-aos-once="true">
                    <a href="{{ route('create_articles') }}" class="btn btn-nutri-accent btn-lg rounded-pill px-5 py-3 shadow animate__animated animate__pulse animate__infinite">
                        <i class="bi bi-plus-circle-fill me-2"></i> Create New Article
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <hr class="my-5 nutri-divider">

    {{-- Articles Grid Section --}}
    <h2 class="text-center mb-5 fw-bold text-nutri-primary" data-aos="fade-up" data-aos-once="true">Latest Articles</h2>
    @if($articles->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($articles as $article)
                <div class="col" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}" data-aos-once="true">
                    <div class="card h-100 nutri-card shadow-sm border-0 rounded-4 overflow-hidden">
                        <div class="position-relative nutri-thumbnail-wrapper">
                            @if ($article->image)
                                <img src="{{ asset('storage/' . $article->image) }}"
                                        class="card-img-top nutri-thumbnail"
                                        alt="{{ $article->title }}"
                                        loading="lazy">
                            @else
                                <div class="nutri-thumbnail bg-nutri-light-alt text-nutri-secondary d-flex align-items-center justify-content-center fs-5 rounded-top">
                                    <i class="bi bi-image me-2"></i> No Image Available
                                </div>
                            @endif
                            @if(isset($article->category))
                            <div class="nutri-category-badge badge bg-nutri-primary position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill">
                                {{ $article->category }}
                            </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold text-nutri-primary mb-2">{{ $article->title }}</h5>
                            <div class="d-flex align-items-center mb-3 text-nutri-secondary small">
                                <i class="bi bi-person-circle me-2"></i> <span class="me-3">{{ $article->author }}</span>
                                <i class="bi bi-calendar-event me-2"></i> <span>{{ $article->created_at->format('j M, Y') }}</span>
                            </div>

                            <p class="card-text text-nutri-secondary mb-4 nutri-description-clamp">{{ Str::words(strip_tags($article->content), 25, '...') }}</p>

                            <div class="mt-auto">
                                <a href="{{ url('/articles/' . $article->id) }}"
                                    class="btn btn-outline-nutri w-100 rounded-pill nutri-read-more-btn">
                                    <i class="bi bi-arrow-right-circle-fill me-2"></i> Read More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5" data-aos="fade-up" data-aos-delay="{{ count($articles) * 100 }}" data-aos-once="true">
            {{ $articles->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @else
        {{-- No Articles Found Message --}}
        <div class="card nutri-no-result-card text-center py-5 shadow-sm" data-aos="fade-up" data-aos-once="true">
            <div class="card-body">
                <i class="bi bi-exclamation-circle-fill display-4 text-nutri-primary mb-3"></i>
                <h4 class="nutri-no-result-title text-nutri-primary">No Articles Found!</h4>
                <p class="text-nutri-secondary mb-0">
                    It seems there are no articles matching your search "{{ request('search') }}".
                    @if(request('search'))
                        Try a different search term or <a href="{{ url('/articles') }}" class="text-nutri-accent fw-semibold text-decoration-none">view all articles</a>.
                    @endif
                </p>
            </div>
        </div>
    @endif
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    /* --- Custom Nutriverse Green Palette (Slightly Refined) --- */
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
        line-height: 1.7; /* Slightly increased for readability */
    }

    /* --- Text Colors --- */
    .text-nutri-primary { color: var(--nutri-primary) !important; }
    .text-nutri-secondary { color: var(--nutri-secondary) !important; }
    .text-nutri-accent { color: var(--nutri-accent) !important; }

    /* --- Hero Section Styling --- */
    .display-3 {
        font-family: 'Montserrat', sans-serif; /* More impactful font for headings */
        font-size: 4.5rem; /* Larger and bolder */
        letter-spacing: -2.5px;
        font-weight: 900 !important; /* Extra bold */
        text-shadow: 3px 3px 8px rgba(0,0,0,0.08);
    }
    .lead {
        font-size: 1.35rem; /* Slightly larger lead text */
        line-height: 1.9;
        max-width: 850px;
        margin-left: auto;
        margin-right: auto;
        font-weight: 400;
        color: #555;
    }
    @media (max-width: 768px) {
        .display-3 {
            font-size: 3rem;
        }
        .lead {
            font-size: 1.15rem;
        }
    }

    .nutri-search-form {
        border: none; /* No visible border for a cleaner look */
        transition: all 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
        position: relative;
        z-index: 2;
        overflow: hidden;
        border-radius: 50px !important; /* More pronounced rounded corners */
        box-shadow: 0 10px 30px rgba(0,0,0,0.08); /* Softer initial shadow */
    }
    .nutri-search-form:hover {
        box-shadow: 0 20px 45px var(--nutri-shadow-green) !important; /* Enhanced hover shadow */
        transform: translateY(-5px);
    }
    .nutri-search-form .form-control {
        font-size: 1.25rem;
        color: var(--nutri-secondary);
        padding-left: 2.5rem;
        padding-right: 1.5rem; /* Space for the search icon */
        background-color: var(--nutri-light-alt);
        height: 65px; /* Taller input */
        border-radius: 50px 0 0 50px !important; /* Match form rounding */
    }
    .nutri-search-form .form-control::placeholder {
        color: #a0a0a0;
        opacity: 0.9;
    }
    .nutri-search-form .form-control:focus {
        background-color: white !important;
        box-shadow: 0 0 0 0.25rem rgba(var(--nutri-primary), 0.25); /* Subtle focus ring */
    }

    .btn-nutri-search {
        background: linear-gradient(135deg, var(--nutri-accent) 0%, var(--nutri-primary) 100%);
        border: none;
        font-weight: 700;
        color: white;
        transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 8px 25px rgba(0,0,0,.25); /* Stronger button shadow */
        padding: 1rem 3rem; /* More padding */
        font-size: 1.2rem;
        text-transform: uppercase;
        letter-spacing: 1px; /* More distinct lettering */
        border-radius: 0 50px 50px 0 !important; /* Match form rounding */
    }
    .btn-nutri-search:hover {
        background: linear-gradient(135deg, var(--nutri-primary) 0%, var(--nutri-dark-hover) 100%);
        transform: translateY(-4px) scale(1.05); /* More pronounced hover effect */
        box-shadow: 0 12px 30px rgba(0,0,0,.4);
    }

    /* --- Create Article Button --- */
    .btn-nutri-accent {
        background: linear-gradient(45deg, var(--nutri-accent) 0%, var(--nutri-primary) 100%);
        border: none;
        color: white;
        font-weight: 700;
        font-size: 1.4rem; /* Larger font */
        transition: all 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 12px 35px var(--nutri-shadow-green); /* Enhanced shadow */
        position: relative;
        overflow: hidden;
        letter-spacing: 1px;
        padding: 1.2rem 4rem; /* More generous padding */
    }
    .btn-nutri-accent:before {
        content: '';
        position: absolute;
        top: 0;
        left: -150%; /* Wider swipe effect */
        width: 60%; /* Wider highlight */
        height: 100%;
        background: rgba(255, 255, 255, 0.4); /* Brighter highlight */
        transition: all 0.8s cubic-bezier(0.25, 0.8, 0.25, 1);
        transform: skewX(-25deg); /* More angled swipe */
    }
    .btn-nutri-accent:hover:before {
        left: 150%;
    }
    .btn-nutri-accent:hover {
        background: linear-gradient(45deg, var(--nutri-primary) 0%, var(--nutri-dark-hover) 100%);
        transform: translateY(-8px) scale(1.06); /* Even more lift */
        box-shadow: 0 20px 50px var(--nutri-shadow-green);
    }
    .btn-nutri-accent.animate__animated.animate__pulse {
        animation-duration: 2s; /* Slightly faster pulse */
    }

    /* --- Custom Horizontal Divider --- */
    .nutri-divider {
        border: 0;
        height: 5px; /* Thicker divider */
        background-image: linear-gradient(to right, transparent, var(--nutri-accent), var(--nutri-primary), var(--nutri-accent), transparent);
        margin-top: 7rem; /* More vertical spacing */
        margin-bottom: 7rem;
        border-radius: 50%;
        opacity: 0.9;
    }

    /* --- Article Cards --- */
    .nutri-card {
        transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 15px 40px var(--nutri-card-shadow) !important; /* Lighter, more modern shadow */
        background-color: #fff;
        border: none; /* No border for a floating effect */
        border-radius: 1.2rem; /* More rounded */
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .nutri-card:hover {
        transform: translateY(-20px); /* Greater lift */
        box-shadow: 0 2.5rem 5rem rgba(0,0,0,.15) !important; /* More diffused hover shadow */
    }

    /* Article Thumbnail Styling */
    .nutri-thumbnail-wrapper {
        height: 280px; /* Taller thumbnails */
        overflow: hidden;
        position: relative;
        border-bottom: 6px solid var(--nutri-primary); /* Thicker border on bottom */
        background-color: var(--nutri-light-alt); /* Fallback background */
    }
    .nutri-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s cubic-bezier(0.25, 0.8, 0.25, 1); /* Slower, smoother zoom */
    }
    .nutri-card:hover .nutri-thumbnail {
        transform: scale(1.2); /* More zoom */
    }
    .nutri-thumbnail.bg-nutri-light-alt {
        background-color: var(--nutri-light-alt) !important;
        color: var(--nutri-secondary) !important;
        font-size: 1.8rem; /* Larger no image text */
    }
    .nutri-thumbnail.bg-nutri-light-alt i {
        font-size: 3.5rem; /* Larger icon */
        opacity: 0.8;
    }

    /* Category Badge Styling */
    .nutri-category-badge {
        font-size: 0.95rem; /* Slightly larger font */
        font-weight: 800; /* Bolder */
        letter-spacing: 1.5px; /* More spacing */
        text-transform: uppercase;
        z-index: 1;
        opacity: 0.99;
        background-color: var(--nutri-primary) !important;
        color: white;
        padding: 0.8rem 1.6rem; /* More padding */
        border-bottom-right-radius: 1rem;
        border-top-left-radius: 1rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.35); /* Stronger shadow */
        transform: rotate(-4deg); /* Slightly more rotation */
        transform-origin: top left;
    }

    /* Description Clamping */
    .nutri-description-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 4; /* Slightly fewer lines for a cleaner look */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 100px; /* Adjusted min-height */
        line-height: 1.8;
        font-size: 1.05rem;
        color: #666;
    }

    /* Read More Button Styling */
    .btn-outline-nutri {
        font-weight: 700; /* Bolder */
        transition: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
        border-color: var(--nutri-primary);
        color: var(--nutri-primary);
        padding: 1rem 2.5rem; /* More padding */
        font-size: 1.15rem; /* Slightly larger */
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
        transition: all 0.5s ease; /* Slower, smoother transition */
        z-index: -1;
    }
    .btn-outline-nutri:hover:before {
        width: 100%;
    }
    .btn-outline-nutri:hover {
        color: white !important;
        border-color: var(--nutri-primary);
        box-shadow: 0 10px 25px var(--nutri-shadow-green); /* Stronger hover shadow */
        transform: translateY(-4px);
    }

    /* No Results Card Styling */
    .nutri-no-result-card {
        border-radius: 1.8rem; /* More rounded */
        background-color: white;
        border: 5px dashed var(--nutri-accent); /* Thicker dashed border */
        box-shadow: 0 20px 50px rgba(0,0,0,.12); /* More prominent shadow */
        padding: 5rem; /* More padding */
        margin-top: 4rem;
        margin-bottom: 4rem;
    }
    .nutri-no-result-card .bi {
        color: var(--nutri-primary) !important;
        font-size: 6rem; /* Larger icon */
        text-shadow: 3px 3px 15px rgba(0,0,0,0.15);
    }
    .nutri-no-result-card .nutri-no-result-title {
        font-weight: 800; /* Bolder title */
        margin-top: 2rem;
        font-size: 2.5rem; /* Larger title */
        color: var(--nutri-primary);
    }
    .nutri-no-result-card p {
        font-size: 1.3rem; /* Larger text */
        color: var(--nutri-secondary);
        line-height: 1.8;
    }
    .nutri-no-result-card a {
        color: var(--nutri-accent) !important;
        font-weight: 800; /* Bolder link */
        text-decoration: none;
        transition: color 0.4s ease;
    }
    .nutri-no-result-card a:hover {
        color: var(--nutri-primary) !important;
        text-decoration: underline !important;
    }

    /* Pagination Styling */
    .pagination .page-item .page-link {
        font-size: 1.15rem; /* Slightly larger */
        padding: 0.8rem 1.4rem; /* More padding */
        min-width: 52px; /* Wider buttons */
        border-radius: 1rem !important; /* More rounded */
        margin: 0 0.5rem; /* More spacing between buttons */
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        color: var(--nutri-primary) !important;
        border: 2px solid var(--nutri-primary) !important; /* Thicker border */
        background-color: #fff;
        box-shadow: 0 3px 10px rgba(0,0,0,0.08); /* Softer shadow */
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(90deg, var(--nutri-primary) 0%, var(--nutri-accent) 100%) !important;
        border-color: var(--nutri-primary) !important;
        color: white !important;
        box-shadow: 0 8px 20px var(--nutri-shadow-green); /* Stronger active shadow */
        transform: translateY(-3px); /* More lift on active */
    }
    .pagination .page-link:hover:not(.active) {
        background-color: var(--nutri-light-alt) !important;
        color: var(--nutri-dark-hover) !important;
        box-shadow: 0 5px 15px rgba(0,0,0,0.18);
        transform: translateY(-2px);
    }
    .pagination .page-item.disabled .page-link {
        background-color: var(--nutri-light) !important; /* Lighter disabled background */
        border-color: var(--nutri-light) !important;
        color: var(--nutri-secondary) !important;
        opacity: 0.6; /* More faded */
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }
</style>

{{-- AOS (Animate On Scroll) initialization. Make sure these are properly linked. --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 1200, // Even longer animation duration for more elegance
            once: true,    // Animation happens only once
            easing: 'ease-in-out', // Smoother easing
            delay: 50, // Slight delay for a cascading effect
        });
    });
</script>
@endsection