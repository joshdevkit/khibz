<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khibz Lounge - Reservation Details</title>
    @vite('resources/css/app.css')
    <style>
        .floor-plan {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            max-width: 100%;
            margin: 20px auto;
        }
        .table-cell {
            border: 2px solid #333;
            padding: 20px 0;
            text-align: center;
            cursor: pointer;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .selected {
            background-color: red;
            color: white;
        }
        .floor-plan-image {
            max-width: 100%;
            height: auto;
            margin: 20px auto;
            display: block;
        }
        #tableSelection {
            display: none;
        }
        .error {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: none; /* Hide error by default */
        }
    </style>
</head>
<body class="bg-white text-white">

@include('layouts._navbar')

<div class="bg-black text-white py-12">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-4">MAKE A RESERVATION</h1>
        <p class="text-center mb-8">Join us for an evening of great food, crafted cocktails, and lively atmosphere at our restobar. Whether you're planning a casual night out or a special celebration, reserving your table ensures you won't miss out on our unique blend of flavor and fun. Reserve now and let us take care of the rest!</p>

        <div class="bg-white text-black p-8 rounded shadow-lg mx-auto max-w-md">
            <h2 class="text-xl font-bold mb-4 text-center">Selected Date: {{ $selectedDate }}</h2> <!-- Display selected date -->
            <h2 class="text-xl font-bold mb-4 text-center">SELECT A TABLE TYPE</h2>
            <select id="tableType" class="w-full p-2 border border-gray-300 rounded mb-4">
                <option value="">Choose Table Type</option>
                <option value="VIP">VIP Table</option>
                <option value="Cocktail">Cocktail Table</option>
            </select>

            <div id="requirements" class="mb-4"></div>

            <div id="tableSelection">
                <h2 class="text-xl font-bold mb-4 text-center">SELECT A TABLE</h2>
                <p class="text-center text-sm">Click on a table to select it!</p>
                <div class="floor-plan" id="vipTables" style="display: none;">
                    @foreach (['Me1', 'Me2', 'Me3', 'Me4', 'Me5', 'Me6', 'Me7', 'MB1', 'MB2', 'MB3', 'MB4', 'MB5', 'MB6', 'MC1', 'MC2', 'MC3', 'MC4', 'MD1', 'MD2', 'MD3'] as $vipTable)
                        <div id="table-{{ $vipTable }}" class="table-cell" data-table="{{ $vipTable }}">{{ $vipTable }}</div>
                    @endforeach
                </div>
                <div class="floor-plan" id="cocktailTables" style="display: none;">
                    @foreach (range(1, 28) as $num)
                        <div id="table-A{{ $num }}" class="table-cell" data-table="A{{ $num }}">A{{ $num }}</div>
                    @endforeach
                </div>

                <input type="hidden" id="selectedTable" name="selectedTable" value="">

                <form method="GET" action="{{ route('reservation.form') }}" onsubmit="return validateSelection()">
                    <input type="hidden" id="date" name="date" value="{{ $selectedDate }}">
                    <input type="hidden" id="selectedTableInput" name="selectedTable" value="">
                    <div class="flex justify-between mt-4">
                        <button type="button" onclick="history.back()" class="bg-gray-500 text-white py-2 px-4 rounded">Back</button>
                        <button type="submit" class="bg-black text-white py-2 px-4 rounded">Next</button>
                    </div>
                    <p id="selectionError" class="error">Please select a table before proceeding.</p>
                </form>
            </div>
        </div>

        <div class="mt-12 text-center">
            <h3 class="text-lg font-semibold mb-4">FLOOR PLAN</h3>
            <p class="text-sm mb-4">You may check the table layout for your table reference!</p>
            <img id="floorPlanImage" src="{{ asset('images/FloorplanReg.png') }}" alt="Ground Floor Plan" class="floor-plan-image">
        </div>
    </div>
</div>

@include('layouts._footer')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableTypeSelect = document.getElementById('tableType');
        const requirementsDiv = document.getElementById('requirements');
        const tableSelectionDiv = document.getElementById('tableSelection');
        const vipTablesDiv = document.getElementById('vipTables');
        const cocktailTablesDiv = document.getElementById('cocktailTables');
        const selectedTableInput = document.getElementById('selectedTableInput');
        const selectionError = document.getElementById('selectionError');

        tableTypeSelect.addEventListener('change', function() {
            const selectedType = this.value;
            if (selectedType === 'VIP') {
                requirementsDiv.innerHTML = `
                    <h3 class="font-bold">VIP Reservation Requirements:</h3>
                    <ul>
                        <li>VIP guests must avail 1 bundle to reserve their VIP couch.</li>
                        <li>The VIP couch can accommodate 10-12 people.</li>
                        <li>To secure your reservation, a non-refundable downpayment of Php 1,000 should be settled. This amount will be deducted from the total bill on the day of your reservation.</li>
                        <li>Your table will be held for a duration of 1 hour. If your party has not arrived within this time, we reserve the right to disregard your reservation. (Waiting time starts at 8PM)</li>
                        <li>Entrance fee will be charged to your total bill.</li>
                    </ul>
                `;
                tableSelectionDiv.style.display = 'block';
                vipTablesDiv.style.display = 'grid'; // Show VIP tables
                cocktailTablesDiv.style.display = 'none'; // Hide Cocktail tables
            } else if (selectedType === 'Cocktail') {
                requirementsDiv.innerHTML = `
                    <h3 class="font-bold">TABLE COCKTAIL RESERVATION:</h3>
                    <ul>
                        <li>Minimum of 2 orders of cocktail towers or 1 hard drink.</li>
                        <li>To secure your reservation, a non-refundable downpayment of Php 1,000 should be settled. This amount will be deducted from the total bill on the day of your reservation.</li>
                        <li>Your table will be held for a duration of 30 mins. If your party has not arrived within this time, we reserve the right to disregard your reservation. (Waiting time starts at 8PM)</li>
                    </ul>
                `;
                tableSelectionDiv.style.display = 'block';
                vipTablesDiv.style.display = 'none'; // Hide VIP tables
                cocktailTablesDiv.style.display = 'grid'; // Show Cocktail tables
            } else {
                requirementsDiv.innerHTML = '';
                tableSelectionDiv.style.display = 'none';
                vipTablesDiv.style.display = 'none'; 
                cocktailTablesDiv.style.display = 'none';
            }
        });

        const tableCells = document.querySelectorAll('.table-cell');
        let selectedTable = null;

        tableCells.forEach(cell => {
            cell.addEventListener('click', function() {
                if (selectedTable) {
                    selectedTable.classList.remove('selected');
                }
                this.classList.add('selected');
                selectedTable = this;
                selectedTableInput.value = this.getAttribute('data-table'); 
                selectionError.style.display = 'none'; // Hide error when a table is selected
            });
        });
    });

    function validateSelection() {
        const selectedTable = document.getElementById('selectedTableInput').value;
        const selectionError = document.getElementById('selectionError');

        if (!selectedTable) {
            selectionError.style.display = 'block'; // Show error message
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>

</body>
</html>
