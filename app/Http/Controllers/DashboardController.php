<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('items')
            ->latest()
            ->paginate(12);

        $stats = [
            'total' => Invoice::count(),
            'this_month' => Invoice::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'total_amount' => Invoice::sum('total_amount'),
        ];

        return view('dashboard.index', compact('invoices', 'stats'));
    }
}
