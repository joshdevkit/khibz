<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script>
        function toggleDropdown() {
            document.getElementById('userDropdown').classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Wrapper for Sidebar and Content -->
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-sidebar-bg p-6 shadow-lg"> <!-- Use the custom utility class -->
            <div class="text-white font-bold text-2xl mb-8 flex items-center">
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
                        <a href="{{ route('admin.users') }}" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-users mr-3"></i> Manage Users
                        </a>
                    </li>
                    <!-- New Reports Link -->
                    <li>
                        <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-2 text-white hover:bg-gray-700 rounded transition duration-200">
                            <i class="fas fa-chart-line mr-3"></i> Reports
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Navbar -->
            <header class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">@yield('title')</h1>
                <!-- User Profile, Notification Icons, and Dropdown Section -->
                <div class="flex items-center space-x-4">
                    <!-- Bell Icon -->
                    <button class="relative p-2 bg-white rounded-full shadow-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-bell text-gray-600"></i>
                        <!-- Notification Dot -->
                        <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
                    </button>
                    <!-- User Profile and Dropdown -->
                    <div class="relative">
                        <!-- User Profile Button -->
                        <button onclick="toggleDropdown()" class="flex items-center space-x-3 focus:outline-none">
                            <img src="https://via.placeholder.com/40" alt="User Avatar" class="w-10 h-10 rounded-full">
                            <div class="flex flex-col text-left">
                                <span class="text-gray-800 font-medium">Jiu Anderson</span>
                                <span class="text-sm text-gray-500">Manager</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-600"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 hidden">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <section class="bg-white shadow-md rounded p-6">
                @yield('content')
            </section>
        </main>
    </div>

</body>
</html>
