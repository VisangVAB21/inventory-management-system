<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockify - Login</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .login-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        .warehouse-bg {
            position: fixed;
            inset: 0;
            background-image: 
                linear-gradient(rgba(15, 23, 42, 0.82), rgba(15, 23, 42, 0.92)),
                url('https://images.unsplash.com/photo-1586528116311-ad8dd3c83137?ixlib=rb-4.0.3&auto=format&fit=crop&q=80');
            background-size: cover;
            background-position: center;
            filter: blur(3px) brightness(0.75);
            z-index: -2;
        }

        .blue-overlay {
            position: fixed;
            inset: 0;
            background: linear-gradient(
                180deg,
                rgba(15, 23, 42, 0.65) 0%,
                rgba(30, 41, 59, 0.85) 40%,
                rgba(15, 23, 42, 0.95) 100%
            );
            z-index: -1;
        }

        .tech-grid {
            position: fixed;
            inset: 0;
            background-image: 
                linear-gradient(rgba(59, 130, 246, 0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.07) 1px, transparent 1px);
            background-size: 70px 70px;
            z-index: -1;
            opacity: 0.6;
        }

        .glow {
            position: absolute;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.18) 0%, transparent 70%);
            filter: blur(90px);
            z-index: -1;
        }
    </style>
</head>
<body class="login-bg flex items-center justify-center min-h-screen overflow-hidden">

    <!-- Background Layers -->
    <div class="warehouse-bg"></div>
    <div class="blue-overlay"></div>
    <div class="tech-grid"></div>

    <!-- Blue Glow Accents -->
    <div class="glow" style="top: -15%; left: -20%;"></div>
    <div class="glow" style="bottom: -20%; right: -15%; transform: scale(0.75);"></div>

    <!-- Login Card -->
    <div class="w-full max-w-md bg-slate-800/90 backdrop-blur-xl rounded-3xl shadow-2xl p-8 border border-slate-700/50 relative z-10 mx-4">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-10">
            <div class="w-20 h-20 bg-gradient-to-br from-blue-600 to-cyan-400 rounded-2xl flex items-center justify-center shadow-xl shadow-blue-500/30 mb-4">
                <i class="fa-solid fa-boxes-stacked text-white text-4xl"></i>
            </div>
            <h1 class="text-white text-3xl font-bold tracking-tighter">Stockify</h1>
            <p class="text-slate-400 text-sm mt-1">Inventory Management System</p>
        </div>

        <!-- Login Form -->
       <form method="POST" action="{{ route('login.post') }}">
    @csrf

            <!-- Email -->
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-2">Email or Username</label>
                <div class="relative">
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           class="w-full px-5 py-4 pl-12 bg-slate-900 border border-slate-700 rounded-2xl focus:border-blue-500 focus:ring-2 focus:ring-blue-600/50 text-white placeholder-slate-500 transition-all"
                           placeholder="Masukkan email atau username"
                           required autofocus>
                    <i class="fa-solid fa-user absolute left-5 top-1/2 -translate-y-1/2 text-slate-500"></i>
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-2">Password</label>
                <div class="relative">
                    <input type="password" 
                           name="password"
                           class="w-full px-5 py-4 pl-12 bg-slate-900 border border-slate-700 rounded-2xl focus:border-blue-500 focus:ring-2 focus:ring-blue-600/50 text-white placeholder-slate-500 transition-all"
                           placeholder="Masukkan password"
                           required>
                    <i class="fa-solid fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-slate-500"></i>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-slate-400 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 accent-blue-600 rounded border-slate-600">
                    <span class="ml-2">Ingat saya</span>
                </label>
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" 
                       class="text-blue-500 hover:text-blue-400 transition-colors">
                        Lupa Password?
                    </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 py-4 rounded-2xl text-white font-semibold text-lg transition-all duration-200 shadow-lg shadow-blue-600/40">
                Masuk ke Stockify
            </button>
        </form>

        <div class="text-center mt-8 text-slate-500 text-xs">
            © {{ date('Y') }} Stockify • Sistem Manajemen Inventori
        </div>
    </div>

</body>

<!-- SWEETALERT CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session('error') }}'
});
</script>
@endif

@if ($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    html: `{!! implode('<br>', $errors->all()) !!}`
});
</script>
@endif

</html>