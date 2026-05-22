<!-- Admin Sidebar Component -->
<aside id="admin-sidebar" class="w-64 bg-white shadow-lg flex flex-col h-full border-r border-gray-100 fixed md:relative z-30 transition-transform transform -translate-x-full md:translate-x-0">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <div>
            <a href="<?= base_url('admin/dashboard') ?>" class="inline-block group">
                <img src="<?= base_url('images/logo.png') ?>" alt="TickTrack Logo" class="h-10 group-hover:scale-105 transition-transform">
            </a>
            <p class="text-xs text-gray-400 mt-1">Panel Administrasi</p>
        </div>
        <button id="sidebar-close-btn" class="md:hidden text-gray-500 hover:text-red-500 focus:outline-none">
            <i data-feather="x" class="w-5 h-5"></i>
        </button>
    </div>
    <nav class="mt-4 flex-1 px-3 overflow-y-auto">
        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>
        <?php
        $uri = uri_string();
        $links = [
            ['admin/dashboard','admin.dashboard','home','Dashboard'],
            ['admin/tickets','admin/tickets','tag','Tiket'],
            ['admin/users','admin/users','users','Pengguna'],
            ['admin/reports','admin/reports','bar-chart-2','Laporan'],
        ];
        foreach ($links as $l):
            $active = str_starts_with($uri, $l[0]) ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900';
        ?>
        <a href="<?= base_url($l[0]) ?>" class="flex items-center px-3 py-2.5 rounded-lg mb-1 transition-colors <?= $active ?>">
            <i data-feather="<?= $l[2] ?>" class="w-5 h-5 mr-3"></i><?= $l[3] ?>
        </a>
        <?php endforeach; ?>

        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Pengaturan</p>
        <a href="<?= base_url('admin/categories') ?>" class="flex items-center px-3 py-2.5 rounded-lg mb-1 transition-colors <?= str_starts_with($uri,'admin/categories')?'bg-blue-50 text-blue-700 font-medium':'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
            <i data-feather="folder" class="w-5 h-5 mr-3"></i>Kategori
        </a>
        <a href="<?= base_url('admin/settings') ?>" class="flex items-center px-3 py-2.5 rounded-lg mb-1 transition-colors <?= str_starts_with($uri,'admin/settings')?'bg-blue-50 text-blue-700 font-medium':'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
            <i data-feather="settings" class="w-5 h-5 mr-3"></i>Pengaturan
        </a>

        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Akun</p>
        <a href="<?= base_url('admin/profile') ?>" class="flex items-center px-3 py-2.5 rounded-lg mb-1 transition-colors <?= str_starts_with($uri,'admin/profile')?'bg-blue-50 text-blue-700 font-medium':'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
            <i data-feather="user" class="w-5 h-5 mr-3"></i>Profil Saya
        </a>
        <a href="<?= base_url('admin/notifications') ?>" class="flex items-center px-3 py-2.5 rounded-lg mb-1 transition-colors <?= str_starts_with($uri,'admin/notifications')?'bg-blue-50 text-blue-700 font-medium':'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
            <i data-feather="bell" class="w-5 h-5 mr-3"></i>Notifikasi
        </a>
    </nav>
    <div class="p-3 border-t border-gray-100">
        <a href="<?= base_url('auth/logout') ?>" class="w-full flex items-center px-3 py-2.5 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors">
            <i data-feather="log-out" class="w-5 h-5 mr-3"></i>Keluar
        </a>
    </div>
</aside>
