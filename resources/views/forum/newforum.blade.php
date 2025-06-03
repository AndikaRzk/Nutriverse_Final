@extends('layouts.layout')

@section('content')

<section id="create-forum" class="py-5" style="background: linear-gradient(135deg, #f9f9f9 0%, #f0f0f0 100%);">
    <div class="container">
        <a href="/forums"
           class="btn back-btn px-4 py-2 mb-4 d-inline-flex align-items-center animate__animated animate__fadeInLeft"
           style="
             border-radius: 0.75rem;
             font-weight: 600;
             box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
             transition: all 0.3s ease;
             color: var(--green-main-dark); /* Darker green text */
             border-color: var(--green-light-border); /* Lighter green border */
             background-color: white;
           ">
            <i class="ri-arrow-left-line me-2"></i>Kembali
        </a>
    </div>

    <div class="container" style="
        max-width: 800px;
        background-color: white;
        border-radius: 1rem; /* More rounded corners for a softer look */
        padding: 3rem; /* Increased padding for more breathing room */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Deeper, softer shadow */
        animation: fadeInScale 0.5s ease-out; /* Custom animation for the main card */
      ">

        <h1 class="text-center mb-5" style="
            color: var(--green-main); /* Main green color */
            font-weight: 700; /* Bolder font weight */
            font-size: 2.8rem; /* Slightly larger font size */
            letter-spacing: -0.02em; /* Subtle letter spacing for a modern touch */
           ">
            <i class="ri-leaf-line me-3 align-middle"></i>Buat Forum Baru {{-- Changed icon to a leaf for a fresh, green theme --}}
        </h1>

        <form action="/createforum" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf

            @if(null !== Session::get("user_data"))
            <input type="hidden" id="userid" name="id" value="{{ Session::get('user_data')->id }}">
            @endif

            <div class="mb-4">
                <label for="title" class="form-label fw-bold text-muted mb-2">
                    <i class="ri-edit-2-line me-2" style="color: var(--green-accent);"></i>Judul Forum {{-- Changed icon to edit for title --}}
                </label>
                <input type="text"
                       class="form-control form-control-lg forum-input"
                       id="title"
                       name="title"
                       placeholder="Contoh: Diskusi Mengenai Keberlanjutan Lingkungan..." {{-- More specific example placeholder --}}
                       required>
                <div class="invalid-feedback text-danger fw-semibold">
                    Judul forum tidak boleh kosong.
                </div>
            </div>

            <div class="mb-4">
                <label for="content" class="form-label fw-bold text-muted mb-2">
                    <i class="ri-chat-1-line me-2" style="color: var(--green-accent);"></i>Konten Forum {{-- Changed icon to chat for content --}}
                </label>
                <textarea class="form-control forum-input"
                          id="content"
                          name="content"
                          rows="8"
                          placeholder="Jelaskan topik diskusi Anda secara detail dan provokatif..."
                          required></textarea>
                <div class="invalid-feedback text-danger fw-semibold">
                    Konten forum tidak boleh kosong.
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-muted mb-2">
                    <i class="ri-image-add-line me-2" style="color: var(--green-accent);"></i>Gambar Pendukung (Opsional) {{-- Changed icon to image-add --}}
                </label>
                <div class="input-group">
                    <input type="file"
                           class="form-control forum-input"
                           id="fileupload"
                           name="ForumImage"
                           accept="image/*">
                </div>
                <small class="text-muted mt-2 d-block">
                    Format yang didukung: JPG, PNG, GIF (Max. 5MB). Unggah gambar untuk memperkaya forum Anda.
                </small>
            </div>

            <div id="imagePreview" class="mb-5 d-none text-center">
                <img src="" alt="Pratinjau Gambar Forum" class="img-fluid rounded-lg shadow-sm" style="max-height: 250px; border: 1px solid var(--green-light-border); object-fit: cover;">
            </div>

            <div class="text-center">
                <button type="submit"
                        class="btn btn-lg btn-publish px-5 py-3 animate__animated animate__pulse animate__infinite" {{-- Added custom class for submit button, pulse animation --}}
                        style="
                          background-color: var(--green-main); /* Main green */
                          border: none;
                          color: white;
                          border-radius: 0.75rem;
                          font-weight: 700;
                          font-size: 1.25rem;
                          letter-spacing: 0.02em;
                          box-shadow: 0 8px 20px var(--green-shadow); /* Green shadow */
                          transition: all 0.3s ease;
                        ">
                    <i class="ri-send-plane-fill me-2"></i>
                    Publikasikan Forum
                </button>
            </div>
        </form>
    </div>
</section>

<style>
    /* Custom CSS Variables for Green Theme */
    :root {
        --green-main: #4CAF50; /* A vibrant green */
        --green-main-dark: #388E3C; /* Darker green for hover/accents */
        --green-accent: #66BB6A; /* A slightly lighter, more vibrant green for icons */
        --green-light-border: #A5D6A7; /* Light green for borders */
        --green-shadow: rgba(76, 175, 80, 0.3); /* Green shadow with transparency */
        --text-muted: #6c757d;
        --input-border-color: #dcdcdc; /* Keep original light border for non-focused */
        --input-focus-shadow: rgba(76, 175, 80, 0.25); /* Green shadow for focus */
    }

    /* General Styling for Form Inputs */
    .forum-input {
        border: 1px solid var(--input-border-color); /* Lighter default border */
        border-radius: 0.75rem; /* Matches container rounding */
        padding: 1rem 1.25rem; /* Slightly more padding */
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    /* Custom input focus styles */
    .forum-input:focus {
        border-color: var(--green-main) !important; /* Green border on focus */
        box-shadow: 0 0 0 0.2rem var(--input-focus-shadow) !important;
    }

    /* Back button hover effect */
    .back-btn:hover {
        background-color: #e0e6ed !important; /* Lighter hover for back button */
        color: var(--green-main) !important; /* Green text on hover */
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12) !important;
        transform: translateY(-2px); /* Slight lift */
    }

    /* Submit button hover effect */
    .btn-publish:hover {
        background-color: var(--green-main-dark) !important; /* Slightly darker green on hover */
        box-shadow: 0 12px 25px var(--green-shadow) !important; /* Enhanced shadow on hover */
        transform: translateY(-3px); /* Slight lift effect */
    }

    /* Custom Animations (if using Animate.css, ensure it's linked) */
    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.98) translateY(10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
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
                previewDiv.classList.add('animate__animated', 'animate__fadeIn'); // Add animation
            }
            reader.readAsDataURL(file);
        } else {
            previewDiv.classList.add('d-none');
            previewDiv.classList.remove('animate__animated', 'animate__fadeIn'); // Remove animation class if hidden
            previewImg.src = ''; // Clear image source
        }
    });

    // Input focus/blur animations (refactored using the custom class)
    const inputs = document.querySelectorAll('.forum-input'); // Select by new custom class
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.classList.add('shadow-input-focus'); // Example: add a class for specific JS-driven effects
        });

        input.addEventListener('blur', () => {
            input.classList.remove('shadow-input-focus');
        });
    });
</script>

@endsection