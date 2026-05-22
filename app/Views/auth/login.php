<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <div class="mb-6 flex justify-center">
            <img src="<?= base_url('images/logo.png') ?>" alt="TickTrack Logo" class="h-20">
        </div>
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h2>
        <p class="text-gray-500">Masuk ke akun Anda untuk melanjutkan</p>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg text-sm flex items-start gap-3 animate-shake">
            <i data-feather="alert-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
            <div>
                <p class="font-semibold">Login Gagal</p>
                <p class="text-xs mt-1"><?= esc(session()->getFlashdata('error')) ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg text-sm flex items-start gap-3">
            <i data-feather="check-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
            <p><?= esc(session()->getFlashdata('success')) ?></p>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg text-sm animate-shake">
            <ul class="list-disc list-inside space-y-1">
                <?php foreach (session()->getFlashdata('errors') as $err): ?>
                    <li><?= esc($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Form Login -->
    <form action="<?= base_url('auth/login') ?>" method="POST" class="space-y-6">
        <?= csrf_field() ?>

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
                    class="w-full pl-12 pr-12 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all"
                    placeholder="••••••••">
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                    <button type="button" onclick="togglePassword()" class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
                        <i id="eye-icon" data-feather="eye" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember"
                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                <label for="remember" class="ml-2 block text-sm text-gray-700 cursor-pointer">Ingat saya</label>
            </div>
            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">Lupa password?</a>
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-base font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
            <i data-feather="log-in" class="w-5 h-5"></i>
            Masuk ke Akun
        </button>
    </form>

    <!-- Register Link -->
    <div class="text-center">
        <p class="text-sm text-gray-600">
            Belum punya akun?
            <a href="<?= base_url('auth/register') ?>" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">Daftar sekarang</a>
        </p>
    </div>
</div>

<script>
function togglePassword() {
    const pw = document.getElementById('password');
    const icon = document.getElementById('eye-icon');
    if (pw.type === 'password') {
        pw.type = 'text';
        icon.setAttribute('data-feather', 'eye-off');
    } else {
        pw.type = 'password';
        icon.setAttribute('data-feather', 'eye');
    }
    feather.replace();
}
</script>
<?= $this->endSection() ?>
