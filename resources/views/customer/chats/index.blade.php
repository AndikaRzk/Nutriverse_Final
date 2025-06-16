@extends('layouts.layout')

@section('title', 'Consultant List')

@section('content')
<style>
    /* Global Page Styles (without specific body background) */
    .consultant-page-wrapper {
        font-family: 'Poppins', sans-serif;
        color: #333;
        line-height: 1.6;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        padding: 40px 0;
        /* No specific background-color here, rely on layout.blade.php */
    }

    /* Container Styling */
    .consultant-container {
        padding: 40px 25px; /* Slightly reduced padding */
        max-width: 1000px; /* Slightly reduced max-width for a more compact feel */
        width: 95%;
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 20px; /* Slightly less rounded */
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.08); /* Refined shadow */
        border: 1px solid #eef2f6; /* Subtle border */
        box-sizing: border-box;
    }

    /* Main Heading Styling */
    .consultant-page-title {
        color: #2e8b57;
        font-size: 2.8rem; /* Reduced font size */
        font-weight: 800;
        text-align: center;
        margin-bottom: 50px; /* Reduced margin */
        letter-spacing: -1px; /* Adjusted letter spacing */
        position: relative;
        padding-bottom: 20px; /* Reduced padding */
    }

    .consultant-page-title::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 100px; /* Reduced width */
        height: 5px; /* Reduced thickness */
        background: linear-gradient(to right, #4CAF50, #28a745);
        border-radius: 3px;
    }

    /* Consultant Card Styling */
    .consultant-card {
        display: flex;
        align-items: center;
        border: 1px solid #f5f5f5; /* Lighter border for cards */
        border-radius: 15px; /* Slightly less rounded */
        padding: 25px; /* Reduced padding */
        margin-bottom: 25px; /* Reduced margin */
        background-color: #ffffff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06); /* Lighter shadow */
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .consultant-card:hover {
        transform: translateY(-8px); /* Slightly less lift */
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12); /* More pronounced hover shadow */
    }

    /* Decorative Vertical Line */
    .consultant-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 8px; /* Reduced width */
        height: 100%;
        background: linear-gradient(to bottom, #4CAF50, #2e8b57);
        border-top-left-radius: 15px;
        border-bottom-left-radius: 15px;
    }

    .consultant-info {
        flex-grow: 1;
        padding-left: 20px; /* Reduced padding */
    }

    .consultant-info h3 {
        margin-top: 0;
        margin-bottom: 12px; /* Reduced margin */
        color: #28a745;
        font-size: 1.8rem; /* Reduced font size */
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .consultant-info p {
        margin-bottom: 8px; /* Reduced margin */
        font-size: 0.95rem; /* Reduced font size */
        color: #5a6a7d;
    }

    .consultant-info p strong {
        color: #333;
        font-weight: 600;
    }

    /* Status Badges */
    .status-badge-custom {
        display: inline-block;
        padding: 6px 12px; /* Reduced padding */
        border-radius: 20px; /* Slightly less rounded */
        font-size: 0.85rem; /* Reduced font size */
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px; /* Reduced letter spacing */
        color: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .status-online { background-color: #28a745; }
    .status-offline { background-color: #6c757d; }
    .status-available { background-color: #28a745; }
    .status-unavailable { background-color: #dc3545; }

    .consultant-status {
        margin-left: 30px; /* Reduced margin */
        text-align: right;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
    }

    .consultant-status p {
        margin-bottom: 20px; /* Reduced margin */
        font-size: 1rem; /* Adjusted font size */
        font-weight: 500;
    }

    /* Chat Button */
    .chat-button {
        background-color: #28a745;
        color: white;
        padding: 12px 28px; /* Reduced padding */
        border: none;
        border-radius: 10px; /* Slightly less rounded */
        cursor: pointer;
        font-size: 1.05rem; /* Reduced font size */
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        box-shadow: 0 6px 15px rgba(40, 167, 69, 0.25); /* Lighter shadow */
        letter-spacing: 0.5px; /* Reduced letter spacing */
    }

    .chat-button:hover {
        background-color: #218838;
        transform: translateY(-3px); /* Slightly less lift */
        box-shadow: 0 10px 20px rgba(40, 167, 69, 0.4); /* More subtle hover shadow */
    }

    /* Error Message */
    .error-message {
        background-color: #fef0f2;
        color: #c0392b;
        padding: 15px; /* Reduced padding */
        border-radius: 12px; /* Slightly less rounded */
        margin-bottom: 30px; /* Reduced margin */
        text-align: center;
        font-weight: 500;
        border: 1px solid #fce8eb;
        font-size: 1rem; /* Reduced font size */
        box-shadow: 0 4px 10px rgba(0,0,0,0.04);
    }

    /* No Consultants Message */
    .no-consultants-message-box {
        text-align: center;
        padding: 50px 20px; /* Reduced padding */
        background-color: #edfcf1;
        border-radius: 15px; /* Slightly less rounded */
        margin-top: 40px; /* Reduced margin */
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        border: 1px solid #d9f3de;
    }

    .no-consultants-message-box img {
        width: 100px; /* Reduced icon size */
        opacity: 0.75;
        margin-bottom: 25px; /* Reduced margin */
    }

    .no-consultants-message-box h5 {
        color: #28a745;
        font-size: 1.8rem; /* Reduced font size */
        font-weight: 700;
        margin-bottom: 15px; /* Reduced margin */
    }

    .no-consultants-message-box p {
        color: #728294;
        font-size: 1rem; /* Reduced font size */
        max-width: 500px; /* Reduced max-width */
        margin: 0 auto 25px auto; /* Reduced margin */
    }

    /* Action Button (Back to Home) */
    .btn-action-custom {
        display: inline-block;
        padding: 12px 25px; /* Reduced padding */
        background-color: #28a745;
        color: white;
        border-radius: 8px; /* Slightly less rounded */
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem; /* Reduced font size */
        letter-spacing: 0.4px; /* Reduced letter spacing */
        transition: all 0.3s ease;
        box-shadow: 0 5px 12px rgba(40, 167, 69, 0.2);
    }

    .btn-action-custom:hover {
        background-color: #218838;
        transform: translateY(-2px); /* Slightly less lift */
        box-shadow: 0 8px 15px rgba(40, 167, 69, 0.3);
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .consultant-container {
            padding: 30px 20px;
            width: 98%;
        }
        .consultant-page-title {
            font-size: 2.2rem;
            margin-bottom: 40px;
        }
        .consultant-info h3 {
            font-size: 1.5rem;
        }
        .consultant-info p, .consultant-status p {
            font-size: 0.9rem;
        }
        .chat-button {
            padding: 10px 20px;
            font-size: 0.95rem;
        }
        .consultant-card {
            padding: 20px;
        }
    }

    @media (max-width: 768px) {
        .consultant-page-wrapper {
            padding: 15px 0;
        }
        .consultant-container {
            padding: 25px 10px;
            margin: 0 auto;
        }
        .consultant-page-title {
            font-size: 2rem;
            margin-bottom: 30px;
        }
        .consultant-card {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px;
            margin-bottom: 15px;
        }
        .consultant-card::before {
            height: 100%;
            width: 4px;
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }
        .consultant-info {
            padding-left: 10px;
            width: 100%;
            margin-bottom: 15px;
        }
        .consultant-info h3 {
            font-size: 1.3rem;
        }
        .consultant-info p {
            font-size: 0.85rem;
        }
        .consultant-status {
            margin-left: 0;
            width: 100%;
            align-items: center;
            text-align: center;
        }
        .consultant-status p {
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        .chat-button {
            width: 85%;
            padding: 8px 15px;
            font-size: 0.9rem;
        }
        .no-consultants-message-box {
            padding: 30px 10px;
        }
        .no-consultants-message-box h5 {
            font-size: 1.4rem;
        }
        .no-consultants-message-box p {
            font-size: 0.9rem;
        }
    }
</style>

<div class="consultant-page-wrapper"> {{-- Overall page wrapper --}}
    <div class="consultant-container">
        <h1 class="consultant-page-title">Professional Consultant List</h1>

        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        @if($consultants->isEmpty())
            <div class="no-consultants-message-box">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No Consultants">
                <h5>No consultants available at the moment.</h5>
                <p>Please check back later or try a different specialization.</p>
                <a href="{{ url('/') }}" class="btn-action-custom">
                    Back to Home
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
                                    <p><strong class="order-card-strong">Specialization:</strong> {{ $consultant->specialization }}</p>
                                    <p><strong class="order-card-strong">Experience:</strong> {{ $consultant->experience }} Years</p>
                                    <p>
                                        <strong class="order-card-strong">Availability:</strong>
                                        @if($consultant->is_available)
                                            <span class="status-badge-custom status-available">Available</span>
                                        @else
                                            <span class="status-badge-custom status-unavailable">Unavailable</span>
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
                                        <button type="submit" class="chat-button">Start Chat</button>
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