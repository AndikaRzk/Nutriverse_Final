@extends('layouts.layout')

@section('content')
<section id="create-article" class="py-5 bg-light-green"> {{-- More subtle background --}}
 <div class="container">
   <a href="/articles" class="btn btn-outline-success shadow-sm rounded-pill px-4 py-2 mb-4">
     <i class="bi bi-arrow-left me-2"></i> Kembali
   </a>
 </div>

 <div class="container" style="max-width: 800px;">
   <div class="card shadow-lg rounded-3 border-0">
     <div class="card-body p-5">
       <h1 class="text-center mb-4 text-success"><i class="bi bi-pencil-square me-2"></i> Buat Artikel Baru</h1>

       @if(session('success'))
       <div class="alert alert-success alert-dismissible fade show rounded-pill mb-4" role="alert">
         <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
       @endif

       <form action="/createarticles" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
         @csrf

         <div class="mb-3">
           <label for="author" class="form-label fw-semibold text-muted"><i class="bi bi-person-circle me-2"></i> Penulis</label>
           <input type="text" class="form-control form-control-lg rounded-pill border-success" id="author" name="author" placeholder="Nama Anda..." required>
           <div class="invalid-feedback">Nama penulis wajib diisi.</div>
         </div>

         <div class="mb-3">
           <label for="title" class="form-label fw-semibold text-muted"><i class="bi bi-bookmark-fill me-2"></i> Judul</label>
           <input type="text" class="form-control form-control-lg rounded-pill border-success" id="title" name="title" placeholder="Masukkan judul yang menarik..." required>
           <div class="invalid-feedback">Judul tidak boleh kosong.</div>
         </div>

         <div class="mb-3">
           <label for="content" class="form-label fw-semibold text-muted"><i class="bi bi-journal-richtext me-2"></i> Konten</label>
           <textarea class="form-control rounded-3 border-success" id="content" name="content" rows="6" placeholder="Tulis isi artikel..." required></textarea>
           <div class="invalid-feedback">Konten tidak boleh kosong.</div>
         </div>

         <div class="mb-3">
           <label class="form-label fw-semibold text-muted"><i class="bi bi-image-fill me-2"></i> Gambar Pendukung</label>
           <input type="file" class="form-control rounded-pill border-success" id="fileupload" name="image" accept="image/*">
           <small class="text-muted mt-2 d-block">Format: JPG, PNG, GIF (Max. 5MB)</small>
           <div class="invalid-feedback">Ukuran atau format gambar tidak valid.</div>
         </div>

         <div id="imagePreview" class="mb-3 d-none text-center">
           <img src="#" alt="Preview Gambar" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
           <p class="text-muted mt-2 small">Pratinjau Gambar Artikel Anda</p>
         </div>

         <div class="text-center">
           <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 py-3 shadow-lg">
             <i class="bi bi-upload me-2"></i> Publikasikan Artikel
           </button>
         </div>
       </form>
     </div>
   </div>
 </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
 /* Subtle Green Background */
 .bg-light-green {
   background-color: #f8f9fa; /* A very light gray as a base */
   /* Subtle green overlay for a hint of green */
   background-image: linear-gradient(rgba(240, 255, 240, 0.2), rgba(240, 255, 240, 0.2));
 }

 .btn-outline-success {
   border-color: #28a745;
   color: #28a745;
 }
 .btn-outline-success:hover {
   background-color: #28a745;
   color: white;
 }

 .form-control.border-success:focus {
   border-color: #1e7e34;
   box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
 }
</style>
@endpush

@push('scripts')
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
@endpush