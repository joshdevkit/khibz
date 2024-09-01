@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="bg-white p-8 rounded-lg shadow mb-8">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Completed Reservations Report</h2>

    <!-- Search and Filter Section -->
    <div class="flex items-center justify-between mb-4">
        <!-- Filter for Number of Rows -->
        <div class="flex items-center">
            <label for="rowsPerPage" class="mr-2 text-sm text-gray-600">Show</label>
            <select id="rowsPerPage" class="border border-gray-300 rounded p-1" onchange="handleSearch()">
                <option value="10" {{ request('rowsPerPage') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('rowsPerPage') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('rowsPerPage') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('rowsPerPage') == 100 ? 'selected' : '' }}>100</option>
            </select>
        </div>

        <!-- Search Input -->
        <div class="flex items-center">
            <input type="text" id="search" class="border border-gray-300 rounded p-1" placeholder="Search..." value="{{ request('search') }}" oninput="handleSearch()">
            <button onclick="generateReport()" class="ml-4 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Generate Report</button>
        </div>
    </div>

    <!-- Table Container -->
    <div id="tableContainer" class="overflow-y-auto rounded-lg border border-gray-200" style="max-height: 500px;">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="py-3 px-4 text-left text-sm font-medium text-gray-600 uppercase tracking-wide">Name</th>
                    <th scope="col" class="py-3 px-4 text-left text-sm font-medium text-gray-600 uppercase tracking-wide">Email</th>
                    <th scope="col" class="py-3 px-4 text-left text-sm font-medium text-gray-600 uppercase tracking-wide">Contact</th>
                    <th scope="col" class="py-3 px-4 text-left text-sm font-medium text-gray-600 uppercase tracking-wide">Guests</th>
                    <th scope="col" class="py-3 px-4 text-left text-sm font-medium text-gray-600 uppercase tracking-wide">Table Number</th>
                    <th scope="col" class="py-3 px-4 text-left text-sm font-medium text-gray-600 uppercase tracking-wide">Selected Date</th>
                    <th scope="col" class="py-3 px-4 text-left text-sm font-medium text-gray-600 uppercase tracking-wide">Status</th>
                    <th scope="col" class="py-3 px-4 text-left text-sm font-medium text-gray-600 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="reservationsTableBody">
                @forelse($completedReservations as $reservation)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="py-4 px-4 whitespace-nowrap text-sm text-gray-800">{{ $reservation->name }}</td>
                    <td class="py-4 px-4 whitespace-nowrap text-sm text-gray-800">{{ $reservation->email }}</td>
                    <td class="py-4 px-4 whitespace-nowrap text-sm text-gray-800">{{ $reservation->contact }}</td>
                    <td class="py-4 px-4 whitespace-nowrap text-sm text-gray-800">{{ $reservation->guests }}</td>
                    <td class="py-4 px-4 whitespace-nowrap text-sm text-gray-800">{{ $reservation->table_number }}</td>
                    <td class="py-4 px-4 whitespace-nowrap text-sm text-gray-800">{{ \Carbon\Carbon::parse($reservation->date)->format('d-m-Y') }}</td>
                    <td class="py-4 px-4 whitespace-nowrap text-sm text-green-700">Completed</td>
                    <td class="py-4 px-4 whitespace-nowrap">
                        <button type="button" onclick="showModal({{ $reservation->id }})" class="text-gray-600 hover:text-gray-800 transition duration-150 focus:outline-none" title="See Details">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-4 px-4 text-center text-sm text-gray-600">No completed reservations found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Structure for Viewing Details -->
<div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0 invisible z-50">
    <div class="bg-white w-11/12 md:max-w-lg mx-auto rounded-lg shadow-lg transform transition-transform duration-300 scale-95">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Reservation Details</h3>
            <button onclick="closeModal()" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- Modal Content -->
        <div id="modalContent" class="p-6">
            <!-- Dynamic content will be injected here -->
        </div>
        <!-- Modal Footer -->
        <div class="flex justify-end p-4 border-t">
            <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Close</button>
        </div>
    </div>
</div>

<!-- Larger Modal Structure for Viewing Payment Screenshot -->
<div id="screenshotModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center transition-opacity duration-300 opacity-0 invisible z-50">
    <div class="bg-white w-full max-w-3xl mx-auto rounded-lg shadow-lg transform transition-transform duration-300 scale-95">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Payment Screenshot</h3>
            <button onclick="closeScreenshotModal()" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- Modal Content -->
        <div id="screenshotContent" class="p-6">
            <!-- Dynamic screenshot content will be injected here -->
        </div>
    </div>
</div>

