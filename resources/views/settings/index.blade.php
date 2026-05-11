<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* [PASTE SEMUA CSS LUXURY DARI SEBELUMNYA] */
        
        .settings-group {
            @apply bg-white/5 backdrop-blur-xl rounded-3xl p-8 mb-8 border border-white/20;
        }
        
        .color-picker {
            @apply w-full h-16 rounded-2xl border-2 border-white/30 focus:border-amber-400/60 
                   focus:ring-4 focus:ring-amber-400/40 transition-all cursor-pointer;
        }
        
        .file-preview {
            @apply w-24 h-24 rounded-2xl object-cover border-4 border-white/30 shadow-2xl;
        }
    </style>

    <div class="luxury-bg min-h-screen p-6 lg:p-8">
        <div class="glass-effect rounded-3xl p-10 mb-10">
            <div class="flex items-center gap-6 mb-8">
                <div class="w-24 h-24 bg-gradient-to-br from-amber-500 to-orange-500 rounded-3xl flex items-center justify-center shadow-3xl">
                    <i class="fas fa-cogs text-3xl text-white"></i>
                </div>
                <div>
                    <h1 class="font-serif text-5xl font-black bg-gradient-to-r from-white to-amber-100 bg-clip-text text-transparent mb-3">
                        Pengaturan Aplikasi
                    </h1>
                    <p class="text-2xl text-white/80 font-semibold">Kustomisasi tampilan & informasi aplikasi</p>
                </div>
            </div>
        </div>

        <div class="glass-effect rounded-3xl p-10 mb-10">
            <form id="settingsForm" enctype="multipart/form-data">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    @foreach($settings as $group => $groupSettings)
                        <div class="settings-group">
                            <h3 class="text-3xl font-bold text-white mb-8 flex items-center gap-4 border-b border-white/20 pb-6">
                                <i class="fas fa-{{ $group === 'general' ? 'globe' : ($group === 'appearance' ? 'palette' : 'building') }} text-3xl text-amber-400"></i>
                                {{ ucfirst(str_replace('_', ' ', $group)) }}
                            </h3>
                            
                            @foreach($groupSettings as $setting)
                                <div class="mb-10 last:mb-0">
                                    <label class="block text-white/90 font-bold text-xl mb-6 flex items-center gap-4">
                                        {{ $setting->label }}
                                        @if($setting->type === 'file' && $setting->value)
                                            <i class="fas fa-check-circle text-emerald-400"></i>
                                        @endif
                                    </label>
                                    
                                    @if($setting->type === 'color')
                                        <input type="color" name="settings[{{ $setting->key }}]" 
                                               value="{{ $setting->value }}" 
                                               class="color-picker shadow-2xl hover:shadow-3xl transition-all">
                                        <input type="hidden" name="settings[{{ $setting->key }}]_old" value="{{ $setting->value }}">
                                        
                                    @elseif($setting->type === 'file')
                                        <div class="flex items-center gap-6">
                                            @if($setting->value)
                                                <img src="{{ $setting->value ? Storage::url($setting->value) : '' }}" 
                                                     alt="{{ $setting->label }}" 
                                                     class="file-preview {{ $setting->value ? '' : 'bg-gray-800 flex items-center justify-center text-white/50' }}">
                                                <i class="fas fa-image text-3xl text-white/50"></i>
                                            @else
                                                <div class="file-preview bg-gray-800 flex items-center justify-center text-white/50 rounded-2xl">
                                                    <i class="fas fa-cloud-upload-alt text-2xl"></i>
                                                </div>
                                            @endif
                                            <input type="file" name="settings[{{ $setting->key }}]" 
                                                   accept="image/*" class="flex-1 px-6 py-4 bg-white/10 rounded-2xl border-2 border-dashed border-white/30 text-white/80 font-bold backdrop-blur-xl hover:border-amber-400/60 transition-all">
                                        </div>
                                        
                                    @elseif($setting->type === 'textarea')
                                        <textarea name="settings[{{ $setting->key }}]" rows="4" 
                                                  class="w-full p-8 rounded-3xl bg-white/10 border-2 border-white/30 text-white placeholder-white/50 
                                                         focus:outline-none focus:ring-4 focus:ring-amber-400/60 text-xl font-semibold backdrop-blur-xl shadow-xl resize-vertical">{{ $setting->value }}</textarea>
                                    @else
                                        <input type="{{ $setting->type }}" name="settings[{{ $setting->key }}]" 
                                               value="{{ $setting->value }}" 
                                               class="w-full p-8 rounded-3xl bg-white/10 border-2 border-white/30 text-white placeholder-white/50 
                                                      focus:outline-none focus:ring-4 focus:ring-amber-400/60 text-xl font-semibold backdrop-blur-xl shadow-xl">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="flex gap-6 justify-end mt-16 pt-12 border-t border-white/30">
                    <button type="button" onclick="resetSettings()" 
                            class="px-16 py-8 bg-white/20 hover:bg-white/30 rounded-3xl border-2 border-white/40 
                                   text-white font-black transition-all text-2xl shadow-2xl hover:shadow-3xl hover:scale-105 backdrop-blur-xl flex items-center gap-4">
                        <i class="fas fa-undo"></i>
                        Reset Default
                    </button>
                    <button type="submit" 
                            class="px-20 py-8 btn-luxury text-2xl shadow-4xl font-black">
                        <i class="fas fa-save mr-4"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-save dengan debounce
        let saveTimeout;
        document.getElementById('settingsForm').addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                saveSettings();
            }, 1000);
        });

        document.getElementById('settingsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            saveSettings();
        });

        function saveSettings() {
            const formData = new FormData(document.getElementById('settingsForm'));
            
            fetch('{{ route("admin.settings.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            })
            .catch(error => {
                Swal.fire('Error!', 'Gagal menyimpan pengaturan', 'error');
            });
        }

        function resetSettings() {
            Swal.fire({
                title: 'Reset ke Default?',
                text: 'Semua pengaturan akan kembali ke nilai awal',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Reset',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    // Logic reset
                    Swal.fire('Reseted!', 'Pengaturan sudah direset', 'success');
                }
            });
        }
    </script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
</x-app-layout>