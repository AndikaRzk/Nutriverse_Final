@extends('layouts.layout')

@section('content')
    {{-- <h1>Dashboard</h1> --}}

    @if(Auth::guard('customers')->check())
                <!-- Jika customers sudah login, tampilkan tombol logout -->
                {{-- <h1>Hallo Customer</h1> --}}
                <section class="home" id="home">
                    <div class="content">
                        <h2> Take Control Of Your <span>Health</span> </h2>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Maiores, voluptatem.</p>
                        <a href="/supplements" class="btn">shop now</a>
                    </div>
                </section>

                <section class="products py-5" id="products">
                    <div class="container">
                        <h1 class="heading text-center mb-4">Our <span>Products</span></h1>

                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                            <div class="carousel-inner">

                                @foreach ($supplements->chunk(3) as $chunkIndex => $chunk)
                                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                                        <div class="row justify-content-center">
                                            @foreach ($chunk as $supplement)
                                                <div class="col-md-4 mb-3">
                                                    <div class="card h-100 text-center">
                                                        <img src="{{ asset('storage/' . ($supplement->image ?? 'default.jpg')) }}" class="card-img-top mx-auto mt-3" style="max-height: 160px; width: auto;" alt="{{ $supplement->name }}">
                                                        <div class="card-body">
                                                            <h5 class="card-title">{{ $supplement->name }}</h5>
                                                            <p class="card-text text-success fw-bold">Rp {{ number_format($supplement->price, 0, ',', '.') }}</p>
                                                            <div class="stars text-warning mb-2">
                                                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                            </div>
                                                            <a href="#" class="btn btn-primary">Add to Cart</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </section>

                <section class="blogs" id="blogs">
                    <h1 class="heading">Our <span>Blogs</span></h1>
                    <div class="box-container">
                        @foreach ($articles as $article)
                            <div class="box">
                                <img src="{{ asset('storage/'. $article->image ?? 'default.jpg') }}" alt="">
                                <div class="content">
                                    <div class="icons">
                                        <a href="#"> <i class="fas fa-user"></i>by {{ $article->author }}</a>
                                        <a href="#"> <i class="fas fa-calendar"></i>{{ $article->created_at->format('jS M, Y') }}</a>
                                    </div>
                                    <h3>{{ $article->title }}</h3>
                                    <p>{{ Str::limit(strip_tags($article->content), 100) }}</p>
                                    <a href="#" class="btn">Read More</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @elseif(Auth::guard('couriers')->check())
                <!-- Jika couriers sudah login, tampilkan tombol logout -->
                <h1>Hallo Courier</h1>
            @elseif(Auth::guard('consultants')->check())
                <!-- Jika consultants sudah login, tampilkan tombol logout -->
                {{-- <h1>Hallo Consultant</h1> --}}
            @else
                <!-- Jika belum login, tampilkan tombol login -->
                {{-- <h1>Selamat datang</h1> --}}
                 <!-- home section start  -->
    <section class="home" id="home">
        <div class="content">
            <h2> Take Control Of Your <span>Health</span> </h2>
            <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Maiores, voluptatem.</p>
            <a href="#" class="btn">shop now</a>
        </div>
    </section>


    <!-- features section start -->
    <section class="service" id="service">
        <h1 class="heading">our <span>service</span></h1>

        <div class="box-container">
            <div class="box">
                <img src="NUTRIVERSE/consult ilust.jpg" width="350" height="350" alt="">
                <h3>Clinical Expertise</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore, vitae! A fugit voluptas totam vitae.</p>
                <a href="#" class="btn">read more</a>
            </div>

            <div class="box">
                <img src="NUTRIVERSE/menu service.jpg" width="350" height="350" alt="">
                <h3>Menu Services</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore, vitae! A fugit voluptas totam vitae.</p>
                <a href="#" class="btn">read more</a>
            </div>

            <div class="box">
                <img src="NUTRIVERSE/vitamin.jpg" width="350" height="350" alt="">
                <h3>Healthy Living</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore, vitae! A fugit voluptas totam vitae.</p>
                <a href="#" class="btn">read more</a>
            </div>
        </div>
    </section>

