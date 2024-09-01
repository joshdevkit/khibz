<?php

// ReportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Define how many results you want per page
        $rowsPerPage = $request->query('rowsPerPage', 10); // Default is 10
        $searchQuery = $request->query('search', '');

        // Fetch only reservations with a 'Completed' status, filter by search, and paginate
        $completedReservations = Reservation::where('status', 'Completed')
            ->where(function ($query) use ($searchQuery) {
                $query->where('name', 'like', "%{$searchQuery}%")
                      ->orWhere('email', 'like', "%{$searchQuery}%")
                      ->orWhere('contact', 'like', "%{$searchQuery}%")
                      ->orWhere('table_number', 'like', "%{$searchQuery}%");
            })
            ->paginate($rowsPerPage);

        // Check if the request is AJAX
        if ($request->ajax()) {
            return view('admin.partials.reservations_table', compact('completedReservations'));
        }

        return view('admin.reports', compact('completedReservations'));
    }
}


