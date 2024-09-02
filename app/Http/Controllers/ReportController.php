<?php

// ReportController.php

// ReportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'rowsPerPage' => 'integer|min:1|max:100',
            'search' => 'nullable|string|max:255',
            'startDate' => 'nullable|date_format:Y-m-d',
            'endDate' => 'nullable|date_format:Y-m-d|after_or_equal:startDate',
        ]);
    
        $rowsPerPage = $validated['rowsPerPage'] ?? 10; // Default is 10
        $searchQuery = $validated['search'] ?? '';
        $startDate = $validated['startDate'] ?? null;
        $endDate = $validated['endDate'] ?? null;
    
        $query = Reservation::where('status', 'Completed');
    
        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('name', 'like', "%{$searchQuery}%")
                  ->orWhere('email', 'like', "%{$searchQuery}%")
                  ->orWhere('contact', 'like', "%{$searchQuery}%")
                  ->orWhere('table_number', 'like', "%{$searchQuery}%");
            });
        }
    
        if ($startDate && $endDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate = Carbon::parse($endDate)->endOfDay();
            $query->whereBetween('date', [$startDate, $endDate]);
        }
    
        $completedReservations = $query->paginate($rowsPerPage);
    
        if ($request->ajax()) {
            return view('admin.partials.reservations_table', compact('completedReservations'));
        }
    
        return view('admin.reports', compact('completedReservations'));
    }
    
}



