@extends('layouts.admin')

@section('title', 'Manage Orders')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-lg mb-8">
    <h2 class="text-3xl font-semibold mb-6 text-gray-800">Manage Orders</h2>

    <!-- Scrollable Table -->
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm max-h-96">
        <table class="min-w-full bg-white divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wide">Order ID</th>
                    <th class="py-3 px-6 text-center text-sm font-semibold text-gray-700 uppercase tracking-wide">Table Number</th>
                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wide">Total Amount</th>
                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wide">Status</th>
                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-800">{{ $order->id }}</td>
                        <td class="py-4 px-6 whitespace-nowrap text-center text-sm text-gray-800">{{ $order->table_id }}</td>
                        <td class="py-4 px-6 whitespace-nowrap text-sm text-gray-800">PHP {{ number_format($order->total_amount, 2) }}</td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <!-- Status Dropdown with Icons and Color-Coding -->
                            <select 
                                onchange="handleStatusChange({{ $order->id }}, this.value)" 
                                id="statusDropdown_{{ $order->id }}"
                                class="block w-full p-2 text-sm font-medium rounded-md focus:ring-2 focus:ring-indigo-500 transition ease-in-out duration-150
                                    {{ $order->status == 'Completed' ? 'bg-green-100 text-green-700' : ($order->status == 'Cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}"
                                {{ in_array($order->status, ['Completed', 'Cancelled']) ? 'disabled' : '' }}>
                                <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>🕒 Pending</option>
                                <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>✔️ Completed</option>
                                <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                            </select>
                            <span id="loading_{{ $order->id }}" class="text-xs text-gray-500 hidden">Updating...</span>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            <!-- Actions Buttons with Tooltips and Spacing -->
                            <div class="flex justify-between items-center space-x-4">
                                <!-- View details button with Tooltip -->
                                <button type="button" onclick="showOrderDetails({{ $order->id }})" 
                                    class="text-blue-500 hover:text-blue-600 p-2 rounded-full focus:outline-none transition ease-in-out duration-150" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- Delete button with Tooltip -->
                                <button type="button" onclick="confirmDelete({{ $order->id }})" 
                                    class="text-red-500 hover:text-red-600 p-2 rounded-full focus:outline-none transition ease-in-out duration-150" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modals Section -->
@include('admin.orders.modals')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let selectedOrderId = null;
    let selectedStatus = null;

    // Handle status change with confirmation using SweetAlert
    function handleStatusChange(orderId, status) {
        if (status === 'Completed' || status === 'Cancelled') {
            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to mark this order as ${status}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it!',
                cancelButtonText: 'No, cancel!',
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(orderId, status);
                } else {
                    document.getElementById(`statusDropdown_${orderId}`).value = 'Pending';
                }
            });
        } else {
            updateStatus(orderId, status);
        }
    }

    function updateStatus(orderId, status) {
        document.getElementById(`loading_${orderId}`).classList.remove('hidden');
        fetch(`/admin/orders/${orderId}/update-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById(`loading_${orderId}`).classList.add('hidden');
            if (data.success) {
                Swal.fire({
                    title: 'Status Updated!',
                    text: `Order status updated to ${status}.`,
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
                setTimeout(() => location.reload(), 2000);
            } else {
                Swal.fire('Error', 'Failed to update order status', 'error');
            }
        })
        .catch(error => {
            console.error('Error updating status:', error);
            Swal.fire('Error', 'Failed to update order status', 'error');
        });
    }

    function confirmDelete(orderId) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to delete this order? This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
        }).then((result) => {
            if (result.isConfirmed) {
                deleteOrder(orderId);
            }
        });
    }

    function deleteOrder(orderId) {
        fetch(`/admin/orders/${orderId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Order has been deleted.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 2000);
                } else {
                    Swal.fire('Error', 'Failed to delete order', 'error');
                }
            })

        .catch(error => {
            console.error('Error deleting order:', error);
            Swal.fire('Error', 'Failed to delete order', 'error');
        });
    }

    function showOrderDetails(orderId) {
        fetch(`/admin/orders/${orderId}`)
        .then(response => response.json())
        .then(order => {
            let orderItemsHtml = `
                <div class="text-center mb-6">
                    <p class="text-xl font-semibold"><strong>Table Number:</strong> ${order.table_id}</p>
                </div>
                <div class="grid gap-4">
                    <h4 class="font-semibold text-gray-700">Ordered Items:</h4>
            `;

            order.items.forEach(item => {
                orderItemsHtml += `
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                        <div class="flex justify-between">
                            <span class="font-bold">${item.name}</span>
                            <span>PHP ${parseFloat(item.price).toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>Quantity: ${item.quantity}</span>
                            <span>Total: PHP ${(item.price * item.quantity).toFixed(2)}</span>
                        </div>
                    </div>
                `;
            });

            orderItemsHtml += `</div>`;

            document.getElementById('modalContent').innerHTML = orderItemsHtml;
            const modal = document.getElementById('orderDetailsModal');
            modal.classList.remove('opacity-0', 'invisible');
            modal.classList.add('opacity-100', 'visible');
            modal.querySelector('.transform').classList.add('scale-100');
        })
        .catch(error => {
            console.error('Error fetching order details:', error);
        });
    }

    function closeOrderDetailsModal() {
        const modal = document.getElementById('orderDetailsModal');
        modal.classList.add('opacity-0', 'invisible');
        modal.querySelector('.transform').classList.remove('scale-100');
    }
</script>
@endsection
