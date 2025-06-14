@extends('layouts.layout')

@section('content')
<section id="create-article" class="py-5 create-article-section">
    <div class="container">
        <a href="/articles" class="btn btn-back-to-articles shadow-sm rounded-pill px-4 py-2 mb-4">
            <i class="bi bi-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="container" style="max-width: 800px;">
        <div class="card shadow-lg rounded-3 border-0 article-form-card">
            <div class="card-body p-5">
                <h1 class="text-center mb-4 article-form-title">
                    <i class="bi bi-pencil-square me-2"></i> Create New Article
                </h1>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-pill mb-4 animated-alert" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="/createarticles" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf

                    <div class="mb-4"> {{-- Increased margin-bottom for better spacing --}}
                        <label for="author" class="form-label fw-semibold text-muted form-label-custom"><i class="bi bi-person-circle me-2"></i> Author</label>
                        <input type="text" class="form-control form-control-lg rounded-pill custom-input" id="author" name="author" placeholder="Your Name..." required>
                        <div class="invalid-feedback">Author name is required.</div>
                    </div>

                    <div class="mb-4"> {{-- Increased margin-bottom --}}
                        <label for="title" class="form-label fw-semibold text-muted form-label-custom"><i class="bi bi-bookmark-fill me-2"></i> Title</label>
                        <input type="text" class="form-control form-control-lg rounded-pill custom-input" id="title" name="title" placeholder="Enter an engaging title..." required>
                        <div class="invalid-feedback">Title cannot be empty.</div>
                    </div>

                    <div class="mb-4"> {{-- Increased margin-bottom --}}
                        <label for="content" class="form-label fw-semibold text-muted form-label-custom"><i class="bi bi-journal-richtext me-2"></i> Content</label>
                        <textarea class="form-control rounded-3 custom-textarea" id="content" name="content" rows="8" placeholder="Write your article content..." required></textarea> {{-- Taller textarea --}}
                        <div class="invalid-feedback">Content cannot be empty.</div>
                    </div>

                    <div class="mb-4"> {{-- Increased margin-bottom --}}
                        <label class="form-label fw-semibold text-muted form-label-custom"><i class="bi bi-image-fill me-2"></i> Supporting Image</label>
                        <input type="file" class="form-control rounded-pill custom-file-input" id="fileupload" name="image" accept="image/*">
                        <small class="text-muted mt-2 d-block">Format: JPG, PNG, GIF (Max. 5MB)</small>
                        <div class="invalid-feedback">Invalid image size or format.</div>
                    </div>

                    <div id="imagePreview" class="mb-4 d-none text-center image-preview-wrapper"> {{-- Added custom class --}}
                        <img src="#" alt="Image Preview" class="img-fluid rounded shadow-sm image-preview-img">
                        <p class="text-muted mt-2 small">Preview of Your Article Image</p>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-submit-article btn-lg rounded-pill px-5 py-3 shadow-lg">
                            <i class="bi bi-upload me-2"></i> Publish Article
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-green: #388E3C; /* A slightly darker, richer green */
        --dark-text: #212121;
        --medium-text: #555555;
        --light-text: #888888;
        --border-color: #E0E0E0;
        --focus-border: #4CAF50; /* A brighter green for focus */
        --shadow-light: rgba(0, 0, 0, 0.08);
        --shadow-medium: rgba(0, 0, 0, 0.12);
        --radius-pill: 50px;
        --radius-rounded: 0.75rem; /* For general rounded elements */
        --transition-ease: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); /* Smoother transition */
    }

    body {
        font-family: 'Poppins', sans-serif;
        color: var(--medium-text);
        background-color: #fcfdff; /* Even lighter, almost white background */
    }

    .create-article-section {
        /* Removed background-color and padding-top/bottom to rely on parent layout */
        padding-top: 6rem; /* Still keep padding for content spacing */
        padding-bottom: 6rem; /* Still keep padding for content spacing */
    }

    .article-form-card {
        border-radius: 1.5rem !important; /* Larger rounded corners for the card */
        box-shadow: 0 15px 30px var(--shadow-medium); /* More pronounced shadow */
        transition: var(--transition-ease);
    }
    .article-form-card:hover {
        box-shadow: 0 20px 40px var(--shadow-medium);
        transform: translateY(-5px);
    }

    .article-form-title {
        font-family: 'Playfair Display', serif; /* Elegant serif font for the title */
        color: var(--primary-green);
        font-weight: 700;
        font-size: 2.8rem; /* Larger title */
        margin-bottom: 2.5rem !important;
        position: relative;
    }
    .article-form-title::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background-color: var(--primary-green);
        margin: 1rem auto 0;
        border-radius: 2px;
    }

    /* Back Button */
    .btn-back-to-articles {
        background-color: white;
        border: 1px solid var(--border-color);
        color: var(--medium-text);
        font-weight: 500;
        transition: var(--transition-ease);
        padding: 0.75rem 1.5rem; /* Adjust padding */
        border-radius: var(--radius-pill) !important;
    }
    .btn-back-to-articles:hover {
        background-color: #E6E6E6;
        color: var(--dark-text);
        border-color: #C2C2C2;
        transform: translateY(-3px);
        box-shadow: 0 5px 10px var(--shadow-light) !important;
    }

    /* Form Labels */
    .form-label-custom {
        color: var(--dark-text) !important;
        font-weight: 600;
        font-size: 1.05rem;
        margin-bottom: 0.75rem;
        display: block;
    }
    .form-label-custom i {
        color: var(--primary-green);
    }

    /* Form Inputs */
    .custom-input,
    .custom-textarea,
    .custom-file-input {
        border: 1px solid var(--border-color);
        padding: 1rem 1.5rem; /* Larger padding for inputs */
        font-size: 1.05rem;
        color: var(--dark-text);
        transition: var(--transition-ease);
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05); /* Subtle inner shadow */
    }

    .custom-input.rounded-pill {
        border-radius: var(--radius-pill) !important;
    }

    .custom-textarea {
        border-radius: var(--radius-rounded) !important;
        line-height: 1.7;
        min-height: 180px; /* Ensure sufficient height */
    }

    .custom-input:focus,
    .custom-textarea:focus,
    .custom-file-input:focus {
        border-color: var(--focus-border);
        box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.2); /* Softer, broader focus ring */
        outline: none;
        background-color: #FAFFFA; /* Very light green on focus */
    }

    /* Image Preview */
    .image-preview-wrapper {
        border: 2px dashed var(--border-color);
        border-radius: var(--radius-rounded);
        padding: 1.5rem;
        margin-top: 1.5rem;
        background-color: #fdfdfd;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .image-preview-img {
        max-height: 250px !important; /* Slightly larger preview image */
        width: auto;
        object-fit: contain;
        border-radius: var(--radius-rounded) !important;
        box-shadow: 0 5px 15px var(--shadow-light);
    }
    .image-preview-wrapper p {
        color: var(--light-text);
        font-size: 0.9rem;
        margin-top: 1rem;
        margin-bottom: 0;
    }

    /* Submit Button */
    .btn-submit-article {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
        font-weight: 600;
        font-size: 1.2rem;
        transition: var(--transition-ease);
        position: relative;
        overflow: hidden;
        z-index: 1;
        padding: 1rem 3rem; /* More prominent button */
        box-shadow: 0 8px 15px rgba(56, 142, 60, 0.3); /* Green tinted shadow */
    }
    .btn-submit-article::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
        z-index: -1;
    }
    .btn-submit-article:hover::before {
        left: 100%;
    }
    .btn-submit-article:hover {
        background-color: #2E7D32; /* Darker green on hover */
        border-color: #2E7D32;
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(56, 142, 60, 0.4);
    }

    /* Alert Styling */
    .animated-alert {
        animation: slideInFromTop 0.5s ease-out;
        border-radius: var(--radius-pill) !important; /* Ensure consistent roundedness */
        background-color: #E8F5E9; /* Light green for success */
        color: #28a745;
        border-color: #A5D6A7;
        font-weight: 500;
    }
    .animated-alert .btn-close {
        font-size: 0.8rem; /* Smaller close button */
        color: #28a745;
    }
    .animated-alert .btn-close:focus {
        box-shadow: none;
    }

    @keyframes slideInFromTop {
        0% { transform: translateY(-30px); opacity: 0; }
        100% { transform: translateY(0); opacity: 1; }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .create-article-section {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }
        .article-form-card {
            border-radius: 1rem !important;
            box-shadow: 0 10px 20px var(--shadow-light);
        }
        .article-form-title {
            font-size: 2rem;
            margin-bottom: 1.5rem !important;
        }
        .article-form-title::after {
            width: 60px;
        }
        .custom-input,
        .custom-textarea,
        .custom-file-input {
            padding: 0.8rem 1.2rem;
            font-size: 1rem;
        }
        .btn-submit-article {
            font-size: 1rem;
            padding: 0.8rem 2rem;
        }
    }
</style>

<script>
    (function() {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    document.getElementById('fileupload').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const previewImg = preview.querySelector('img');
        const file = e.target.files && e.target.files.length > 0 ? e.target.files.item(0) : null;
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            previewImg.src = '#';
            preview.classList.add('d-none');
        }
    });
</script>
@endsection