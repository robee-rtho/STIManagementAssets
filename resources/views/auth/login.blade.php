<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="login-page min-h-screen flex items-center justify-center">

    <div class="card">
        <!-- Bagian Header dengan Logo dan Tulisan LOGIN -->
        <div class="flex justify-center items-center mb-6">
            <img src="{{ asset('http://127.0.0.1:8000/images/logo-pln.png') }}" alt="Logo" class="h-18 w-12 mr-2">
            <h2 class="text-2xl font-bold text-gray-700">LOGIN</h2>
        </div>

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-800 font-bold mb-2">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your email">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-800 font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter your password">
            </div>

            <div class="mb-4">
                <button type="submit"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Login</button>
            </div>
        </form>

        <!-- Link ke Register -->
        <div class="text-center">
            <p class="text-white font-bold">Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Register</a>
            </p>
        </div>
    </div>

</body>

</html>