<script>
    const completedReservations = @json($completedReservations->items());

    function handleSearch() {
        const searchQuery = document.getElementById('search').value;
        const rowsPerPage = document.getElementById('rowsPerPage').value;

        const url = new URL(window.location.href);
        url.searchParams.set('search', searchQuery);
        url.searchParams.set('rowsPerPage', rowsPerPage);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(data => {
            document.querySelector('#tableContainer').innerHTML = data; // Correctly replace the entire table content
        })
        .catch(error => console.error('Error:', error));
    }

    function generateReport() {
        // Create a printable area dynamically
        let printContents = `
            <h2>Completed Reservations Report</h2>
            <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Guests</th>
                        <th>Table Number</th>
                        <th>Selected Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
        `;

        completedReservations.forEach(reservation => {
            printContents += `
                <tr>
                    <td>${reservation.name}</td>
                    <td>${reservation.email}</td>
                    <td>${reservation.contact}</td>
                    <td>${reservation.guests}</td>
                    <td>${reservation.table_number}</td>
                    <td>${new Date(reservation.date).toLocaleDateString()}</td>
                    <td>Completed</td>
                </tr>
            `;
        });

        printContents += `
                </tbody>
            </table>
        `;

        const printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write(`
            <html>
                <head>
                    <title>Completed Reservations Report</title>
                    <style>
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f4f4f4;
                        }
                    </style>
                </head>
                <body>
                    ${printContents}
                </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    }

    function showModal(reservationId) {
        const reservation = completedReservations.find(r => r.id == reservationId);

        if (reservation) {
            const modalContent = `
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <p class="flex items-center mb-2">
                            <i class="fas fa-id-badge text-gray-500 mr-2"></i>
                            <strong>ID:</strong> ${reservation.id}
                        </p>
                        <p class="flex items-center mb-2">
                            <i class="fas fa-user text-gray-500 mr-2"></i>
                            <strong>Name:</strong> ${reservation.name}
                        </p>
                        <p class="flex items-center mb-2">
                            <i class="fas fa-envelope text-gray-500 mr-2"></i>
                            <strong>Email:</strong> ${reservation.email}
                        </p>
                        <p class="flex items-center mb-2">
                            <i class="fas fa-phone text-gray-500 mr-2"></i>
                            <strong>Contact:</strong> ${reservation.contact}
                        </p>
                        <p class="flex items-center mb-2">
                            <i class="fas fa-users text-gray-500 mr-2"></i>
                            <strong>Guests:</strong> ${reservation.guests}
                        </p>
                        <p class="flex items-center mb-2">
                            <i class="fas fa-table text-gray-500 mr-2"></i>
                            <strong>Table Number:</strong> ${reservation.table_number}
                        </p>
                        <p class="flex items-center mb-2">
                            <i class="fas fa-info-circle text-gray-500 mr-2"></i>
                            <strong>Status:</strong> Completed
                        </p>
                        <p class="flex items-center mb-2">
                            <i class="fas fa-calendar-alt text-gray-500 mr-2"></i>
                            <strong>Selected Date:</strong> ${new Date(reservation.date).toLocaleDateString()}
                        </p>
                        ${reservation.screenshot ? `<p class="flex items-center mb-2">
                            <i class="fas fa-file-image text-gray-500 mr-2"></i>
                            <strong>Payment Screenshot:</strong>
                        </p>
                        <img src="/storage/${reservation.screenshot}" alt="Payment Screenshot" class="cursor-pointer w-full h-auto rounded shadow-sm" onclick="showScreenshotModal('/storage/${reservation.screenshot}')">` : `<p class="flex items-center mb-2">
                            <i class="fas fa-file-image text-gray-500 mr-2"></i>
                            <strong>Payment Screenshot:</strong> No Screenshot Available
                        </p>`}
                    </div>
                </div>
            `;
            document.getElementById('modalContent').innerHTML = modalContent;
            const modal = document.getElementById('detailsModal');
            modal.classList.remove('opacity-0', 'invisible');
            modal.classList.add('opacity-100', 'visible');
            modal.querySelector('.transform').classList.add('scale-100');
        } else {
            console.log('Reservation not found');
        }
    }

    function closeModal() {
        const modal = document.getElementById('detailsModal');
        modal.classList.add('opacity-0', 'invisible');
        modal.classList.remove('opacity-100', 'visible');
        modal.querySelector('.transform').classList.remove('scale-100');
    }

    function showScreenshotModal(imageSrc) {
        document.getElementById('screenshotContent').innerHTML = `<img src="${imageSrc}" alt="Payment Screenshot" class="w-full h-auto rounded shadow-lg">`;
        const modal = document.getElementById('screenshotModal');
        modal.classList.remove('opacity-0', 'invisible');
        modal.classList.add('opacity-100', 'visible');
        modal.querySelector('.transform').classList.add('scale-100');
    }

    function closeScreenshotModal() {
        const modal = document.getElementById('screenshotModal');
        modal.classList.add('opacity-0', 'invisible');
        modal.classList.remove('opacity-100', 'visible');
        modal.querySelector('.transform').classList.remove('scale-100');
    }

    function changeRowsPerPage(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('rowsPerPage', value);
        handleSearch();
    }
</script>
@endsection
