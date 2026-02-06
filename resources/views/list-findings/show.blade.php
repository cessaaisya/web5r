<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show List Finding</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <header class="bg-blue-600 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">List Finding Details</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('list-findings.edit', $listFinding) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <a href="{{ route('list-findings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Daily Activity</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $listFinding->dailyActivity->zone }} - {{ $listFinding->dailyActivity->pic_name }}
                                    <br><span class="text-xs text-gray-500">{{ $listFinding->dailyActivity->date->format('Y-m-d') }}</span>
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Level</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ strtoupper($listFinding->level) }}</dd>
                            </div>

                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Countermeasure</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $listFinding->countermeasure }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Countermeasure Schedule</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $listFinding->countermeasure_schedule->format('Y-m-d') }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Progress</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($listFinding->progress == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($listFinding->progress == 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($listFinding->progress == 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $listFinding->progress)) }}
                                    </span>
                                </dd>
                            </div>

                            @if($listFinding->image)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Image</dt>
                                <dd class="mt-1">
                                    <img src="{{ asset('storage/' . $listFinding->image) }}" alt="Finding Image" class="max-w-xs h-auto rounded-lg shadow">
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>