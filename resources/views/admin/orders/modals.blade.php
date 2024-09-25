<!-- Order Details Modal -->
<div id="orderDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-300 opacity-0 invisible z-50">
    <div class="bg-white w-11/12 max-w-lg mx-auto rounded-lg shadow-lg transform transition-transform duration-300 scale-95 overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b bg-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Order Details</h3>
            <button onclick="closeOrderDetailsModal()" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="modalContent" class="p-4 max-h-[60vh] overflow-y-auto"></div>
        <div class="flex justify-end p-4 border-t bg-gray-100">
            <button onclick="closeOrderDetailsModal()" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Close</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-300 opacity-0 invisible z-50">
    <div class="bg-white w-11/12 max-w-md mx-auto rounded-lg shadow-lg transform transition-transform duration-300 scale-95">
        <div class="flex justify-between items-center p-4 border-b bg-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Confirm Delete</h3>
            <button onclick="closeDeleteModal()" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-700">Are you sure you want to delete this order?</p>
        </div>
        <div class="flex justify-end p-4 border-t bg-gray-100">
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</button>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Delete</button>
            </form>
        </div>
    </div>
</div>

<!-- Status Confirmation Modal -->
<div id="statusConfirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-300 opacity-0 invisible z-50">
    <div class="bg-white w-11/12 max-w-md mx-auto rounded-lg shadow-lg transform transition-transform duration-300 scale-95">
        <div class="flex justify-between items-center p-4 border-b bg-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Confirm Status Change</h3>
            <button onclick="closeStatusConfirmationModal()" class="text-gray-600 hover:text-gray-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-700">Are you sure you want to mark this order as <strong><span id="statusText"></span></strong>? Once confirmed, this cannot be edited.</p>
        </div>
        <div class="flex justify-end p-4 border-t bg-gray-100">
            <button type="button" onclick="closeStatusConfirmationModal()" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Cancel</button>
            <button type="button" onclick="confirmStatusChange()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Confirm</button>
        </div>
    </div>
</div>
