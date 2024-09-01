<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khibz Lounge - Reservation</title>
    @vite('resources/css/app.css')
    <style>
        /* Animation for fadeInUp */
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

        /* Applying the animation */
        .fadeInUp {
            animation: fadeInUp 1s ease-out forwards;
        }

        /* Background Gradient */
        .bg-gradient {
            background: linear-gradient(135deg, #1c1c1c 0%, #333333 100%);
        }

        /* Enhanced Shadow */
        .shadow-enhanced {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        /* Button Hover Effect */
        .btn-hover:hover {
            background-color: #e60000;
            transition: background-color 0.3s ease-in-out;
        }

        /* Enhanced Image Hover */
        .image-hover:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('date');
            const today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);
        });
    </script>
</head>
<body class="bg-gradient text-white"> <!-- Applied gradient background -->

@include('layouts._navbar')

<div class="bg-black text-white py-12 fadeInUp">
    <div class="container mx-auto fadeInUp">
        <h1 class="text-4xl font-extrabold text-center mb-6 tracking-wide">MAKE A RESERVATION</h1>
        <p class="text-center mb-10 text-lg leading-relaxed">Join us for an evening of great food, crafted cocktails, and a lively atmosphere at our restobar. Whether you're planning a casual night out or a special celebration, reserving your table ensures you won't miss out on our unique blend of flavor and fun. Reserve now and let us take care of the rest!</p>

        <div class="bg-white text-black p-10 rounded-lg shadow-enhanced mx-auto max-w-md fadeInUp">
            <h2 class="text-2xl font-bold mb-6 text-center">SELECT A DATE</h2>
            <form method="GET" action="{{ route('reservation.details') }}">
                <div class="mb-6">
                    <label for="date" class="block text-lg font-semibold mb-2">Date:</label>
                    <input type="date" id="date" name="date" required class="w-full p-3 border border-gray-300 rounded-lg">
                </div>
                <button type="submit" class="bg-black text-white w-full py-3 rounded-lg font-semibold btn-hover">Next</button>
            </form>
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 px-4 fadeInUp">
            <div class="bg-cover bg-center h-64 rounded-lg shadow-enhanced image-hover" style="background-image: url('{{ asset('images/bacardi.jpg') }}');"></div>
            <div class="bg-cover bg-center h-64 rounded-lg shadow-enhanced image-hover" style="background-image: url('{{ asset('images/KhibzLogo.png') }}');"></div>
            <div class="bg-cover bg-center h-64 rounded-lg shadow-enhanced image-hover" style="background-image: url('{{ asset('images/Cuervo.jpg') }}');"></div>
        </div>
    </div>
</div>

@include('layouts._footer')
</body>
</html>
