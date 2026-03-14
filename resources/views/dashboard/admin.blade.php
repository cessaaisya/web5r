<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - 5R Analysis Report for Toyota</title>
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
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white">AKTI 5R Dashboard</h1>
                    </div>

                    <div class="flex items-center md:hidden">
                        <button id="mobile-menu-button" aria-expanded="false" aria-label="Open menu" class="text-white focus:outline-none">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-        ="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>

                    <nav id="main-nav" class="hidden md:flex items-center space-x-4">
                        <span class="hidden md:inline text-sm text-white">Welcome, {{ auth()->user()->name }}</span>
                        <a href="{{ route('daily-activities.index') }}" class="bg-gold hover:bg-white text-maroon font-bold py-2 px-3 rounded focus:outline-none focus:ring-2 focus:ring-gold">
                            Daily Activities
                        </a>
                        <a href="{{ route('list-findings.index') }}" class="bg-gold hover:bg-white text-maroon font-bold py-2 px-3 rounded focus:outline-none focus:ring-2 focus:ring-gold">
                            List Findings
                        </a>
                        <a href="{{ route('reports.index') }}" class="bg-gold hover:bg-white text-maroon font-bold py-2 px-3 rounded focus:outline-none focus:ring-2 focus:ring-gold">
                            Reports
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-gold hover:bg-white text-maroon font-bold py-2 px-3 rounded focus:outline-none focus:ring-2 focus:ring-gold">
                                Logout
                            </button>
                        </form>
                    </nav>
                </div>

                <!-- Mobile menu (hidden by default) -->
                <div id="mobile-menu" class="md:hidden hidden mt-3 z-50">
                    <div class="space-y-2 px-2">
                        <div class="text-sm text-white px-2">Welcome, {{ auth()->user()->name }}</div>
                        <a href="{{ route('daily-activities.index') }}" class="block w-full text-left px-4 py-3 bg-gold text-maroon font-semibold rounded-md touch-manipulation">Daily Activities</a>
                        <a href="{{ route('list-findings.index') }}" class="block w-full text-left px-4 py-3 bg-gold text-maroon font-semibold rounded-md touch-manipulation">List Findings</a>
                        <form method="POST" action="{{ route('logout') }}" class="px-2 py-2">
                            @csrf
                            <button type="submit" class="w-full bg-gold text-maroon font-semibold py-3 rounded-md">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                

                <!-- Admin Overview Section -->
                <div class="mt-8 bg-white shadow rounded-lg border-2 border-maroon">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-maroon mb-4">System Administration Overview</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-maroon">{{ $totalUsers }}</div>
                                <div class="text-sm text-black">Total Users</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-maroon">{{ $totalActivities }}</div>
                                <div class="text-sm text-black">Total Activities</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-maroon">{{ $totalFindings }}</div>
                                <div class="text-sm text-black">Total Findings</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-maroon">{{ $recentReports->count() }}</div>
                                <div class="text-sm text-black">Recent Reports</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Roles Distribution -->
                <div class="mt-8 bg-white shadow rounded-lg border-2 border-maroon">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-maroon mb-4">User Roles Distribution</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @foreach($usersByRole as $role)
                            <div class="text-center">
                                <div class="text-2xl font-bold text-maroon">{{ $role->users_count }}</div>
                                <div class="text-sm text-black">{{ ucfirst($role->name) }}s</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Reports Section -->
                <div class="mt-8 bg-white shadow rounded-lg border-2 border-maroon">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-maroon mb-4">Recent Reports</h3>
                        <div class="space-y-4">
                            @foreach($recentReports as $report)
                            <div class="border-b border-gray-200 pb-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $report->title }}</h4>
                                        <p class="text-sm text-gray-500">{{ Str::limit($report->description, 100) }}</p>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $report->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-8 bg-white shadow rounded-lg border-2 border-maroon">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-maroon mb-4">Detailed Reports Overview</h3>
                        <div class="h-64 sm:h-96">
                            <canvas id="detailed-reports-chart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Daily Activities Chart -->
                <div class="mt-8 bg-white shadow rounded-lg border-2 border-maroon">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-maroon mb-4">Daily Activities Overview</h3>
                        <canvas id="daily-activities-chart" class="w-full h-64 sm:h-80"></canvas>
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
                            <canvas id="abnormality-chart" class="w-full h-48 sm:h-64"></canvas>
                        </div>
                    </div>
                    <div class="bg-white shadow rounded-lg border-2 border-maroon">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg leading-6 font-medium text-maroon mb-4">Findings Progress</h3>
                            <canvas id="progress-chart" class="w-full h-48 sm:h-64"></canvas>
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

        // Mobile menu toggle
        (function(){
            var btn = document.getElementById('mobile-menu-button');
            var menu = document.getElementById('mobile-menu');
            if(!btn || !menu) return;
            btn.addEventListener('click', function() {
                var expanded = btn.getAttribute('aria-expanded') === 'true';
                btn.setAttribute('aria-expanded', !expanded);
                menu.classList.toggle('hidden');
            });
        })();

        // Daily Activities Overview Chart
        var dailyActivitiesCtx = document.getElementById('daily-activities-chart').getContext('2d');
        var allDailyData = @json($totalActivities).concat(@json($abnormalities)).concat(@json($findings));
        var maxDailyValue = Math.max(...allDailyData);
        var maxDailyAxis = Math.ceil(maxDailyValue / 5) * 5 || 5;
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
                        beginAtZero: true,
                        max: maxDailyAxis,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                if(Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    }
                }
            }
        });

        // Power BI Style Chart for All Detailed Reports
        @php
            $sortedData = collect($data)->sortBy(function($item, $key) { return (int)$key; });
            $allLabels = [];
            $allMetricsData = [];
            $colors = ['rgba(75, 192, 192, 0.8)', 'rgba(54, 162, 235, 0.8)', 'rgba(255, 206, 86, 0.8)', 'rgba(153, 102, 255, 0.8)', 'rgba(255, 99, 132, 0.8)'];
            $borderColors = ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 99, 132, 1)'];
        @endphp

        @php
            foreach($sortedData as $key => $item) {
                $allLabels[] = $item['title'];
                foreach($item['metrics'] as $metric => $value) {
                    if(!isset($allMetricsData[$metric])) {
                        $allMetricsData[$metric] = [];
                    }
                    $allMetricsData[$metric][] = $value;
                }
            }
        @endphp

        var detailedReportsCtx = document.getElementById('detailed-reports-chart').getContext('2d');
        var datasets = [];
        @php
            $metricIndex = 0;
            foreach($allMetricsData as $metricName => $values) {
        @endphp
            datasets.push({
                label: '{{ $metricName }}',
                data: @json($values),
                backgroundColor: '{{ $colors[$metricIndex % count($colors)] }}',
                borderColor: '{{ $borderColors[$metricIndex % count($colors)] }}',
                borderWidth: 2,
                borderRadius: 5
            });
        @php
            $metricIndex++;
            }
        @endphp

        var allDetailedValues = [];
        datasets.forEach(function(dataset) {
            allDetailedValues = allDetailedValues.concat(dataset.data);
        });
        var maxDetailedValue = Math.max(...allDetailedValues);
        var maxDetailedAxis = Math.ceil(maxDetailedValue / 5) * 5 || 5;
        
        new Chart(detailedReportsCtx, {
            type: 'bar',
            data: {
                labels: @json($allLabels),
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    y: {
                        grid: {
                            display: true
                        },
                        max: maxDetailedAxis,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                if(Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
                    }
                }
            }
        });

        // Abnormality trends chart
        var abnormalityCtx = document.getElementById('abnormality-chart').getContext('2d');
        var abnormalityData = @json($abnormalityTrends->pluck('count'));
        var maxAbnormalityValue = Math.max(...abnormalityData);
        var maxAbnormalityAxis = Math.ceil(maxAbnormalityValue / 5) * 5 || 5;
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
                        beginAtZero: true,
                        max: maxAbnormalityAxis,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                if(Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        }
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