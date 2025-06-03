@extends('layouts.layout') {{-- Ensure this path is correct for your main layout --}}

@section('title', 'Nutriverse Insights - Healthy Living Blogs') {{-- More engaging title --}}

@section('content')
<div class="container py-5">
    {{-- Hero Section for Search and Introduction --}}
    <div class="row justify-content-center mb-5 mt-5">
        <div class="col-md-9"> {{-- Slightly wider column for hero section --}}
            <div class="text-center mb-5" data-aos="fade-up">
                <h1 class="display-3 fw-bolder text-nutri-primary mb-3">Explore Our Blog</h1> {{-- Bold and larger heading --}}
                <p class="lead text-nutri-secondary px-lg-5">Dive into our latest articles on health, nutrition, and well-being. Discover insights, tips, and inspiration for a healthier life!</p>
            </div>
            <form action="{{ url('/articles') }}" method="GET" class="nutri-search-form shadow-lg rounded-pill p-2 bg-white" data-aos="fade-up" data-aos-delay="100">
                <div class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control border-0 rounded-start-pill ps-4 py-3" placeholder="Search articles by title, author, or content..."> {{-- Larger padding and updated placeholder --}}
                    <button class="btn btn-nutri-search rounded-end-pill pe-4" type="submit">
                        <i class="bi bi-search me-2"></i> Search
                    </button>
                </div>
            </form>

            {{-- Create Article Button (visible only for consultants) --}}
            @auth('consultants')
                <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{ route('create_articles') }}" class="btn btn-nutri-accent btn-lg rounded-pill px-5 py-3 shadow animate__animated animate__pulse animate__infinite"> {{-- Larger button, more pronounced shadow --}}
                        <i class="bi bi-plus-circle-fill me-2"></i> Create New Article
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <hr class="my-5 nutri-divider"> {{-- Custom divider with new class --}}

    {{-- Articles Grid Section --}}
    <h2 class="text-center mb-5 fw-bold text-nutri-primary" data-aos="fade-up">Latest Articles</h2> {{-- Updated heading style --}}
    @if($articles->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($articles as $article)
                <div class="col" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <div class="card h-100 nutri-card shadow-sm border-0 rounded-4 overflow-hidden"> {{-- More rounded corners, subtle shadow --}}
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
                            <div class="nutri-category-badge badge bg-nutri-primary position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill"> {{-- New badge class --}}
                                {{ $article->category }}
                            </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column p-4">
                            <h5 class="card-title fw-bold text-nutri-primary mb-2">{{ $article->title }}</h5>
                            <div class="d-flex align-items-center mb-3 text-nutri-secondary small">
                                <i class="bi bi-person-circle me-2"></i> <span class="me-3">{{ $article->author }}</span> {{-- Changed icon --}}
                                <i class="bi bi-calendar-event me-2"></i> <span>{{ $article->created_at->format('j M, Y') }}</span> {{-- Changed icon --}}
                            </div>

                            {{-- FIX: Change text-secondary to text-nutri-secondary --}}
                            <p class="card-text text-nutri-secondary mb-4 nutri-description-clamp">{{ Str::words(strip_tags($article->content), 25, '...') }}</p>

                            <div class="mt-auto">
                                <a href="{{ url('/articles/' . $article->id) }}"
                                   class="btn btn-outline-nutri w-100 rounded-pill nutri-read-more-btn"> {{-- New button class --}}
                                    <i class="bi bi-arrow-right-circle-fill me-2"></i> Read More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5" data-aos="fade-up" data-aos-delay="{{ count($articles) * 100 }}">
            {{ $articles->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @else
        {{-- No Articles Found Message --}}
        <div class="card nutri-no-result-card text-center py-5 shadow-sm" data-aos="fade-up"> {{-- New class for no results card --}}
            <div class="card-body">
                <i class="bi bi-exclamation-circle-fill display-4 text-nutri-primary mb-3"></i> {{-- Changed icon --}}
                <h4 class="nutri-no-result-title text-nutri-primary">No Articles Found!</h4>
                {{-- FIX: Change text-muted to text-nutri-secondary --}}
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
@endsection

{{-- Custom Styles specific to this page --}}
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
    /* --- Custom Nutriverse Green Palette --- */
    :root {
        --nutri-primary: #33855f; /* Deep vibrant green for primary elements */
        --nutri-secondary: #5a7c5c; /* Muted green for secondary text/borders */
        --nutri-accent: #6ec07c; /* Brighter green for interactive elements/highlights */
        --nutri-light: #e6f2ed; /* Very light green for backgrounds */
        --nutri-light-alt: #f1f8f3; /* Slightly different very light green for contrasts */
        --nutri-dark-hover: #296b4b; /* Darker green for hover states */
        --nutri-shadow-green: rgba(51, 133, 95, 0.25); /* Green shadow for focus/hover */
    }

    body {
        background-color: var(--nutri-light); /* Overall light green background */
        font-family: 'Poppins', sans-serif; /* Modern, readable font */
    }

    /* --- Text Colors --- */
    .text-nutri-primary { color: var(--nutri-primary) !important; }
    .text-nutri-secondary { color: var(--nutri-secondary) !important; }
    .text-nutri-accent { color: var(--nutri-accent) !important; }

    /* --- Hero Section Styling --- */
    .display-3 { font-size: 3.5rem; } /* Slightly larger heading for impact */

    .nutri-search-form {
        border: 2px solid var(--nutri-light-alt); /* More defined border for the search bar */
        transition: all 0.3s ease;
    }
    .nutri-search-form:hover {
        box-shadow: 0 8px 20px var(--nutri-shadow-green) !important; /* Enhanced shadow on hover */
    }
    .nutri-search-form .form-control {
        font-size: 1.1rem; /* Slightly larger text in search input */
        color: var(--nutri-secondary);
    }
    .nutri-search-form .form-control::placeholder {
        color: #a0a0a0; /* Lighter placeholder text */
    }
    .nutri-search-form .form-control:focus {
        border-color: transparent !important; /* No direct border change on focus */
        box-shadow: none !important; /* Remove Bootstrap's default focus shadow */
    }

    .btn-nutri-search {
        background: linear-gradient(90deg, var(--nutri-accent) 0%, var(--nutri-primary) 100%); /* Gradient for search button */
        border: none;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(0,0,0,.15); /* Subtle shadow for button */
    }
    .btn-nutri-search:hover {
        background: linear-gradient(90deg, var(--nutri-primary) 0%, var(--nutri-dark-hover) 100%); /* Darker gradient on hover */
        transform: translateY(-2px); /* Slight lift */
        box-shadow: 0 6px 15px rgba(0,0,0,.2);
    }

    /* --- Create Article Button --- */
    .btn-nutri-accent {
        background: linear-gradient(45deg, var(--nutri-accent) 0%, var(--nutri-primary) 100%); /* Angled gradient */
        border: none;
        color: white;
        font-weight: 700;
        font-size: 1.15rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px var(--nutri-shadow-green); /* Green shadow */
    }
    .btn-nutri-accent:hover {
        background: linear-gradient(45deg, var(--nutri-primary) 0%, var(--nutri-dark-hover) 100%);
        transform: translateY(-3px);
        box-shadow: 0 8px 20px var(--nutri-shadow-green);
    }

    /* --- Custom Horizontal Divider --- */
    .nutri-divider {
        border: 0;
        height: 2px; /* Slightly thicker divider */
        background-image: linear-gradient(to right, rgba(0, 0, 0, 0), var(--nutri-accent), rgba(0, 0, 0, 0));
        margin-top: 4rem;
        margin-bottom: 4rem;
    }

    /* --- Article Cards --- */
    .nutri-card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        box-shadow: 0 5px 15px rgba(0,0,0,.08) !important; /* Default shadow */
    }
    .nutri-card:hover {
        transform: translateY(-10px); /* More pronounced lift */
        box-shadow: 0 1.25rem 2.5rem rgba(0,0,0,.15) !important; /* Deeper shadow on hover */
    }

    /* Article Thumbnail Styling */
    .nutri-thumbnail-wrapper {
        height: 200px; /* Consistent height for all image containers */
        overflow: hidden;
        position: relative;
        border-bottom: 3px solid var(--nutri-light); /* Adds a subtle green line below image */
    }
    .nutri-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease; /* Slower, smoother zoom */
    }
    .nutri-card:hover .nutri-thumbnail {
        transform: scale(1.08); /* More pronounced zoom effect */
    }
    .nutri-thumbnail.bg-nutri-light-alt { /* Style for the 'No Image Available' placeholder */
        background-color: var(--nutri-light-alt) !important;
        color: var(--nutri-secondary) !important;
    }

    /* Category Badge Styling */
    .nutri-category-badge {
        font-size: 0.8rem; /* Slightly larger font */
        font-weight: 700;
        letter-spacing: 0.8px; /* More letter spacing */
        text-transform: uppercase; /* Uppercase text */
        z-index: 1;
        opacity: 0.98;
        background-color: var(--nutri-primary) !important; /* Stronger background for badge */
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }

    /* Description Clamping */
    .nutri-description-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Limit text to 3 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 72px; /* Approx height for 3 lines, ensure consistent card height */
        line-height: 1.6; /* Better readability */
    }

    /* Read More Button Styling */
    .btn-outline-nutri {
        font-weight: 600;
        transition: all 0.3s ease;
        border-color: var(--nutri-primary); /* Default border color */
        color: var(--nutri-primary); /* Default text color */
        padding: 0.75rem 1.5rem; /* More generous padding */
        font-size: 1.05rem;
    }
    .btn-outline-nutri:hover {
        background-color: var(--nutri-primary) !important; /* Fill with primary green */
        color: white !important;
        border-color: var(--nutri-primary);
        box-shadow: 0 4px 12px var(--nutri-shadow-green); /* Subtle green shadow on hover */
        transform: translateY(-1px);
    }

    /* No Results Card Styling */
    .nutri-no-result-card {
        border-radius: 1rem; /* More rounded */
        background-color: white;
        border: 2px dashed var(--nutri-accent); /* Dashed accent green border */
        box-shadow: 0 8px 20px rgba(0,0,0,.05);
    }
    .nutri-no-result-card .bi {
        color: var(--nutri-primary) !important; /* Icon color */
    }
    .nutri-no-result-card .text-nutri-primary {
        font-weight: 700;
    }
    .nutri-no-result-card a {
        color: var(--nutri-accent) !important;
        font-weight: 600;
    }
    .nutri-no-result-card a:hover {
        text-decoration: underline !important;
    }

    /* Pagination Styling */
    .pagination .page-item.active .page-link {
        background-color: var(--nutri-primary) !important;
        border-color: var(--nutri-primary) !important;
        color: white !important;
        box-shadow: 0 2px 8px var(--nutri-shadow-green);
    }
    .pagination .page-link {
        color: var(--nutri-primary) !important;
        border-color: var(--nutri-secondary) !important;
        transition: all 0.2s ease;
        border-radius: 0.5rem; /* Rounded pagination buttons */
        margin: 0 0.2rem;
    }
    .pagination .page-link:hover {
        background-color: var(--nutri-light-alt) !important;
        color: var(--nutri-primary) !important;
    }
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        border-radius: 0.5rem !important; /* Ensure first/last buttons are also rounded */
    }
</style>
@endpush

{{-- Custom Scripts specific to this page --}}
@push('scripts')
{{-- AOS (Animate On Scroll) initialization. Make sure these are properly linked. --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800, // animation duration
            once: true,    // whether animation should happen only once - while scrolling down
        });
    });
</script>
@endpush