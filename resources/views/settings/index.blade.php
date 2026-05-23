<x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">

<style>
.s-wrap { font-family: 'DM Sans', sans-serif; padding: 2rem 2.5rem; color: #e2e8f0; }

/* PAGE HEADER */
.s-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 2rem;
}
.s-header-left { display: flex; align-items: center; gap: 1rem; }
.s-header-icon {
    width: 2.75rem; height: 2.75rem;
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    border-radius: 0.75rem;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 16px rgba(245,158,11,0.3);
}
.s-header-title { font-size: 1.375rem; font-weight: 700; color: #f1f5f9; letter-spacing: -0.02em; }
.s-header-sub { font-size: 0.8rem; color: #475569; margin-top: 0.1rem; }
.s-badge {
    font-size: 0.7rem; font-weight: 600; letter-spacing: 0.06em;
    color: #f59e0b; background: rgba(245,158,11,0.1);
    border: 1px solid rgba(245,158,11,0.25);
    padding: 0.25rem 0.75rem; border-radius: 2rem;
}

/* LAYOUT: NAV + CONTENT */
.s-layout { display: grid; grid-template-columns: 200px 1fr; gap: 1.25rem; align-items: start; }

/* LEFT NAV */
.s-nav {
    background: #1e293b; border: 1px solid #2d3f55;
    border-radius: 0.875rem; padding: 0.375rem; position: sticky; top: 1.5rem;
}
.s-nav-item {
    width: 100%; display: flex; align-items: center; gap: 0.625rem;
    padding: 0.575rem 0.875rem; border-radius: 0.5rem;
    font-size: 0.825rem; font-weight: 500; color: #64748b;
    background: none; border: none; cursor: pointer;
    transition: all 0.15s; text-align: left; text-decoration: none;
}
.s-nav-item:hover { background: #263548; color: #94a3b8; }
.s-nav-item.active { background: rgba(245,158,11,0.1); color: #f59e0b; font-weight: 600; }
.s-nav-item i { width: 0.9rem; text-align: center; font-size: 0.775rem; flex-shrink: 0; }
.s-nav-sep { height: 1px; background: #2d3f55; margin: 0.3rem 0.5rem; }

/* PANELS */
.s-panel { display: none; flex-direction: column; gap: 1rem; }
.s-panel.active { display: flex; }

/* CARD */
.s-card {
    background: #1e293b; border: 1px solid #2d3f55;
    border-radius: 0.875rem; overflow: hidden;
}
.s-card-head {
    padding: 1rem 1.375rem; border-bottom: 1px solid #2d3f55;
    display: flex; align-items: center; justify-content: space-between;
}
.s-card-head-left { display: flex; align-items: center; gap: 0.5rem; }
.s-card-head-left i { color: #f59e0b; font-size: 0.8rem; }
.s-card-head-title { font-size: 0.875rem; font-weight: 600; color: #e2e8f0; }
.s-card-head-hint { font-size: 0.72rem; color: #475569; }
.s-card-body { padding: 1.375rem; display: flex; flex-direction: column; gap: 1.125rem; }

/* GRID ROW */
.s-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
.s-row-1 { display: grid; grid-template-columns: 1fr; }

/* FIELD */
.s-field { display: flex; flex-direction: column; gap: 0.35rem; }
.s-label {
    font-size: 0.72rem; font-weight: 600; color: #64748b;
    text-transform: uppercase; letter-spacing: 0.055em;
    display: flex; align-items: center; gap: 0.4rem;
}
.s-input {
    background: #0f172a; border: 1px solid #2d3f55;
    border-radius: 0.5rem; padding: 0.6rem 0.875rem;
    color: #e2e8f0; font-size: 0.875rem; font-family: 'DM Sans', sans-serif;
    transition: all 0.2s; outline: none; width: 100%;
}
.s-input:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,0.08); }
.s-input::placeholder { color: #2d3f55; }
textarea.s-input { resize: vertical; min-height: 5.5rem; line-height: 1.65; }

/* FILE UPLOAD */
.s-upload { display: flex; align-items: center; gap: 0.875rem; }
.s-upload-thumb {
    width: 4rem; height: 4rem; border-radius: 0.625rem;
    background: #0f172a; border: 1px solid #2d3f55;
    display: flex; align-items: center; justify-content: center;
    color: #2d3f55; font-size: 1.1rem; flex-shrink: 0; overflow: hidden;
}
.s-upload-thumb img { width: 100%; height: 100%; object-fit: cover; }
.s-upload-right { flex: 1; display: flex; flex-direction: column; gap: 0.3rem; }
.s-upload-name { font-size: 0.72rem; color: #475569; font-family: monospace; }
.s-file {
    width: 100%; padding: 0.475rem 0.75rem;
    background: #0f172a; border: 1px dashed #2d3f55;
    border-radius: 0.5rem; color: #475569; font-size: 0.775rem;
    cursor: pointer; transition: border-color 0.2s;
}
.s-file:hover { border-color: rgba(245,158,11,0.4); color: #64748b; }
.s-file::file-selector-button {
    background: rgba(245,158,11,0.12); color: #f59e0b;
    border: none; padding: 0.2rem 0.6rem; border-radius: 0.35rem;
    font-size: 0.72rem; font-weight: 600; cursor: pointer; margin-right: 0.5rem;
}

/* SOCIAL FIELD */
.s-social { display: flex; align-items: center; gap: 0.625rem; }
.s-social-icon {
    width: 2rem; height: 2rem; border-radius: 0.5rem;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.775rem; flex-shrink: 0;
}
.s-social-icon.fb { background: rgba(59,130,246,0.1); color: #60a5fa; }
.s-social-icon.ig { background: rgba(236,72,153,0.1); color: #f472b6; }
.s-social-icon.wa { background: rgba(34,197,94,0.1); color: #4ade80; }

/* STATUS CHIP */
.s-chip-ok {
    font-size: 0.68rem; font-weight: 500; color: #4ade80;
    background: rgba(74,222,128,0.08); border: 1px solid rgba(74,222,128,0.2);
    padding: 0.15rem 0.5rem; border-radius: 2rem;
    display: inline-flex; align-items: center; gap: 0.3rem;
}
.s-chip-ok::before { content:''; width:5px; height:5px; border-radius:50%; background:#4ade80; display:inline-block; }

/* ACTION BAR */
.s-actions {
    background: #1e293b; border: 1px solid #2d3f55;
    border-radius: 0.875rem; padding: 0.875rem 1.375rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
}
.s-actions-hint { font-size: 0.75rem; color: #475569; display: flex; align-items: center; gap: 0.375rem; }
.s-actions-hint i { color: #334155; }
.s-actions-btns { display: flex; gap: 0.5rem; }
.s-btn {
    padding: 0.525rem 1.125rem; border-radius: 0.5rem;
    font-size: 0.825rem; font-weight: 600; font-family: 'DM Sans', sans-serif;
    cursor: pointer; transition: all 0.2s; border: none;
    display: inline-flex; align-items: center; gap: 0.375rem;
}
.s-btn-ghost {
    background: transparent; border: 1px solid #2d3f55; color: #475569;
}
.s-btn-ghost:hover { background: #263548; color: #64748b; }
.s-btn-primary {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff; box-shadow: 0 2px 10px rgba(245,158,11,0.2);
}
.s-btn-primary:hover { box-shadow: 0 4px 18px rgba(245,158,11,0.38); transform: translateY(-1px); }
.s-btn-primary:active { transform: translateY(0); }

/* AUTO-SAVE PILL */
.s-saving {
    display: none; align-items: center; gap: 0.375rem;
    font-size: 0.72rem; color: #f59e0b;
    background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.18);
    padding: 0.2rem 0.6rem; border-radius: 2rem;
}
.s-saving.show { display: inline-flex; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.25} }
.s-saving-dot { width:5px; height:5px; border-radius:50%; background:#f59e0b; animation: blink 1s infinite; }
</style>

<div class="s-wrap">

    <!-- HEADER -->
    <div class="s-header">
        <div class="s-header-left">
            <div class="s-header-icon">
                <i class="fas fa-sliders text-white text-sm"></i>
            </div>
            <div>
                <div class="s-header-title">Pengaturan</div>
                <div class="s-header-sub">Konfigurasi sistem Stockify</div>
            </div>
        </div>
        <span class="s-badge">ADMIN ONLY</span>
    </div>

    <form id="settingsForm" enctype="multipart/form-data">
        @csrf

        <div class="s-layout">

            <!-- LEFT NAV -->
            <nav class="s-nav">
                <button type="button" class="s-nav-item active" onclick="switchTab('general', this)">
                    <i class="fas fa-building"></i> Informasi Umum
                </button>
                <button type="button" class="s-nav-item" onclick="switchTab('appearance', this)">
                    <i class="fas fa-image"></i> Logo & Favicon
                </button>
                <button type="button" class="s-nav-item" onclick="switchTab('social', this)">
                    <i class="fas fa-share-nodes"></i> Sosial Media
                </button>
                <div class="s-nav-sep"></div>
                <button type="button" class="s-nav-item" onclick="switchTab('contact', this)">
                    <i class="fas fa-address-card"></i> Kontak
                </button>
            </nav>

            <!-- RIGHT -->
            <div style="display:flex; flex-direction:column; gap:1rem;">

                <!-- PANEL: INFORMASI UMUM -->
                <div class="s-panel active" id="panel-general">
                    <div class="s-card">
                        <div class="s-card-head">
                            <div class="s-card-head-left">
                                <i class="fas fa-building"></i>
                                <span class="s-card-head-title">Informasi Aplikasi</span>
                            </div>
                            <span class="s-card-head-hint">Data identitas sistem</span>
                        </div>
                        <div class="s-card-body">
                            <div class="s-row-2">
                                <div class="s-field">
                                    <label class="s-label">Nama Aplikasi</label>
                                    <input type="text" name="app_name"
                                           value="{{ $setting->app_name ?? 'Stockify' }}"
                                           placeholder="Nama aplikasi..."
                                           class="s-input">
                                </div>
                                <div class="s-field">
                                    <label class="s-label">Email</label>
                                    <input type="email" name="email"
                                           value="{{ $setting->email ?? '' }}"
                                           placeholder="admin@domain.com"
                                           class="s-input">
                                </div>
                            </div>
                            <div class="s-field s-row-1">
                                <label class="s-label">Deskripsi</label>
                                <textarea name="app_description"
                                          placeholder="Deskripsi singkat aplikasi..."
                                          class="s-input">{{ $setting->app_description ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PANEL: LOGO & FAVICON -->
                <div class="s-panel" id="panel-appearance">
                    <div class="s-card">
                        <div class="s-card-head">
                            <div class="s-card-head-left">
                                <i class="fas fa-image"></i>
                                <span class="s-card-head-title">Logo & Favicon</span>
                            </div>
                            <span class="s-card-head-hint">Format: PNG, JPG, SVG</span>
                        </div>
                        <div class="s-card-body">

                            <!-- Logo -->
                            <div class="s-field">
                                <label class="s-label">
                                    Logo Aplikasi
                                    @if($setting->app_logo ?? false)
                                        <span class="s-chip-ok">Terpasang</span>
                                    @endif
                                </label>
                                <div class="s-upload">
                                    <div class="s-upload-thumb">
                                        @if($setting->app_logo ?? false)
                                            <img src="{{ Storage::url($setting->app_logo) }}" alt="Logo">
                                        @else
                                            <i class="fas fa-image"></i>
                                        @endif
                                    </div>
                                    <div class="s-upload-right">
                                        <div class="s-upload-name">
                                            {{ $setting->app_logo ? basename($setting->app_logo) : 'Belum ada file' }}
                                        </div>
                                        <input type="file" name="app_logo" accept="image/*" class="s-file">
                                    </div>
                                </div>
                            </div>

                            <!-- Favicon -->
                            <div class="s-field">
                                <label class="s-label">
                                    Favicon
                                    @if($setting->app_favicon ?? false)
                                        <span class="s-chip-ok">Terpasang</span>
                                    @endif
                                </label>
                                <div class="s-upload">
                                    <div class="s-upload-thumb">
                                        @if($setting->app_favicon ?? false)
                                            <img src="{{ Storage::url($setting->app_favicon) }}" alt="Favicon">
                                        @else
                                            <i class="fas fa-star"></i>
                                        @endif
                                    </div>
                                    <div class="s-upload-right">
                                        <div class="s-upload-name">
                                            {{ $setting->app_favicon ? basename($setting->app_favicon) : 'Belum ada file' }}
                                        </div>
                                        <input type="file" name="app_favicon" accept="image/*" class="s-file">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- PANEL: SOSIAL MEDIA -->
                <div class="s-panel" id="panel-social">
                    <div class="s-card">
                        <div class="s-card-head">
                            <div class="s-card-head-left">
                                <i class="fas fa-share-nodes"></i>
                                <span class="s-card-head-title">Sosial Media</span>
                            </div>
                            <span class="s-card-head-hint">Link platform sosial perusahaan</span>
                        </div>
                        <div class="s-card-body">
                            <div class="s-field">
                                <label class="s-label">Facebook</label>
                                <div class="s-social">
                                    <div class="s-social-icon fb"><i class="fab fa-facebook-f"></i></div>
                                    <input type="text" name="facebook"
                                           value="{{ $setting->facebook ?? '' }}"
                                           placeholder="https://facebook.com/namahalaman"
                                           class="s-input">
                                </div>
                            </div>
                            <div class="s-field">
                                <label class="s-label">Instagram</label>
                                <div class="s-social">
                                    <div class="s-social-icon ig"><i class="fab fa-instagram"></i></div>
                                    <input type="text" name="instagram"
                                           value="{{ $setting->instagram ?? '' }}"
                                           placeholder="https://instagram.com/username"
                                           class="s-input">
                                </div>
                            </div>
                            <div class="s-field">
                                <label class="s-label">WhatsApp</label>
                                <div class="s-social">
                                    <div class="s-social-icon wa"><i class="fab fa-whatsapp"></i></div>
                                    <input type="text" name="whatsapp"
                                           value="{{ $setting->whatsapp ?? '' }}"
                                           placeholder="628xxxxxxxxxx"
                                           class="s-input">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PANEL: KONTAK -->
                <div class="s-panel" id="panel-contact">
                    <div class="s-card">
                        <div class="s-card-head">
                            <div class="s-card-head-left">
                                <i class="fas fa-address-card"></i>
                                <span class="s-card-head-title">Informasi Kontak</span>
                            </div>
                            <span class="s-card-head-hint">Data kontak perusahaan</span>
                        </div>
                        <div class="s-card-body">
                            <div class="s-row-2">
                                <div class="s-field">
                                    <label class="s-label">No. Telepon</label>
                                    <input type="text" name="phone"
                                           value="{{ $setting->phone ?? '' }}"
                                           placeholder="021-xxxx / 08xx"
                                           class="s-input">
                                </div>
                                <div class="s-field">
                                    <label class="s-label">Email Kontak</label>
                                    <input type="email" name="email"
                                           value="{{ $setting->email ?? '' }}"
                                           placeholder="info@domain.com"
                                           class="s-input">
                                </div>
                            </div>
                            <div class="s-field s-row-1">
                                <label class="s-label">Alamat Lengkap</label>
                                <textarea name="address"
                                          placeholder="Jl. Contoh No. 123, Kota, Provinsi..."
                                          class="s-input">{{ $setting->address ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACTION BAR -->
                <div class="s-actions">
                    <div class="s-actions-hint">
                        <i class="fas fa-circle-info"></i>
                        Perubahan diterapkan setelah disimpan
                        <span class="s-saving" id="savingPill">
                            <span class="s-saving-dot"></span> Menyimpan...
                        </span>
                    </div>
                    <div class="s-actions-btns">
                        <button type="button" onclick="resetSettings()" class="s-btn s-btn-ghost">
                            <i class="fas fa-rotate-left"></i> Reset
                        </button>
                        <button type="submit" class="s-btn s-btn-primary">
                            <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
function switchTab(tab, btn) {
    document.querySelectorAll('.s-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.s-nav-item').forEach(n => n.classList.remove('active'));
    document.getElementById('panel-' + tab).classList.add('active');
    btn.classList.add('active');
}

let saveTimeout;
document.getElementById('settingsForm').addEventListener('input', function () {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => saveSettings(false), 2000);
});
document.getElementById('settingsForm').addEventListener('submit', function (e) {
    e.preventDefault();
    saveSettings(true);
});

function saveSettings(showAlert = true) {
    const pill = document.getElementById('savingPill');
    pill.classList.add('show');

    const formData = new FormData(document.getElementById('settingsForm'));
    formData.append('_method', 'PUT');

    fetch('{{ route("admin.settings.update") }}', {
        method: 'POST',
        body: formData,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    })
    .then(async res => {
        pill.classList.remove('show');
        const data = await res.json().catch(() => ({}));
        if (res.ok && data.success) {
            if (showAlert) {
                Swal.fire({
                    icon: 'success', title: 'Tersimpan!',
                    text: data.message || 'Pengaturan berhasil disimpan',
                    timer: 1800, showConfirmButton: false,
                    background: '#1e293b', color: '#e2e8f0', iconColor: '#f59e0b'
                });
            } else {
                Swal.fire({
                    toast: true, position: 'bottom-end', icon: 'success',
                    title: 'Auto-saved', showConfirmButton: false, timer: 1500,
                    background: '#1e293b', color: '#94a3b8', iconColor: '#4ade80'
                });
            }
        } else if (showAlert) {
            const msg = data?.errors
                ? Object.values(data.errors).flat().join('\n')
                : (data?.message || 'Gagal menyimpan');
            Swal.fire({ icon: 'error', title: 'Gagal', text: msg, background: '#1e293b', color: '#e2e8f0' });
        }
    })
    .catch(() => {
        pill.classList.remove('show');
        if (showAlert) Swal.fire({ icon: 'error', title: 'Koneksi Bermasalah', background: '#1e293b', color: '#e2e8f0' });
    });
}

function resetSettings() {
    Swal.fire({
        title: 'Reset Pengaturan?',
        text: 'Halaman akan dimuat ulang, perubahan yang belum disimpan akan hilang',
        icon: 'warning', showCancelButton: true,
        confirmButtonText: 'Reset', cancelButtonText: 'Batal',
        confirmButtonColor: '#ef4444', cancelButtonColor: '#475569',
        background: '#1e293b', color: '#e2e8f0'
    }).then(r => { if (r.isConfirmed) location.reload(); });
}
</script>

</x-app-layout>