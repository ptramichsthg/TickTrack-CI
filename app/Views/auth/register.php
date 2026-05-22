<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <div class="mb-6 flex justify-center">
            <img src="<?= base_url('images/logo.png') ?>" alt="TickTrack Logo" class="h-20">
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
        <p class="text-gray-500">Daftar untuk memulai menggunakan TickTrack</p>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg text-sm animate-shake">
            <ul class="list-disc list-inside space-y-1">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form Register -->
    <form action="<?= base_url('auth/register') ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-feather="user" class="w-5 h-5 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                </div>
                <input type="text" id="name" name="name" required value="<?= old('name') ?>"
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                    placeholder="Masukkan nama lengkap">
            </div>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-feather="mail" class="w-5 h-5 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                </div>
                <input type="email" id="email" name="email" required value="<?= old('email') ?>"
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                    placeholder="nama@perusahaan.com">
            </div>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
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
            <label for="password_confirm" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-feather="shield" class="w-5 h-5 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                </div>
                <input type="password" id="password_confirm" name="password_confirm" required
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                    placeholder="Ulangi password Anda">
            </div>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
            <i data-feather="user-plus" class="w-5 h-5"></i>
            Daftar Sekarang
        </button>
    </form>

    <!-- Login Link -->
    <div class="text-center">
        <p class="text-sm text-gray-600">
            Sudah punya akun?
            <a href="<?= base_url('auth/login') ?>" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">Masuk di sini</a>
        </p>
    </div>
</div>
<?= $this->endSection() ?>
