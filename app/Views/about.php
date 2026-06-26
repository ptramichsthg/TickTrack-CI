<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami — TickTrack</title>
    <meta name="description" content="Kenali tim pengembang di balik TickTrack — Sistem Helpdesk & Ticketing Modern.">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    animation: {
                        'float': 'float 4s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s ease-in-out infinite',
                    },
                    keyframes: {
                        float: { '0%,100%': { transform: 'translateY(0px)' }, '50%': { transform: 'translateY(-12px)' } },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 50%, #f3e8ff 100%); }
        .glass { background: rgba(255,255,255,0.7); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.8); }
        .glow-btn { box-shadow: 0 8px 30px rgba(37,99,235,0.4); }
        .gradient-text { background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 50%, #3b82f6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .card-hover { transition: all 0.3s cubic-bezier(0.4,0,0.2,1); }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
        .orb { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.5; }
        .nav-scroll { transition: all 0.3s ease; }
        .stat-number { font-variant-numeric: tabular-nums; }
    </style>
</head>
<body class="bg-slate-50 text-gray-900 overflow-x-hidden">

    <!-- ── NAVBAR ─────────────────────────────── -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 nav-scroll">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                <img src="<?= base_url('images/logo.png') ?>" alt="TickTrack Logo" class="h-12 group-hover:scale-105 transition-transform">
            </a>
            <div class="hidden md:flex items-center gap-8">
                <a href="/" class="text-sm text-gray-600 hover:text-blue-600 transition-colors font-medium">Beranda</a>
                <a href="#tim" class="text-sm text-gray-600 hover:text-blue-600 transition-colors font-medium">Tim Kami</a>
                <a href="#industri" class="text-sm text-gray-600 hover:text-blue-600 transition-colors font-medium">Industri 4.0</a>
                <a href="<?= base_url('about') ?>" class="text-sm text-blue-600 font-semibold">Tentang Kami</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="<?= base_url('auth/login') ?>" class="hidden md:inline-flex px-4 py-2 text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Masuk</a>
                <a href="<?= base_url('auth/register') ?>" class="hidden md:inline-flex px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all glow-btn">
                    Daftar Gratis
                </a>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 text-gray-600 hover:text-blue-600 focus:outline-none">
                    <i data-feather="menu" class="w-6 h-6"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu Panel -->
        <div id="mobile-menu" class="hidden md:hidden bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm">
            <div class="px-6 py-4 space-y-4 flex flex-col">
                <a href="/" class="text-base font-medium text-gray-600 hover:text-blue-600 mobile-link">Beranda</a>
                <a href="#tim" class="text-base font-medium text-gray-600 hover:text-blue-600 mobile-link">Tim Kami</a>
                <a href="#industri" class="text-base font-medium text-gray-600 hover:text-blue-600 mobile-link">Industri 4.0</a>
                <a href="<?= base_url('about') ?>" class="text-base font-semibold text-blue-600 mobile-link">Tentang Kami</a>
                <div class="h-px bg-gray-100 my-2"></div>
                <a href="<?= base_url('auth/login') ?>" class="text-base font-medium text-gray-600 hover:text-blue-600 mobile-link">Masuk</a>
                <a href="<?= base_url('auth/register') ?>" class="inline-flex justify-center px-5 py-3 text-base font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-all text-center">Daftar Gratis</a>
            </div>
        </div>
    </nav>

    <!-- ── HERO ───────────────────────────────── -->
    <section class="hero-gradient relative min-h-[70vh] flex items-center overflow-hidden">
        <!-- Orbs -->
        <div class="orb w-96 h-96 bg-blue-300 top-20 -left-32"></div>
        <div class="orb w-80 h-80 bg-cyan-300 bottom-20 -right-20"></div>
        <div class="orb w-64 h-64 bg-sky-200 top-1/2 left-1/2 -translate-x-1/2"></div>

        <!-- Grid lines -->
        <div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(rgba(0,0,0,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(0,0,0,.05) 1px,transparent 1px);background-size:60px 60px;"></div>

        <div class="max-w-7xl mx-auto px-6 py-32 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/60 backdrop-blur-md border border-white rounded-full text-sm font-semibold text-blue-700 mb-8 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse-slow"></span>
                    Tugas Besar — Teknologi Web
                    <i data-feather="arrow-right" class="w-3 h-3"></i>
                </div>

                <!-- Headline -->
                <h1 class="text-5xl md:text-7xl font-black mb-6 leading-[1.1] tracking-tight text-gray-900">
                    Tentang<br>
                    <span class="gradient-text">Kami</span>
                </h1>

                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto mb-10 leading-relaxed font-medium">
                    Kenali tim pengembang di balik <strong class="text-gray-900">TickTrack</strong> — platform helpdesk dan ticketing modern yang dibangun sebagai proyek Tugas Besar mata kuliah Teknologi Web.
                </p>

                <!-- Hero Stats -->
                <div class="grid grid-cols-3 gap-6 max-w-2xl mx-auto">
                    <?php $hero_stats = [['3','Anggota Tim'],['CI4','Framework'],['100%','Open Source']]; ?>
                    <?php foreach($hero_stats as $s): ?>
                    <div class="glass shadow-sm rounded-2xl p-5 text-center transform hover:-translate-y-1 transition-transform">
                        <div class="text-3xl font-black text-gray-900 stat-number"><?= $s[0] ?></div>
                        <div class="text-sm font-semibold text-gray-500 mt-1"><?= $s[1] ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Wave -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 80L1440 80L1440 40C1200 80 960 0 720 20C480 40 240 80 0 40L0 80Z" fill="#ffffff"/>
            </svg>
        </div>
    </section>

    <!-- ── TENTANG PROYEK ─────────────────────── -->
    <section class="bg-white py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-full text-sm font-bold mb-4">
                    <i data-feather="info" class="w-4 h-4"></i> Tentang Proyek
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">Apa Itu <span class="gradient-text">TickTrack</span>?</h2>
                <p class="text-gray-500 text-lg max-w-xl mx-auto">Sistem Helpdesk & Ticketing Modern untuk pengelolaan pengaduan pelanggan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $about_features = [
                    ['code','CodeIgniter 4','Dibangun menggunakan framework PHP CodeIgniter 4 dengan arsitektur MVC dan REST API untuk interoperabilitas sistem.','blue'],
                    ['layout','Tailwind CSS','Tampilan responsif dan modern menggunakan Tailwind CSS dengan desain yang konsisten di seluruh halaman.','cyan'],
                    ['database','MySQL Database','Basis data relasional MySQL untuk penyimpanan data tiket, pengguna, kategori, dan notifikasi.','purple'],
                    ['shield','Keamanan RBAC','Role-based access control untuk pemisahan akses Admin dan User, dilengkapi proteksi CSRF.','pink'],
                    ['bell','Notifikasi Real-time','Sistem polling notifikasi otomatis untuk pembaruan status tiket dan balasan baru.','orange'],
                    ['bar-chart-2','Dashboard Analitik','Visualisasi data interaktif menggunakan Chart.js untuk monitoring performa helpdesk.','teal'],
                ];
                foreach($about_features as $f): ?>
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm card-hover cursor-default">
                    <div class="w-14 h-14 bg-<?= $f[3] ?>-50 rounded-2xl flex items-center justify-center mb-6">
                        <i data-feather="<?= $f[0] ?>" class="w-7 h-7 text-<?= $f[3] ?>-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3"><?= $f[1] ?></h3>
                    <p class="text-base text-gray-500 leading-relaxed"><?= $f[2] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ── TIM PENGEMBANG ─────────────────────── -->
    <section id="tim" class="bg-slate-50 py-24 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-full text-sm font-bold mb-4">
                    <i data-feather="users" class="w-4 h-4"></i> Tim Pengembang
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">Anggota <span class="gradient-text">Kelompok</span></h2>
                <p class="text-gray-500 text-lg max-w-xl mx-auto">Mahasiswa Informatika yang berkolaborasi membangun TickTrack.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <?php
                $members = [
                    [
                        'name'  => 'Arnest Suhendra',
                        'nim'   => '2350081054',
                        'role'  => 'Project Leader & Backend Developer',
                        'icon'  => 'server',
                        'color' => 'blue',
                    ],
                    [
                        'name'  => 'Putra Michael Sitohang',
                        'nim'   => '2350081087',
                        'role'  => 'Full-Stack Developer & QA Tester',
                        'icon'  => 'terminal',
                        'color' => 'cyan',
                    ],
                ];
                foreach ($members as $m): ?>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm card-hover overflow-hidden flex flex-col items-center text-center justify-center">
                    <div class="p-8 relative w-full">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-<?= $m['color'] ?>-50 rounded-full text-xs font-bold text-<?= $m['color'] ?>-600 mb-4">
                            <i data-feather="<?= $m['icon'] ?>" class="w-3 h-3"></i>
                            <?= $m['role'] ?>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2"><?= $m['name'] ?></h3>
                        <p class="text-sm font-semibold text-blue-600 flex items-center justify-center gap-2">
                            <i data-feather="hash" class="w-3.5 h-3.5"></i>
                            NIM: <?= $m['nim'] ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ── INDUSTRI 4.0 ───────────────────────── -->
    <section id="industri" class="bg-white py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-600 rounded-full text-sm font-bold mb-4">
                    <i data-feather="cpu" class="w-4 h-4"></i> Relevansi Teknologi
                </div>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">TickTrack & <span class="gradient-text">Industri 4.0</span></h2>
                <p class="text-gray-500 text-lg max-w-2xl mx-auto">Bagaimana TickTrack mengadopsi prinsip-prinsip revolusi industri keempat dalam pengembangan sistem helpdesk berbasis web.</p>
            </div>

            <!-- Statistik Industri 4.0 -->
            <div class="rounded-[2.5rem] overflow-hidden relative shadow-2xl mb-16" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
                <div class="absolute inset-0 opacity-20" style="background-image:radial-gradient(circle at 2px 2px,rgba(255,255,255,.4) 1px,transparent 0);background-size:32px 32px;"></div>
                
                <div class="relative z-10 p-12 md:p-16">
                    <div class="text-center mb-12">
                        <h3 class="text-3xl md:text-4xl font-black text-white mb-4">Transformasi Digital</h3>
                        <p class="text-blue-100 text-lg max-w-2xl mx-auto">TickTrack mengubah penanganan pengaduan dari metode konvensional menjadi sistem digital yang otomatis, terstruktur, dan berbasis data — sejalan dengan semangat Industri 4.0.</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-white/20">
                        <?php
                        $i40_stats = [
                            ['REST API','Interoperabilitas'],
                            ['RBAC','Keamanan Akses'],
                            ['Real-time','Notifikasi'],
                            ['Chart.js','Data Analytics'],
                        ];
                        foreach($i40_stats as $index => $stat): ?>
                        <div class="text-center <?= $index === 0 ? 'border-none' : '' ?>">
                            <div class="text-3xl md:text-4xl font-black text-white mb-2 stat-number"><?= $stat[0] ?></div>
                            <div class="text-base font-medium text-blue-100"><?= $stat[1] ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Pilar Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                $pillars = [
                    ['globe','Interkonektivitas','Sistem REST API memungkinkan komunikasi antar-layanan dan integrasi dengan platform eksternal secara seamless.','blue'],
                    ['database','Transparansi Informasi','Setiap tiket memiliki jejak audit lengkap — dari pembuatan, diskusi, hingga penyelesaian.','purple'],
                    ['zap','Bantuan Teknis Cerdas','Notifikasi real-time dan kategorisasi otomatis membantu admin merespons pengaduan lebih cepat.','cyan'],
                    ['settings','Desentralisasi Keputusan','Role-based access control memungkinkan setiap stakeholder bertindak sesuai kapasitasnya.','pink'],
                ];
                foreach($pillars as $p): ?>
                <div class="bg-white rounded-2xl p-8 border border-gray-100 shadow-sm card-hover cursor-default">
                    <div class="w-14 h-14 bg-<?= $p[3] ?>-50 rounded-2xl flex items-center justify-center mb-6">
                        <i data-feather="<?= $p[0] ?>" class="w-7 h-7 text-<?= $p[3] ?>-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3"><?= $p[1] ?></h3>
                    <p class="text-sm text-gray-500 leading-relaxed"><?= $p[2] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ── CTA SECTION ────────────────────────── -->
    <section class="bg-slate-50 py-24 border-t border-gray-100">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-700 rounded-full text-sm font-bold mb-6">
                <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse-slow"></span>
                Gratis 100% untuk Memulai
            </div>
            <h2 class="text-4xl md:text-6xl font-black text-gray-900 mb-6 leading-tight">
                Siap Mencoba<br><span class="gradient-text">TickTrack?</span>
            </h2>
            <p class="text-gray-500 text-xl mb-10 max-w-2xl mx-auto leading-relaxed">
                Bergabung sekarang dan rasakan kemudahan dalam mengelola pengaduan pelanggan secara profesional dan tertata.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="<?= base_url('auth/register') ?>" class="group inline-flex items-center gap-3 px-10 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl hover:from-blue-700 hover:to-blue-800 transition-all glow-btn transform hover:scale-105 w-full sm:w-auto justify-center">
                    <i data-feather="user-plus" class="w-5 h-5"></i>
                    Daftar Sekarang — Gratis
                </a>
                <a href="<?= base_url('auth/login') ?>" class="inline-flex items-center gap-3 px-10 py-4 text-lg font-bold text-gray-700 bg-white border-2 border-gray-200 rounded-2xl hover:border-blue-500 hover:text-blue-600 transition-all w-full sm:w-auto justify-center shadow-sm">
                    <i data-feather="log-in" class="w-5 h-5"></i>
                    Sudah Punya Akun
                </a>
            </div>
        </div>
    </section>

    <!-- ── FOOTER ─────────────────────────────── -->
    <footer class="bg-white border-t border-gray-200 py-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <img src="<?= base_url('images/logo.png') ?>" alt="TickTrack Logo" class="h-10">
                <span class="text-gray-300">|</span>
                <span class="text-sm font-medium text-gray-500">Tugas Besar — Teknologi Web</span>
            </div>
            <p class="text-sm font-medium text-gray-400">&copy; <?= date('Y') ?> TickTrack. Hak cipta dilindungi.</p>
        </div>
    </footer>

    <script>
        feather.replace();

        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255,255,255,0.95)';
                navbar.style.backdropFilter = 'blur(10px)';
                navbar.style.borderBottom = '1px solid rgba(0,0,0,0.05)';
                navbar.style.boxShadow = '0 4px 6px -1px rgba(0,0,0,0.05)';
            } else {
                navbar.style.background = 'transparent';
                navbar.style.backdropFilter = 'none';
                navbar.style.borderBottom = 'none';
                navbar.style.boxShadow = 'none';
                mobileMenu.classList.add('hidden');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href'))?.scrollIntoView({ behavior: 'smooth' });
            });
        });

        // Animate on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.card-hover').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>
