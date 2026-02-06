<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Report</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-maroon { background-color: #940404; }
        .bg-gold { background-color: #D4AF37; }
        .text-maroon { color: #940404; }
        .text-gold { color: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
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
                    <h1 class="text-3xl font-bold text-white">Create New Report</h1>
                    <div class="flex items-center space-x-4">
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
                        <form method="POST" action="{{ route('reports.store') }}">
                            @csrf

                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="category" class="block text-sm font-medium text-black">Category</label>
                                    <select name="category" id="category" class="mt-1 block w-full py-2 px-3 border border-gold bg-white rounded-md shadow-sm focus:outline-none focus:ring-maroon focus:border-maroon sm:text-sm" required>
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <p class="mt-1 text-sm text-maroon">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="metric_name" class="block text-sm font-medium text-black">Metric Name</label>
                                    <input type="text" name="metric_name" id="metric_name" value="{{ old('metric_name') }}" class="mt-1 block w-full py-2 px-3 border border-gold bg-white rounded-md shadow-sm focus:outline-none focus:ring-maroon focus:border-maroon sm:text-sm" required>
                                    @error('metric_name')
                                        <p class="mt-1 text-sm text-maroon">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="value" class="block text-sm font-medium text-black">Value</label>
                                    <input type="text" name="value" id="value" value="{{ old('value') }}" class="mt-1 block w-full py-2 px-3 border border-gold bg-white rounded-md shadow-sm focus:outline-none focus:ring-maroon focus:border-maroon sm:text-sm" required>
                                    @error('value')
                                        <p class="mt-1 text-sm text-maroon">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="report_date" class="block text-sm font-medium text-black">Report Date (Optional)</label>
                                    <input type="date" name="report_date" id="report_date" value="{{ old('report_date') }}" class="mt-1 block w-full py-2 px-3 border border-gold bg-white rounded-md shadow-sm focus:outline-none focus:ring-maroon focus:border-maroon sm:text-sm">
                                    @error('report_date')
                                        <p class="mt-1 text-sm text-maroon">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <a href="{{ route('reports.index') }}" class="bg-white py-2 px-4 border border-gold rounded-md shadow-sm text-sm font-medium text-maroon hover:bg-gold hover:text-white focus:outline-none focus:ring-2 focus:ring-maroon">
                                    Cancel
                                </a>
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-maroon hover:bg-gold focus:outline-none focus:ring-2 focus:ring-maroon">
                                    Create Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>