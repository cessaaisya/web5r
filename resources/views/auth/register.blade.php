<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-maroon { background-color: #940404; }
        .bg-gold { background-color: #D4AF37; }
        .text-maroon { color: #940404; }
        .text-gold { color: #D4AF37; }
        .border-gold { border-color: #D4AF37; }
        .hover\:bg-gold:hover { background-color: #D4AF37; }
        .hover\:text-white:hover { color: white; }
        .focus\:ring-maroon:focus { --tw-ring-color: #940404; }
    </style>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md border-2 border-maroon">
        <h2 class="text-2xl font-bold mb-6 text-center text-maroon">Register</h2>
        @if(session('success'))
            <div class="mb-4 text-maroon">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 text-maroon">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-black">Name</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border border-gold rounded-lg focus:outline-none focus:ring-maroon focus:border-maroon" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-black">Email</label>
                <input type="email" name="email" id="email" class="w-full px-3 py-2 border border-gold rounded-lg focus:outline-none focus:ring-maroon focus:border-maroon" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-black">Password</label>
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gold rounded-lg focus:outline-none focus:ring-maroon focus:border-maroon" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-black">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border border-gold rounded-lg focus:outline-none focus:ring-maroon focus:border-maroon" required>
            </div>
            <button type="submit" class="w-full bg-maroon text-white py-2 rounded-lg hover:bg-gold hover:text-maroon focus:outline-none focus:ring-2 focus:ring-maroon">Register</button>
        </form>
        <p class="mt-4 text-center">Already have an account? <a href="{{ route('login') }}" class="text-maroon hover:text-gold">Login</a></p>
    </div>
</body>
</html>