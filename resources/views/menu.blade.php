<!-- resources/views/menu.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khibz Lounge - Menu</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<!-- Include the Navigation Bar -->
@include('layouts._navbar')

<!-- Content for Menu Page -->
<div class="container mx-auto mt-6 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">Menu</h2>
    <p class="text-gray-700">Here is our menu content...</p>
</div>

</body>
</html>
