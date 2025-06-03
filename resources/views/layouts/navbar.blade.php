{{-- <nav class="navbar navbar-expand-lg premium-navbar">
    <div class="container">
        <div class="d-flex ms-auto"> <!-- Gunakan flexbox untuk mengatur posisi tombol -->
            @if(Auth::guard('customers')->check())
                <!-- Jika sudah login sebagai customer, tampilkan tombol logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger shadow-lg d-flex align-items-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout (Customer)
                    </button>
                </form>
            @elseif(Auth::guard('couriers')->check())
                <!-- Jika sudah login sebagai courier, tampilkan tombol logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger shadow-lg d-flex align-items-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout (Courier)
                    </button>
                </form>
            @elseif(Auth::guard('consultants')->check())
                <!-- Jika sudah login sebagai consultant, tampilkan tombol logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger shadow-lg d-flex align-items-center gap-2">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout (Consultant)
                    </button>
                </form>
            @else
                <!-- Jika belum login, tampilkan tombol login -->
                <div class="action-buttons">
                    <a href="{{ route('login') }}" class="btn btn-login">
                        <i class="fas fa-user"></i>
                        <span>Login</span>
                    </a>
                </div>
            @endif

        </div>
    </div>
</nav> --}}

<!-- header section -->
<header class="header">
    <!-- class="fas fa-shopping-basket" -->
    <!-- Logo dengan teks dan ikon -->
{{-- <a href="#" class="logo">
    <i class="fas fa-leaf"></i> Nutriverse
</a> --}}

