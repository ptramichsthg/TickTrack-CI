<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Add Category -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Kategori Baru</h3>
    <form action="<?= base_url('admin/categories/store') ?>" method="POST" class="flex flex-wrap items-end gap-3">
        <?= csrf_field() ?>
        <div class="flex-1 min-w-[180px]"><label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label><input type="text" name="name" required class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500" placeholder="Nama kategori"></div>
        <div class="flex-1 min-w-[180px]"><label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label><input type="text" name="description" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500" placeholder="Deskripsi singkat"></div>
        <div class="w-24"><label class="block text-sm font-semibold text-gray-700 mb-1">Warna</label><input type="color" name="color" value="#3B82F6" class="w-full h-[42px] rounded-lg border border-gray-200 cursor-pointer"></div>
        <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700"><i data-feather="plus" class="w-4 h-4 inline mr-1"></i>Tambah</button>
    </form>
</div>

<!-- Category List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Warna</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Nama</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Deskripsi</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Status</th>
                <th class="text-center px-5 py-3 font-semibold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
        <?php if(empty($categories)):?>
        <tr><td colspan="5" class="px-5 py-8 text-center text-gray-400">Belum ada kategori.</td></tr>
        <?php else: foreach($categories as $c): ?>
        <tr class="hover:bg-gray-50">
            <td class="px-5 py-3"><div class="w-6 h-6 rounded-full" style="background-color:<?=esc($c['color'])?>"></div></td>
            <td class="px-5 py-3 font-medium text-gray-800"><?=esc($c['name'])?></td>
            <td class="px-5 py-3 text-gray-500"><?=esc($c['description']??'-')?></td>
            <td class="px-5 py-3"><span class="px-2 py-0.5 text-xs font-medium rounded-full <?=$c['is_active']?'text-green-700 bg-green-100':'text-red-700 bg-red-100'?>"><?=$c['is_active']?'Aktif':'Nonaktif'?></span></td>
            <td class="px-5 py-3 text-center">
                <form action="<?=base_url('admin/categories/'.$c['id'])?>" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')"><?=csrf_field()?><input type="hidden" name="_method" value="DELETE"><button class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100"><i data-feather="trash-2" class="w-3 h-3 inline"></i></button></form>
            </td>
        </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
