<!-- resources/views/about.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khibz Lounge - About Us</title>
    @vite('resources/css/app.css')
    <style>
        /* Main Container */
        .content-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Section Header Styling */
        .section-header {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #333;
            position: relative;
        }

        .section-header::after {
            content: "";
            display: block;
            width: 50px;
            height: 4px;
            background-color: #d32f2f;
            margin: 8px auto 20px;
            border-radius: 5px;
        }

        .section-description {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #555;
            margin-bottom: 2.5rem;
            text-align: center;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Gallery Styles */
        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .gallery-image-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-image-wrapper:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .gallery-image-wrapper:hover .gallery-image {
            transform: scale(1.1);
        }

        /* Footer Styling */
        .footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            font-size: 0.9rem;
        }

        /* Animation and Hover Effects */
        .content-container, .gallery-container {
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="bg-gradient-to-b from-gray-50 to-white">

<!-- Include the Navigation Bar -->
@include('layouts._navbar')

<!-- Content for About Us Page -->
<div class="content-container bg-white shadow-lg rounded-lg p-6 mt-6">
    <!-- Our Story Section -->
    <section class="text-center">
        <h2 class="section-header">OUR STORY</h2>
        <p class="section-description">
            Khibz Lounge San Pablo is one of the famous restobars in San Pablo City which serves a fine dining and clubbing experience. 
            Khibz Lounge San Pablo is a second branch of Khibz Restobar 3.0 Candelaria. Khibz Lounge San Pablo started on June 15, 2023, 
            and it is owned by Mr. Harvey De Leon and their co-owners Mr. Henry Licup and his son Mr. Harry Licup. Its unique name "KHIBZ" 
            was derived from the names of Mr. De Leon’s sons and daughters: KM De Leon, Hagen De Leon, Isaiah Zane De Leon, Byrone De Leon, 
            and Zianna Marie De Leon. Their logo started from Mr. De Leon's first business, Lechon Baboy, and later included serving their 
            own recipes of cocktail drinks.
        </p>
    </section>
    
    <!-- Gallery Section -->
    <section class="text-center">
        <h2 class="section-header">Gallery</h2>
        <div class="gallery-container">
            <!-- Add your gallery images here -->
            <div class="gallery-image-wrapper">
                <img src="{{ asset('images/ribboncutting.jpg') }}" alt="Ribbon Cutting Ceremony" class="gallery-image">
            </div>
            <div class="gallery-image-wrapper">
                <img src="{{ asset('images/khibz3.jpg') }}" alt="Inside Khibz Lounge" class="gallery-image">
            </div>
            <div class="gallery-image-wrapper">
                <img src="{{ asset('images/3owner.jpg') }}" alt="Three Owners" class="gallery-image">
            </div>
        </div>
    </section>
</div>

<!-- Include the Footer -->
@include('layouts._footer')

</body>
</html>
