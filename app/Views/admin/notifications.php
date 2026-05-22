<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php
    $unreadCount = count(array_filter($notifications, fn($n) => !$n['is_read']));
    $filter = $_GET['filter'] ?? 'all';
    
    $filteredNotifications = $notifications;
    if ($filter === 'unread') {
        $filteredNotifications = array_filter($notifications, fn($n) => !$n['is_read']);
    }
?>

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola dan lihat semua notifikasi Anda</p>
        </div>
        <?php if ($unreadCount > 0): ?>
        <button onclick="fetch('<?= base_url('api/notifications/read') ?>', {method: 'POST'}).then(() => window.location.reload())"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
            <i data-feather="check-double" class="w-4 h-4 mr-2"></i> Tandai Semua Dibaca
        </button>
        <?php endif; ?>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center space-x-2 mb-6">
            <a href="<?= base_url('admin/notifications?filter=all') ?>" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors <?= $filter === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                Semua (<?= count($notifications) ?>)
            </a>
            <a href="<?= base_url('admin/notifications?filter=unread') ?>" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors <?= $filter === 'unread' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' ?>">
                Belum Dibaca (<?= $unreadCount ?>)
            </a>
        </div>

        <?php if (empty($filteredNotifications)): ?>
        <div class="text-center py-12">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-feather="bell-off" class="w-10 h-10 text-gray-400"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada notifikasi</h3>
            <p class="text-gray-500">Anda tidak memiliki notifikasi <?= $filter === 'unread' ? 'yang belum dibaca' : '' ?></p>
        </div>
        <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($filteredNotifications as $n): 
                $icon = 'bell';
                $color = 'gray';
                if ($n['type'] === 'ticket_reply') { $icon = 'message-square'; $color = 'blue'; }
                elseif ($n['type'] === 'ticket_status' || $n['type'] === 'ticket_created') { $icon = 'refresh-cw'; $color = 'yellow'; }
                elseif ($n['type'] === 'ticket_resolved') { $icon = 'check-circle'; $color = 'green'; }
            ?>
            <div class="flex items-start p-4 rounded-xl border transition-all hover:shadow-md <?= $n['is_read'] ? 'bg-white border-gray-200' : 'bg-blue-50 border-blue-200' ?>">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 mr-4 bg-<?= $color ?>-100">
                    <i data-feather="<?= $icon ?>" class="w-6 h-6 text-<?= $color ?>-600"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold mb-1 <?= $n['is_read'] ? 'text-gray-900' : 'text-blue-900' ?>">
                                <?= esc($n['title']) ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-2"><?= esc($n['message']) ?></p>
                            <p class="text-xs text-gray-500">
                                <?= date('d M Y, H:i', strtotime($n['created_at'])) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
