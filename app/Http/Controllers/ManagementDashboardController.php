<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyActivity;
use App\Models\ListFinding;
use App\Models\User;
use App\Models\Report;

class ManagementDashboardController extends Controller
{
    public function index()
    {
        // Management can see all data with additional management-specific metrics
        $activitiesByZone = DailyActivity::all()->groupBy('zone');

        $data = [];
        foreach ($activitiesByZone as $zone => $activities) {
            $abnormalityCount = $activities->where('abnormality', 'y')->count();
            $totalActivities = $activities->count();
            $findingsCount = ListFinding::whereIn('daily_activity_id', $activities->pluck('id'))->count();
            $pendingFindings = ListFinding::whereIn('daily_activity_id', $activities->pluck('id'))
                ->where('progress', '!=', 'completed')
                ->count();

            $data[$zone] = [
                'title' => ucfirst($zone),
                'description' => "Zone activities and findings overview.",
                'metrics' => [
                    'Total Activities' => $totalActivities,
                    'Abnormalities' => $abnormalityCount,
                    'Findings' => $findingsCount,
                    'Pending Findings' => $pendingFindings,
                ]
            ];
        }

        // Additional management data
        $abnormalityTrends = DailyActivity::selectRaw('DATE(date) as date, COUNT(*) as count')
            ->where('abnormality', 'y')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $progressStats = ListFinding::selectRaw('progress, COUNT(*) as count')
            ->groupBy('progress')
            ->pluck('count', 'progress');

        $totalUsers = User::count();
        $activeUsers = User::whereHas('roles', function($q) {
            $q->where('name', 'student');
        })->count();

        $recentReports = Report::latest()->take(5)->get();

        return view('dashboard.management', compact('data', 'abnormalityTrends', 'progressStats', 'totalUsers', 'activeUsers', 'recentReports'));
    }
}