<!-- Logo dalam bentuk gambar -->
<a href="{{ url('/') }}" aria-label="Go to Homepage" class="navbar-brand"> {{-- Added Bootstrap's navbar-brand class --}}
    <img src="{{ asset('css/images/logo.png') }}"
         alt="Nutriverse Logo - Empowering Healthy Lives"
         class="img-fluid"
         style="max-height: 40px;" {{-- Set a max-height for better navbar integration --}}
         loading="lazy">
</a>



    {{-- <nav class="navbar">
        <a href="#home">Home</a>
        <a href="#service">Service</a>
        <a href="#products">Products</a>
        <a href="#categories">Categories</a>
        <a href="#review">Review</a>
        <a href="{{ url('/articles') }}">Blogs</a>
    </nav> --}}

    <nav class="navbar navbar-expand-lg premium-navbar">
        <div class="container">
            <!-- Navbar Menu -->
            <div class="navbar-nav">
                @if(Auth::guard('customers')->check())
                    {{-- Hanya customer, hanya bisa akses Articles --}}
                    <a class="nav-link" href="{{ url('/articles') }}">Blogs</a>
                    <a class="nav-link" href="{{ url('/forums') }}">Forums</a>
                    <a class="nav-link" href="{{ url('/bmirecord') }}">BMI Tracker</a>
                    <a class="nav-link" href="{{ url('/supplements') }}">Supplements</a>
                    <a class="nav-link" href="{{ url('/orders') }}">Transactions</a>
                    {{-- <a class="nav-link" href="{{ url('/cart') }}">Cart</a> --}}
                @elseif(Auth::guard('couriers')->check())
                    {{-- Courier bisa akses Dashboard dan Review --}}
                    {{-- <a class="nav-link" href="">Dashboard</a>
                    <a class="nav-link" href="#review">Review</a> --}}
                @elseif(Auth::guard('consultants')->check())
                    {{-- Consultant bisa akses Dashboard dan Service --}}
                    {{-- <a class="nav-link" href="">Dashboard</a> --}}
                    <a class="nav-link" href="{{ url('/articles') }}">Blogs</a>
                    {{-- <a class="nav-link" href="{{ url('/forums') }}">Forums</a> --}}
                    {{-- <a class="nav-link" href="#service">Service</a> --}}
                @else
                    {{-- Guest (belum login), bisa akses semua --}}
                    <a class="nav-link" href="/">Home</a>
                    <a class="nav-link" href="#service">Service</a>
                    <a class="nav-link" href="#products">Products</a>
                    <a class="nav-link" href="#categories">Categories</a>
                    {{-- <a class="nav-link" href="#review">Review</a> --}}
                    <a class="nav-link" href="#blogs">Blogs</a>
                @endif
            </div>

            <!-- Tombol Login/Logout -->
            {{-- <div class="d-flex ms-auto">
                @if(Auth::guard('customers')->check())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger shadow-lg d-flex align-items-center gap-2">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout (Customer)
                        </button>
                    </form>
                @elseif(Auth::guard('couriers')->check())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger shadow-lg d-flex align-items-center gap-2">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout (Courier)
                        </button>
                    </form>
                @elseif(Auth::guard('consultants')->check())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger shadow-lg d-flex align-items-center gap-2">
                            <i class="bi bi-box-arrow-right"></i>
                            Logout (Consultant)
                        </button>
                    </form>
                @else
                    <div class="action-buttons">
                        <a href="{{ route('login') }}" class="btn btn-login">
                            <i class="fas fa-user"></i>
                            <span>Login</span>
                        </a>
                    </div>
                @endif
            </div> --}}
        </div>
    </nav>


    <div class="icons">
        @if(Auth::guard('customers')->check())
                    {{-- Hanya customer, hanya bisa akses Articles --}}
                    <div class="fas fa-bars" id="menu-btn"></div>
                    {{-- <div class="fas fa-search" id="search-btn"></div> --}}
                    <div class="fas fa-shopping-cart" id="cart-btn" onclick="window.location.href='{{ route('cart.index') }}'"></div>
                    <div class="fas fa-user" id="login-btn"></div>
                    {{-- <a class="nav-link" href="{{ url('/cart') }}">Cart</a> --}}
                @elseif(Auth::guard('couriers')->check())
                    {{-- Courier bisa akses Dashboard dan Review --}}
                    {{-- <div class="fas fa-bars" id="menu-btn"></div> --}}
                    {{-- <div class="fas fa-search" id="search-btn"></div> --}}
                    <div class="fas fa-user" id="login-btn"></div>
                @elseif(Auth::guard('consultants')->check())
                    <div class="fas fa-bars" id="menu-btn"></div>
                    {{-- <div class="fas fa-search" id="search-btn"></div> --}}
                    <div class="fas fa-user" id="login-btn"></div>
                @else
                    <div class="fas fa-bars" id="menu-btn"></div>
                    {{-- <div class="fas fa-search" id="search-btn"></div> --}}
                    {{-- <div class="fas fa-shopping-cart" id="cart-btn" onclick="window.location.href='{{ route('cart.index') }}'"></div> --}}
                    <div class="fas fa-user" id="login-btn"></div>
                @endif
    </div>


    {{-- <form action="{{ url('/articles') }}" method="GET" class="search-form">
        <input type="search" name="search" id="search-box" placeholder="Cari artikel yang Anda inginkan..." value="{{ request('search') }}">
        <label for="search-box" class="fas fa-search"></label>
    </form> --}}


    {{-- <button class="shopping-cart" onclick="window.location.href='{{ url('/cart') }}'">
    Go to Cart
</button> --}}
    {{-- href="{{ url('/cart') }} --}}

    {{-- <form action="" class="login-form">
        <h3>login now</h3>
        <input type="email" placeholder="your email.." class="box">
        <input type="password" placeholder="your password.." class="box">
        <p>forget your password <a href="#"> click here</a></p>
        <p>dont have an account<a href="#"> create now</a></p>
        <input type="submit" value="login now" class="btn">
    </form> --}}

    <div class="login">
        @auth('customers')
            <div class="login-form">
                <a href="{{ route('customers.edit', ['id' => Auth::guard('customers')->user()->id]) }}" class="btn">Setting</a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn">Logout</button>
                </form>
            </div>
            @endauth

            @auth('consultants')
                {{-- <a href="{{ route('customers.edit') }}" class="btn">Setting</a> --}}
                <div class="login-form">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn">Logout</button>
                    </form>
                </div>
            @endauth

            @auth('couriers')
                {{-- <a href="{{ route('customers.edit') }}" class="btn">Setting</a> --}}
                <div class="login-form">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn">Logout</button>
                    </form>
                </div>
            @endauth

            @guest
                <!-- LOGIN FORM UNTUK GUEST -->
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <h3>login now</h3>

                <input type="email" name="email" placeholder="your email.."
                       class="box @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror

                <input type="password" name="password" placeholder="your password.."
                       class="box @error('password') is-invalid @enderror"
                       required>
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror

                <p>dont have an account <a href="{{ route('show.register') }}"> create now</a></p>

                <input type="submit" value="login now" class="btn">

                <a href="{{ route('filament.admin.auth.login') }}" class="btn">
                    login as admin
                </a>
            </form>
            @endguest
            <script src="{{ asset('js/script.js') }}"></script>
    </div>
</header>
