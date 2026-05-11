@extends('layouts.app')

@section('page_title', 'Pengaturan Umum')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-white">Pengaturan Umum</h1>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="glass-effect p-8 rounded-3xl">

            <!-- GENERAL INFORMATION -->
            <div class="mb-10">
                <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-3">
                    <i class="fas fa-info-circle text-emerald-400"></i>
                    Informasi Aplikasi
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- App Name -->
                    <div>
                        <label class="block text-white/70 mb-2">Nama Aplikasi</label>
                        <input type="text" name="app_name" 
                               value="{{ old('app_name', $setting->app_name ?? config('app.name')) }}" 
                               class="w-full bg-slate-800 border border-slate-700 focus:border-emerald-500 rounded-2xl px-5 py-4 text-white">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-white/70 mb-2">Email Utama</label>
                        <input type="email" name="email" 
                               value="{{ old('email', $setting->email ?? '') }}" 
                               class="w-full bg-slate-800 border border-slate-700 focus:border-emerald-500 rounded-2xl px-5 py-4 text-white">
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-white/70 mb-2">Deskripsi Singkat</label>
                    <textarea name="app_description" rows="3" 
                              class="w-full bg-slate-800 border border-slate-700 focus:border-emerald-500 rounded-3xl px-5 py-4 text-white">{{ old('app_description', $setting->app_description ?? '') }}</textarea>
                </div>
            </div>

            <!-- LOGO & FAVICON -->
<div class="mb-10">
    <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-3">
        <i class="fas fa-image text-emerald-400"></i>
        Logo & Tampilan
    </h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- Logo Utama -->
        <div class="space-y-4">
            <label class="block text-white/70 font-medium">Logo Aplikasi</label>
            
            @if(isset($setting->app_logo) && $setting->app_logo)
                <div class="mb-4">
                    
                </div>
            @endif

            <div class="relative">
                <input type="file" 
                       name="app_logo" 
                       id="logo-input"
                       accept="image/png,image/jpeg,image/svg+xml, image/webp" 
                       class="hidden">
                
                <div onclick="document.getElementById('logo-input').click()" 
                     class="cursor-pointer border border-dashed border-slate-600 hover:border-emerald-500 transition-all rounded-3xl p-8 text-center">
                    <i class="fas fa-cloud-upload-alt text-4xl text-slate-400 mb-3"></i>
                    <p class="text-white/70">Klik untuk upload logo baru</p>
                    <p class="text-xs text-slate-500 mt-1">PNG, JPG, SVG, WebP (Max 2MB)</p>
                </div>
            </div>

            <!-- Preview Area -->
            <div id="logo-preview" class="hidden mt-4">
                <p class="text-xs text-white/50 mb-2">Preview Logo Baru:</p>
                <img id="logo-preview-img" 
                     class="h-28 w-auto object-contain bg-slate-900 p-3 rounded-2xl border border-emerald-500" 
                     alt="Logo Preview">
            </div>
        </div>

        <!-- Favicon -->
        <div class="space-y-4">
            <label class="block text-white/70 font-medium">Favicon</label>
            
            @if(isset($setting->app_favicon) && $setting->app_favicon)
                <div class="mb-4">
                    <p class="text-xs text-white/50 mb-2">Favicon Saat Ini:</p>
                    <img src="{{ asset('storage/' . $setting->app_favicon) }}" 
                         class="h-16 w-16 object-contain bg-slate-900 p-2 rounded-xl border border-slate-700" 
                         alt="Current Favicon">
                </div>
            @endif

            <div class="relative">
                <input type="file" 
                       name="app_favicon" 
                       id="favicon-input"
                       accept="image/png,image/x-icon,image/jpeg" 
                       class="hidden">
                
                <div onclick="document.getElementById('favicon-input').click()" 
                     class="cursor-pointer border border-dashed border-slate-600 hover:border-emerald-500 transition-all rounded-3xl p-8 text-center">
                    <i class="fas fa-cloud-upload-alt text-4xl text-slate-400 mb-3"></i>
                    <p class="text-white/70">Upload Favicon</p>
                    <p class="text-xs text-slate-500 mt-1">Disarankan ukuran 512x512 px</p>
                </div>
            </div>

            <div id="favicon-preview" class="hidden mt-4">
                <p class="text-xs text-white/50 mb-2">Preview Favicon Baru:</p>
                <img id="favicon-preview-img" 
                     class="h-16 w-16 object-contain bg-slate-900 p-2 rounded-xl border border-emerald-500" 
                     alt="Favicon Preview">
            </div>
        </div>

    </div>
