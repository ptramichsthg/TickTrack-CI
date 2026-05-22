<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin — TickTrack') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>tailwind.config={theme:{extend:{fontFamily:{sans:['Inter','sans-serif']}}}}</script>
    <style>body{font-family:'Inter',sans-serif}@keyframes fadeIn{from{opacity:0}to{opacity:1}}.animate-fade-in{animation:fadeIn .3s ease-out}</style>
</head>
<body class="bg-gray-50">
<div class="flex h-screen relative">
    <!-- Overlay for mobile sidebar -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 hidden md:hidden"></div>
    
    <?= $this->include('components/admin_sidebar') ?>
    <main class="flex-1 overflow-x-hidden overflow-y-auto flex flex-col">
        <div class="bg-white shadow-sm sticky top-0 z-10">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center gap-3">
                    <button id="mobile-sidebar-btn" class="md:hidden text-gray-500 hover:text-blue-600 focus:outline-none">
                        <i data-feather="menu" class="w-6 h-6"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800"><?= esc($pageTitle ?? '') ?></h2>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell -->
                    <a href="<?= base_url('admin/notifications') ?>" class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all">
                        <i data-feather="bell" class="w-5 h-5"></i>
                        <span id="nav-bell-badge" class="hidden absolute top-1.5 right-1.5 w-4 h-4 bg-red-500 rounded-full ring-2 ring-white flex items-center justify-center text-[10px] text-white font-bold">0</span>
                    </a>
                    
                    <!-- User Profile Pill & Dropdown -->
                    <div class="relative" id="user-menu-container">
                        <button onclick="document.getElementById('user-dropdown').classList.toggle('hidden')" class="flex items-center space-x-3 bg-gray-50 hover:bg-gray-100 transition-colors px-4 py-2 rounded-xl border border-transparent hover:border-gray-200 focus:outline-none">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm uppercase">
                                <?= substr(session('user_name') ?? 'A', 0, 2) ?>
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-900"><?= esc(session('user_name')) ?></p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <i data-feather="chevron-down" class="w-4 h-4 text-gray-500 hidden md:block"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50 animate-fade-in">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900"><?= esc(session('user_name')) ?></p>
                                <p class="text-xs text-gray-500 mt-0.5"><?= esc(session('user_email')) ?></p>
                            </div>
                            <a href="<?= base_url('admin/dashboard') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i data-feather="home" class="w-4 h-4 mr-3 text-gray-400"></i> Dashboard
                            </a>
                            <a href="<?= base_url('admin/profile') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i data-feather="user" class="w-4 h-4 mr-3 text-gray-400"></i> Profil Saya
                            </a>
                            <a href="<?= base_url('admin/notifications') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i data-feather="bell" class="w-4 h-4 mr-3 text-gray-400"></i> Notifikasi
                                <span id="nav-dropdown-badge" class="hidden ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">0</span>
                            </a>
                            <div class="border-t border-gray-100 my-2"></div>
                            <a href="<?= base_url('auth/logout') ?>" class="flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <i data-feather="log-out" class="w-4 h-4 mr-3"></i> Keluar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 pt-4">
            <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-3 mb-4 animate-fade-in">
                <i data-feather="check-circle" class="w-5 h-5 shrink-0"></i><?= esc(session()->getFlashdata('success')) ?>
            </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg text-sm flex items-center gap-3 mb-4 animate-fade-in">
                <i data-feather="alert-circle" class="w-5 h-5 shrink-0"></i><?= esc(session()->getFlashdata('error')) ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="p-6 space-y-6 flex-1 animate-fade-in"><?= $this->renderSection('content') ?></div>
    </main>
</div>
<script>
    feather.replace();
    document.addEventListener('click', function(event) {
        var container = document.getElementById('user-menu-container');
        var dropdown = document.getElementById('user-dropdown');
        if (container && !container.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

    // Mobile Sidebar Toggle
    var sidebarBtn = document.getElementById('mobile-sidebar-btn');
    var sidebar = document.getElementById('admin-sidebar');
    var sidebarCloseBtn = document.getElementById('sidebar-close-btn');
    var sidebarOverlay = document.getElementById('sidebar-overlay');

    if (sidebarBtn) {
        sidebarBtn.addEventListener('click', function() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
        });
    }

    if (sidebarCloseBtn) {
        sidebarCloseBtn.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        });
    }

    function fetchNotifications() {
        fetch('<?= base_url('api/notifications/fetch') ?>')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    const badge1 = document.getElementById('nav-bell-badge');
                    const badge2 = document.getElementById('nav-dropdown-badge');
                    if (badge1 && badge2) {
                        if (data.unread_count > 0) {
                            badge1.innerText = data.unread_count > 9 ? '9+' : data.unread_count;
                            badge2.innerText = data.unread_count > 9 ? '9+' : data.unread_count;
                            badge1.classList.remove('hidden');
                            badge2.classList.remove('hidden');
                        } else {
                            badge1.classList.add('hidden');
                            badge2.classList.add('hidden');
                        }
                    }
                }
            }).catch(err => console.error(err));
    }

    fetchNotifications();
    setInterval(fetchNotifications, 30000);
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
