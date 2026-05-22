<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>

<?php 
    $hour = date('H');
    $greeting = 'Selamat Pagi';
    if ($hour >= 12 && $hour < 15) {
        $greeting = 'Selamat Siang';
    } elseif ($hour >= 15 && $hour < 18) {
        $greeting = 'Selamat Sore';
    } elseif ($hour >= 18) {
        $greeting = 'Selamat Malam';
    }
?>

<!-- Welcome Banner -->
<div class="bg-blue-600 rounded-2xl shadow-md overflow-hidden relative">
    <div class="absolute right-0 top-0 opacity-10 pointer-events-none">
        <svg width="400" height="400" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="200" cy="200" r="200" fill="white"/>
        </svg>
    </div>
    <div class="p-8 md:p-10 flex flex-col md:flex-row items-center justify-between relative z-10">
        <div class="text-white mb-6 md:mb-0">
            <h1 class="text-3xl md:text-4xl font-bold mb-2"><?= $greeting ?>, <?= esc(session('user_name') ?? 'User') ?></h1>
            <p class="text-blue-100 text-lg">Kelola tiket support Anda dengan mudah dan cepat</p>
        </div>
        <div>
            <a href="<?= base_url('user/tickets/create') ?>" class="inline-flex items-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors shadow-sm">
                <i data-feather="plus" class="w-5 h-5 mr-2"></i> Buat Tiket Baru
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Tiket</p>
            <h3 class="text-3xl font-bold text-gray-900"><?= $stats['total'] ?></h3>
        </div>
        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
            <i data-feather="inbox" class="w-6 h-6 text-blue-600"></i>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Buka</p>
            <h3 class="text-3xl font-bold text-blue-600"><?= $stats['open'] ?></h3>
        </div>
        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
            <i data-feather="alert-circle" class="w-6 h-6 text-blue-500"></i>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Diproses</p>
            <h3 class="text-3xl font-bold text-yellow-600"><?= $stats['in_progress'] ?></h3>
        </div>
        <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
            <i data-feather="clock" class="w-6 h-6 text-yellow-600"></i>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Selesai</p>
            <h3 class="text-3xl font-bold text-green-600"><?= $stats['resolved'] ?></h3>
        </div>
        <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
            <i data-feather="check-circle" class="w-6 h-6 text-green-600"></i>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col md:flex-row gap-4">
    <div class="flex-1 relative">
        <i data-feather="search" class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2"></i>
        <input type="text" placeholder="Cari tiket..." class="w-full pl-12 pr-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500 text-sm">
    </div>
    <div class="w-full md:w-48">
        <select class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500 text-sm text-gray-700">
            <option value="">Semua Status</option>
        </select>
    </div>
    <div class="w-full md:w-48">
        <select class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500 text-sm text-gray-700">
            <option value="">Semua Prioritas</option>
        </select>
    </div>
    <div class="w-full md:w-48">
        <select class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-blue-500 text-sm text-gray-700">
            <option value="">Semua Tanggal</option>
        </select>
    </div>
</div>

<!-- Tickets List -->
<div class="space-y-4">
    <?php if (empty($recentTickets)): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-feather="inbox" class="w-8 h-8 text-gray-400"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Belum Ada Tiket</h3>
            <p class="text-gray-500 mb-6">Anda belum pernah membuat tiket support.</p>
            <a href="<?= base_url('user/tickets/create') ?>" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors">
                Buat Tiket Pertama
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($recentTickets as $ticket): 
            $statusColors = [
                'open'        => 'text-blue-700 bg-blue-50 border-blue-200',
                'in_progress' => 'text-yellow-700 bg-yellow-50 border-yellow-200',
                'resolved'    => 'text-green-700 bg-green-50 border-green-200',
                'rejected'    => 'text-red-700 bg-red-50 border-red-200',
            ];
            $priorityColors = [
                'low'    => 'text-gray-600 bg-gray-50 border-gray-200',
                'medium' => 'text-blue-600 bg-blue-50 border-blue-200',
                'high'   => 'text-orange-600 bg-orange-50 border-orange-200',
                'urgent' => 'text-red-600 bg-red-50 border-red-200',
            ];
            
            // Format Relative Time
            $created_at = new DateTime($ticket['created_at']);
            $now = new DateTime();
            $interval = $now->diff($created_at);
            if ($interval->d > 0) $time_ago = $interval->d . ' hari yang lalu';
            elseif ($interval->h > 0) $time_ago = $interval->h . ' jam yang lalu';
            elseif ($interval->i > 0) $time_ago = $interval->i . ' menit yang lalu';
            else $time_ago = 'Baru saja';
        ?>
        <a href="<?= base_url('user/tickets/' . $ticket['code']) ?>" class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all group">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors"><?= esc($ticket['title']) ?></h3>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg border <?= $statusColors[$ticket['status']] ?? '' ?>">
                            <?= format_status($ticket['status']) ?>
                        </span>
                        <span class="px-2.5 py-1 text-xs font-semibold rounded-lg border <?= $priorityColors[$ticket['priority']] ?? '' ?>">
                            <?= format_priority($ticket['priority']) ?>
                        </span>
                    </div>
                    <div class="flex items-center text-sm text-gray-500 mb-3 space-x-2">
                        <span class="font-medium text-gray-700">#<?= esc($ticket['code']) ?></span>
                        <span>&bull;</span>
                        <span>Dibuat <?= $time_ago ?></span>
                    </div>
                    <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                        <?= esc($ticket['description'] ?? 'Deskripsi detail masalah yang dialami pengguna.') ?>
                    </p>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <div class="flex items-center">
                            <i data-feather="message-square" class="w-4 h-4 mr-1.5 text-gray-400"></i> 0 balasan
                        </div>
                        <div class="flex items-center">
                            <i data-feather="clock" class="w-4 h-4 mr-1.5 text-gray-400"></i> Update <?= $time_ago ?>
                        </div>
                    </div>
                </div>
                <div class="ml-4 w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center group-hover:bg-blue-50 transition-colors">
                    <i data-feather="chevron-right" class="w-5 h-5 text-gray-400 group-hover:text-blue-600"></i>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