</div>

            <!-- CONTACT -->
            <div class="mb-10">
                <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-3">
                    <i class="fas fa-address-book text-emerald-400"></i>
                    Informasi Kontak
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-white/70 mb-2">Nomor Telepon</label>
                        <input type="text" name="phone" 
                               value="{{ old('phone', $setting->phone ?? '') }}" 
                               class="w-full bg-slate-800 border border-slate-700 focus:border-emerald-500 rounded-2xl px-5 py-4 text-white">
                    </div>
                    <div>
                        <label class="block text-white/70 mb-2">Alamat</label>
                        <input type="text" name="address" 
                               value="{{ old('address', $setting->address ?? '') }}" 
                               class="w-full bg-slate-800 border border-slate-700 focus:border-emerald-500 rounded-2xl px-5 py-4 text-white">
                    </div>
                </div>
            </div>

            <!-- SOCIAL MEDIA -->
            <div>
                <h2 class="text-xl font-semibold text-white mb-6 flex items-center gap-3">
                    <i class="fas fa-share-alt text-emerald-400"></i>
                    Media Sosial
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-white/70 mb-2">Instagram</label>
                        <input type="url" name="instagram" placeholder="https://instagram.com/..."
                               value="{{ old('instagram', $setting->instagram ?? '') }}" 
                               class="w-full bg-slate-800 border border-slate-700 focus:border-emerald-500 rounded-2xl px-5 py-4 text-white">
                    </div>
                    <div>
                        <label class="block text-white/70 mb-2">Facebook</label>
                        <input type="url" name="facebook" placeholder="https://facebook.com/..."
                               value="{{ old('facebook', $setting->facebook ?? '') }}" 
                               class="w-full bg-slate-800 border border-slate-700 focus:border-emerald-500 rounded-2xl px-5 py-4 text-white">
                    </div>
                    <div>
                        <label class="block text-white/70 mb-2">WhatsApp</label>
                        <input type="text" name="whatsapp" placeholder="628xxxxxxxxxx"
                               value="{{ old('whatsapp', $setting->whatsapp ?? '') }}" 
                               class="w-full bg-slate-800 border border-slate-700 focus:border-emerald-500 rounded-2xl px-5 py-4 text-white">
                    </div>
                </div>
            </div>

            <!-- SUBMIT -->
            <div class="mt-12 flex justify-end">
                <button type="submit" 
                        class="bg-emerald-600 hover:bg-emerald-700 transition-all px-10 py-4 rounded-3xl font-semibold text-lg flex items-center gap-3 shadow-lg shadow-emerald-500/30">
                    <i class="fas fa-save"></i>
                    Simpan Semua Perubahan
                </button>
            </div>

        </div>
    </form>
</div>

<script>
document.getElementById('logo-input').addEventListener('change', function(e) {
    const preview = document.getElementById('logo-preview');
    const previewImg = document.getElementById('logo-preview-img');
    
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            previewImg.src = ev.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});

document.getElementById('favicon-input').addEventListener('change', function(e) {
    const preview = document.getElementById('favicon-preview');
    const previewImg = document.getElementById('favicon-preview-img');
    
    if (e.target.files && e.target.files[0]) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            previewImg.src = ev.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(e.target.files[0]);
    }
});
</script>
@endsection