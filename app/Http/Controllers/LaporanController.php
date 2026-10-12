<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $monthFilter = $request->input('month');

        $query = Booking::query();
        
        if ($monthFilter) {
            $year = substr($monthFilter, 0, 4);
            $month = substr($monthFilter, 5, 2);
            $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
        }

        $totalPendapatan = (clone $query)->whereIn('status', ['dikonfirmasi', 'selesai'])->sum('total_price');
        $bookingSelesai  = (clone $query)->where('status', 'selesai')->count();
        $bookingAktif    = (clone $query)->where('status', 'dikonfirmasi')->count();
        $bookingBatal    = (clone $query)->where('status', 'dibatalkan')->count();

        // Monthly summary
        $monthlyStatsQuery = Booking::select(
                DB::raw("DATE_FORMAT(created_at, '%M %Y') as bulan"),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan_key"),
                DB::raw("COUNT(*) as total"),
                DB::raw("SUM(CASE WHEN status IN ('dikonfirmasi','selesai') THEN total_price ELSE 0 END) as pendapatan")
            );

        if ($monthFilter) {
            $year = substr($monthFilter, 0, 4);
            $month = substr($monthFilter, 5, 2);
            $monthlyStatsQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        }

        $monthlyStats = $monthlyStatsQuery->groupBy(DB::raw("DATE_FORMAT(created_at, '%M %Y')"), DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), 'desc')
            ->take(6)
            ->get();

        $recentBookings = (clone $query)->with('bookingItems.item')->latest()->take(50)->get();

        return view('admin.laporan', compact(
            'totalPendapatan',
            'bookingSelesai',
            'bookingAktif',
            'bookingBatal',
            'monthlyStats',
            'recentBookings',
            'monthFilter'
        ));
    }

    public function exportPdf(Request $request)
    {
        $monthFilter = $request->input('month');

        $query = Booking::query();
        
        if ($monthFilter) {
            $year = substr($monthFilter, 0, 4);
            $month = substr($monthFilter, 5, 2);
            $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
        }

        $totalPendapatan = (clone $query)->whereIn('status', ['dikonfirmasi', 'selesai'])->sum('total_price');
        $bookingSelesai  = (clone $query)->where('status', 'selesai')->count();
        $bookingAktif    = (clone $query)->where('status', 'dikonfirmasi')->count();
        $bookingBatal    = (clone $query)->where('status', 'dibatalkan')->count();

        $monthlyStatsQuery = Booking::select(
                DB::raw("DATE_FORMAT(created_at, '%M %Y') as bulan"),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan_key"),
                DB::raw("COUNT(*) as total"),
                DB::raw("SUM(CASE WHEN status IN ('dikonfirmasi','selesai') THEN total_price ELSE 0 END) as pendapatan")
            );

        if ($monthFilter) {
            $year = substr($monthFilter, 0, 4);
            $month = substr($monthFilter, 5, 2);
            $monthlyStatsQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        }

        $monthlyStats = $monthlyStatsQuery->groupBy(DB::raw("DATE_FORMAT(created_at, '%M %Y')"), DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
            ->orderBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), 'desc')
            ->take(6)
            ->get();

        $recentBookings = (clone $query)->with('bookingItems.item')->latest()->take(100)->get();

        $pdf = Pdf::loadView('admin.laporan_pdf', compact(
            'totalPendapatan',
            'bookingSelesai',
            'bookingAktif',
            'bookingBatal',
            'monthlyStats',
            'recentBookings',
            'monthFilter'
        ));

        $fileName = 'Laporan_CampRent' . ($monthFilter ? '_' . $monthFilter : '') . '.pdf';
        
        return $pdf->download($fileName);
    }
}
