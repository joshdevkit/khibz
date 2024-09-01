<!-- resources/views/order/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <!-- Include Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-2xl mx-auto bg-white p-6 shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Order Details</h2>
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
    <p><strong>Total Amount:</strong> ${{ $order->total }}</p>
    <!-- Add more order details as needed -->

    <h3 class="text-xl font-semibold mt-6 mb-2">QR Code for Order</h3>
    <div>
        <img src="data:image/png;base64, {!! base64_encode($qrCode) !!}" alt="QR Code">
    </div>
</div>

</body>
</html>
