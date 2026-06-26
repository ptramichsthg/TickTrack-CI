<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Laporan & Statistik</h1>
    <p class="text-sm text-gray-500 mt-1">Analisis performa dan tren tiket support</p>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
    <form action="<?= base_url('admin/reports') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Laporan</label>
            <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                <option value="daily" <?= $reportType === 'daily' ? 'selected' : '' ?>>Harian</option>
                <option value="weekly" <?= $reportType === 'weekly' ? 'selected' : '' ?>>Mingguan</option>
                <option value="monthly" <?= $reportType === 'monthly' ? 'selected' : '' ?>>Bulanan</option>
                <option value="yearly" <?= $reportType === 'yearly' ? 'selected' : '' ?>>Tahunan</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
            <select name="month" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                <?php
                $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                foreach ($months as $index => $m):
                    $monthVal = $index + 1;
                ?>
                <option value="<?= $monthVal ?>" <?= $selectedMonth == $monthVal ? 'selected' : '' ?>><?= $m ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
            <select name="year" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                <?php
                $currentYear = date('Y');
                for ($y = $currentYear; $y >= $currentYear - 3; $y--):
                ?>
                <option value="<?= $y ?>" <?= $selectedYear == $y ? 'selected' : '' ?>><?= $y ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="flex items-end">
            <button type="button" onclick="window.print()"
                class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center no-print">
                <i data-feather="download" class="w-5 h-5 mr-2"></i> Export PDF
            </button>
        </div>
    </form>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Tiket</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $stats['total_tickets'] ?></h3>
            </div>
            <div class="p-3 bg-blue-50 rounded-lg"><i data-feather="tag" class="w-6 h-6 text-blue-600"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Tiket Selesai</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $stats['resolved_tickets'] ?></h3>
            </div>
            <div class="p-3 bg-green-50 rounded-lg"><i data-feather="check-circle" class="w-6 h-6 text-green-600"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Rata-rata Waktu</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $stats['avg_resolution_time'] ?>h</h3>
            </div>
            <div class="p-3 bg-purple-50 rounded-lg"><i data-feather="clock" class="w-6 h-6 text-purple-600"></i></div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Kepuasan</p>
                <h3 class="text-2xl font-bold text-gray-800 mt-1"><?= $stats['satisfaction_rate'] ?>%</h3>
            </div>
            <div class="p-3 bg-yellow-50 rounded-lg"><i data-feather="star" class="w-6 h-6 text-yellow-600"></i></div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Ticket Trend -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tren Tiket</h3>
        <div style="height: 300px;">
            <canvas id="ticketTrendChart"></canvas>
        </div>
    </div>
    <!-- Category Distribution -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Kategori</h3>
        <div style="height: 300px;">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const trendData = <?= $trendData ?>;
    const categoryData = <?= $categoryData ?>;

    // Trend Chart
    const trendCtx = document.getElementById('ticketTrendChart');
    if (trendCtx) {
        new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: trendData.labels,
                datasets: [
                    {
                        label: 'Tiket Dibuat',
                        data: trendData.created,
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Tiket Selesai',
                        data: trendData.resolved,
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    // Category Chart
    const catCtx = document.getElementById('categoryChart');
    if (catCtx) {
        new Chart(catCtx, {
            type: 'bar',
            data: {
                labels: categoryData.labels,
                datasets: [{
                    label: 'Jumlah Tiket',
                    data: categoryData.data,
                    backgroundColor: categoryData.colors.length > 0 ? categoryData.colors : ['#3B82F6', '#F59E0B', '#10B981', '#8B5CF6', '#EF4444', '#6B7280']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }
</script>
<?= $this->endSection() ?>