<!-- Products Section -->
{{-- <section class="products" id="products">
    <h1 class="heading">Our <span>Products</span></h1>
    <div class="swiper product-slider">
        <div class="swiper-wrapper">
            @foreach ($supplements as $supplement)
                <div class="swiper-slide box">
                    <img src="{{ asset('storage/' . ($supplement->image ?? 'default.jpg')) }}" alt="" class="mx-auto max-h-40">
                    <h3>{{ $supplement->name }}</h3>
                    <div class="price">Rp {{ $supplement->price }}</div>
                    <div class="stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <a href="#" class="btn">Add to Cart</a>
                </div>
            @endforeach
        </div>
    </div>
</section> --}}
<!-- Products Section -->
<section class="products py-5" id="products">
    <div class="container">
        <h1 class="heading text-center mb-4">Our <span>Products</span></h1>

        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
            <div class="carousel-inner">

                @foreach ($supplements->chunk(3) as $chunkIndex => $chunk)
                    <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                        <div class="row justify-content-center">
                            @foreach ($chunk as $supplement)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 text-center">
                                        <img src="{{ asset('storage/' . ($supplement->image ?? 'default.jpg')) }}" class="card-img-top mx-auto mt-3" style="max-height: 160px; width: auto;" alt="{{ $supplement->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $supplement->name }}</h5>
                                            <p class="card-text text-success fw-bold">Rp {{ number_format($supplement->price, 0, ',', '.') }}</p>
                                            <div class="stars text-warning mb-2">
                                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <a href="#" class="btn btn-primary">Add to Cart</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>


<!-- User Stats Section -->
<section class="categories" id="users">
    <h1 class="heading">Application <span>Users</span></h1>
    <div class="box-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px;">
        <div class="box" style="background: #fff; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); padding: 30px; text-align: center; width: 250px;">
            {{-- <img src="{{ asset('images/customer-icon.png') }}" alt="Customer Icon" style="width: 80px; height: 80px; margin-bottom: 15px;"> --}}
            <h3>Total Customers</h3>
            <p style="font-size: 1.8rem; font-weight: bold; color: #007bff;">{{ $totalCustomers }}</p>
            {{-- <a href="#" class="btn">view details</a> --}}
        </div>

        <div class="box" style="background: #fff; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); padding: 30px; text-align: center; width: 250px;">
            {{-- <img src="{{ asset('images/courier-icon.png') }}" alt="Courier Icon" style="width: 80px; height: 80px; margin-bottom: 15px;"> --}}
            <h3>Total Couriers</h3>
            <p style="font-size: 1.8rem; font-weight: bold; color: #28a745;">{{ $totalCouriers }}</p>
            {{-- <a href="#" class="btn">view details</a> --}}
        </div>

        <div class="box" style="background: #fff; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); padding: 30px; text-align: center; width: 250px;">
            {{-- <img src="{{ asset('images/consultant-icon.png') }}" alt="Consultant Icon" style="width: 80px; height: 80px; margin-bottom: 15px;"> --}}
            <h3>Total Consultants</h3>
            <p style="font-size: 1.8rem; font-weight: bold; color: #ffc107;">{{ $totalConsultants }}</p>
            {{-- <a href="#" class="btn">view details</a> --}}
        </div>
    </div>
</section>



<!-- Categories Section -->
{{-- <section class="categories" id="categories">
    <h1 class="heading">Product <span>Categories</span></h1>
    <div class="box-container">
        @foreach ($categories as $category)
            <div class="box">
                <img src="{{ asset('default-category.jpg') }}" alt="">
                <h3>{{ $category->category }}</h3>
                <p>Up to 45% off</p>
                <a href="#" class="btn">Shop Now</a>
            </div>
        @endforeach
    </div>
</section> --}}

<!-- Blog Section -->
<section class="blogs" id="blogs">
    <h1 class="heading">Our <span>Blogs</span></h1>
    <div class="box-container">
        @foreach ($articles as $article)
            <div class="box">
                <img src="{{ asset('storage/'. $article->image ?? 'default.jpg') }}" alt="">
                <div class="content">
                    <div class="icons">
                        <a href="#"> <i class="fas fa-user"></i>by {{ $article->author }}</a>
                        <a href="#"> <i class="fas fa-calendar"></i>{{ $article->created_at->format('jS M, Y') }}</a>
                    </div>
                    <h3>{{ $article->title }}</h3>
                    <p>{{ Str::limit(strip_tags($article->content), 100) }}</p>
                    <a href="#" class="btn">Read More</a>
                </div>
            </div>
        @endforeach
    </div>
</section>


            @endif


@endsection