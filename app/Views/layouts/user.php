<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'TickTrack') ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <!-- Topbar Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-40 backdrop-blur-sm bg-white/95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="<?= base_url('user/dashboard') ?>" class="flex items-center group">
                        <img src="<?= base_url('images/logo.png') ?>" alt="TickTrack Logo" class="h-12 group-hover:scale-105 transition-transform">
                    </a>
                </div>

                <!-- Right Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell -->
                    <a href="<?= base_url('user/notifications') ?>" class="relative p-2.5 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-xl transition-all">
                        <i data-feather="bell" class="w-5 h-5"></i>
                        <span id="nav-bell-badge" class="hidden absolute top-1.5 right-1.5 w-4 h-4 bg-red-500 rounded-full ring-2 ring-white flex items-center justify-center text-[10px] text-white font-bold">0</span>
                    </a>
                    
                    <!-- User Profile Pill & Dropdown -->
                    <div class="relative" id="user-menu-container">
                        <button onclick="document.getElementById('user-dropdown').classList.toggle('hidden')" class="flex items-center space-x-3 bg-gray-50 hover:bg-gray-100 transition-colors px-4 py-2 rounded-xl border border-transparent hover:border-gray-200 focus:outline-none">
                            <?php if(session('user_avatar')): ?>
                                <img src="<?= base_url(esc(session('user_avatar'))) ?>" alt="User Avatar" class="w-8 h-8 rounded-lg shadow-sm object-cover">
                            <?php else: ?>
                                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm uppercase">
                                    <?= substr(session('user_name') ?? 'U', 0, 2) ?>
                                </div>
                            <?php endif; ?>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-semibold text-gray-900"><?= esc(session('user_name')) ?></p>
                                <p class="text-xs text-gray-500">User</p>
                            </div>
                            <i data-feather="chevron-down" class="w-4 h-4 text-gray-500 hidden md:block"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50 animate-fade-in">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-900"><?= esc(session('user_name')) ?></p>
                                <p class="text-xs text-gray-500 mt-0.5"><?= esc(session('user_email')) ?></p>
                            </div>
                            <a href="<?= base_url('user/dashboard') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i data-feather="home" class="w-4 h-4 mr-3 text-gray-400"></i> Dashboard
                            </a>
                            <a href="<?= base_url('user/profile') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                <i data-feather="user" class="w-4 h-4 mr-3 text-gray-400"></i> Profil Saya
                            </a>
                            <a href="<?= base_url('user/notifications') ?>" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
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
    </nav>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center gap-3 mb-6 animate-fade-in">
                <i data-feather="check-circle" class="w-5 h-5 shrink-0"></i>
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg text-sm flex items-center gap-3 mb-6 animate-fade-in">
                <i data-feather="alert-circle" class="w-5 h-5 shrink-0"></i>
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <!-- Page Content -->
        <div class="animate-fade-in space-y-6">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

<script>
    feather.replace();
    document.addEventListener('click', function(event) {
        var container = document.getElementById('user-menu-container');
        var dropdown = document.getElementById('user-dropdown');
        if (container && !container.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

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
