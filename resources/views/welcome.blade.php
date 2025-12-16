<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine Laptop</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom Background Pattern (Dot halus) */
        .bg-dot-pattern {
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 24px 24px;
        }

        /* Animasi Text Muncul */
        .animate-fade-up { animation: fadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(30px); }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 bg-dot-pattern min-h-screen flex flex-col">

    <nav class="w-full py-6 px-6 md:px-12 flex justify-between items-center bg-white/50 backdrop-blur-md fixed top-0 z-50 border-b border-gray-100">
        <a href="#" class="text-xl font-extrabold tracking-tighter text-black hover:opacity-80 transition">
            Meine Laptop
        </a>

        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-black transition-colors hidden md:block">
                Log In
            </a>
            <a href="{{ route('register') }}" class="bg-black text-white text-sm font-bold px-5 py-2.5 rounded-full hover:bg-gray-800 transition-transform transform hover:-translate-y-0.5 shadow-lg">
                Get Started
            </a>
        </div>
    </nav>

    <main class="flex-grow flex flex-col items-center justify-center pt-32 pb-20 px-4">
        
        <div class="max-w-4xl mx-auto text-center space-y-6 mb-20">
            <h1 class="animate-fade-up delay-100 text-5xl md:text-7xl font-extrabold tracking-tight text-black leading-[1.1]">
                Manage Your <br>
                <span class="text-gray-400">Laptop Rental.</span>
            </h1>

            <p class="animate-fade-up delay-200 text-lg text-gray-500 max-w-xl mx-auto leading-relaxed">
                The all-in-one platform to manage inventory, track tenants, and automate monthly billing effortlessly.
            </p>

            <div class="animate-fade-up delay-300 flex flex-col md:flex-row items-center justify-center gap-4 mt-8">
                <a href="{{ route('register') }}" class="group bg-black text-white px-8 py-4 rounded-full font-bold text-lg shadow-xl hover:shadow-2xl hover:bg-gray-900 transition-all flex items-center gap-2">
                    Start Managing
                    <i class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform duration-300"></i>
                </a>
                <a href="{{ route('login') }}" class="px-8 py-4 rounded-full font-bold text-gray-600 hover:text-black bg-white border border-gray-200 hover:border-gray-400 transition-all shadow-sm">
                    Log In Account
                </a>
            </div>
        </div>

        <div class="animate-fade-up delay-300 w-full max-w-6xl grid grid-cols-1 md:grid-cols-3 gap-6 px-4">
            
            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center mb-6 border border-gray-100 group-hover:bg-black group-hover:text-white transition-colors">
                    <i class="fa-solid fa-laptop text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Inventory Tracking</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Monitor stock availability, specifications, and unit status in real-time without the hassle.
                </p>
            </div>

            <div class="bg-black text-white p-8 rounded-3xl shadow-xl shadow-gray-400/20 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-gray-800 rounded-full blur-2xl opacity-50"></div>
                
                <div class="w-12 h-12 bg-gray-800 rounded-2xl flex items-center justify-center mb-6 border border-gray-700">
                    <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Smart Billing</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Automated monthly calculations. No more manual counting. Get precise billing instantly.
                </p>
            </div>

            <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 group">
                <div class="w-12 h-12 bg-gray-50 rounded-2xl flex items-center justify-center mb-6 border border-gray-100 group-hover:bg-black group-hover:text-white transition-colors">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Tenant Database</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Securely store and manage customer identity, rental history, and active statuses.
                </p>
            </div>

        </div>

    </main>

    <footer class="py-8 text-center border-t border-gray-200 bg-white">
        <p class="text-xs text-gray-400 font-medium">
            &copy; {{ date('Y') }} Meine Laptop System.
        </p>
    </footer>

</body>
</html>