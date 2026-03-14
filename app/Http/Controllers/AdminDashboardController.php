<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyActivity;
use App\Models\ListFinding;
use App\Models\User;
use App\Models\Report;
use App\Models\Role;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Admin can see all data with full administrative metrics
        $activitiesByZone = DailyActivity::all()->groupBy('zone');

        $data = [];
        foreach ($activitiesByZone as $zone => $activities) {
            $abnormalityCount = $activities->where('abnormality', 'y')->count();
            $totalActivities = $activities->count();
            $findingsCount = ListFinding::whereIn('daily_activity_id', $activities->pluck('id'))->count();
            $pendingFindings = ListFinding::whereIn('daily_activity_id', $activities->pluck('id'))
                ->where('progress', '!=', 'completed')
                ->count();
            $completedFindings = ListFinding::whereIn('daily_activity_id', $activities->pluck('id'))
                ->where('progress', 'completed')
                ->count();

            $data[$zone] = [
                'title' => ucfirst($zone),
                'description' => "Zone activities and findings overview.",
                'metrics' => [
                    'Total Activities' => $totalActivities,
                    'Abnormalities' => $abnormalityCount,
                    'Findings' => $findingsCount,
                    'Pending Findings' => $pendingFindings,
                    'Completed Findings' => $completedFindings,
                ]
            ];
        }

        // Additional admin data
        $abnormalityTrends = DailyActivity::selectRaw('DATE(date) as date, COUNT(*) as count')
            ->where('abnormality', 'y')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $progressStats = ListFinding::selectRaw('progress, COUNT(*) as count')
            ->groupBy('progress')
            ->pluck('count', 'progress');

        $totalUsers = User::count();
        $usersByRole = Role::withCount('users')->get();

        $recentReports = Report::latest()->take(10)->get();
        $totalActivities = DailyActivity::count();
        $totalFindings = ListFinding::count();

        return view('dashboard.admin', compact('data', 'abnormalityTrends', 'progressStats', 'totalUsers', 'usersByRole', 'recentReports', 'totalActivities', 'totalFindings'));
    }
}