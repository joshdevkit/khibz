<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khibz Lounge - Home</title>
    @vite('resources/css/app.css')
    <style>
        /* Keyframes for Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleUp {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        /* Animated Content Styles */
        .fade-in {
            animation: fadeIn 1.2s ease-out forwards;
        }

        .scale-up {
            animation: scaleUp 1s ease-out forwards;
        }

        /* Image Flashing and Hover Effect */
        .flashing-image {
            transition: transform 0.4s ease-out, box-shadow 0.4s ease-out;
        }

        .flashing-image:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        /* Gradient Background for Hero Section */
        .hero-bg {
            background: linear-gradient(135deg, #1a1a1a, #3a3a3a);
            padding: 6rem 1rem;
            text-align: center;
            color: #fff;
        }

        .hero-bg h1, .hero-bg h2 {
            animation: fadeIn 1.5s ease-out forwards;
        }

        .hero-bg p {
            animation: fadeIn 1.8s ease-out forwards;
        }

        /* Enhanced Button Styles */
        .btn-primary {
            background-color: #e60000;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-primary:hover {
            background-color: #c50000;
            transform: translateY(-3px);
        }

        /* Footer Styling */
        footer {
            background: #111;
            color: #fff;
            padding: 2rem 0;
            font-size: 0.875rem;
        }

        footer a {
            color: #e60000;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #fff;
        }
    </style>
</head>
<body class="bg-white text-white">

<!-- Navigation Bar -->
@include('layouts._navbar')

<!-- Hero Section with Gradient Background -->
<div class="hero-bg">
    <h1 class="text-4xl md:text-5xl font-extrabold mb-4">WELCOME TO KHIBZ LOUNGE - SAN PABLO</h1>
    <h2 class="text-2xl md:text-3xl font-semibold mb-6 italic">"THE BEST OF LAGUNA"</h2>
    <p class="text-lg md:text-xl max-w-3xl mx-auto leading-relaxed mb-4">
        Step into a world of comfort and elegance at Khibz Lounge. Here, we blend a chic atmosphere with exceptional service and a menu designed to delight. Whether you're here to unwind with friends or celebrate a special occasion, our inviting space and flavorful offerings promise a memorable experience. Sit back, relax, and let us make your visit extraordinary!
    </p>
    <!-- Redirect to About Us Page -->
    <a href="{{ route('about') }}" class="btn-primary inline-block mt-6">Explore More</a>
</div>

<!-- Flashing Image Section with Animation -->
<div class="flex justify-center my-12 scale-up">
    <img id="flashing-image" src="{{ asset('images/Khibz.jpg') }}" alt="Khibz Lounge Events" class="flashing-image rounded-lg shadow-lg w-full md:w-2/3 max-w-screen-lg"> <!-- Initial image -->
</div>

<!-- Footer -->
@include('layouts._footer')


<!-- JavaScript for Flashing Images -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const images = [
            "{{ asset('images/Khibz.jpg') }}",
            "{{ asset('images/Khibz_Club_Experience.jpg') }}",
            "{{ asset('images/KhibzEventCelebrate.jpg') }}",
            "{{ asset('images/dj.jpg') }}",
            "{{ asset('images/bacardi.jpg') }}",
            "{{ asset('images/Cocktail.jpg') }}",
            "{{ asset('images/Cuervo.jpg') }}",
            "{{ asset('images/henessy.jpg') }}",
            "{{ asset('images/henessy1.jpg') }}",
            "{{ asset('images/khbz2.jpg') }}"
        ];

        const fallbackImage = "{{ asset('images/Khibz.jpg') }}";
        const imageElement = document.getElementById('flashing-image');

        function changeImage() {
            const randomIndex = Math.floor(Math.random() * images.length);
            const newImageSrc = images[randomIndex];
            console.log('Changing image to:', newImageSrc);
            imageElement.src = newImageSrc;
        }

        imageElement.addEventListener('error', function() {
            console.error('Failed to load image:', imageElement.src);
            imageElement.src = fallbackImage;
        });

        setInterval(changeImage, 3000); // Change image every 3 seconds
    });
</script>

</body>
</html>
