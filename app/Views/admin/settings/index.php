<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan Sistem</h1>
    <p class="text-sm text-gray-500 mt-1">Konfigurasi sistem dan preferensi aplikasi</p>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-2">
        <i data-feather="check-circle" class="w-5 h-5 shrink-0"></i>
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg text-sm">
        <ul class="list-disc list-inside space-y-1">
            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/settings/save') ?>" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <?= csrf_field() ?>

    <!-- Settings Form -->
    <div class="lg:col-span-2 space-y-6">

        <!-- General Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i data-feather="settings" class="w-5 h-5 mr-2"></i> Pengaturan Umum
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Aplikasi</label>
                    <input type="text" name="app_name"
                        value="<?= esc(old('app_name', $settings['app_name'] ?? 'TickTrack')) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Support</label>
                    <input type="email" name="support_email"
                        value="<?= esc(old('support_email', $settings['support_email'] ?? 'support@ticktrack.com')) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prefix Tiket</label>
                    <input type="text" name="ticket_prefix"
                        value="<?= esc(old('ticket_prefix', $settings['ticket_prefix'] ?? 'TT')) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-xs text-gray-400 mt-1">Huruf kapital, max 10 karakter. Contoh: TT → Kode tiket: TT-000001</p>
                </div>
            </div>
        </div>

        <!-- Ticket Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i data-feather="tag" class="w-5 h-5 mr-2"></i> Pengaturan Tiket
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prioritas Default</label>
                    <select name="default_priority" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="low"    <?= (($settings['default_priority'] ?? '') === 'low')    ? 'selected' : '' ?>>Rendah</option>
                        <option value="medium" <?= (($settings['default_priority'] ?? 'medium') === 'medium') ? 'selected' : '' ?>>Sedang</option>
                        <option value="high"   <?= (($settings['default_priority'] ?? '') === 'high')   ? 'selected' : '' ?>>Tinggi</option>
                        <option value="urgent" <?= (($settings['default_priority'] ?? '') === 'urgent') ? 'selected' : '' ?>>Mendesak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Auto Close Setelah (hari)</label>
                    <input type="number" name="auto_close_days" min="1"
                        value="<?= esc(old('auto_close_days', $settings['auto_close_days'] ?? '7')) ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Auto Assign Tiket</p>
                        <p class="text-xs text-gray-500">Otomatis assign tiket ke admin tersedia</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="auto_assign" class="sr-only peer" <?= ($settings['auto_assign'] ?? '1') === '1' ? 'checked' : '' ?>>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Notification Settings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i data-feather="bell" class="w-5 h-5 mr-2"></i> Pengaturan Notifikasi
            </h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Email Notifikasi</p>
                        <p class="text-xs text-gray-500">Kirim notifikasi via email</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="email_notif" class="sr-only peer" <?= ($settings['email_notif'] ?? '1') === '1' ? 'checked' : '' ?>>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Integrasi Slack</p>
                        <p class="text-xs text-gray-500">Kirim notifikasi ke Slack</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="slack_notif" class="sr-only peer" <?= ($settings['slack_notif'] ?? '0') === '1' ? 'checked' : '' ?>>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="space-y-6">
        <!-- Save Actions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
            <div class="space-y-3">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                    <i data-feather="save" class="w-5 h-5"></i> Simpan Pengaturan
                </button>
                <a href="<?= base_url('admin/settings') ?>" class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center gap-2 block text-center">
                    <i data-feather="refresh-cw" class="w-5 h-5 inline-block mr-1"></i> Reset / Batal
                </a>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Sistem</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Database</span>
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Online</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Environment</span>
                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full"><?= esc(ENVIRONMENT) ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">CodeIgniter</span>
                    <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-700 rounded-full"><?= CodeIgniter\CodeIgniter::CI_VERSION ?></span>
                </div>
            </div>
        </div>

        <!-- Maintenance Mode -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Mode Maintenance</h3>
            <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-gray-700">Maintenance Mode</p>
                    <p class="text-xs text-gray-500">Nonaktifkan akses user sementara</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="maintenance_mode" class="sr-only peer" <?= ($settings['maintenance_mode'] ?? '0') === '1' ? 'checked' : '' ?>>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                </label>
            </div>
            <p class="text-xs text-gray-400 mt-2">⚠️ Aktifkan hanya saat maintenance. User tidak bisa login.</p>
        </div>
    </div>
</form>
<?= $this->endSection() ?>
