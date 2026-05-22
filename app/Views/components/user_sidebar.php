<!-- User Sidebar Component -->
<aside class="w-64 bg-white shadow-lg flex flex-col h-full border-r border-gray-100">
    <!-- Brand -->
    <div class="p-6 border-b border-gray-100">
        <a href="<?= base_url('user/dashboard') ?>" class="text-2xl font-bold text-blue-600 flex items-center">
            <i data-feather="activity" class="w-7 h-7 mr-2"></i>
            TickTrack
        </a>
        <p class="text-xs text-gray-400 mt-1">Helpdesk Support</p>
    </div>

    <!-- Navigation -->
    <nav class="mt-4 flex-1 px-3 overflow-y-auto">
        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu Utama</p>

        <a href="<?= base_url('user/dashboard') ?>"
            class="flex items-center px-3 py-2.5 rounded-lg mb-1 transition-colors <?= uri_string() === 'user/dashboard' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
            <i data-feather="home" class="w-5 h-5 mr-3"></i>
            Dashboard
        </a>

        <a href="<?= base_url('user/tickets') ?>"
            class="flex items-center px-3 py-2.5 rounded-lg mb-1 transition-colors <?= str_starts_with(uri_string(), 'user/tickets') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
            <i data-feather="tag" class="w-5 h-5 mr-3"></i>
            Tiket Saya
        </a>

        <a href="<?= base_url('user/tickets/create') ?>"
            class="flex items-center px-3 py-2.5 rounded-lg mb-1 transition-colors <?= uri_string() === 'user/tickets/create' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
            <i data-feather="plus-circle" class="w-5 h-5 mr-3"></i>
            Buat Tiket
        </a>

        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">Akun</p>

        <a href="<?= base_url('user/profile') ?>"
            class="flex items-center px-3 py-2.5 rounded-lg mb-1 transition-colors <?= uri_string() === 'user/profile' ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' ?>">
            <i data-feather="user" class="w-5 h-5 mr-3"></i>
            Profil Saya
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-3 border-t border-gray-100">
        <a href="<?= base_url('auth/logout') ?>"
            class="w-full flex items-center px-3 py-2.5 rounded-lg text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors">
            <i data-feather="log-out" class="w-5 h-5 mr-3"></i>
            Keluar
        </a>
    </div>
</aside>
