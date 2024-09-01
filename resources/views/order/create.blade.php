<!-- resources/views/order/create.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <!-- Include Tailwind CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-2xl mx-auto bg-white p-6 shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-4">Create a New Order</h2>
    
    @if ($errors->any())
        <div class="mb-4 text-red-500">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="customer_name" class="block text-sm font-medium text-gray-700">Customer Name</label>
            <input type="text" name="customer_name" id="customer_name" required class="mt-1 p-2 block w-full border rounded-md">
        </div>

        <div class="mb-4">
            <label for="total" class="block text-sm font-medium text-gray-700">Total Amount</label>
            <input type="number" name="total" id="total" required class="mt-1 p-2 block w-full border rounded-md">
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Create Order</button>
    </form>
</div>

</body>
</html>
