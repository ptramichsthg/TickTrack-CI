<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <div class="mb-6 flex justify-center">
            <img src="<?= base_url('images/logo.png') ?>" alt="TickTrack Logo" class="h-20">
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Lupa Password?</h2>
        <p class="text-gray-500">Masukkan email Anda untuk mendapatkan link reset password</p>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg text-sm flex items-start gap-3">
            <i data-feather="alert-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
            <p><?= esc(session()->getFlashdata('error')) ?></p>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg text-sm flex items-start gap-3">
            <i data-feather="check-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
            <div>
                <p><?= esc(session()->getFlashdata('success')) ?></p>
                <?php if (session()->getFlashdata('reset_link')): ?>
                    <div class="mt-3 p-3 bg-white border border-green-200 rounded-lg">
                        <p class="text-xs font-semibold text-gray-600 mb-1">🔗 Link Reset Password (Development Mode):</p>
                        <a href="<?= session()->getFlashdata('reset_link') ?>"
                           class="text-xs text-blue-600 underline break-all hover:text-blue-800">
                            <?= session()->getFlashdata('reset_link') ?>
                        </a>
                        <p class="text-xs text-gray-400 mt-1">⏰ Link berlaku 1 jam.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Form -->
    <form action="<?= base_url('auth/forgot-password') ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>

        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i data-feather="mail" class="w-5 h-5 text-gray-400 group-focus-within:text-blue-600 transition-colors"></i>
                </div>
                <input type="email" id="email" name="email" required value="<?= old('email') ?>"
                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                    placeholder="nama@perusahaan.com">
            </div>
        </div>

        <button type="submit"
            class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
            <i data-feather="send" class="w-5 h-5"></i>
            Kirim Link Reset
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
