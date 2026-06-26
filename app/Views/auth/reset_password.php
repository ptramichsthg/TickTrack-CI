<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <div class="mb-6 flex justify-center">
            <img src="<?= base_url('images/logo.png') ?>" alt="TickTrack Logo" class="h-20">
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Password Baru</h2>
        <p class="text-gray-500">Masukkan password baru Anda di bawah ini</p>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg text-sm">
            <ul class="list-disc list-inside space-y-1">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form Reset -->
    <form action="<?= base_url('auth/reset-password') ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>
        <input type="hidden" name="token" value="<?= esc($token) ?>">

        <!-- New Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-feather="lock" class="w-5 h-5 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                </div>
                <input type="password" id="password" name="password" required
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                    placeholder="Minimal 6 karakter">
            </div>
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirm" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-feather="shield" class="w-5 h-5 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                </div>
                <input type="password" id="password_confirm" name="password_confirm" required
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                    placeholder="Ulangi password baru Anda">
            </div>
        </div>

        <button type="submit"
            class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
            <i data-feather="check-circle" class="w-5 h-5"></i>
            Simpan Password Baru
        </button>
    </form>

    <!-- Back to Login -->
    <div class="text-center">
        <a href="<?= base_url('auth/login') ?>" class="text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors flex items-center justify-center gap-1">
            <i data-feather="arrow-left" class="w-4 h-4"></i>
            Kembali ke halaman Login
        </a>
    </div>
</div>
<?= $this->endSection() ?>
