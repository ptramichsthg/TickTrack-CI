<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="flex flex-wrap items-center justify-between gap-3 mb-2">
    <form action="<?= base_url('admin/users') ?>" method="GET" class="flex items-center gap-2">
        <div class="relative"><i data-feather="search" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
        <input type="text" name="search" value="<?= esc($search??'') ?>" class="pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500" placeholder="Cari pengguna..."></div>
        <button type="submit" class="px-4 py-2.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Cari</button>
    </form>
    <a href="<?= base_url('admin/users/create') ?>" class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700"><i data-feather="plus" class="w-4 h-4"></i>Tambah Pengguna</a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Nama</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Email</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Peran</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Status</th>
                <th class="text-left px-5 py-3 font-semibold text-gray-600">Terdaftar</th>
                <th class="text-center px-5 py-3 font-semibold text-gray-600">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
        <?php if(empty($users)):?>
        <tr><td colspan="6" class="px-5 py-8 text-center text-gray-400">Tidak ada pengguna.</td></tr>
        <?php else: foreach($users as $u): ?>
        <tr class="hover:bg-gray-50">
            <td class="px-5 py-3"><div class="flex items-center gap-3"><img src="https://ui-avatars.com/api/?name=<?=urlencode($u['name'])?>&size=32&background=<?=$u['role']==='admin'?'2563EB':'6B7280'?>&color=fff&bold=true" class="w-8 h-8 rounded-lg"><span class="font-medium text-gray-800"><?=esc($u['name'])?></span></div></td>
            <td class="px-5 py-3 text-gray-600"><?=esc($u['email'])?></td>
            <td class="px-5 py-3"><span class="px-2 py-0.5 text-xs font-medium rounded-full <?=$u['role']==='admin'?'text-blue-700 bg-blue-100':'text-gray-700 bg-gray-100'?>"><?=$u['role']==='admin'?'Admin':'Pengguna'?></span></td>
            <td class="px-5 py-3"><span class="px-2 py-0.5 text-xs font-medium rounded-full <?=$u['is_active']?'text-green-700 bg-green-100':'text-red-700 bg-red-100'?>"><?=$u['is_active']?'Aktif':'Nonaktif'?></span></td>
            <td class="px-5 py-3 text-gray-400 text-xs"><?=date('d M Y',strtotime($u['created_at']))?></td>
            <td class="px-5 py-3 text-center">
                <div class="flex items-center justify-center gap-2">
                    <a href="<?=base_url('admin/users/'.$u['id'].'/edit')?>" class="px-3 py-1.5 bg-yellow-50 text-yellow-600 rounded-lg text-xs hover:bg-yellow-100"><i data-feather="edit-2" class="w-3 h-3 inline"></i></a>
                    <?php if($u['id']!=session('user_id')):?>
                    <form action="<?=base_url('admin/users/'.$u['id'])?>" method="POST" onsubmit="return confirm('Hapus pengguna ini?')"><?=csrf_field()?><input type="hidden" name="_method" value="DELETE"><button class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100"><i data-feather="trash-2" class="w-3 h-3 inline"></i></button></form>
                    <?php endif;?>
                </div>
            </td>
        </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<?php if(!empty($users)):?><div class="flex justify-center"><?=$pager->links('default','default_full')?></div><?php endif;?>
<?= $this->endSection() ?>
