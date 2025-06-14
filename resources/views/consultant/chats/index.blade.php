@extends('layouts.layout')

@section('title', 'My Customer Chats')

@section('content')
<style>
    /* Import Google Fonts - Poppins for a modern, clean look */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    /* Base body styling for the entire page */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f5f7fa; /* Consistent light, cool background */
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh; /* Ensures the page takes full viewport height */
        color: #333; /* Default text color */
        line-height: 1.6;
    }

    /* Main wrapper for the chat list interface */
    .chat-list-wrapper { /* Renamed from .container for clarity and to apply new styles */
        max-width: 900px; /* Wider to accommodate modern cards */
        width: 95%; /* Responsive width */
        margin: 40px auto; /* Centered with generous top/bottom margin */
        background-color: #ffffff;
        padding: 30px;
        border-radius: 25px; /* Smooth, modern rounded corners */
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08); /* Deeper, more elegant shadow */
        box-sizing: border-box; /* Include padding in width calculation */
        flex-grow: 1; /* Allows it to take up available space */
    }

    /* Main Heading Styling */
    .chat-list-title { /* Renamed from h1 for specificity */
        color: #2e8b57; /* Softer, natural green */
        font-size: 3.2rem; /* Significantly larger and more impactful title */
        font-weight: 800; /* Extra bold */
        text-align: center;
        margin-bottom: 60px; /* More space below the main heading */
        letter-spacing: -1.5px; /* Tighter letter spacing for a premium feel */
        position: relative;
        padding-bottom: 20px; /* Space for the decorative line */
    }

    .chat-list-title::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 0;
        transform: translateX(-50%);
        width: 120px; /* Longer, more prominent underline */
        height: 6px; /* Thicker underline */
        background: linear-gradient(to right, #4CAF50, #28a745); /* Gradient green underline */
        border-radius: 4px;
    }

    /* Session Error Message */
    .error-message { /* Consistent naming with other pages */
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

    /* Chat List Item (Individual Chat Card) */
    .customer-chat-card { /* Renamed from .chat-list-item for clarity */
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #e9eff5; /* Subtle, light border */
        border-radius: 20px; /* More rounded corners */
        padding: 25px 30px; /* More generous padding */
        margin-bottom: 25px; /* More space between items */
        background-color: #ffffff;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07); /* Elegant shadow */
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        position: relative;
        overflow: hidden; /* Ensures shadow doesn't bleed */
    }

    .customer-chat-card:hover {
        transform: translateY(-8px); /* Lifts on hover */
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12); /* More pronounced shadow */
    }

    /* Decorative Vertical Line for chat card */
    .customer-chat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 8px; /* Green line width */
        height: 100%;
        background: linear-gradient(to bottom, #3498db, #2980b9); /* A professional blue gradient */
        border-top-left-radius: 20px; /* Match card border radius */
        border-bottom-left-radius: 20px; /* Match card border radius */
    }

    /* Customer Information Section */
    .customer-info-section { /* Renamed from .customer-info */
        flex-grow: 1;
        padding-left: 20px; /* Space from the decorative line */
    }

    .customer-info-section h3 {
        margin-top: 0;
        margin-bottom: 12px; /* More space below name */
        color: #2980b9; /* Professional blue for customer name */
        font-size: 1.8rem; /* Larger and bolder name */
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .customer-info-section p {
        margin-bottom: 8px;
        font-size: 1rem;
        color: #5d6d7e; /* Softer text color */
    }

    .customer-info-section p strong {
        color: #444; /* Darker for labels */
        font-weight: 600;
    }

    /* View Chat Button */
    .view-chat-button { /* Renamed from .chat-button for clarity in this context */
        background: linear-gradient(to right, #4CAF50, #2e8b57); /* Elegant green gradient */
        color: white;
        padding: 14px 30px; /* Larger padding for a prominent button */
        border: none;
        border-radius: 12px; /* More rounded button corners */
        cursor: pointer;
        font-size: 1.15rem; /* Larger font */
        font-weight: 600;
        text-decoration: none; /* Remove underline for links */
        display: inline-block;
        transition: all 0.3s ease; /* Smooth transition for hover */
        box-shadow: 0 8px 20px rgba(46, 204, 113, 0.3); /* Deeper shadow for button */
        letter-spacing: 0.7px;
        white-space: nowrap; /* Prevent button text from wrapping */
    }

    .view-chat-button:hover {
        background: linear-gradient(to right, #2e8b57, #28b46d); /* Darker gradient on hover */
        transform: translateY(-4px); /* Lifts more on hover */
        box-shadow: 0 12px 25px rgba(46, 204, 113, 0.45); /* More pronounced shadow on hover */
    }

    /* Empty State Message */
    .no-chats-message-box { /* Consistent naming with other pages */
        text-align: center;
        padding: 60px 30px;
        background-color: #f6faff; /* Very light blueish background */
        border-radius: 20px; /* More rounded */
        margin-top: 30px; /* Adjusted margin */
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        border: 1px solid #e1eaf3;
    }

    .no-chats-message-box img {
        width: 130px; /* Larger icon */
        opacity: 0.75;
        margin-bottom: 30px;
    }

    .no-chats-message-box h5 {
        color: #28a745; /* Primary green */
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .no-chats-message-box p {
        color: #728294; /* Softer gray text */
        font-size: 1.15rem;
        max-width: 550px;
        margin: 0 auto 35px auto;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .chat-list-wrapper {
            margin: 25px auto;
            padding: 25px;
            border-radius: 18px;
        }
        .chat-list-title {
            font-size: 2.5rem;
            margin-bottom: 40px;
        }
        .customer-chat-card {
            flex-direction: column; /* Stack info and button vertically */
            align-items: flex-start; /* Align text to the left */
            padding: 20px;
            margin-bottom: 20px;
        }
        .customer-chat-card::before {
            height: 100%;
            width: 5px;
            border-top-left-radius: 18px;
            border-bottom-left-radius: 18px;
        }
        .customer-info-section {
            padding-left: 15px;
            width: 100%; /* Take full width */
            margin-bottom: 20px; /* Space between info and button */
        }
        .view-chat-button {
            width: 100%; /* Make button take full width */
            padding: 12px 25px;
            font-size: 1.05em;
        }
        .customer-info-section h3 {
            font-size: 1.5em;
        }
        .customer-info-section p {
            font-size: 0.95em;
        }
        .no-chats-message-box {
            padding: 50px 20px;
            font-size: 1em;
        }
    }

    @media (max-width: 480px) {
        .chat-list-wrapper {
            margin: 15px auto;
            padding: 20px;
            border-radius: 15px;
        }
        .chat-list-title {
            font-size: 1.8em;
            margin-bottom: 30px;
            letter-spacing: -1px;
        }
        .chat-list-title::after {
            width: 80px;
            height: 4px;
        }
        .customer-chat-card {
            padding: 15px;
            border-radius: 15px;
        }
        .customer-chat-card::before {
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
        }
        .customer-info-section h3 {
            font-size: 1.2em;
        }
        .customer-info-section p {
            font-size: 0.85em;
        }
        .view-chat-button {
            padding: 10px 20px;
            font-size: 0.95em;
            border-radius: 10px;
        }
        .no-chats-message-box {
            padding: 40px 15px;
        }
        .no-chats-message-box h5 {
            font-size: 1.5rem;
        }
        .no-chats-message-box p {
            font-size: 1em;
        }
        .no-chats-message-box img {
            width: 100px;
            margin-bottom: 20px;
        }
    }
</style>

<div class="chat-list-wrapper">
    <h1 class="chat-list-title">My Customer Chats</h1>

    @if(session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    @if($chats->isEmpty())
        <div class="no-chats-message-box">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" alt="No Chats">
            <h5>No customers have started a chat with you yet.</h5>
            <p>Your ongoing conversations with customers will appear here.</p>
            {{-- Add a button if you want to redirect them somewhere else, e.g., dashboard --}}
            {{-- <a href="{{ route('consultant.dashboard') }}" class="view-chat-button">Go to Dashboard</a> --}}
        </div>
    @else
        <div class="chat-list">
            @foreach($chats as $chat)
                <div class="customer-chat-card">
                    <div class="customer-info-section">
                        <h3>{{ $chat->customer->name }}</h3>
                        <p><strong>Email:</strong> {{ $chat->customer->email }}</p>
                        <p><strong>Last Active:</strong> {{ $chat->updated_at->diffForHumans() }}</p>
                    </div>
                    <div class="chat-action">
                        <a href="{{ route('consultant.chat.show', $chat) }}" class="view-chat-button">View Chat</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection