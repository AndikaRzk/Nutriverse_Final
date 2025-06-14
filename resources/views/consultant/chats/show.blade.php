@extends('layouts.layout')

@section('title', 'Chat with ' . $chat->customer->name)

@section('content')
<style>
    /* Import Google Fonts - Poppins for a modern, clean look */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    /* Base body styling for the entire page */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #eef2f6; /* Lighter, cooler background for the entire page */
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh; /* Ensures the page takes full viewport height */
        color: #333; /* Default text color */
        line-height: 1.6;
        -webkit-font-smoothing: antialiased; /* Smoother font rendering */
        -moz-osx-font-smoothing: grayscale; /* Smoother font rendering */
    }

    /* Main wrapper for the chat interface */
    .chat-wrapper {
        display: flex;
        flex-direction: column;
        flex-grow: 1; /* Allows the chat content to expand and fill available space */
        max-width: 960px; /* Slightly wider for a more spacious feel */
        margin: 40px auto; /* Centered with generous top/bottom margin */
        background-color: #ffffff;
        border-radius: 30px; /* More pronounced rounded corners */
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1); /* Deeper, softer shadow */
        overflow: hidden; /* Ensures internal elements respect the border-radius */
        height: calc(100vh - 80px); /* Adjusts height to fit within viewport, accounting for margin */
        min-height: 600px; /* Minimum height for usability on smaller screens */
    }

    /* Chat Header */
    .chat-header {
        background: linear-gradient(to right, #2ecc71, #28a745); /* Brighter, vibrant green gradient */
        color: white;
        padding: 25px 30px; /* More padding */
        text-align: center;
        font-size: 1.8em; /* Larger, more impactful title */
        font-weight: 700; /* Bolder text */
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1); /* Subtle header shadow */
        border-bottom: 1px solid rgba(255, 255, 255, 0.1); /* Subtle separation line */
        position: sticky; /* Keeps header visible when scrolling */
        top: 0;
        z-index: 100; /* Ensures header is on top of other content */
        letter-spacing: -0.8px; /* Tighter letter spacing for a premium feel */
    }

    /* Chat Messages Container */
    .chat-container {
        flex-grow: 1;
        padding: 30px; /* More ample padding around messages */
        overflow-y: auto; /* Enables scrolling for message history */
        display: flex;
        flex-direction: column;
        gap: 18px; /* More space between individual message bubbles */
        background-color: #fbfdff; /* Very light blueish-white background for chat area */
    }

    /* Individual Message Bubble */
    .message {
        max-width: 70%; /* Messages take up a good portion of the width */
        padding: 18px 25px; /* Generous padding inside bubbles */
        border-radius: 28px; /* Very rounded for a friendly, modern look */
        word-wrap: break-word; /* Ensures long words wrap */
        line-height: 1.5; /* Good line height for readability */
        position: relative;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); /* Softer, more diffused shadow for bubbles */
        transition: transform 0.2s ease-out, box-shadow 0.2s ease-out; /* Smooth hover effects */
        font-size: 1rem; /* Consistent font size */
    }

    .message:hover {
        transform: translateY(-4px); /* Lifts slightly more on hover */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); /* More visible shadow on hover */
    }

    /* Message Bubble Tail */
    .message::after {
        content: '';
        position: absolute;
        bottom: 0;
        width: 0;
        height: 0;
        border: 10px solid transparent; /* Base for the triangle */
    }

    /* Consultant's OWN messages (sender_type === 'App\Models\Consultant') */
    .message.consultant {
        background-color: #dcf8c6; /* Light, pleasant green */
        align-self: flex-end; /* Aligns consultant's messages to the right */
        margin-left: auto; /* Pushes consultant's messages to the right */
        color: #1a6d00; /* Darker green text for contrast */
        border-bottom-right-radius: 8px; /* Slightly less rounded on the bottom-right for a conversational feel */
    }

    .message.consultant::after {
        border-left-color: #dcf8c6; /* Match bubble color */
        border-right: 0;
        right: -8px; /* Position the tail */
    }

    /* Customer's messages (sender_type === 'App\Models\Customer') */
    .message.customer {
        background-color: #e0e9f1; /* Soft blueish-gray for customer messages */
        align-self: flex-start; /* Aligns customer messages to the left */
        margin-right: auto; /* Pushes customer messages to the left */
        color: #444; /* Standard dark text */
        border-bottom-left-radius: 8px; /* Slightly less rounded on the bottom-left */
    }

    .message.customer::after {
        border-right-color: #e0e9f1; /* Match bubble color */
        border-left: 0;
        left: -8px; /* Position the tail */
    }

    /* Message Sender Name */
    .message-sender {
        font-size: 0.9em; /* Clearer, slightly larger sender name */
        color: #666; /* Subtler color */
        margin-bottom: 8px; /* Space between sender and message content */
        font-weight: 600; /* Bolder sender name */
        opacity: 0.9;
    }

    /* Message Timestamp */
    .message-time {
        font-size: 0.75em; /* Small and unobtrusive */
        color: #999; /* Faded color */
        text-align: right;
        margin-top: 12px; /* More space below message content */
        font-weight: 400;
        opacity: 0.8;
    }

    /* Image in Messages */
    .message img {
        max-width: 100%;
        height: auto;
        border-radius: 18px; /* Rounded corners for embedded images */
        margin-top: 15px; /* Space above the image */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Softer shadow for images */
    }

    /* Chat Input Area */
    .chat-input-area {
        display: flex;
        flex-direction: column; /* Stack preview and input */
        align-items: center; /* Center horizontally */
        padding: 20px 30px; /* More padding */
        background-color: #ffffff;
        border-top: 1px solid #e9eff5; /* Light, clean border at the top */
        box-shadow: 0 -8px 25px rgba(0, 0, 0, 0.05); /* Softer, deeper shadow indicating elevation */
        position: sticky; /* Keeps input area visible */
        bottom: 0;
        z-index: 100;
    }

    .chat-input-area form {
        display: flex;
        width: 100%;
        align-items: flex-end; /* Align items to the bottom, useful for multi-line textarea */
        gap: 15px; /* Space between elements in the form */
    }

    .chat-input-area textarea {
        flex-grow: 1; /* Allows textarea to take most available space */
        border: 1px solid #d4dbe2; /* Softer border color */
        border-radius: 35px; /* Even more rounded for a modern chat input */
        padding: 15px 25px; /* Generous padding */
        resize: none; /* Disables manual resizing by user */
        overflow-y: auto; /* Allows vertical scrolling for long messages */
        font-size: 1.05em;
        min-height: 55px; /* Minimum height for the textarea */
        max-height: 180px; /* Maximum height before content scrolls */
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        line-height: 1.5; /* Good line height */
    }

    .chat-input-area textarea:focus {
        outline: none; /* Removes default focus outline */
        border-color: #2ecc71; /* Vibrant green border on focus */
        box-shadow: 0 0 0 5px rgba(46, 204, 113, 0.2); /* Soft glowing effect on focus */
    }

    /* Chat Buttons (Send and Upload) */
    .chat-button {
        background: linear-gradient(to right, #2ecc71, #28a745); /* Vibrant green gradient for action buttons */
        color: white;
        border: none;
        border-radius: 35px; /* Highly rounded buttons */
        padding: 15px 30px; /* Generous padding */
        cursor: pointer;
        font-size: 1.05em;
        font-weight: 600; /* Bolder text */
        transition: all 0.3s ease; /* Smooth transition for all properties */
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap; /* Prevents button text from wrapping */
        box-shadow: 0 6px 20px rgba(46, 204, 113, 0.3); /* Deeper shadow for buttons */
        letter-spacing: 0.5px;
    }

    .chat-button:hover {
        background: linear-gradient(to right, #28a745, #229954); /* Darker green gradient on hover */
        transform: translateY(-4px); /* Lifts more on hover */
        box-shadow: 0 10px 25px rgba(46, 204, 113, 0.45); /* More pronounced shadow on hover */
    }

    .upload-button {
        background: linear-gradient(to right, #3498db, #2980b9); /* A friendly blue gradient for the upload button */
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.3); /* Softer shadow for upload button */
    }

    .upload-button:hover {
        background: linear-gradient(to right, #2980b9, #2374ab); /* Darker blue on hover */
        box-shadow: 0 10px 25px rgba(52, 152, 219, 0.45);
    }

    .file-input {
        display: none; /* Hides the default file input button */
    }

    /* Image Preview Area */
    .image-preview-container {
        width: 100%;
        display: none; /* HIDDEN BY DEFAULT! Only shown by JS */
        flex-wrap: wrap;
        gap: 12px; /* More space between previews */
        margin-bottom: 20px; /* More space below preview area */
        padding: 15px;
        border: 2px dashed #ccd9e7; /* Thicker, softer dashed border */
        border-radius: 20px; /* More rounded */
        background-color: #f6faff; /* Lighter background for preview */
        justify-content: center;
        align-items: center;
        min-height: 100px; /* Minimum height for better visibility */
        box-sizing: border-box;
        overflow: hidden;
        transition: min-height 0.3s ease-in-out, border-color 0.3s ease; /* Transition height and border */
    }

    .image-preview {
        position: relative;
        width: 120px; /* Slightly larger preview thumbnails */
        height: 120px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border: 2px solid #ffffff; /* White border around thumbnail */
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-preview .remove-image {
        position: absolute;
        top: 8px; /* Adjusted position */
        right: 8px; /* Adjusted position */
        background-color: rgba(231, 76, 60, 0.85); /* Darker red, slightly opaque */
        color: white;
        border-radius: 50%;
        width: 30px; /* Larger button */
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1.4em; /* Larger 'x' */
        cursor: pointer;
        line-height: 1;
        transition: background-color 0.2s ease, transform 0.2s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .image-preview .remove-image:hover {
        background-color: rgba(192, 57, 43, 0.95); /* Darker red on hover */
        transform: scale(1.1); /* Slightly enlarge on hover */
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .chat-wrapper {
            margin: 20px;
            border-radius: 20px;
            height: calc(100vh - 40px);
            min-height: 500px;
        }
        .chat-header {
            font-size: 1.5em;
            padding: 20px 25px;
        }
        .chat-container {
            padding: 20px;
            gap: 15px;
        }
        .message {
            max-width: 85%;
            padding: 16px 20px;
            border-radius: 24px;
            font-size: 0.95rem;
        }
        .message.customer::after {
            left: -6px; /* Adjust tail position */
            border-width: 8px;
        }
        .message.consultant::after {
            right: -6px; /* Adjust tail position */
            border-width: 8px;
        }
        .chat-input-area {
            padding: 15px 20px;
        }
        .chat-input-area form {
            gap: 10px;
        }
        .chat-input-area textarea {
            font-size: 1em;
            padding: 13px 20px;
            min-height: 50px;
            max-height: 120px;
            border-radius: 30px;
        }
        .chat-button, .upload-button {
            font-size: 1em;
            padding: 13px 25px;
            border-radius: 30px;
        }
        .image-preview-container {
            min-height: 80px;
            padding: 12px;
            border-radius: 18px;
        }
        .image-preview {
            width: 100px;
            height: 100px;
            border-radius: 12px;
        }
        .image-preview .remove-image {
            width: 28px;
            height: 28px;
            font-size: 1.3em;
            top: 6px;
            right: 6px;
        }
    }

    @media (max-width: 480px) {
        body {
            background-color: #f5f7fa; /* Simpler background on small screens */
        }
        .chat-wrapper {
            margin: 0; /* Full width on tiny screens */
            border-radius: 0; /* No border-radius on wrapper */
            height: 100vh; /* Full height */
            min-height: unset; /* Remove min-height constraint */
            box-shadow: none; /* No shadow */
        }
        .chat-header {
            font-size: 1.3em;
            padding: 18px 15px;
            border-radius: 0; /* No border-radius */
        }
        .chat-container {
            padding: 15px;
            gap: 12px;
        }
        .message {
            max-width: 95%;
            padding: 14px 18px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        .message-sender {
            font-size: 0.85em;
        }
        .message-time {
            font-size: 0.7em;
        }
        .chat-input-area {
            flex-wrap: wrap; /* Allow items to wrap */
            padding: 10px;
            justify-content: center;
            border-radius: 0; /* No border-radius */
        }
        .chat-input-area form {
            flex-direction: column; /* Stack input and buttons */
            align-items: stretch; /* Stretch items to full width */
            gap: 10px;
        }
        .chat-input-area textarea {
            flex-basis: auto; /* Auto size */
            margin-right: 0; /* Remove margin */
            font-size: 0.9em;
            padding: 12px 18px;
            min-height: 45px;
            border-radius: 25px;
        }
        .upload-button, .chat-button {
            width: 100%; /* Full width buttons */
            padding: 12px 20px;
            font-size: 0.95em;
            border-radius: 25px;
        }
        .image-preview-container {
            min-height: 70px;
            padding: 10px;
            border-radius: 15px;
        }
        .image-preview {
            width: 90px;
            height: 90px;
            border-radius: 10px;
        }
        .image-preview .remove-image {
            width: 25px;
            height: 25px;
            font-size: 1.1em;
            top: 5px;
            right: 5px;
        }
    }
</style>

<div class="chat-wrapper">
    <div class="chat-header">
        Chat with {{ $chat->customer->name }}
    </div>

    <div class="chat-container" id="chat-container">
        @foreach($messages as $message)
            <div class="message {{ $message->sender_type === 'App\Models\Consultant' ? 'consultant' : 'customer' }}">
                <div class="message-sender">
                    {{ $message->sender ? $message->sender->name : 'Unknown Sender' }}
                </div>
                @if($message->message)
                    <p>{{ $message->message }}</p>
                @endif
                @if($message->file_path && $message->file_type === 'image')
                    <img src="{{ Storage::url($message->file_path) }}" alt="Image" />
                @endif
                <div class="message-time">
                    {{ $message->created_at->format('H:i') }}
                </div>
            </div>
        @endforeach
    </div>

    <div class="chat-input-area">
        {{-- Image Preview Container (Hidden by default) --}}
        <div class="image-preview-container" id="image-preview-container">
            {{-- Image previews will be injected here by JavaScript --}}
        </div>

        <form action="{{ route('consultant.chat.messages.store', $chat) }}" method="POST" enctype="multipart/form-data" id="chat-form">
            @csrf
            <label for="image-upload" class="chat-button upload-button">
                Upload Photo
                <input type="file" name="file" id="image-upload" class="file-input" accept="image/*">
            </label>
            <textarea name="message" rows="1" placeholder="Type a message..." id="message-input"></textarea>
            <button type="submit" class="chat-button">Send</button>
        </form>
    </div>
</div>

<script>
    // Auto-scroll to the bottom of the chat when the page loads
    function scrollToBottom() {
        const chatContainer = document.getElementById('chat-container');
        if (chatContainer) {
            // Use setTimeout to ensure all content is rendered before scrolling
            setTimeout(() => {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }, 0);
        }
    }

    // Call on page load
    document.addEventListener('DOMContentLoaded', scrollToBottom);

    // Auto-resize textarea based on content
    const messageInput = document.getElementById('message-input');
    if (messageInput) {
        messageInput.addEventListener('input', () => {
            messageInput.style.height = 'auto'; // Reset height to recalculate
            messageInput.style.height = messageInput.scrollHeight + 'px';
            scrollToBottom(); // Scroll to bottom when new line is added
        });
    }

    // --- Image Preview Logic ---
    const imageUploadInput = document.getElementById('image-upload');
    const imagePreviewContainer = document.getElementById('image-preview-container');
    const chatForm = document.getElementById('chat-form');

    imageUploadInput.addEventListener('change', function(event) {
        // Clear previous previews
        imagePreviewContainer.innerHTML = '';

        const file = event.target.files[0]; // Get the first selected file

        if (file) {
            // Show the preview container
            imagePreviewContainer.style.display = 'flex';

            const reader = new FileReader();

            reader.onload = function(e) {
                // Create preview element
                const previewDiv = document.createElement('div');
                previewDiv.classList.add('image-preview');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Image Preview';

                const removeButton = document.createElement('span');
                removeButton.classList.add('remove-image');
                removeButton.innerHTML = '&times;'; // 'x' icon
                removeButton.onclick = function() {
                    // Clear the file input
                    imageUploadInput.value = null;
                    // Remove the preview
                    imagePreviewContainer.innerHTML = '';
                    // Hide the preview container
                    imagePreviewContainer.style.display = 'none';
                };

                previewDiv.appendChild(img);
                previewDiv.appendChild(removeButton);
                imagePreviewContainer.appendChild(previewDiv);
            };

            reader.readAsDataURL(file); // Read the file as a data URL (base64)
        } else {
            // If no file is selected (e.g., user cancels selection), hide the container
            imagePreviewContainer.innerHTML = '';
            imagePreviewContainer.style.display = 'none';
        }
    });

    // Reset preview after form submission (if not using AJAX for submission)
    chatForm.addEventListener('submit', function() {
        // A small delay to ensure form submission starts before clearing
        setTimeout(() => {
            imageUploadInput.value = null; // Clear the file input
            imagePreviewContainer.innerHTML = ''; // Clear preview
            imagePreviewContainer.style.display = 'none'; // Hide the preview container
        }, 100);
        // Also scroll to bottom after sending a message
        scrollToBottom();
    });

    // Optional: If you implement real-time messaging (e.g., WebSockets),
    // make sure to call scrollToBottom() after appending new messages
    // to keep the view at the latest message.
</script>
@endsection