@extends('layouts.layout')

@section('content')

<section id="create-forum" class="py-5">
    <div class="container mb-4">
        <a href="/forums"
           class="btn back-btn px-4 py-2 d-inline-flex align-items-center animate__animated animate__fadeInLeft"
           style="
             border-radius: 0.75rem;
             font-weight: 600;
             box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
             transition: all 0.3s ease;
             color: var(--green-main-dark);
             border-color: var(--green-light-border);
             background-color: white;
           ">
            <i class="ri-arrow-left-s-line me-2"></i> Back to Forums
        </a>
    </div>

    <div class="container forum-card" style="
        max-width: 800px;
        background-color: white;
        border-radius: 1.75rem; /* Even more rounded corners for a super modern, soft feel */
        padding: 4.5rem; /* Increased padding for luxurious spacing */
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12); /* Deeper, more elegant shadow */
        animation: fadeInScale 0.8s ease-out; /* Slower, more graceful animation */
      ">

        <h1 class="text-center mb-5 pb-3" style="
            color: var(--green-main);
            font-weight: 800;
            font-size: 3.4rem; /* Larger, more impactful title */
            letter-spacing: -0.05em; /* Tighter spacing for a sleek, premium look */
            position: relative;
            ">
            <i class="ri-discuss-line me-3 align-middle"></i> Create New Forum Topic
        </h1>

        <form action="/createforum" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf

            @if(null !== Session::get("user_data"))
            <input type="hidden" id="userid" name="id" value="{{ Session::get('user_data')->id }}">
            @endif

            <div class="mb-4">
                <label for="title" class="form-label fw-bold text-muted mb-2">
                    <i class="ri-question-answer-line me-2" style="color: var(--green-accent);"></i> Discussion Title
                </label>
                <input type="text"
                       class="form-control form-control-lg forum-input"
                       id="title"
                       name="title"
                       placeholder="Example: Innovative Ideas for Renewable Energy..."
                       required>
                <div class="invalid-feedback text-danger fw-semibold">
                    The discussion title cannot be empty.
                </div>
            </div>

            <div class="mb-4">
                <label for="content" class="form-label fw-bold text-muted mb-2">
                    <i class="ri-article-line me-2" style="color: var(--green-accent);"></i> Topic Details
                </label>
                <textarea class="form-control forum-input"
                               id="content"
                               name="content"
                               rows="14"
                               placeholder="Explain your questions, ideas, or discussion points thoroughly here..."
                               required></textarea>
                <div class="invalid-feedback text-danger fw-semibold">
                    The topic content cannot be empty.
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-muted mb-2">
                    <i class="ri-image-fill me-2" style="color: var(--green-accent);"></i> Upload Image (Optional)
                </label>
                <div class="input-group">
                    <input type="file"
                           class="form-control forum-input"
                           id="fileupload"
                           name="ForumImage"
                           accept="image/*">
                </div>
                <small class="text-muted mt-2 d-block">
                    Supported formats: JPG, PNG, GIF (Max. 5MB).
                </small>
            </div>

            <div id="imagePreview" class="mb-5 d-none text-center p-4 border rounded-lg" style="border-color: var(--green-light-border); background-color: #f8fcf8;">
                <img src="" alt="Forum Image Preview" class="img-fluid rounded-lg shadow-sm" style="max-height: 400px; object-fit: cover; width: 100%;">
            </div>

            <div class="text-center mt-5">
                <button type="submit"
                                class="btn btn-lg btn-publish px-5 py-3 animate__animated animate__pulse animate__infinite"
                                style="
                                  background-color: var(--green-main);
                                  border: none;
                                  color: white;
                                  border-radius: 0.8rem;
                                  font-weight: 700;
                                  font-size: 1.55rem;
                                  letter-spacing: 0.05em;
                                  box-shadow: 0 15px 35px var(--green-shadow);
                                  transition: all 0.3s ease;
                                ">
                    <i class="ri-send-plane-2-fill me-2"></i> Publish Discussion
                </button>
            </div>
        </form>
    </div>
</section>

<style>
    /* Custom CSS Variables for Green Theme */
    :root {
        --green-main: #2ECC71; /* A vibrant, fresh green */
        --green-main-dark: #27AE60; /* Darker green for hover */
        --green-accent: #58D68D; /* Lighter, more active green for icons */
        --green-light-border: #A9DFBF; /* Soft green for borders */
        --green-shadow: rgba(46, 204, 113, 0.4); /* Green shadow with transparency */
        --text-muted: #6c757d;
        --input-border-color: #e9ecef; /* Very light grey for input borders */
        --input-focus-shadow: rgba(46, 204, 113, 0.2);
    }

    /* General Styling for Form Inputs */
    .forum-input {
        border: 1px solid var(--input-border-color);
        border-radius: 0.8rem; /* Matches button and card rounding */
        padding: 1.1rem 1.35rem; /* Slightly more generous padding */
        transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        box-shadow: 0 3px 10px rgba(0,0,0,0.06); /* Slightly more prominent initial shadow for depth */
    }

    /* Custom input focus styles */
    .forum-input:focus {
        border-color: var(--green-main) !important;
        box-shadow: 0 0 0 0.25rem var(--input-focus-shadow) !important; /* Slightly larger focus shadow */
        transform: translateY(-3px); /* More noticeable lift on focus */
    }

    /* Back button hover effect */
    .back-btn:hover {
        background-color: #f0f0f0 !important; /* Gentle grey hover for back button */
        color: var(--green-main) !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important; /* Stronger shadow on hover */
        transform: translateY(-4px) scale(1.02); /* More pronounced lift and scale */
    }

    /* Submit button hover effect */
    .btn-publish:hover {
        background-color: var(--green-main-dark) !important;
        box-shadow: 0 20px 45px var(--green-shadow) !important; /* Even more pronounced shadow on hover */
        transform: translateY(-7px) scale(1.05); /* Stronger lift and scale */
    }

    /* Custom Animations (if using Animate.css, ensure it's linked) */
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.93) translateY(40px); /* Starts from further down and smaller */
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Modern heading underline effect */
    .forum-card h1::after {
        content: '';
        display: block;
        width: 120px; /* Longer underline for significant emphasis */
        height: 7px; /* Thicker underline */
        background: linear-gradient(to right, var(--green-accent), var(--green-main));
        margin: 20px auto 0; /* More space below title */
        border-radius: 7px;
        animation: drawLine 1s ease-out forwards; /* Slower, more elegant animation */
    }

    @keyframes drawLine {
        from {
            width: 0;
            opacity: 0;
        }
        to {
            width: 120px;
            opacity: 1;
        }
    }
</style>

<script>
    // Form validation
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

    // Image preview
    document.getElementById('fileupload').addEventListener('change', function(e) {
        const previewDiv = document.getElementById('imagePreview');
        const previewImg = previewDiv.querySelector('img');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewDiv.classList.remove('d-none');
                previewDiv.classList.add('animate__animated', 'animate__fadeIn');
            }
            reader.readAsDataURL(file);
        } else {
            previewDiv.classList.add('d-none');
            previewDiv.classList.remove('animate__animated', 'animate__fadeIn');
            previewImg.src = '';
        }
    });
</script>

@endsection