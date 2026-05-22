<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
    <?php
    $cards = [
        ['Total Tiket',  $stats['total'],       'tag',          'blue'],
        ['Buka',         $stats['open'],         'clock',        'yellow'],
        ['Diproses',     $stats['in_progress'],  'loader',       'orange'],
        ['Selesai',      $stats['resolved'],     'check-circle', 'green'],
        ['Total Pengguna', $stats['total_users'],  'users',        'purple'],
    ];
    foreach ($cards as $c): ?>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600"><?= $c[0] ?></p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $c[1] ?></h3>
            </div>
            <div class="p-3 bg-<?= $c[3] ?>-50 rounded-lg">
                <i data-feather="<?= $c[2] ?>" class="w-6 h-6 text-<?= $c[3] ?>-600"></i>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Chart + Recent -->
<div class="grid grid-cols-12 gap-6">
    <!-- Recent Tickets -->
    <div class="col-span-12 lg:col-span-8 bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Tiket Terbaru</h3>
            <a href="<?= base_url('admin/tickets') ?>" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Lihat Semua</a>
        </div>
        <div class="divide-y divide-gray-100">
            <?php if (empty($recentTickets)): ?>
            <div class="p-8 text-center"><p class="text-sm text-gray-400">Belum ada tiket.</p></div>
            <?php else: ?>
            <?php
            $sc = ['open'=>'text-blue-700 bg-blue-100','in_progress'=>'text-yellow-700 bg-yellow-100','resolved'=>'text-green-700 bg-green-100','rejected'=>'text-red-700 bg-red-100'];
            foreach ($recentTickets as $t): ?>
            <a href="<?= base_url('admin/tickets/'.$t['code']) ?>" class="block p-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-800"><?= esc($t['title']) ?></h4>
                        <div class="flex items-center mt-1 gap-2">
                            <span class="text-xs text-gray-400">#<?= esc($t['code']) ?></span>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full <?= $sc[$t['status']]??'' ?>"><?= format_status($t['status']) ?></span>
                            <span class="text-xs text-gray-400">oleh <?= esc($t['user_name']) ?></span>
                        </div>
                    </div>
                    <span class="text-xs text-gray-400"><?= date('d M', strtotime($t['created_at'])) ?></span>
                </div>
            </a>
            <?php endforeach; endif; ?>
        </div>
    </div>

    <!-- Chart -->
    <div class="col-span-12 lg:col-span-4 bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Status</h3>
        <canvas id="statusChart" height="280"></canvas>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Buka', 'Diproses', 'Selesai', 'Ditolak'],
        datasets: [{
            data: [<?= $stats['open'] ?>, <?= $stats['in_progress'] ?>, <?= $stats['resolved'] ?>, <?= $stats['rejected'] ?>],
            backgroundColor: ['#3B82F6', '#F59E0B', '#10B981', '#EF4444'],
            borderWidth: 0, hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 } } } },
        cutout: '65%'
    }
});
</script>
<?= $this->endSection() ?>
