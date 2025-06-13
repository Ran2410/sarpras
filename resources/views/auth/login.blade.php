<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        .input-focus:focus {
            box-shadow: 0 0 0 2px rgba(107, 114, 128, 0.2);
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-xl shadow-sm p-8">
                <div class="text-center mb-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                    </svg>
                    <h1 class="text-2xl font-light text-gray-800 mt-4">Welcome back</h1>
                    <p class="text-gray-500 mt-1">Sign in to your account</p>
                </div>

                <form class="space-y-5" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" required 
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none input-focus transition-all duration-200"
                            placeholder="your@email.com">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        </div>
                        <input type="password" name="password" id="password" required 
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:outline-none input-focus transition-all duration-200"
                            placeholder="••••••••">
                    </div>

                    <button type="submit" 
                        class="w-full py-2.5 px-4 text-sm font-medium text-white bg-gray-800 hover:bg-gray-700 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Sign In
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-500">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="font-medium text-gray-700 hover:text-gray-900">Sign up</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>