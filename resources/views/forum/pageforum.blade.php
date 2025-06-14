@extends('layouts.layout')

@section('content')
<div class="container-fluid px-0 py-5"> {{-- Added vertical padding to the fluid container --}}
    <div class="row justify-content-center g-0">
        <div class="col-xxl-10 col-xl-11 col-lg-12 col-md-12">
            @if(isset($forum) && count($forum) > 0)
                @foreach($forum as $foru)
                <div class="card forum-post-card shadow-lg border-0 mb-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-white pt-6 px-6 pb-0 border-bottom-0 position-relative">
                        <h1 class="forum-post-title text-center mb-4">{{ $foru->ForumTitle }}</h1>
                        <div class="d-flex align-items-center justify-content-center mb-4 text-muted">
                            @if(isset($creator))
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($creator->name) }}&background=607d8b&color=fff&size=48"
                                     class="avatar me-3 rounded-circle border border-3 border-light-subtle"
                                     alt="Profile">
                                <span class="fw-bold text-dark-emphasis me-2">{{ $creator->name }}</span>
                                <small class="text-secondary-emphasis">&bull; {{ \Carbon\Carbon::parse($foru->CreatedAt)->format('j M, Y \a\t H:i') }}</small>
                            @else
                                <img src="https://ui-avatars.com/api/?name=Anonymous&background=607d8b&color=fff&size=48"
                                     class="avatar me-3 rounded-circle border border-3 border-light-subtle"
                                     alt="Profile">
                                <span class="fw-bold text-dark-emphasis me-2">Anonymous</span>
                                <small class="text-secondary-emphasis">&bull; {{ \Carbon\Carbon::parse($foru->CreatedAt)->format('j M, Y \a\t H:i') }}</small>
                            @endif
                        </div>
                        <div class="header-accent"></div>
                    </div>

                    @if(!empty($foru->ForumImage))
                        <div class="forum-image-wrapper mt-5 mb-5">
                            <img src="{{ asset('storage/forumimages/'.$foru->ForumImage) }}"
                                 class="img-fluid rounded-4 w-100"
                                 alt="Forum Image">
                        </div>
                    @endif

                    <div class="card-body px-6 pb-6 pt-0 forum-post-content">
                        <p class="lead text-dark-emphasis lh-lg">{!! nl2br(e($foru->ForumContent)) !!}</p>
                    </div>

                    <div class="card-footer bg-light-subtle border-top-0 d-flex flex-column flex-md-row justify-content-between p-5 rounded-bottom-5">
                        <a href="/forums" class="btn btn-outline-secondary btn-back-forum mb-3 mb-md-0 me-md-3">
                            <i class="ri-arrow-left-line me-2"></i>Back to All Discussions
                        </a>
                        <button onclick="commentbtn()" class="btn btn-primary-green btn-comment-toggle">
                            <i class="ri-message-line me-2"></i>Join the Conversation {{-- Changed icon to a more modern one --}}
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                <div class="alert alert-warning text-center rounded-4 shadow-sm py-5" role="alert">
                    <h4 class="alert-heading display-5 mb-3"><i class="ri-question-line me-3"></i>Discussion Not Found!</h4>
                    <p class="lead mb-4">Sorry, the discussion you are looking for might have been deleted or is unavailable.</p>
                    <hr class="my-4">
                    <a href="/forums" class="btn btn-primary-green btn-lg">Browse Other Discussions</a>
                </div>
            @endif

            <div class="comments-area mt-6" data-aos="fade-up" data-aos-delay="200">
                <h3 class="comments-heading text-center mb-5 pb-3 border-bottom">
                    <i class="ri-chat-smile-line me-2 text-primary-green"></i>Comments <span class="badge bg-primary-green-light text-primary-green ms-2 comment-count-badge">{{ count($forumposts) ?? 0 }}</span>
                </h3>

                @if(isset($forumposts) && count($forumposts) > 0)
                    <div class="comment-list">
                        @foreach($forumposts as $forump)
                            <div class="comment-item card shadow-sm mb-4 border-0 rounded-4">
                                <div class="card-body d-flex align-items-start p-4">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($forump->username) }}&background=4CAF50&color=fff&size=52"
                                         class="avatar me-4 rounded-circle border border-3 border-success-subtle"
                                         alt="Profile">
                                    <div>
                                        <div class="comment-author fw-bold text-dark-emphasis mb-1">{{ $forump->username }}</div>
                                        <div class="comment-text text-secondary-emphasis mt-1 lh-base">{{ $forump->commentcontent }}</div>
                                        <small class="text-muted mt-2 d-block">
                                            {{ \Carbon\Carbon::parse($forump->CreatedAt)->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center rounded-4 shadow-sm py-4 mt-4" role="alert">
                        <h5 class="alert-heading mb-2"><i class="ri-chat-1-line me-2"></i>No comments yet!</h5>
                        <p class="mb-0">Be the first to share your valuable insights.</p>
                    </div>
                @endif
            </div>

            <div id="comment-form-section" class="comment-form-wrapper mt-6 card shadow-sm border-0 rounded-5 p-5" style="display: none;" data-aos="fade-up" data-aos-delay="300">
                <h4 class="mb-4 text-dark-emphasis fw-bold text-center">Share Your Thoughts</h4>
                @if(Auth::check())
                    <?php $currentuser = Auth::user(); ?>
                    <form action="/forumpost/{{ $forumid }}" method="post" class="comment-submit-form">
                        @csrf
                        <input type="hidden" value="{{ $forumid }}" name="ForumID">
                        <input type="hidden" name="username" value="{{ $currentuser->name }}">
                        <input type="hidden" name="userid" value="{{ $currentuser->id }}">

                        <div class="mb-4">
                            <textarea name="commentcontent" class="form-control" rows="7" placeholder="Type your comment here..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary-green btn-lg w-100">
                            <i class="ri-send-plane-fill me-2"></i>Post Comment
                        </button>
                    </form>
                @else
                    <div class="alert alert-info text-center rounded-4 py-3" role="alert">
                        <p class="mb-0">Please <a href="/login" class="alert-link fw-bold">log in</a> to participate in the discussion.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
    function commentbtn() {
        const commentSection = document.getElementById("comment-form-section");
        if (commentSection.style.display === "none" || commentSection.style.display === "") {
            commentSection.style.display = "block";
            commentSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            commentSection.style.display = "none";
        }
    }

    // Optional: Add AOS initialization if not already in your layout
    document.addEventListener('DOMContentLoaded', () => {
        AOS.init({
            duration: 800,
            easing: 'ease-out-quad',
            once: true, // Only animate once
            mirror: false, // Do not animate on scroll out and scroll back in
        });
    });
</script>

<style>
    /* Google Fonts Import */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400..700;1,400..700&display=swap');

    /* Color Palette & Variables (More Refined) */
    :root {
        --primary-green: #4CAF50; /* A vibrant yet professional green */
        --primary-green-light: #E8F5E9; /* Very light green for subtle accents */
        --primary-green-dark: #388E3C; /* Darker green for active states */

        --text-heading-dark: #212121; /* Almost black for strong headings */
        --text-body-dark: #424242;    /* Dark gray for main content */
        --text-muted-subtle: #757575; /* Soft gray for metadata */

        --background-light: #F8F9FA; /* Off-white for a clean canvas */
        --card-background: #FFFFFF; /* Pure white for card elevation */

        --border-subtle: #ECEFF1; /* Very light border */
        --border-medium: #CFD8DC; /* Slightly more defined border */

        /* Enhanced Shadows for Depth and Modernity (More pronounced) */
        --shadow-sm-custom: 0px 4px 8px rgba(0, 0, 0, 0.05);
        --shadow-md-custom: 0px 10px 20px rgba(0, 0, 0, 0.08);
        --shadow-lg-custom: 0px 20px 40px rgba(0, 0, 0, 0.12);
        --shadow-xl-custom: 0px 30px 60px rgba(0, 0, 0, 0.18);

        /* Border Radius Values (Larger for a softer look) */
        --radius-sm: 0.75rem;
        --radius-md: 1rem;
        --radius-lg: 1.5rem;
        --radius-xl: 2rem; /* Even larger for prominent elements */
        --radius-pill: 50vw;

        /* Spacing Units (For consistent vertical rhythm) */
        --space-1: 0.5rem;
        --space-2: 1rem;
        --space-3: 1.5rem;
        --space-4: 2rem;
        --space-5: 2.5rem;
        --space-6: 3rem;
        --space-7: 3.5rem;
        --space-8: 4rem;

        /* Transitions (Smoother and more deliberate) */
        --transition-elegant: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    body {
        background-color: var(--background-light);
        font-family: 'Inter', sans-serif;
        line-height: 1.8; /* Even more enhanced readability */
        color: var(--text-body-dark);
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        overflow-x: hidden;
    }

    /* --- General Typography & Spacing --- */
    h1, h2, h3, h4, h5, h6 {
        color: var(--text-heading-dark);
        font-weight: 700;
        margin-bottom: var(--space-4);
    }

    /* Specific heading for forum title (Elegant serif font) */
    .forum-post-title {
        font-family: 'Lora', serif; /* A more classic and elegant serif */
        font-size: clamp(2.8rem, 6vw, 4.5rem); /* Responsive font size */
        font-weight: 700;
        line-height: 1.1;
        color: var(--text-heading-dark);
        margin-bottom: var(--space-3);
    }

    p {
        margin-bottom: var(--space-4);
        font-size: 1.15rem; /* Slightly larger base font size */
        color: var(--text-body-dark);
    }

    a {
        text-decoration: none;
        color: var(--primary-green);
        transition: var(--transition-elegant);
    }
    a:hover {
        color: var(--primary-green-dark);
        text-decoration: underline;
    }

    /* --- Container & Layout Adjustments --- */
    .container-fluid {
        padding-left: var(--space-7); /* Generous horizontal padding */
        padding-right: var(--space-7);
        padding-top: var(--space-6);
        padding-bottom: var(--space-6);
    }

    /* --- Main Forum Post Card --- */
    .forum-post-card {
        background-color: var(--card-background);
        border-radius: var(--radius-xl) !important;
        box-shadow: var(--shadow-md-custom);
        transition: var(--transition-elegant);
        overflow: hidden;
        position: relative;
        padding: 0;
        margin-bottom: var(--space-6) !important; /* More space below the main card */
    }
    .forum-post-card:hover {
        transform: translateY(-10px); /* Even more pronounced lift */
        box-shadow: var(--shadow-xl-custom); /* Stronger, deeper shadow on hover */
    }

    .card-header {
        background-color: var(--card-background) !important;
        padding-bottom: 0 !important;
        position: relative;
        padding-left: var(--space-6) !important; /* Larger padding */
        padding-right: var(--space-6) !important;
        padding-top: var(--space-6) !important;
    }
    .card-header .text-muted small {
        color: var(--text-muted-subtle) !important;
        font-size: 0.95rem;
    }
    .card-header .fw-bold {
        color: var(--text-heading-dark) !important;
        font-size: 1.05rem;
    }
    .header-accent {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px; /* Wider accent */
        height: 6px; /* Thicker accent */
        background-color: var(--primary-green);
        border-radius: var(--radius-pill);
        opacity: 0.85;
    }

    .avatar {
        border: 4px solid var(--primary-green-light);
        box-shadow: var(--shadow-sm-custom);
        transition: var(--transition-elegant);
        flex-shrink: 0;
    }
    .avatar:hover {
        transform: scale(1.1); /* More noticeable zoom on avatar hover */
    }

    .forum-image-wrapper {
        padding: 0 var(--space-6);
        margin-top: var(--space-5);
        margin-bottom: var(--space-5);
        overflow: hidden;
        /* Add a subtle pseudo-element border/frame to the image wrapper */
        position: relative;
    }
    .forum-image-wrapper::before {
        content: '';
        position: absolute;
        top: var(--space-2);
        left: calc(var(--space-6) + var(--space-2)); /* Adjust for padding and extra margin */
        right: calc(var(--space-6) + var(--space-2));
        bottom: var(--space-2);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-lg);
        pointer-events: none; /* Allow clicks to pass through */
        z-index: 1; /* Ensure it's above content but below image */
        transition: var(--transition-elegant);
    }
    .forum-post-card:hover .forum-image-wrapper::before {
        border-color: var(--primary-green-light);
        box-shadow: inset 0 0 0 1px var(--primary-green-light); /* Inner shadow on hover */
    }

    .forum-image-wrapper img {
        border-radius: var(--radius-lg);
        height: 550px; /* Even taller image for dramatic effect */
        width: 100%;
        object-fit: cover;
        box-shadow: var(--shadow-md-custom);
        transition: var(--transition-elegant);
        position: relative; /* Needed for z-index to work with pseudo-element */
        z-index: 2;
    }
    .forum-post-card:hover .forum-image-wrapper img {
        transform: scale(1.015); /* Gentle zoom effect */
        box-shadow: var(--shadow-lg-custom);
    }

    @media (max-width: 991.98px) { /* Adjust for larger tablets and smaller desktops */
        .container-fluid {
            padding-left: var(--space-4);
            padding-right: var(--space-4);
        }
        .card-header, .forum-image-wrapper, .card-body, .card-footer {
            padding-left: var(--space-4) !important;
            padding-right: var(--space-4) !important;
        }
        .forum-image-wrapper::before {
            left: calc(var(--space-4) + var(--space-2));
            right: calc(var(--space-4) + var(--space-2));
        }
        .forum-post-title {
            font-size: clamp(2.2rem, 5vw, 3.5rem);
        }
        .forum-image-wrapper img {
            height: 400px;
        }
        .comments-area, .comment-form-wrapper {
            padding: var(--space-6) !important;
        }
    }

    @media (max-width: 767.98px) { /* Mobile adjustments */
        .container-fluid {
            padding-left: var(--space-3);
            padding-right: var(--space-3);
            padding-top: var(--space-4);
            padding-bottom: var(--space-4);
        }
        .card-header, .forum-image-wrapper, .card-body, .card-footer {
            padding-left: var(--space-3) !important;
            padding-right: var(--space-3) !important;
            padding-top: var(--space-4) !important;
            padding-bottom: var(--space-4) !important;
        }
        .forum-image-wrapper::before {
            left: calc(var(--space-3) + var(--space-1));
            right: calc(var(--space-3) + var(--space-1));
            top: var(--space-1);
            bottom: var(--space-1);
        }
        .forum-post-title {
            font-size: clamp(1.8rem, 8vw, 2.8rem);
        }
        .forum-image-wrapper {
            margin-top: var(--space-3);
            margin-bottom: var(--space-3);
        }
        .forum-image-wrapper img {
            height: 280px;
            border-radius: var(--radius-md);
        }
        .card-footer {
            flex-direction: column;
            gap: var(--space-3);
        }
        .btn-back-forum, .btn-comment-toggle {
            width: 100%;
            text-align: center;
        }
        .comments-area, .comment-form-wrapper {
            padding: var(--space-4) !important;
        }
        .comments-heading {
            font-size: 1.8rem;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: var(--space-4) !important;
            padding-bottom: var(--space-3);
        }
        .comments-heading .comment-count-badge {
            margin-top: var(--space-2);
            margin-left: 0 !important;
            font-size: 1rem;
        }
        .comment-item .card-body {
            padding: var(--space-3) !important;
        }
        .comment-item .avatar {
            width: 45px;
            height: 45px;
            margin-right: var(--space-3) !important;
        }
        .comment-author {
            font-size: 1.05rem;
        }
        .comment-text {
            font-size: 1rem;
        }
    }

    .forum-post-content {
        line-height: 1.85; /* Even more line height for content */
        font-size: 1.15rem;
        color: var(--text-body-dark);
        padding-left: var(--space-6); /* Match header padding */
        padding-right: var(--space-6);
        padding-bottom: var(--space-6);
    }

    /* --- Action Buttons (Back & Comment) --- */
    .btn {
        font-weight: 600;
        border-radius: var(--radius-pill);
        padding: 1rem 2.5rem; /* Larger padding */
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-transform: uppercase;
        letter-spacing: 0.05em; /* Slightly more letter spacing */
        font-size: 1.08rem; /* Slightly larger font for buttons */
        box-shadow: var(--shadow-sm-custom);
        transition: var(--transition-elegant);
    }

    .btn-back-forum {
        background-color: transparent;
        border-color: var(--border-medium);
        color: var(--text-body-dark);
    }
    .btn-back-forum:hover {
        background-color: var(--border-medium);
        color: var(--text-heading-dark);
        transform: translateY(-5px); /* More lift */
        box-shadow: var(--shadow-md-custom);
        border-color: var(--border-medium);
    }

    .btn-primary-green {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
        position: relative; /* For the subtle glow effect */
        overflow: hidden;
    }
    .btn-primary-green::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
    }
    .btn-primary-green:hover::before {
        left: 100%;
    }
    .btn-primary-green:hover {
        background-color: var(--primary-green-dark);
        border-color: var(--primary-green-dark);
        transform: translateY(-5px); /* More lift */
        box-shadow: var(--shadow-md-custom);
    }
    .btn-primary-green i {
        animation: pulse-icon 1.8s infinite ease-in-out; /* Slower, more elegant pulse */
    }
    @keyframes pulse-icon {
        0% { transform: scale(1); }
        50% { transform: scale(1.08); } /* Slightly more pronounced pulse */
        100% { transform: scale(1); }
    }

    /* --- Comments Section --- */
    .comments-area {
        background-color: var(--card-background);
        border-radius: var(--radius-xl);
        padding: var(--space-7); /* Generous padding */
        box-shadow: var(--shadow-md-custom);
        margin-top: var(--space-6) !important;
    }

    .comments-heading {
        font-size: clamp(2rem, 4vw, 3rem); /* Responsive font size */
        font-weight: 700;
        color: var(--text-heading-dark);
        padding-bottom: var(--space-3);
        margin-bottom: var(--space-5) !important;
        border-color: var(--border-subtle) !important;
        display: flex;
        align-items: center;
        justify-content: center; /* Center the heading */
        gap: var(--space-2);
    }
    .comments-heading .comment-count-badge {
        font-size: 1.1rem;
        padding: 0.7em 1.2em; /* More padding for badge */
        border-radius: var(--radius-pill);
        background-color: var(--primary-green-light) !important;
        color: var(--primary-green) !important;
        font-weight: 600;
        box-shadow: var(--shadow-sm-custom);
    }

    .comment-list {
        display: grid;
        gap: var(--space-4); /* More space between comments */
    }

    .comment-item {
        background-color: var(--background-light);
        padding: var(--space-4); /* Increased padding */
        border-left: 10px solid var(--primary-green) !important; /* Even stronger accent border */
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm-custom);
        transition: var(--transition-elegant);
        display: flex;
        align-items: flex-start;
    }
    .comment-item:hover {
        transform: translateY(-6px); /* More lift */
        box-shadow: var(--shadow-md-custom) !important;
        border-left-color: var(--primary-green-dark) !important;
    }

    .comment-item .avatar {
        margin-top: 0.3rem;
        width: 60px; /* Larger avatars in comments */
        height: 60px;
        border-color: var(--primary-green-light);
    }

    .comment-author {
        font-size: 1.15rem;
        color: var(--text-heading-dark);
        margin-bottom: var(--space-1);
    }
    .comment-text {
        font-size: 1.08rem;
        color: var(--text-body-dark);
        margin-bottom: var(--space-2);
    }
    .comment-item small {
        font-size: 0.9rem;
        color: var(--text-muted-subtle);
        opacity: 0.95;
    }

    /* --- Comment Form --- */
    .comment-form-wrapper {
        background-color: var(--card-background);
        border-radius: var(--radius-xl) !important;
        box-shadow: var(--shadow-md-custom);
        padding: var(--space-7); /* Consistent generous padding */
        margin-top: var(--space-6) !important;
    }
    .comment-form-wrapper h4 {
        font-size: 2rem;
        margin-bottom: var(--space-4);
    }

    .comment-submit-form textarea {
        border: 1px solid var(--border-medium);
        border-radius: var(--radius-md);
        padding: var(--space-4); /* More padding for textarea */
        font-size: 1.1rem;
        min-height: 200px; /* Taller textarea */
        resize: vertical;
        box-shadow: var(--shadow-sm-custom);
        transition: var(--transition-elegant);
        color: var(--text-body-dark);
        line-height: 1.7;
    }
    .comment-submit-form textarea:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.4rem rgba(76, 175, 80, 0.2); /* Softer, wider focus ring */
        outline: none;
        background-color: #FDFEFC; /* Very subtle light background on focus */
    }

    .comment-submit-form .btn-primary-green {
        padding: 1.3rem 2.8rem; /* Even larger button for form submission */
        font-size: 1.2rem;
        margin-top: var(--space-5);
    }

    /* --- Alert styles --- */
    .alert {
        border-width: 1px;
        padding: var(--space-5) var(--space-6);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm-custom);
        font-size: 1.05rem;
    }
    .alert-warning {
        background-color: #FFFDE7; /* Softer, warmer warning background */
        border-color: #FFECB3;
        color: #FF8F00; /* Richer orange text */
    }
    .alert-info {
        background-color: #E3F2FD; /* Softer, cooler info background */
        border-color: #BBDEFB;
        color: #2196F3; /* Brighter blue text */
    }
    .alert-heading {
        font-weight: 700;
        color: inherit;
    }
    .alert-link {
        font-weight: 700;
        color: inherit;
        text-decoration: underline;
        transition: var(--transition-elegant);
    }
    .alert-link:hover {
        color: var(--text-heading-dark);
    }

    /* --- Utility classes for consistency --- */
    .text-primary-green { color: var(--primary-green) !important; }
    .bg-primary-green-light { background-color: var(--primary-green-light) !important; }
    .text-dark-emphasis { color: var(--text-heading-dark) !important; }
    .text-secondary-emphasis { color: var(--text-body-dark) !important; }
    .text-light-subtle { color: var(--text-muted-subtle) !important; }
    .bg-light-subtle { background-color: #FDFDFD !important; } /* A very subtle off-white for footers */
    .border-light-subtle { border-color: var(--border-subtle) !important; }
    .border-success-subtle { border-color: var(--primary-green-light) !important; }

    /* New spacing utility classes */
    .mb-6 { margin-bottom: var(--space-6) !important; }
    .mt-6 { margin-top: var(--space-6) !important; }
    .pt-6 { padding-top: var(--space-6) !important; }
    .pb-6 { padding-bottom: var(--space-6) !important; }
    .px-6 { padding-left: var(--space-6) !important; padding-right: var(--space-6) !important; }
</style>
@endsection