<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khibz Lounge - Menu</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Include html5-qrcode library -->
    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        /* Modal animation for smooth transitions */
        .modal-hidden {
            opacity: 0;
            transform: scale(0.95);
            visibility: hidden;
        }
        .modal-visible {
            opacity: 1;
            transform: scale(1);
            visibility: visible;
        }
        .modal-transition {
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s ease;
        }

        /* Success modal keyframe animation */
        @keyframes successModalAnimation {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }
            70% {
                transform: scale(1.05);
                opacity: 1;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Success modal fade and bounce effect */
        .success-modal-animate {
            animation: successModalAnimation 0.6s ease-out;
        }

        /* Fade-in animation for overlay */
        @keyframes fadeInOverlay {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        .fade-in-overlay {
            animation: fadeInOverlay 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gray-100">

<!-- Include the Navigation Bar -->
@include('layouts._navbar')

<!-- QR Code Scanning Section -->
<div id="qr-section" class="flex flex-col items-center justify-center min-h-screen p-4">
    <h2 class="text-2xl font-semibold mb-6 text-center">SCAN THE QR CODE TO PROCEED WITH ORDERING</h2>
    
    <!-- QR Code Scan Icon -->
    <button id="scanQrBtn" class="text-blue-500 hover:text-blue-700 transition duration-150 mb-6">
        <i class="fas fa-qrcode fa-4x"></i> <!-- QR Code Icon -->
    </button>

    <!-- QR Code Upload Option -->
    <label for="uploadQr" class="text-blue-500 hover:text-blue-700 transition duration-150 mb-6 cursor-pointer">
        <i class="fas fa-upload fa-4x"></i> <!-- QR Code Upload Icon -->
    </label>
    <input type="file" id="uploadQr" accept="image/*" class="hidden" />

    <!-- QR Code Scanning Container -->
    <div id="qr-reader" class="hidden"></div> <!-- Hidden initially, will show when scanning -->

    <p id="qr-status" class="text-gray-700 text-center">Click the QR code icon above to start scanning or upload an image of the QR code.</p>
</div>

<!-- Menu Content Section -->
<div id="menuContent" class="flex flex-col md:flex-row min-h-screen hidden p-4">
    <!-- Sidebar for Categories -->
    <div id="sidebar" class="w-full md:w-1/6 bg-white p-4 shadow-lg mb-4 md:mb-0">
        <h2 class="text-xl font-bold mb-4">Menu</h2>
        <ul id="categoryList" class="space-y-2">
            <!-- Categories will be dynamically populated here -->
        </ul>
    </div>

    <!-- Menu Items Section -->
    <div id="menuItemsSection" class="w-full md:w-2/3 p-4">
        <!-- Centered table number -->
        <div class="flex justify-center items-center mb-4">
            <h2 id="tableNumber" class="text-2xl font-bold text-gray-800">Table: <span id="tableIdDisplay"></span></h2>
        </div>

        <!-- Items will be dynamically populated here -->
        <div id="menuItems" class="grid grid-cols-2 md:grid-cols-3 gap-4">
            <!-- Menu items will be injected here -->
        </div>
    </div>

    <!-- Order Summary Section -->
    <div class="w-full md:w-1/6 bg-white p-4 shadow-lg mt-4 md:mt-0">
        <h2 class="text-xl font-bold mb-4">Your Order</h2>
        <div id="orderSummary" class="h-40 md:h-2/3 overflow-y-auto">
            <!-- Order items will be displayed here -->
        </div>
        <div class="mt-4">
            <button onclick="viewCart()" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded transition ease-in-out duration-200">View Cart</button>
            <div class="text-right font-bold mt-2" id="cartTotal">Total: PHP 0.00</div>
        </div>
    </div>
</div>

<!-- Cart Modal -->
<div id="cartModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 modal-hidden modal-transition">
    <div class="bg-white w-11/12 md:w-1/2 p-6 rounded-lg shadow-lg overflow-y-auto max-h-[80vh]">
        <h2 class="text-2xl font-bold mb-4">Your Cart</h2>
        <div id="cartItems" class="overflow-y-auto max-h-[60vh] mb-4">
            <!-- Cart items will be dynamically populated here -->
        </div>
        <div class="flex justify-between items-center mt-4">
            <button onclick="closeCartModal()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition ease-in-out duration-200">Close</button>
            <span class="font-bold text-xl" id="cartTotalModal">Total: PHP 0.00</span>
        </div>
        <div class="flex justify-end mt-4">
            <button onclick="submitOrder()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition ease-in-out duration-200">Checkout</button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50 fade-in-overlay">
    <div class="bg-white w-11/12 md:w-1/3 p-6 rounded-lg shadow-lg text-center success-modal-animate">
        <h2 class="text-2xl font-bold mb-4 text-green-600">Order Placed Successfully!</h2>
        <p class="text-gray-700 mb-4">Your order has been placed. Please wait while we prepare your order.</p>
        <button onclick="closeSuccessModal()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition ease-in-out duration-200">OK</button>
    </div>
</div>

<script>
    let qrScanner;
    let isScanning = false;
    let cart = [];
    let menuData = {};

    // Function to submit the order
    function submitOrder() {
        const tableId = document.getElementById('tableIdDisplay').textContent;
        
        // Prepare the order data
        const orderData = {
            table_id: tableId,
            items: cart
        };

        // Send the data to the server via AJAX
        fetch('/submit-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show the success modal
                openSuccessModal();
                cart = [];  // Clear the cart
                updateCart();  // Update the cart display
                closeCartModal();  // Close the cart modal
            } else {
                alert('Failed to place the order. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error placing the order:', error);
            alert('An error occurred. Please try again.');
        });
    }

    // Function to open the success modal
    function openSuccessModal() {
        const successModal = document.getElementById('successModal');
        successModal.classList.remove('hidden');
        successModal.classList.add('modal-visible'); // Show with animation
    }

    // Function to close the success modal
    function closeSuccessModal() {
        const successModal = document.getElementById('successModal');
        successModal.classList.remove('modal-visible');
        setTimeout(() => successModal.classList.add('hidden'), 300); // Delay for smooth transition
    }

    // QR Code Scan and Table Check Logic
    document.getElementById('scanQrBtn').addEventListener('click', function() {
        if (isScanning) {
            console.log("Already scanning, please wait.");
            return;
        }

        isScanning = true;
        console.log("Starting QR scanning...");

        const qrReader = document.getElementById('qr-reader');
        qrReader.classList.remove('hidden');

        if (!qrScanner) {
            qrScanner = new Html5Qrcode("qr-reader");
            console.log("QR scanner initialized.");
        }

        qrScanner.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 250, height: 250 } },
            (decodedText, decodedResult) => {
                console.log(`QR Code scanned successfully: ${decodedText}`);
                qrScanner.stop().then(() => { 
                    console.log("QR scanner stopped.");
                    checkTable(decodedText);
                }).catch(err => {
                    console.error(`Failed to stop scanner: ${err}`);
                });
            },
            (errorMessage) => {
                console.error(`QR Code scan error: ${errorMessage}`);
                document.getElementById('qr-status').textContent = "Unable to detect QR code. Please try again.";
                isScanning = false;
            }
        ).catch(err => {
            console.error(`Unable to start scanning: ${err}`);
            isScanning = false;
        });
    });

    document.getElementById('uploadQr').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) {
            console.error("No file selected.");
            return;
        }

        const html5QrCode = new Html5Qrcode("qr-reader");

        html5QrCode.scanFile(file, true)
            .then(decodedText => {
                console.log(`QR Code scanned from uploaded image: ${decodedText}`);
                checkTable(decodedText);
            })
            .catch(err => {
                console.error(`QR Code scan error: ${err}`);
                document.getElementById('qr-status').textContent = "Unable to detect QR code from the uploaded image. Please try again.";
            });
    });

    function checkTable(qrContent) {
        const url = new URL(qrContent);
        const tableId = url.searchParams.get("table");

        if (!tableId) {
            document.getElementById('qr-status').textContent = "Invalid QR code format. Please try again.";
            return;
        }

        // Display the table number
        document.getElementById('tableIdDisplay').textContent = tableId;

        fetch(`/check-table/${tableId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('qr-section').style.display = 'none';
                    document.getElementById('menuContent').classList.remove('hidden');
                    menuData = data.menu; 
                    loadMenu();
                } else {
                    document.getElementById('qr-status').textContent = "Table is not ready for ordering. Please try again.";
                }
            })
            .catch(error => {
                console.error("Error checking table:", error);
                document.getElementById('qr-status').textContent = "Error checking table. Please try again.";
            });
    }

    function loadMenu() {
        const categoryList = document.getElementById('categoryList');
        const menuItemsSection = document.getElementById('menuItems');
        categoryList.innerHTML = '';

        for (let category in menuData) {
            let categoryButton = `<li><button onclick="loadItems('${category}')" class="w-full text-left text-blue-500 py-2">${category}</button></li>`;
            categoryList.innerHTML += categoryButton;
        }

        loadItems(Object.keys(menuData)[0]);
    }

    function loadItems(category) {
        const menuItemsSection = document.getElementById('menuItems');
        menuItemsSection.innerHTML = '';

        if (menuData[category] && Array.isArray(menuData[category])) {
            menuData[category].forEach(item => {
                const itemName = item.name || 'Unnamed Item';
                const itemPrice = parseFloat(item.price);

                if (!isNaN(itemPrice)) {
                    menuItemsSection.innerHTML += `
                        <div class="bg-white p-4 rounded-lg shadow-lg text-center">
                            <img src="${item.image || 'https://via.placeholder.com/150'}" alt="${itemName}" class="w-32 h-32 object-cover mx-auto mb-2 rounded">
                            <h4 class="font-bold text-lg">${itemName}</h4>
                            <p class="text-gray-600 mb-2">PHP ${itemPrice.toFixed(2)}</p>
                            <button class="mt-2 bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition ease-in-out duration-200" onclick="addToCart('${itemName}', ${itemPrice})">Add to Cart</button>
                        </div>`;
                } else {
                    console.error(`Invalid price for item '${itemName}': ${item.price}`);
                }
            });
        } else {
            console.error(`Category '${category}' not found in menuData.`);
        }
    }

    function addToCart(itemName, itemPrice) {
        const existingItem = cart.find(item => item.name === itemName);
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.push({ name: itemName, price: itemPrice, quantity: 1 });
        }
        updateCart();
    }

    function updateCart() {
        document.getElementById('cartTotal').textContent = `Total: PHP ${cart.reduce((acc, item) => acc + item.price * item.quantity, 0).toFixed(2)}`;
        const orderSummary = document.getElementById('orderSummary');
        orderSummary.innerHTML = cart.map(item => `
            <div class="flex justify-between mb-2">
                <div>${item.name} (x${item.quantity})</div>
                <div>PHP ${(item.price * item.quantity).toFixed(2)}</div>
            </div>
        `).join('');
    }

    function viewCart() {
        let cartHtml = '<table class="min-w-full bg-white border mb-4"><thead><tr><th class="px-4 py-2">Item</th><th class="px-4 py-2">Price</th><th class="px-4 py-2">Quantity</th><th class="px-4 py-2">Total</th></tr></thead><tbody>';
        cart.forEach((item, index) => {
            cartHtml += `
                <tr>
                    <td class="border px-4 py-2">${item.name}</td>
                    <td class="border px-4 py-2">PHP ${item.price.toFixed(2)}</td>
                    <td class="border px-4 py-2 text-center flex justify-center items-center">
                        <button onclick="updateItemQuantity(${index}, -1)" class="text-red-500 px-2">-</button>
                        <span class="mx-2">${item.quantity}</span>
                        <button onclick="updateItemQuantity(${index}, 1)" class="text-green-500 px-2">+</button>
                    </td>
                    <td class="border px-4 py-2 text-right">PHP ${(item.price * item.quantity).toFixed(2)}</td>
                </tr>`;
        });

        cartHtml += '</tbody></table>';
        document.getElementById('cartItems').innerHTML = cartHtml;
        document.getElementById('cartTotalModal').textContent = `Total: PHP ${cart.reduce((acc, item) => acc + item.price * item.quantity, 0).toFixed(2)}`;

        openCartModal();
    }

    function openCartModal() {
        const modal = document.getElementById('cartModal');
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.add('modal-visible'), 10); // Adding a slight delay for smooth animation
    }

    function closeCartModal() {
        const modal = document.getElementById('cartModal');
        modal.classList.remove('modal-visible');
        setTimeout(() => modal.classList.add('hidden'), 300); // Delay to complete smooth close transition
    }

    function updateItemQuantity(index, change) {
        cart[index].quantity += change;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        updateCart();
        viewCart();
    }
</script>

</body>
</html>
