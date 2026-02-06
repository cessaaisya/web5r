<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Report</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
                    <h1 class="text-3xl font-bold text-white">View Report</h1>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('reports.edit', $report) }}" class="bg-gold hover:bg-white text-maroon hover:text-maroon font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gold">
                            Edit
                        </a>
                        <a href="{{ route('reports.index') }}" class="bg-gold hover:bg-white text-maroon hover:text-maroon font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gold">
                            Back to Reports
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
                <div class="bg-white shadow rounded-lg border-2 border-maroon">
                    <div class="px-4 py-5 sm:p-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-black">Category</dt>
                                <dd class="mt-1 text-sm text-black">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gold text-maroon">
                                        {{ ucfirst($report->category) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-black">Metric Name</dt>
                                <dd class="mt-1 text-sm text-black">{{ $report->metric_name }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-black">Value</dt>
                                <dd class="mt-1 text-sm text-black">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-maroon text-white">
                                        {{ $report->value }}
                                    </span>
                                </dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-black">Report Date</dt>
                                <dd class="mt-1 text-sm text-black">{{ $report->report_date ? $report->report_date->format('M d, Y') : 'Not set' }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-black">Created At</dt>
                                <dd class="mt-1 text-sm text-black">{{ $report->created_at->format('M d, Y H:i') }}</dd>
                            </div>
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-black">Updated At</dt>
                                <dd class="mt-1 text-sm text-black">{{ $report->updated_at->format('M d, Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                    <div class="bg-gold px-4 py-3 sm:px-6 flex justify-end space-x-3">
                        <a href="{{ route('reports.edit', $report) }}" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-maroon hover:bg-white hover:text-maroon focus:outline-none focus:ring-2 focus:ring-maroon">
                            Edit Report
                        </a>
                        <form method="POST" action="{{ route('reports.destroy', $report) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this report?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-maroon hover:bg-white hover:text-maroon focus:outline-none focus:ring-2 focus:ring-maroon">
                                Delete Report
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>