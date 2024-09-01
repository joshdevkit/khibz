<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all reservations for the dashboard
        $reservations = Reservation::all();

        // Pass the reservations to the admin dashboard view
        return view('admin.dashboard', compact('reservations'));
    }

    /**
     * Show the page for managing reservations.
     *
     * @return \Illuminate\View\View
     */
    public function manageReservation()
    {
        $reservations = Reservation::all();
        return view('admin.manage-reservation', compact('reservations'));
    }

    /**
     * Show the page for managing the menu.
     *
     * @return \Illuminate\View\View
     */
    public function manageMenu()
    {
        // Logic to fetch and manage menu items
        return view('admin.manage-menu'); 
    }

    /**
     * Show the page for managing users.
     *
     * @return \Illuminate\View\View
     */
    public function manageUsers()
    {
        // Logic to fetch and manage users
        return view('admin.manage-users'); 
    }
}
