@extends('layouts.layout')

@section('content')
<div class="container my-5 forum-post-container">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-10">
            @if(isset($forum) && count($forum) > 0)
                @foreach($forum as $foru)
                <div class="card forum-post-card shadow-lg border-0 rounded-4 mb-5" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-white pt-4 px-4 pb-0 border-bottom-0">
                        <h1 class="forum-post-title mb-3">{{ $foru->ForumTitle }}</h1>
                        <div class="d-flex align-items-center mb-3 text-muted">
                            @if(isset($creator))
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($creator->name) }}&background=6c7577&color=fff&size=36"
                                     class="avatar me-2 rounded-circle border border-2 border-light"
                                     alt="Profile">
                                <small class="fw-bold text-dark me-2">{{ $creator->name }}</small>
                                <small class="text-secondary">&bull; {{ \Carbon\Carbon::parse($foru->CreatedAt)->format('j M, Y') }}</small>
                            @else
                                <small class="fw-bold text-dark me-2">Anonymous</small>
                                <small class="text-secondary">&bull; {{ \Carbon\Carbon::parse($foru->CreatedAt)->format('j M, Y') }}</small>
                            @endif
                        </div>
                    </div>

                    @if(!empty($foru->ForumImage))
                        <div class="forum-image-wrapper mt-3">
                            <img src="{{ asset('storage/forumimages/'.$foru->ForumImage) }}"
                                 class="img-fluid rounded-top-0 w-100"
                                 alt="Forum Image">
                        </div>
                    @endif

                    <div class="card-body p-4 p-md-5 forum-post-content">
                        <p class="lead text-dark lh-base">{!! nl2br(e($foru->ForumContent)) !!}</p>
                    </div>

                    <div class="card-footer bg-light border-top-0 d-flex justify-content-between p-4 rounded-bottom-4">
                        <a href="/forums" class="btn btn-outline-secondary btn-back-forum">
                            <i class="ri-arrow-left-line me-2"></i>Kembali ke Forum
                        </a>
                        <button onclick="commentbtn()" class="btn btn-primary-green btn-comment-toggle">
                            <i class="ri-chat-3-line me-2"></i>Komentar
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                <div class="alert alert-warning text-center rounded-3 shadow-sm py-4" role="alert">
                    <h4 class="alert-heading"><i class="ri-question-line me-2"></i>Forum Tidak Ditemukan!</h4>
                    <p>Maaf, diskusi yang Anda cari mungkin telah dihapus atau tidak tersedia.</p>
                    <hr>
                    <a href="/forums" class="btn btn-primary-green">Kembali ke Daftar Forum</a>
                </div>
            @endif

            <div class="comments-area mt-5" data-aos="fade-up" data-aos-delay="200">
                <h3 class="comments-heading mb-4 pb-2 border-bottom">
                    <i class="ri-chat-smile-line me-2 text-primary-green-light"></i>Komentar <span class="badge bg-secondary-subtle text-secondary ms-2">{{ count($forumposts) ?? 0 }}</span>
                </h3>

                @if(isset($forumposts) && count($forumposts) > 0)
                    <div class="comment-list">
                        @foreach($forumposts as $forump)
                            <div class="comment-item card shadow-sm mb-3 border-0 rounded-3">
                                <div class="card-body d-flex align-items-start p-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($forump->username) }}&background=28a745&color=fff&size=40"
                                         class="avatar me-3 rounded-circle border border-2 border-light"
                                         alt="Profile">
                                    <div>
                                        <div class="comment-author fw-bold text-dark">{{ $forump->username }}</div>
                                        <div class="comment-text text-secondary mt-1">{{ $forump->commentcontent }}</div>
                                        <small class="text-muted mt-2 d-block">
                                            {{ \Carbon\Carbon::parse($forump->CreatedAt)->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted py-3">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                @endif
            </div>

            <div id="comment-form-section" class="comment-form-wrapper mt-5 card shadow-sm border-0 rounded-4 p-4" style="display: none;" data-aos="fade-up" data-aos-delay="300">
                <h4 class="mb-4 text-dark fw-bold">Tinggalkan Komentar Anda</h4>
                @if(Auth::check())
                    <?php $currentuser = Auth::user(); ?>
                    <form action="/forumpost/{{ $forumid }}" method="post" class="comment-submit-form">
                        @csrf
                        <input type="hidden" value="{{ $forumid }}" name="ForumID">
                        <input type="hidden" name="username" value="{{ $currentuser->name }}">
                        <input type="hidden" name="userid" value="{{ $currentuser->id }}">

                        <div class="mb-3">
                            <textarea name="commentcontent" class="form-control" rows="4" placeholder="Tulis komentar Anda di sini..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary-green btn-lg w-100">
                            <i class="ri-send-plane-fill me-2"></i>Kirim Komentar
                        </button>
                    </form>
                @else
                    <div class="alert alert-info text-center rounded-3" role="alert">
                        <p class="mb-0">Silakan <a href="/login" class="alert-link fw-bold">login</a> untuk menambahkan komentar.</p>
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
            commentSection.scrollIntoView({ behavior: 'smooth', block: 'center' }); // Smooth scroll to center
        } else {
            commentSection.style.display = "none";
        }
    }
