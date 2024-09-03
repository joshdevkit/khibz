<nav class="bg-black text-white py-4 sticky top-0 z-50 shadow-md">
    <div class="container mx-auto flex justify-between items-center px-4">
        <!-- Logo and Title -->
        <a href="{{ route('home') }}" class="flex items-center">
            <img src="{{ asset('images/logobaboy.jpg') }}" alt="Khibz Logo" class="h-8 mr-3"> <!-- Replace with your logo path -->
            <span class="text-2xl font-bold tracking-wider">KHIBZ LOUNGE - SAN PABLO</span>
        </a>

        <!-- Toggle Button for Mobile -->
        <button id="menu-toggle" class="block md:hidden text-white focus:outline-none" aria-expanded="false" aria-controls="mobile-menu">
            <svg class="h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>

        <!-- Navigation Links for Larger Screens -->
        <div class="hidden md:flex flex-row items-center space-x-8">
            <a href="{{ route('home') }}" class="text-lg hover:text-red-500 {{ request()->is('/') ? 'border-b-2 border-red-500' : '' }}">Home</a>
            <a href="{{ route('reservation.index') }}" class="text-lg hover:text-red-500 {{ request()->is('reservation') ? 'border-b-2 border-red-500' : '' }}">Reservation</a>
            <a href="{{ route('menu') }}" class="text-lg hover:text-red-500 {{ request()->is('menu') ? 'border-b-2 border-red-500' : '' }}">Menu</a>
            <a href="{{ route('about') }}" class="text-lg hover:text-red-500 {{ request()->is('about') ? 'border-b-2 border-red-500' : '' }}">About Us</a>
        </div>
    </div>

    <!-- Navigation Links for Smaller Screens -->
    <div id="mobile-menu" class="md:hidden hidden flex-col space-y-2 bg-black px-4 py-4 transition-transform transform duration-300 ease-in-out">
        <a href="{{ route('home') }}" class="text-lg block hover:text-red-500 {{ request()->is('/') ? 'border-b-2 border-red-500' : '' }}">Home</a>
        <a href="{{ route('reservation.index') }}" class="text-lg block hover:text-red-500 {{ request()->is('reservation') ? 'border-b-2 border-red-500' : '' }}">Reservation</a>
        <a href="{{ route('menu') }}" class="text-lg block hover:text-red-500 {{ request()->is('menu') ? 'border-b-2 border-red-500' : '' }}">Menu</a>
        <a href="{{ route('about') }}" class="text-lg block hover:text-red-500 {{ request()->is('about') ? 'border-b-2 border-red-500' : '' }}">About Us</a>
    </div>
</nav>

<script>
    // JavaScript to toggle the menu visibility for smaller screens
    document.getElementById('menu-toggle').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        const isExpanded = this.getAttribute('aria-expanded') === 'true';

        // Toggle the hidden class and set aria-expanded attribute
        mobileMenu.classList.toggle('hidden');
        this.setAttribute('aria-expanded', !isExpanded);
    });

    // Reset the menu state when resizing to larger screens
    window.addEventListener('resize', function() {
        const mobileMenu = document.getElementById('mobile-menu');

        // If screen size is 768px or larger, ensure menu is hidden
        if (window.innerWidth >= 768) {
            mobileMenu.classList.add('hidden');
        }
    });
</script>
