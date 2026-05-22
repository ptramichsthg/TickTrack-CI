<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Profil Saya</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi profil dan keamanan akun Anda</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg text-sm mb-6">
        <ul class="list-disc list-inside space-y-1">
            <?php foreach (session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="text-center">
                    <div class="relative inline-block">
                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&background=0D8ABC&color=fff&bold=true&size=128" alt="Profile" class="w-32 h-32 rounded-2xl shadow-lg mx-auto">
                        <button type="button" class="absolute bottom-0 right-0 w-10 h-10 bg-blue-600 text-white rounded-xl shadow-lg hover:bg-blue-700 transition-all flex items-center justify-center">
                            <i data-feather="camera" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <h3 class="mt-4 text-xl font-bold text-gray-900"><?= esc($user['name']) ?></h3>
                    <p class="text-sm text-gray-500"><?= esc($user['email']) ?></p>
                    <div class="mt-4 inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-sm font-medium">
                        <i data-feather="shield" class="w-4 h-4 mr-2"></i> Administrator
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-gray-100 space-y-3">
                    <div class="flex items-center text-sm text-gray-600">
                        <i data-feather="mail" class="w-4 h-4 mr-3 text-gray-400"></i>
                        <span><?= esc($user['email']) ?></span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i data-feather="calendar" class="w-4 h-4 mr-3 text-gray-400"></i>
                        <span>Bergabung sejak <?= date('Y', strtotime($user['created_at'])) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h2>
                </div>

                <form action="<?= base_url('admin/profile/update') ?>" method="POST" class="space-y-4">
                    <?= csrf_field() ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="<?= esc($user['name']) ?>" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="<?= esc($user['email']) ?>" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                    </div>

                    <div class="pt-4 border-t border-gray-100 mt-4">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4">Ubah Password (Opsional)</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                                <input type="password" name="current_password"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                <input type="password" name="new_password"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                <input type="password" name="new_password_confirmation"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all shadow-md">
                            <i data-feather="save" class="w-4 h-4 mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
