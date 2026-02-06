<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyActivity;
use App\Models\ListFinding;

class DashboardController extends Controller
{
    public function index()
    {
        // Get daily activities grouped by zone
        $activitiesByZone = DailyActivity::all()->groupBy('zone');

        $data = [];
        foreach ($activitiesByZone as $zone => $activities) {
            $abnormalityCount = $activities->where('abnormality', 'y')->count();
            $totalActivities = $activities->count();
            $findingsCount = ListFinding::whereIn('daily_activity_id', $activities->pluck('id'))->count();

            $data[$zone] = [
                'title' => ucfirst($zone),
                'description' => "Zone activities and findings overview.",
                'metrics' => [
                    'Total Activities' => $totalActivities,
                    'Abnormalities' => $abnormalityCount,
                    'Findings' => $findingsCount,
                ]
            ];
        }

        // Additional data for graphs
        $abnormalityTrends = DailyActivity::selectRaw('DATE(date) as date, COUNT(*) as count')
            ->where('abnormality', 'y')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $progressStats = ListFinding::selectRaw('progress, COUNT(*) as count')
            ->groupBy('progress')
            ->pluck('count', 'progress');

        return view('dashboard', compact('data', 'abnormalityTrends', 'progressStats'));
    }

    private function getDescription($category)
    {
        $descriptions = [
            'reduce' => 'Minimizing waste generation in Toyota production processes.',
            'reuse' => 'Reusing materials and components in manufacturing.',
            'recycle' => 'Recycling materials from end-of-life vehicles.',
            'recover' => 'Recovering energy from waste processes.',
            'rethink' => 'Innovating processes for sustainability.'
        ];

        return $descriptions[$category] ?? 'Description not available.';
    }
}