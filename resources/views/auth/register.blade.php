<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite('resources/css/app.css')
</head>

<body class="login-page">

    <div class="min-h-screen flex items-center justify-center">
        <div class="card">
            <!-- Bagian Header dengan Logo dan Tulisan REGISTER -->
            <div class="flex justify-center items-center mb-6">
                <img src="{{ asset('http://127.0.0.1:8000/images/logo-pln.png') }}" alt="Logo" class="h-18 w-12 mr-2">
                <h2 class="text-2xl font-bold text-gray-700">REGISTER</h2>
            </div>

            <!-- Form Register -->
            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-800 font-bold mb-2">Name</label>
                    <input type="text" id="name" name="name" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your name">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-800 font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your email">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-800 font-bold mb-2">Password</label>
                    <input type="password" id="password" name="password" required minlength="8"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your password">
                    
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-gray-800 font-bold mb-2">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Confirm your password">
                </div>

                <div class="mb-4">
                    <button type="submit"
                        class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">Register</button>
                </div>
            </form>

            <!-- Link ke Login -->
            <div class="text-center">
                <p class="text-black-800">Sudah punya akun?
                    <a href="{{ route('login.index') }}" class="text-blue-500 hover:underline">Login</a>
                </p>
            </div>
        </div>
    </div>

    

</body>

</html>
