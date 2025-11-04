<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DineEasy - Admin Portal</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-6 py-8">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="bg-gray-700 p-6 text-center">
                <h1 class="text-2xl font-bold text-white">DineEasy Admin</h1>
                <p class="text-gray-300 mt-2">Secure access to your dashboard</p>
            </div>

            {{-- Laravel form --}}
            <form method="POST" action="{{ route('admin.login') }}" class="p-6 space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-feather="mail" class="text-gray-400"></i>
                            </div>
                            <input id="email" name="email" type="email" required
                                class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-700 focus:border-gray-700"
                                placeholder="admin@example.com">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-feather="lock" class="text-gray-400"></i>
                            </div>
                            <input id="password" name="password" type="password" required
                                class="pl-10 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-gray-700 focus:border-gray-700"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox"
                            class="h-4 w-4 text-gray-700 focus:ring-gray-700 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-gray-600 hover:text-gray-800">Forgot password?</a>
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="w-full flex justify-center py-2 px-4 rounded-md shadow-sm text-sm font-medium text-white bg-gray-700 hover:bg-gray-800 focus:ring-2 focus:ring-offset-2 focus:ring-gray-600">
                        Sign in
                    </button>
                </div>

                @if(session('error'))
                    <p class="text-red-500 text-sm text-center mt-2">{{ session('error') }}</p>
                @endif
            </form>

            <div class="bg-gray-50 px-6 py-4 text-center">
                <p class="text-xs text-gray-500">&copy; 2025 DineEasy. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
