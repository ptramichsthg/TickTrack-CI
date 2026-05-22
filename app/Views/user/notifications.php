<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Notifikasi Anda</h1>
        <p class="text-sm text-gray-500 mt-1">Lihat semua pemberitahuan dan pembaruan terkait tiket support Anda.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Riwayat Notifikasi</h3>
        </div>
        
        <div class="divide-y divide-gray-100">
            <?php if(empty($notifications)): ?>
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-feather="bell-off" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Belum Ada Notifikasi</h3>
                    <p class="text-gray-500">Anda belum memiliki notifikasi baru saat ini.</p>
                </div>
            <?php else: ?>
                <?php foreach($notifications as $notif): 
                    $time_ago = '';
                    $created_at = new DateTime($notif['created_at']);
                    $now = new DateTime();
                    $interval = $now->diff($created_at);
                    if ($interval->d > 0) $time_ago = $interval->d . ' hari yang lalu';
                    elseif ($interval->h > 0) $time_ago = $interval->h . ' jam yang lalu';
                    elseif ($interval->i > 0) $time_ago = $interval->i . ' menit yang lalu';
                    else $time_ago = 'Baru saja';
                ?>
                <div class="p-5 hover:bg-gray-50 transition-colors flex items-start gap-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 <?= $notif['type'] === 'ticket_created' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600' ?>">
                        <i data-feather="<?= $notif['type'] === 'ticket_created' ? 'file-text' : 'bell' ?>" class="w-5 h-5"></i>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="text-sm font-bold text-gray-900"><?= esc($notif['title']) ?></h4>
                            <span class="text-xs text-gray-400"><?= $time_ago ?></span>
                        </div>
                        <p class="text-sm text-gray-600"><?= esc($notif['message']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
