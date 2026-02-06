<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Management</title>
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
                    <h1 class="text-3xl font-bold text-white">Reports Management</h1>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('reports.create') }}" class="bg-gold hover:bg-white text-maroon hover:text-maroon font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gold">
                            Add New Report
                        </a>
                        <a href="/dashboard" class="bg-gold hover:bg-white text-maroon hover:text-maroon font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gold">
                            Back to Dashboard
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
                @if(session('success'))
                    <div class="mb-4 bg-gold border border-maroon text-maroon px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white shadow overflow-hidden sm:rounded-md border-2 border-maroon">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-maroon">All Reports</h3>
                        <p class="mt-1 max-w-2xl text-sm text-black">Manage your 5R analysis reports</p>
                    </div>
                    <ul class="divide-y divide-gold">
                        @forelse($reports as $report)
                            <li>
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gold text-maroon">
                                                    {{ ucfirst($report->category) }}
                                                </span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-black">{{ $report->metric_name }}</div>
                                                <div class="text-sm text-maroon">Value: {{ $report->value }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('reports.show', $report) }}" class="text-maroon hover:text-gold">View</a>
                                            <a href="{{ route('reports.edit', $report) }}" class="text-maroon hover:text-gold">Edit</a>
                                            <form method="POST" action="{{ route('reports.destroy', $report) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-maroon hover:text-gold">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-4 py-4 sm:px-6 text-center text-black">
                                No reports found. <a href="{{ route('reports.create') }}" class="text-maroon hover:text-gold">Create one now</a>
                            </li>
                        @endforelse
                    </ul>
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gold sm:px-6">
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>