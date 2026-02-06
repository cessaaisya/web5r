<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - 5R Analysis Report for Toyota</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/akti-logo.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .bg-maroon { background-color: #940404; }
        .bg-gold { background-color: #D4AF37; }
        .text-maroon { color: #940404; }
        .text-gold { color: #D4AF37; }
        .border-maroon { border-color: #940404; }
        .hover\:bg-gold:hover { background-color: #D4AF37; }
        .hover\:text-maroon:hover { color: #940404; }
        .focus\:ring-maroon:focus { --tw-ring-color: #940404; }
    </style>
</head>
<body class="bg-white">
    <div class="min-h-screen bg-white">
        <!-- Header -->
        <header class="bg-maroon shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">AKTI 5R Dashboard</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-white">Welcome, {{ auth()->user()->name }}</span>
                        <a href="{{ route('daily-activities.index') }}" class="bg-gold hover:bg-white text-maroon hover:text-maroon font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gold">
                            Daily Activities
                        </a>
                        <a href="{{ route('list-findings.index') }}" class="bg-gold hover:bg-white text-maroon hover:text-maroon font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gold">
                            List Findings
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-gold hover:bg-white text-maroon hover:text-maroon font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gold">
                                Logout
                            </button>  
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <!-- Overview Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                    @foreach($data as $key => $item)
                        <div class="bg-white overflow-hidden shadow rounded-lg border-2 border-maroon">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-maroon rounded-md flex items-center justify-center">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($key, 0, 1)) }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-black truncate">{{ $item['title'] }}</dt>
                                            <dd class="text-lg font-medium text-maroon">{{ count($item['metrics']) }} Metrics</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Detailed Reports -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($data as $key => $item)
                        <div class="bg-white shadow rounded-lg border-2 border-maroon">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-maroon mb-4">{{ $item['title'] }}</h3>
                                <p class="text-sm text-black mb-4">{{ $item['description'] }}</p>

                                <div class="space-y-3">
                                    @foreach($item['metrics'] as $metric => $value)
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-black">{{ $metric }}</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gold text-maroon">
                                                {{ $value }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Daily Activities Chart -->
                <div class="mt-8 bg-white shadow rounded-lg border-2 border-maroon">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-maroon mb-4">Daily Activities Overview</h3>
                        <canvas id="daily-activities-chart" width="800" height="400"></canvas>
                    </div>
                </div>

                <!-- Summary Section -->
                <div class="mt-8 bg-white shadow rounded-lg border-2 border-maroon">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-maroon mb-4">Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-maroon">{{ count($data) }}</div>
                                <div class="text-sm text-black">Zones</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-maroon">{{ collect($data)->sum(function($zone) { return $zone['metrics']['Total Activities']; }) }}</div>
                                <div class="text-sm text-black">Total Activities</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-maroon">{{ collect($data)->sum(function($zone) { return $zone['metrics']['Abnormalities']; }) }}</div>
                                <div class="text-sm text-black">Abnormalities</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-maroon">{{ collect($data)->sum(function($zone) { return $zone['metrics']['Findings']; }) }}</div>
                                <div class="text-sm text-black">Findings</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
                    <div class="bg-white shadow rounded-lg border-2 border-maroon">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-maroon mb-4">Abnormality Trends</h3>
                            <canvas id="abnormality-chart" width="400" height="200"></canvas>
                        </div>
                    </div>
                    <div class="bg-white shadow rounded-lg border-2 border-maroon">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-maroon mb-4">Findings Progress</h3>
                            <canvas id="progress-chart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        @php
            $zones = array_keys($data);
            $totalActivities = array_map(function($zone) use ($data) { return $data[$zone]['metrics']['Total Activities']; }, $zones);
            $abnormalities = array_map(function($zone) use ($data) { return $data[$zone]['metrics']['Abnormalities']; }, $zones);
            $findings = array_map(function($zone) use ($data) { return $data[$zone]['metrics']['Findings']; }, $zones);
        @endphp

        // Daily Activities Overview Chart
        var dailyActivitiesCtx = document.getElementById('daily-activities-chart').getContext('2d');
        var dailyActivitiesChart = new Chart(dailyActivitiesCtx, {
            type: 'bar',
            data: {
                labels: @json($zones),
                datasets: [
                    {
                        label: 'Total Activities',
                        data: @json($totalActivities),
                        backgroundColor: 'rgba(148, 4, 4, 0.6)',
                        borderColor: '#940404',
                        borderWidth: 2
                    },
                    {
                        label: 'Abnormalities',
                        data: @json($abnormalities),
                        backgroundColor: 'rgba(212, 175, 55, 0.6)',
                        borderColor: '#D4AF37',
                        borderWidth: 2
                    },
                    {
                        label: 'Findings',
                        data: @json($findings),
                        backgroundColor: 'rgba(0, 123, 255, 0.6)',
                        borderColor: '#007bff',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Abnormality trends chart
        var abnormalityCtx = document.getElementById('abnormality-chart').getContext('2d');
        var abnormalityChart = new Chart(abnormalityCtx, {
            type: 'line',
            data: {
                labels: @json($abnormalityTrends->pluck('date')),
                datasets: [{
                    label: 'Abnormalities Over Time',
                    data: @json($abnormalityTrends->pluck('count')),
                    backgroundColor: 'rgba(148, 4, 4, 0.6)',
                    borderColor: '#D4AF37',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Progress stats chart
        var progressCtx = document.getElementById('progress-chart').getContext('2d');
        var progressChart = new Chart(progressCtx, {
            type: 'pie',
            data: {
                labels: @json($progressStats->keys()->map(function($key) { return ucfirst(str_replace('_', ' ', $key)); })->toArray()),
                datasets: [{
                    label: 'Findings Progress',
                    data: @json($progressStats->values()->toArray()),
                    backgroundColor: [
                        'rgba(148, 4, 4, 0.6)',
                        'rgba(212, 175, 55, 0.6)',
                        'rgba(0, 123, 255, 0.6)',
                        'rgba(40, 167, 69, 0.6)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>
</body>
</html>