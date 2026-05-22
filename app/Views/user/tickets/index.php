<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>
<!-- Search & Filter Bar -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
    <form action="<?= base_url('user/tickets') ?>" method="GET" class="flex flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[200px]">
            <div class="relative">
                <i data-feather="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="search" value="<?= esc($filters['search'] ?? '') ?>"
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    placeholder="Cari tiket...">
            </div>
        </div>
        <select name="status" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            <option value="">Semua Status</option>
            <option value="open" <?= ($filters['status'] ?? '') === 'open' ? 'selected' : '' ?>>Buka</option>
            <option value="in_progress" <?= ($filters['status'] ?? '') === 'in_progress' ? 'selected' : '' ?>>Diproses</option>
            <option value="resolved" <?= ($filters['status'] ?? '') === 'resolved' ? 'selected' : '' ?>>Selesai</option>
            <option value="rejected" <?= ($filters['status'] ?? '') === 'rejected' ? 'selected' : '' ?>>Ditolak</option>
        </select>
        <select name="priority" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
            <option value="">Semua Prioritas</option>
            <option value="low" <?= ($filters['priority'] ?? '') === 'low' ? 'selected' : '' ?>>Rendah</option>
            <option value="medium" <?= ($filters['priority'] ?? '') === 'medium' ? 'selected' : '' ?>>Sedang</option>
            <option value="high" <?= ($filters['priority'] ?? '') === 'high' ? 'selected' : '' ?>>Tinggi</option>
            <option value="urgent" <?= ($filters['priority'] ?? '') === 'urgent' ? 'selected' : '' ?>>Mendesak</option>
        </select>
        <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
            <i data-feather="filter" class="w-4 h-4 inline-block mr-1"></i> Filter
        </button>
        <a href="<?= base_url('user/tickets') ?>" class="px-4 py-2.5 bg-gray-100 text-gray-600 text-sm rounded-lg hover:bg-gray-200 transition-colors">Reset</a>
    </form>
</div>

<!-- Ticket List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="divide-y divide-gray-100">
        <?php if (empty($tickets)): ?>
            <div class="p-12 text-center">
                <i data-feather="inbox" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                <p class="text-gray-500 mb-4">Belum ada tiket yang sesuai filter.</p>
                <a href="<?= base_url('user/tickets/create') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i data-feather="plus" class="w-4 h-4"></i> Buat Tiket Baru
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($tickets as $ticket): ?>
                <a href="<?= base_url('user/tickets/' . $ticket['code']) ?>" class="block p-5 hover:bg-gray-50 transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-mono text-gray-400">#<?= esc($ticket['code']) ?></span>
                                <?php
                                    $statusColors = ['open' => 'text-blue-700 bg-blue-100', 'in_progress' => 'text-yellow-700 bg-yellow-100', 'resolved' => 'text-green-700 bg-green-100', 'rejected' => 'text-red-700 bg-red-100'];
                                    $priorityColors = ['low' => 'text-gray-600 bg-gray-100', 'medium' => 'text-blue-600 bg-blue-100', 'high' => 'text-orange-600 bg-orange-100', 'urgent' => 'text-red-600 bg-red-100'];
                                ?>
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full <?= $statusColors[$ticket['status']] ?? '' ?>">
                                    <?= format_status($ticket['status']) ?>
                                </span>
                                <span class="px-2 py-0.5 text-xs font-medium rounded-full <?= $priorityColors[$ticket['priority']] ?? '' ?>">
                                    <?= format_priority($ticket['priority']) ?>
                                </span>
                            </div>
                            <h4 class="text-sm font-semibold text-gray-800"><?= esc($ticket['title']) ?></h4>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-1"><?= esc(character_limiter($ticket['description'], 120)) ?></p>
                            <?php if (!empty($ticket['category_name'])): ?>
                                <span class="inline-block mt-2 px-2 py-0.5 text-xs font-medium rounded-full" style="background-color: <?= $ticket['category_color'] ?>20; color: <?= $ticket['category_color'] ?>">
                                    <?= esc($ticket['category_name']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="text-xs text-gray-400 whitespace-nowrap ml-4">
                            <?= date('d M Y', strtotime($ticket['created_at'])) ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Pagination -->
<?php if (!empty($tickets)): ?>
<div class="flex justify-center">
    <?= $pager->links('default', 'default_full') ?>
</div>
<?php endif; ?>
<?= $this->endSection() ?>