</script>

<style>
    :root {
        --main-green: #28a745; /* Your specified green */
        --main-green-light: #e6ffe6; /* A very light tint of the main green */
        --main-green-dark: #1e7e34; /* A darker shade for hover states */
        --heading-color: #2d3748;
        --text-color: #4a5568;
        --light-bg: #f7fafc;
        --card-bg: #ffffff;
        --border-color: #edf2f7;
        --box-shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.08), 0 1px 2px 0 rgba(0, 0, 0, 0.04);
        --box-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --box-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.12), 0 4px 6px -2px rgba(0, 0, 0, 0.08);
        --border-radius-lg: 0.75rem;
        --border-radius-xl: 1rem;
        --transition-ease: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        background-color: var(--light-bg);
        font-family: 'Inter', sans-serif; /* Recommended, ensure linked in layout */
    }

    /* Main Forum Post Card */
    .forum-post-card {
        background-color: var(--card-bg);
        border-radius: var(--border-radius-xl) !important;
        box-shadow: var(--box-shadow-md);
        transition: var(--transition-ease);
    }
    .forum-post-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--box-shadow-lg);
    }

    .forum-post-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--heading-color);
        line-height: 1.3;
    }

    .avatar {
        border: 2px solid var(--border-color); /* Subtle border for avatars */
    }

    .forum-image-wrapper {
        padding: 0 40px; /* Padding for the image to not stretch edge to edge */
        margin-bottom: 20px;
    }
    .forum-image-wrapper img {
        border-radius: var(--border-radius-lg);
        height: 400px; /* Fixed height for consistency */
        object-fit: cover;
    }

    @media (max-width: 767.98px) {
        .forum-image-wrapper {
            padding: 0 20px;
        }
        .forum-image-wrapper img {
            height: 250px;
        }
        .forum-post-title {
            font-size: 2rem;
        }
    }

    .forum-post-content {
        line-height: 1.7;
        font-size: 1.05rem;
        color: var(--text-color);
    }

    /* Action Buttons (Back & Comment) */
    .btn-back-forum {
        background-color: transparent;
        border-color: var(--border-color);
        color: var(--text-color);
        font-weight: 500;
        padding: 0.7rem 1.5rem;
        border-radius: 50px;
        transition: var(--transition-ease);
    }
    .btn-back-forum:hover {
        background-color: var(--border-color);
        color: var(--heading-color);
        transform: translateY(-2px);
    }

    .btn-primary-green {
        background-color: var(--main-green);
        border-color: var(--main-green);
        color: white;
        font-weight: 600;
        padding: 0.7rem 1.5rem;
        border-radius: 50px;
        transition: var(--transition-ease);
        box-shadow: var(--box-shadow-sm);
    }
    .btn-primary-green:hover {
        background-color: var(--main-green-dark);
        border-color: var(--main-green-dark);
        transform: translateY(-2px);
        box-shadow: var(--box-shadow-md);
    }

    /* Comments Section */
    .comments-area {
        background-color: var(--card-bg);
        border-radius: var(--border-radius-xl);
        padding: 40px;
        box-shadow: var(--box-shadow-md);
    }

    .comments-heading {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--heading-color);
        padding-bottom: 15px;
        margin-bottom: 30px !important;
        border-color: var(--border-color) !important;
    }
    .comments-heading .badge {
        font-size: 1rem;
        padding: 0.5em 0.8em;
        border-radius: 50px;
    }

    .comment-item {
        background-color: var(--light-bg);
        padding: 15px 20px;
        border-left: 4px solid var(--main-green-light) !important; /* Accent border */
        margin-bottom: 15px;
        transition: var(--transition-ease);
    }
    .comment-item:hover {
        transform: translateY(-3px);
        box-shadow: var(--box-shadow-md) !important;
    }

    .comment-author {
        font-size: 1.05rem;
        color: var(--heading-color);
    }
    .comment-text {
        font-size: 1rem;
        color: var(--text-color);
    }
    .comment-item small {
        font-size: 0.85rem;
        color: var(--text-color);
    }

    /* Comment Form */
    .comment-form-wrapper {
        background-color: var(--card-bg);
        border-radius: var(--border-radius-xl) !important;
        box-shadow: var(--box-shadow-md);
    }

    .comment-submit-form textarea {
        border: 1px solid var(--border-color);
        border-radius: var(--border-radius-lg);
        padding: 1rem;
        font-size: 1rem;
        min-height: 120px;
        resize: vertical;
        box-shadow: var(--box-shadow-sm);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .comment-submit-form textarea:focus {
        border-color: var(--main-green);
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.15); /* Focus ring with your specific green */
        outline: none;
    }

    .comment-submit-form .btn-primary-green {
        padding: 0.9rem 1.5rem;
        font-size: 1.1rem;
    }
</style>