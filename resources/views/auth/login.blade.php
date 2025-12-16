<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Meine Laptop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-300 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row">

        <div class="w-full lg:w-1/2 p-8 md:p-12 lg:p-14 flex flex-col justify-center">
            
            <div class="mb-8">
                <a href="/" class="text-xl font-bold tracking-tighter text-black text-2xl flex items-center gap-2">
                    Meine Laptop
                </a>
            </div>

            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-2">Welcome Back</h1>
                <p class="text-gray-500 text-sm">Please enter your details to sign in.</p>
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black focus:border-black transition-all outline-none placeholder-gray-400 bg-gray-50 focus:bg-white text-sm"
                            placeholder="name@gmail.com">
                    </div>
                    @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-black focus:border-black transition-all outline-none placeholder-gray-400 bg-gray-50 focus:bg-white text-sm"
                            placeholder="••••••••">
                    </div>
                    @error('password') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" 
                    class="w-full bg-black text-white font-bold py-3.5 rounded-xl hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-all transform hover:-translate-y-0.5 shadow-lg text-sm mt-2">
                    Log in
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-bold text-black hover:underline transition-all">
                    Register here
                </a>
            </div>

            <p class="mt-8 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Meine Laptop.
            </p>
        </div>

        <div class="hidden lg:block w-1/2 bg-black relative">
            <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?q=80&w=2071&auto=format&fit=crop" 
                 alt="Macbook Workspace" 
                 class="absolute inset-0 w-full h-full object-cover filter grayscale contrast-125 opacity-90">
            
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

            <div class="absolute bottom-10 left-10 right-10 text-white">
                <h2 class="text-2xl font-bold mb-2">Premium Laptop</h2>
                <p class="text-gray-300 text-sm leading-relaxed opacity-90">
                    Get your premium laptop with good price here!
                </p>
            </div>
        </div>

    </div>

</body>
</html>