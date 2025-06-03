@extends('layouts.layout')

@section('content')
<section class="forum-section py-5" id="forums">
    <div class="container modern-container">
        <h1 class="section-heading text-center mb-5" data-aos="fade-down" data-aos-delay="50">forum <span>discussions</span></h1>

        <div class="d-flex justify-content-between align-items-center mb-5 flex-column flex-md-row">
            <a href="/createforum" class="btn btn-primary-green btn-create-forum mb-3 mb-md-0" data-aos="fade-right" data-aos-delay="100">
                <i class="ri-add-line me-2"></i> Create New Forum
            </a>

            <form action="/forums" method="POST" data-aos="fade-left" data-aos-delay="150" class="search-form-elevated">
                @csrf
                <div class="input-group input-group-lg shadow-sm rounded-pill overflow-hidden">
                    <input type="search" name="Query" id="search-box-elevated" class="form-control border-0 ps-4 pe-2" placeholder="Cari diskusi yang Anda inginkan..." value="{{ old('Query') }}">
                    <button class="btn btn-search-green" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="row g-4 forum-grid">
            @if($forums->count() > 0)
                @foreach ($forums as $forum)
                    <div class="col-12" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="card forum-card h-100">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    <div class="col-md-auto forum-thumbnail-col">
                                        @if ($forum->ForumImage && Storage::exists('forumimages/' . $forum->ForumImage))
                                            <img src="{{ Storage::url('forumimages/' . $forum->ForumImage) }}"
                                                 alt="{{ $forum->ForumTitle }}"
                                                 class="forum-thumbnail img-fluid">
                                        @else
                                            <img src="{{ asset('images/default-forum-thumbnail.jpg') }}" {{-- Make sure this path is correct! --}}
                                                 alt="Default Image"
                                                 class="forum-thumbnail img-fluid">
                                        @endif
                                    </div>
                                    <div class="col-md">
                                        <div class="p-4 d-flex flex-column h-100">
                                            <div class="forum-meta mb-2">
                                                <small class="text-muted d-block mb-1">
                                                    <i class="fas fa-user-circle me-1 text-primary-green-light"></i> {{ $forum->customer->name ?? 'Anonymous' }}
                                                </small>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1 text-primary-green-light"></i> {{ \Carbon\Carbon::parse($forum->CreatedAt)->format('j M, Y') }}
                                                </small>
                                            </div>
                                            <h5 class="card-title forum-title-clamp mb-2">{{ $forum->ForumTitle }}</h5>
                                            <p class="card-text forum-content-clamp text-secondary mb-3">
                                                {{ Str::words(strip_tags($forum->ForumContent), 25, '...') }}
                                            </p>
                                            <div class="forum-actions mt-auto d-flex justify-content-between align-items-center pt-2">
                                                <a href="{{ url('/forumpost/' . $forum->ForumID) }}" class="btn btn-outline-primary-green btn-sm read-more-btn">
                                                    Read More <i class="fas fa-arrow-right ms-2"></i>
                                                </a>
                                                @if ($forum->ForumCreator == Auth::guard('customers')->id())
                                                    <form action="{{ url('/deleteforum/' . $forum->ForumID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this forum?');" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm delete-btn">
                                                            <i class="fas fa-trash-alt me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-info text-center py-5 shadow-sm rounded-4">
                        <p class="mb-0 fs-5 text-muted">
                            <i class="fas fa-info-circle me-2"></i> No forum discussions to display yet. Be the first to create one!
                        </p>
                        <a href="/createforum" class="btn btn-primary-green mt-3">Start a Discussion</a>
                    </div>
                </div>
            @endif
        </div>

        @if($forums->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $forums->links('vendor.pagination.bootstrap-5') }}
            </div>
        @endif
    </div>
</section>

