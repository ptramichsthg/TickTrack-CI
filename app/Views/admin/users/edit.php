<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <?php if(session()->getFlashdata('errors')):?><div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg text-sm mb-6"><ul class="list-disc list-inside space-y-1"><?php foreach(session()->getFlashdata('errors') as $e):?><li><?=esc($e)?></li><?php endforeach;?></ul></div><?php endif;?>

    <form action="<?= base_url('admin/users/'.$user['id'].'/update') ?>" method="POST" class="space-y-5">
        <?= csrf_field() ?>
        <div><label class="block text-sm font-semibold text-gray-700 mb-2">Nama</label><input type="text" name="name" value="<?=esc($user['name'])?>" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"></div>
        <div><label class="block text-sm font-semibold text-gray-700 mb-2">Email</label><input type="email" name="email" value="<?=esc($user['email'])?>" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"></div>
        <div><label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru (kosongkan jika tidak diubah)</label><input type="password" name="password" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100" placeholder="Min. 6 karakter"></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-semibold text-gray-700 mb-2">Role</label><select name="role" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500"><option value="user" <?=$user['role']==='user'?'selected':''?>>User</option><option value="admin" <?=$user['role']==='admin'?'selected':''?>>Admin</option></select></div>
            <div><label class="block text-sm font-semibold text-gray-700 mb-2">Telepon</label><input type="text" name="phone" value="<?=esc($user['phone']??'')?>" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100"></div>
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" <?=$user['is_active']?'checked':''?> class="h-4 w-4 text-blue-600 rounded border-gray-300">
            <label for="is_active" class="text-sm text-gray-700">Akun Aktif</label>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="flex-1 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:ring-4 focus:ring-blue-200"><i data-feather="save" class="w-4 h-4 inline mr-1"></i>Simpan Perubahan</button>
            <a href="<?= base_url('admin/users') ?>" class="px-6 py-3 rounded-xl text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200">Batal</a>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
