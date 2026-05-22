<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
    <form action="<?= base_url('admin/tickets') ?>" method="GET" class="flex flex-wrap items-center gap-3">
        <div class="flex-1 min-w-[200px]">
            <div class="relative">
                <i data-feather="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                <input type="text" name="search" value="<?= esc($filters['search']??'') ?>" class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100" placeholder="Cari tiket...">
            </div>
        </div>
        <select name="status" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm">
            <option value="">Semua Status</option>
            <?php foreach(['open','in_progress','resolved','rejected'] as $s): ?>
            <option value="<?=$s?>" <?=($filters['status']??'')===$s?'selected':''?>><?= format_status($s) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="priority" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm">
            <option value="">Semua Prioritas</option>
            <?php foreach(['low','medium','high','urgent'] as $p): ?>
            <option value="<?=$p?>" <?=($filters['priority']??'')===$p?'selected':''?>><?= format_priority($p) ?></option>
            <?php endforeach; ?>
        </select>
        <select name="category_id" class="px-3 py-2.5 border border-gray-200 rounded-lg text-sm">
            <option value="">Semua Kategori</option>
            <?php foreach($categories as $c): ?>
            <option value="<?=$c['id']?>" <?=($filters['category_id']??'')==$c['id']?'selected':''?>><?=esc($c['name'])?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700"><i data-feather="filter" class="w-4 h-4 inline mr-1"></i>Filter</button>
        <a href="<?= base_url('admin/tickets') ?>" class="px-4 py-2.5 bg-gray-100 text-gray-600 text-sm rounded-lg hover:bg-gray-200">Reset</a>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Kode</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Judul</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">User</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Status</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Prioritas</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Tanggal</th>
                <th class="text-center px-5 py-3 font-semibold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php if (empty($tickets)): ?>
            <tr><td colspan="7" class="px-5 py-8 text-center text-gray-400">Tidak ada tiket ditemukan.</td></tr>
            <?php else: ?>
            <?php
            $sc=['open'=>'text-blue-700 bg-blue-100','in_progress'=>'text-yellow-700 bg-yellow-100','resolved'=>'text-green-700 bg-green-100','rejected'=>'text-red-700 bg-red-100'];
            $pc=['low'=>'text-gray-600 bg-gray-100','medium'=>'text-blue-600 bg-blue-100','high'=>'text-orange-600 bg-orange-100','urgent'=>'text-red-600 bg-red-100'];
            foreach ($tickets as $t): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-mono text-xs text-gray-500"><?= esc($t['code']) ?></td>
                <td class="px-5 py-3 font-medium text-gray-800 max-w-[200px] truncate"><?= esc($t['title']) ?></td>
                <td class="px-5 py-3 text-gray-600"><?= esc($t['user_name']) ?></td>
                <td class="px-5 py-3"><span class="px-2 py-0.5 text-xs font-medium rounded-full <?=$sc[$t['status']]??''?>"><?= format_status($t['status']) ?></span></td>
                <td class="px-5 py-3"><span class="px-2 py-0.5 text-xs font-medium rounded-full <?=$pc[$t['priority']]??''?>"><?= format_priority($t['priority']) ?></span></td>
                <td class="px-5 py-3 text-gray-400 text-xs"><?= date('d M Y', strtotime($t['created_at'])) ?></td>
                <td class="px-5 py-3 text-center">
                    <a href="<?= base_url('admin/tickets/'.$t['code']) ?>" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs hover:bg-blue-100"><i data-feather="eye" class="w-3 h-3"></i>Detail</a>
                </td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?php if (!empty($tickets)): ?>
<div class="flex justify-center"><?= $pager->links('default','default_full') ?></div>
<?php endif; ?>
<?= $this->endSection() ?>
