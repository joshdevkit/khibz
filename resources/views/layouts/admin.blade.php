<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- Bootstrap 5 CSS and FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Vite (For custom assets) -->
    @vite('resources/css/app.css')

    <!-- Optional JavaScript -->
    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }
    </script>

    <!-- Include SweetAlert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-dark text-white p-6 shadow-lg">
            <div class="font-bold text-2xl mb-8 flex items-center">
                <i class="fas fa-pizza-slice mr-2"></i> Khibz Lounge
            </div>
            <nav>
                <ul class="space-y-4">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-home mr-3"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reservations') }}" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-calendar-check mr-3"></i> Manage Reservations
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.menu') }}" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-utensils mr-3"></i> Manage Menu
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-clipboard-list mr-3"></i> Manage Orders
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.events') }}" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-users mr-3"></i> Manage Events
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-chart-line mr-3"></i> Reports
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reservations.history') }}" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-history mr-3"></i> History
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        
        <main class="flex-1 p-8">
            <header class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">@yield('title')</h1>
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center space-x-3 focus:outline-none">
                        <img src="{{ asset('images/logobaboy.jpg') }}" alt="User Avatar" class="w-10 h-10 rounded-full border-2 border-gray-200 hover:border-gray-400 transition duration-200">
                        <div class="flex flex-col text-left">
                            <span class="text-gray-800 font-medium">{{ Auth::user()->name }}</span>
                            <span class="text-sm text-gray-500">{{ Auth::user()->role ?? 'Admin' }}</span>
                        </div>
                        <i class="fas fa-chevron-down text-gray-600 transition duration-200 transform group-hover:rotate-180"></i>
                    </button>

                    <!-- Improved Dropdown -->
                    <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden transition transform origin-top-right scale-95">
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition duration-200">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <section class="bg-white shadow-md rounded p-6">
                @yield('content')
            </section>
        </main>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- FontAwesome JS (For icons) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

    <!-- SweetAlert for Success Message -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session("success") }}',
                timer: 3000,
                showConfirmButton: false,
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>
