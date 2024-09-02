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