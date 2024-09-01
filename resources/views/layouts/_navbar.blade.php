<nav class="bg-black text-white py-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo and Title -->
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('images/logobaboy.jpg') }}" alt="Khibz Logo" class="h-8 mr-3"> <!-- Replace with your logo path -->
            <span class="text-2xl font-bold tracking-wider">KHIBZ LOUNGE - SAN PABLO</span>
        </a>

        <!-- Navigation Links -->
        <div class="flex space-x-8">
            <a href="{{ route('home') }}" class="hover:text-red-500 text-lg {{ request()->is('/') ? 'border-b-2 border-red-500' : '' }}">Home</a>
            <a href="{{ route('reservation.index') }}" class="hover:text-red-500 text-lg {{ request()->is('reservation') ? 'border-b-2 border-red-500' : '' }}">Reservation</a>
            <a href="{{ route('menu') }}" class="hover:text-red-500 text-lg {{ request()->is('menu') ? 'border-b-2 border-red-500' : '' }}">Menu</a>
            <a href="{{ route('about') }}" class="hover:text-red-500 text-lg {{ request()->is('about') ? 'border-b-2 border-red-500' : '' }}">About Us</a>
        </div>
    </div>
</nav>