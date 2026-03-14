<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    <style>
        .auth-bg {
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }
        @media (prefers-reduced-motion: no-preference) {
            .auth-bg { background-attachment: fixed; }
        }
    </style>
</head>
<body class="auth-bg flex items-center justify-center min-h-screen" style="background-image: url('{{ asset('login-bg.jpg') }}');">
    <div class="absolute inset-0 bg-black opacity-40"></div>
    <div class="relative bg-white p-6 sm:p-8 rounded-lg shadow-md w-full max-w-md border-2 border-maroon" style="background-color: rgba(255,255,255,0.92);">
        <h2 class="text-2xl font-bold mb-6 text-center text-maroon">Login</h2>
        @if($errors->any())
            <div class="mb-4 text-maroon">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="credential" class="block text-black">NIM / Registration Number</label>
                <input type="text" name="credential" id="credential" class="w-full px-3 py-2 border border-gold rounded-lg focus:outline-none focus:ring-maroon focus:border-maroon" placeholder="Enter your NIM or Registration Number" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-black">Password</label>
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gold rounded-lg focus:outline-none focus:ring-maroon focus:border-maroon" required>
            </div>
            <button type="submit" class="w-full bg-maroon text-white py-2 rounded-lg hover:bg-gold hover:text-maroon focus:outline-none focus:ring-2 focus:ring-maroon">Login</button>
        </form>
        <p class="mt-4 text-center">Don't have an account? <a href="{{ route('register') }}" class="text-maroon hover:text-gold">Register</a></p>
    </div>
</body>
</html>