{{-- Custom CSS for Forum Section --}}
<style>
    :root {
        --primary-green: #38b2ac; /* A calming, modern teal-green */
        --primary-green-light: #81e6d9; /* Lighter shade for accents */
        --primary-green-dark: #2c7a7b; /* Darker shade for hover/active */
        --heading-color: #2d3748; /* Darker, sophisticated grey for headings */
        --text-color: #4a5568; /* General text color */
        --light-bg: #f7fafc; /* Very light background for the section */
        --card-bg: #ffffff; /* Pure white for cards */
        --border-color: #edf2f7; /* Subtle border color */
        --box-shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --box-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --box-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --border-radius-xl: 1rem; /* More rounded corners */
        --border-radius-lg: 0.75rem;
        --transition-ease: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        font-family: 'Inter', sans-serif; /* A more modern sans-serif font */
    }

    /* .forum-section {
        background-color: var(--light-bg);
    } */

    .modern-container {
        max-width: 1000px; /* Constrain width for better readability */
    }

    .section-heading {
        color: var(--heading-color);
        font-size: 3.5rem; /* Slightly larger */
        font-weight: 800; /* Extra bold */
        text-transform: capitalize;
        position: relative;
        padding-bottom: 1.25rem;
    }

    .section-heading span {
        color: var(--primary-green);
    }

    .section-heading::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px; /* Slightly wider underline */
        height: 5px; /* Thicker underline */
        background-color: var(--primary-green);
        border-radius: 5px;
    }

    /* Create Forum Button */
    .btn-primary-green {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
        padding: 0.85rem 1.8rem;
        border-radius: var(--border-radius-lg);
        font-weight: 600;
        transition: var(--transition-ease);
        box-shadow: var(--box-shadow-md);
    }

    .btn-primary-green:hover {
        background-color: var(--primary-green-dark);
        border-color: var(--primary-green-dark);
        transform: translateY(-3px);
        box-shadow: var(--box-shadow-lg);
    }

    /* Elevated Search Form */
    .search-form-elevated {
        min-width: 280px; /* Ensure it doesn't get too small */
        max-width: 450px; /* Limit its max width */
        width: 100%;
    }

    .search-form-elevated .input-group-lg .form-control {
        height: 55px; /* Taller input */
        padding-left: 1.5rem;
        font-size: 1.1rem;
        border: none;
        background-color: var(--card-bg); /* Match card background */
        box-shadow: none; /* Remove default focus shadow */
    }

    .search-form-elevated .input-group-lg .form-control:focus {
        outline: none;
        box-shadow: 0 0 0 0.25rem rgba(56, 178, 172, 0.25); /* Subtle green focus ring */
    }

    .btn-search-green {
        background-color: var(--primary-green-light); /* Lighter green for button background */
        color: var(--primary-green-dark); /* Darker green for icon */
        border: none;
        padding: 0 1.2rem;
        transition: var(--transition-ease);
        font-size: 1.25rem;
    }

    .btn-search-green:hover {
        background-color: var(--primary-green);
        color: white;
    }

    /* Forum Card Styling */
    .forum-card {
        border: none;
        border-radius: var(--border-radius-xl); /* Even more rounded */
        box-shadow: var(--box-shadow-md);
        transition: var(--transition-ease);
        background-color: var(--card-bg);
        overflow: hidden;
    }

    .forum-card:hover {
        transform: translateY(-7px); /* More pronounced lift on hover */
        box-shadow: var(--box-shadow-lg); /* Deeper shadow on hover */
    }

    .forum-thumbnail-col {
        flex-shrink: 0;
        width: 200px; /* Fixed width for thumbnail on desktop */
        height: 180px; /* Fixed height */
    }

    .forum-thumbnail {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: var(--border-radius-xl) 0 0 var(--border-radius-xl); /* Rounded left corners only */
        transition: transform 0.4s ease;
    }

    .forum-card:hover .forum-thumbnail {
        transform: scale(1.05); /* Zoom effect on hover */
    }

    @media (max-width: 767.98px) {
        .forum-thumbnail-col {
            width: 100%;
            height: 200px; /* Taller on mobile */
        }
        .forum-thumbnail {
            border-radius: var(--border-radius-xl) var(--border-radius-xl) 0 0; /* Rounded top corners only */
        }
        .forum-card .row.g-0 {
            flex-direction: column;
        }
    }

    .forum-meta small {
        font-size: 0.9rem;
        color: var(--text-color) !important;
        font-weight: 500;
    }

    .forum-meta i {
        color: var(--primary-green-light); /* Accent color for icons */
        font-size: 1rem;
    }

    .card-title.forum-title-clamp {
        font-size: 1.6rem; /* Larger title */
        font-weight: 700;
        color: var(--heading-color);
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card-text.forum-content-clamp {
        font-size: 1.05rem;
        color: var(--text-color) !important;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .read-more-btn, .delete-btn {
        font-size: 0.9rem;
        padding: 0.6rem 1.4rem;
        border-radius: 50px;
        font-weight: 600;
        transition: var(--transition-ease);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-outline-primary-green {
        color: var(--primary-green);
        border-color: var(--primary-green);
        background-color: transparent;
    }

    .btn-outline-primary-green:hover {
        background-color: var(--primary-green);
        color: white;
        box-shadow: var(--box-shadow-sm);
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
        background-color: transparent;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
        box-shadow: var(--box-shadow-sm);
    }

    /* Empty State Alert */
    .alert-info {
        background-color: #e0f2f1; /* Light green tint */
        color: #2c7a7b; /* Darker green text */
        border: 1px solid #a7d9d9;
        box-shadow: var(--box-shadow-sm);
    }

    .alert-info .btn-primary-green {
        padding: 0.6rem 1.2rem;
        font-size: 0.95rem;
    }

    /* Pagination Styling */
    .pagination .page-item .page-link {
        color: var(--primary-green);
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        margin: 0 4px;
        transition: var(--transition-ease);
        font-weight: 600;
    }

    .pagination .page-item .page-link:hover {
        background-color: var(--primary-green-light);
        color: var(--primary-green-dark);
        border-color: var(--primary-green-light);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
        box-shadow: var(--box-shadow-sm);
    }

    .pagination .page-item.disabled .page-link {
        color: #adb5bd;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
</style>
@endsection