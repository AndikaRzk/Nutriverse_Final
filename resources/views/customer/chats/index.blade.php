@extends('layouts.layout')

@section('title', 'Daftar Konsultan')

@section('content')
<style>
    /* Global Page Styles (without specific body background) */
    .consultant-page-wrapper { /* New wrapper to manage page height and font */
        font-family: 'Poppins', sans-serif;
        color: #333;
        line-height: 1.6;
        min-height: 100vh; /* Ensures the page takes full viewport height */
        display: flex;
        flex-direction: column;
        justify-content: flex-start; /* Aligns content to the top */
        align-items: center; /* Centers content horizontally */
        padding: 40px 0; /* Add some vertical padding for overall page */
    }

    /* Container Styling */
    .consultant-container {
        padding: 50px 30px;
        max-width: 1200px;
        width: 95%; /* Make it slightly responsive */
        margin: 0 auto; /* Center it */
        background-color: #ffffff;
        border-radius: 25px; /* Even more rounded corners for a premium feel */
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1); /* Deeper, more elegant shadow */
        border: 1px solid #e9eff5; /* Lighter, more subtle border */
        box-sizing: border-box; /* Include padding and border in the element's total width and height */
    }

    /* Main Heading Styling */
    .consultant-page-title {
        color: #2e8b57;
        font-size: 3.5rem; /* Even larger and more impactful title */
        font-weight: 800;
        text-align: center;
        margin-bottom: 70px; /* More space below */
        letter-spacing: -1.5px; /* Tighter for modern look */
        position: relative;
        padding-bottom: 25px;
    }

    .consultant-page-title::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 120px; /* Longer, more prominent underline */
        height: 6px; /* Thicker underline */
        background: linear-gradient(to right, #4CAF50, #28a745); /* Gradient green */
        border-radius: 4px;
    }

    /* Search Form Styling (if you decide to add one later) */
    /* .consultant-search-form .input-group {} */

    /* Consultant Card Styling */
    .consultant-card {
        display: flex;
        align-items: center;
        border: 1px solid #f0f4f8; /* Very subtle border */
        border-radius: 20px; /* Consistent rounded corners */
        padding: 30px; /* Increased padding */
        margin-bottom: 30px; /* More space between cards */
        background-color: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06); /* Elegant, slightly deeper shadow */
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .consultant-card:hover {
        transform: translateY(-10px); /* Lift higher on hover */
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.15); /* More pronounced shadow */
    }

    /* Decorative Vertical Line */
    .consultant-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 10px; /* Wider green line */
        height: 100%;
        background: linear-gradient(to bottom, #4CAF50, #2e8b57);
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .consultant-info {
        flex-grow: 1;
        padding-left: 25px; /* More space from the green line */
    }

    .consultant-info h3 {
        margin-top: 0;
        margin-bottom: 15px; /* More space below name */
        color: #28a745; /* Primary green for consultant name */
        font-size: 2rem; /* Larger and bolder name */
        font-weight: 700;
        letter-spacing: -0.7px;
    }

    .consultant-info p {
        margin-bottom: 10px; /* More space between paragraphs */
        font-size: 1.05rem; /* Slightly larger text */
        color: #5a6a7d; /* Softer text color */
    }

    .consultant-info p strong {
        color: #333;
        font-weight: 600;
    }

    /* Status Badges */
    .status-badge-custom {
        display: inline-block;
        padding: 7px 14px; /* Larger padding */
        border-radius: 25px; /* More pill-shaped */
        font-size: 0.95rem; /* Slightly larger font */
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.7px; /* A bit more letter spacing */
        color: white;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Subtle shadow for badges */
    }
    .status-online { background-color: #28a745; }
    .status-offline { background-color: #6c757d; }
    .status-available { background-color: #28a745; }
    .status-unavailable { background-color: #dc3545; }

    .consultant-status {
        margin-left: 40px; /* More margin */
        text-align: right;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
    }

    .consultant-status p {
        margin-bottom: 25px; /* More space above the button */
        font-size: 1.1rem;
        font-weight: 500;
    }

    /* Chat Button */
    .chat-button {
        background-color: #28a745;
        color: white;
        padding: 15px 35px; /* Larger padding */
        border: none;
        border-radius: 12px; /* More rounded */
        cursor: pointer;
        font-size: 1.15rem; /* Larger font */
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3); /* Deeper shadow for button */
        letter-spacing: 0.7px;
    }

    .chat-button:hover {
        background-color: #218838;
        transform: translateY(-4px); /* Lift more on hover */
        box-shadow: 0 12px 25px rgba(40, 167, 69, 0.45); /* More pronounced shadow */
    }

    /* Error Message */
    .error-message {
        background-color: #fff0f3; /* Even softer red background */
        color: #c0392b; /* Darker red text */
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 40px;
        text-align: center;
        font-weight: 500;
        border: 1px solid #ffe0e6;
        font-size: 1.15rem;
        box-shadow: 0 6px 15px rgba(0,0,0,0.05);
    }

    /* No Consultants Message */
    .no-consultants-message-box {
        text-align: center;
        padding: 70px 30px; /* More padding */
        background-color: #f6faff; /* Very light blueish background */
        border-radius: 20px; /* More rounded */
        margin-top: 60px; /* More top margin */
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        border: 1px solid #e1eaf3;
    }

    .no-consultants-message-box img {
        width: 130px; /* Larger icon */
        opacity: 0.75; /* Slightly less opaque */
        margin-bottom: 30px;
    }

    .no-consultants-message-box h5 {
        color: #28a745; /* Primary green */
        font-size: 2rem; /* Larger font */
        font-weight: 700;
        margin-bottom: 20px;
    }

    .no-consultants-message-box p {
        color: #728294; /* Softer gray text */
        font-size: 1.15rem; /* Larger font */
        max-width: 550px; /* Wider paragraph */
        margin: 0 auto 35px auto;
    }

    /* Start Shopping Button (used for 'Back to Home' here) */
    .btn-action-custom { /* Reusing the general action button style from your example */
        display: inline-block;
        padding: 14px 30px;
        background-color: #28a745;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(40, 167, 69, 0.25);
    }

    .btn-action-custom:hover {
        background-color: #218838;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(40, 167, 69, 0.35);
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) { /* Adjust for medium screens */
        .consultant-container {
            padding: 40px 25px;
            width: 98%;
        }
        .consultant-page-title {
            font-size: 3rem;
            margin-bottom: 50px;
        }
        .consultant-info h3 {
            font-size: 1.7rem;
        }
        .consultant-info p, .consultant-status p {
            font-size: 1rem;
        }
        .chat-button {
            padding: 12px 25px;
            font-size: 1.05rem;
        }
        .consultant-card {
            padding: 25px;
        }
    }

    @media (max-width: 768px) { /* Adjust for small screens */
        .consultant-page-wrapper {
            padding: 20px 0;
        }
        .consultant-container {
            padding: 30px 15px;
            margin: 0 auto;
        }
        .consultant-page-title {
            font-size: 2.5rem;
            margin-bottom: 40px;
        }
        .consultant-card {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
            margin-bottom: 20px;
        }
        .consultant-card::before {
            height: 100%;
            width: 5px;
            border-top-left-radius: 15px; /* Adjust border radius for small screen */
            border-bottom-left-radius: 15px;
        }
        .consultant-info {
            padding-left: 15px;
            width: 100%;
            margin-bottom: 20px;
        }
        .consultant-info h3 {
            font-size: 1.5rem;
        }
        .consultant-info p {
            font-size: 0.95rem;
        }
        .consultant-status {
            margin-left: 0;
            width: 100%;
            align-items: center;
            text-align: center;
        }
        .consultant-status p {
            margin-bottom: 15px;
            font-size: 1rem;
        }
        .chat-button {
            width: 90%; /* Make button take more width */
            padding: 10px 20px;
            font-size: 1rem;
        }
        .no-consultants-message-box {
            padding: 50px 15px;
        }
        .no-consultants-message-box h5 {
            font-size: 1.6rem;
        }
        .no-consultants-message-box p {
            font-size: 1rem;
        }
    }
</style>

<div class="consultant-page-wrapper"> {{-- Overall page wrapper --}}
    <div class="consultant-container">
        <h1 class="consultant-page-title">Daftar Konsultan Profesional</h1>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        @if($consultants->isEmpty())
            <div class="no-consultants-message-box">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No Consultants">
                <h5>Belum ada konsultan tersedia saat ini.</h5>
                <p>Silakan kembali lagi nanti atau coba spesialisasi lain.</p>
                <a href="{{ url('/') }}" class="btn-action-custom"> {{-- Reused a general button class --}}
                    Kembali ke Beranda
                </a>
            </div>
        @else
            <div class="consultant-list">
                <div class="row">
                    @foreach($consultants as $consultant)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="consultant-card">
                                <div class="consultant-info">
                                    <h3>{{ $consultant->name }}</h3>
                                    <p><strong class="order-card-strong">Spesialisasi:</strong> {{ $consultant->specialization }}</p>
                                    <p><strong class="order-card-strong">Pengalaman:</strong> {{ $consultant->experience }} Tahun</p>
                                    {{-- <p><strong>Harga/Sesi:</strong> Rp{{ number_format($consultant->price_per_session, 0, ',', '.') }}</p> --}}
                                    <p>
                                        <strong class="order-card-strong">Ketersediaan:</strong>
                                        @if($consultant->is_available)
                                            <span class="status-badge-custom status-available">Tersedia</span>
                                        @else
                                            <span class="status-badge-custom status-unavailable">Tidak Tersedia</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="consultant-status">
                                    <p>
                                        <strong class="order-card-strong">Status:</strong>
                                        @if($consultant->is_online)
                                            <span class="status-badge-custom status-online">Online</span>
                                        @else
                                            <span class="status-badge-custom status-offline">Offline</span>
                                        @endif
                                    </p>
                                    <form action="{{ route('customer.chat.start', $consultant) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="chat-button">Mulai Chat</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection