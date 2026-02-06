<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Findings</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <header class="bg-blue-600 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-white">List Findings</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('list-findings.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Add New
                        </a>
                        <a href="/dashboard" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-500">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        @forelse($listFindings as $finding)
                            <li>
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if($finding->image)
                                                    <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $finding->image) }}" alt="">
                                                @else
                                                    <div class="h-10 w-10 rounded-full bg-gray-300"></div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $finding->dailyActivity->zone }} - Level {{ $finding->level }}</div>
                                                <div class="text-sm text-gray-500">{{ $finding->countermeasure }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucfirst(str_replace('_', ' ', $finding->progress)) }}
                                            </span>
                                            <a href="{{ route('list-findings.show', $finding) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            <a href="{{ route('list-findings.edit', $finding) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            <form method="POST" action="{{ route('list-findings.destroy', $finding) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="px-4 py-4 sm:px-6">
                                <div class="text-center text-gray-500">No list findings found.</div>
                            </li>
                        @endforelse
                    </ul>
                </div>
                <div class="mt-4">
                    {{ $listFindings->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>