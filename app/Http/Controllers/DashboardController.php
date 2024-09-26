<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Define the start of the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
    
        // Initialize empty data arrays
        $salesData = [];
        $reservationsData = [];
        $pendingOrdersData = [];
        $completedOrdersData = [];
        $completedReservationsCount = 0; // For counting only "Completed" reservations
    
        // Loop through the 4 weeks in the current month
        for ($week = 1; $week <= 4; $week++) {
            // Calculate start and end of each week
            $startOfWeek = $startOfMonth->copy()->addWeeks($week - 1)->startOfWeek();
            $endOfWeek = $startOfMonth->copy()->addWeeks($week - 1)->endOfWeek();

            // Adjust to include the current day for the current week
            if ($week == Carbon::now()->weekOfMonth) {
                $endOfWeek = Carbon::now();
            }
    
            // Calculate total sales for the week (Completed status only)
            $weeklySales = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                                ->where('status', 'Completed') // Count completed orders only
                                ->sum('total_price');
    
            // Add weekly sales to salesData array
            $salesData[] = $weeklySales;
    
            // Calculate total reservations for the week (status "Done" only)
            $weeklyReservations = DB::table('reservations')
                ->whereBetween('date', [$startOfWeek, $endOfWeek])
                ->where('status', 'Done') // Count only 'Done' reservations for the monthly chart
                ->count();
    
            // Add weekly reservations to reservationsData array
            $reservationsData[] = $weeklyReservations;
    
            // Calculate total pending orders for the week (status "Pending")
            $pendingOrders = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                                  ->where('status', 'Pending') // Count pending orders
                                  ->count();
    
            // Add pending orders count to pendingOrdersData array
            $pendingOrdersData[] = $pendingOrders;
    
            // Calculate total completed orders for the week (status "Completed")
            $completedOrders = Order::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                                    ->where('status', 'Completed') // Count completed orders
                                    ->count();
    
            // Add completed orders count to completedOrdersData array
            $completedOrdersData[] = $completedOrders;
        }

        // Calculate total "Completed" reservations for the entire month
        $completedReservationsCount = DB::table('reservations')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->where('status', 'Completed') // Count only 'Completed' reservations
            ->count();
    
        // Pass all data to the view
        return view('admin.dashboard', compact('salesData', 'reservationsData', 'pendingOrdersData', 'completedOrdersData', 'completedReservationsCount'));
    }
}
