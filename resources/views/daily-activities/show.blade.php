<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Daily Activity</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <header class="bg-blue-600 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">Daily Activity Details</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('daily-activities.edit', $dailyActivity) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                        <a href="{{ route('daily-activities.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
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
                                <dt class="text-sm font-medium text-gray-500">Zone</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $dailyActivity->zone }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">PIC Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $dailyActivity->pic_name }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $dailyActivity->date->format('Y-m-d') }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Abnormality</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $dailyActivity->abnormality == 'y' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $dailyActivity->abnormality == 'y' ? 'Yes' : 'No' }}
                                    </span>
                                </dd>
                            </div>

                            @if($dailyActivity->image)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Image</dt>
                                <dd class="mt-1">
                                    <img src="{{ asset('storage/' . $dailyActivity->image) }}" alt="Activity Image" class="max-w-xs h-auto rounded-lg shadow">
                                </dd>
                            </div>
                            @endif
                        </dl>

                        @if($dailyActivity->abnormality == 'y')
                        <div class="mt-8">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Related Findings</h3>
                            @if($dailyActivity->listFindings->count() > 0)
                                <div class="space-y-4">
                                    @foreach($dailyActivity->listFindings as $finding)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="text-sm font-medium text-gray-900">Level: {{ strtoupper($finding->level) }}</h4>
                                                    <p class="text-sm text-gray-600 mt-1">{{ $finding->countermeasure }}</p>
                                                    <p class="text-sm text-gray-500 mt-1">Schedule: {{ $finding->countermeasure_schedule->format('Y-m-d') }}</p>
                                                    <p class="text-sm text-gray-500">Progress: {{ ucfirst(str_replace('_', ' ', $finding->progress)) }}</p>
                                                </div>
                                                @if($finding->image)
                                                    <img src="{{ asset('storage/' . $finding->image) }}" alt="Finding Image" class="w-16 h-16 object-cover rounded">
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No findings recorded for this activity.</p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>