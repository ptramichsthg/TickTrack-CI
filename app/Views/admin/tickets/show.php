<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php $sc=['open'=>'text-blue-700 bg-blue-100','in_progress'=>'text-yellow-700 bg-yellow-100','resolved'=>'text-green-700 bg-green-100','rejected'=>'text-red-700 bg-red-100']; ?>

<!-- Header -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="text-sm font-mono text-gray-400">#<?= esc($ticket['code']) ?></span>
                <span class="px-2.5 py-1 text-xs font-medium rounded-full <?=$sc[$ticket['status']]??''?>"><?= format_status($ticket['status']) ?></span>
            </div>
            <h2 class="text-xl font-bold text-gray-800"><?= esc($ticket['title']) ?></h2>
            <p class="text-sm text-gray-500 mt-1">Oleh <strong><?= esc($ticket['user_name']) ?></strong> · <?= date('d M Y, H:i', strtotime($ticket['created_at'])) ?></p>
        </div>
        <div class="flex items-center gap-2">
            <!-- Status Update -->
            <form action="<?= base_url('admin/tickets/'.$ticket['code'].'/status') ?>" method="POST" class="flex items-center gap-2">
                <?= csrf_field() ?>
                <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
                    <?php foreach(['open','in_progress','resolved','rejected'] as $s): ?>
                    <option value="<?=$s?>" <?=$ticket['status']===$s?'selected':''?>><?= format_status($s) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Update</button>
            </form>
            <!-- Delete -->
            <form action="<?= base_url('admin/tickets/'.$ticket['code']) ?>" method="POST" onsubmit="return confirm('Hapus tiket ini?')">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 text-sm rounded-lg hover:bg-red-100"><i data-feather="trash-2" class="w-4 h-4 inline"></i></button>
            </form>
            <a href="<?= base_url('admin/tickets') ?>" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200"><i data-feather="arrow-left" class="w-4 h-4 inline mr-1"></i>Kembali</a>
        </div>
    </div>
</div>

<!-- Description -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-sm font-semibold text-gray-700 mb-3">Deskripsi</h3>
    <div class="text-sm text-gray-600"><?= nl2br(esc($ticket['description'])) ?></div>
    <?php if (!empty($attachments)): ?>
    <div class="mt-4 pt-4 border-t border-gray-100">
        <p class="text-xs font-semibold text-gray-500 mb-2">Lampiran:</p>
        <?php foreach ($attachments as $a): ?>
        <a href="<?= base_url($a['file_path']) ?>" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-50 rounded-lg text-xs text-blue-600 hover:bg-blue-50 mr-2 mb-1"><i data-feather="paperclip" class="w-3 h-3"></i><?= esc($a['file_name']) ?></a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Replies -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="p-6 border-b border-gray-100"><h3 class="text-sm font-semibold text-gray-700">Percakapan (<?= count($replies) ?>)</h3></div>
    <div class="divide-y divide-gray-100">
        <?php if (empty($replies)): ?>
        <div class="p-8 text-center"><p class="text-sm text-gray-400">Belum ada balasan.</p></div>
        <?php else: foreach ($replies as $r): ?>
        <div class="p-5 <?=$r['user_role']==='admin'?'bg-blue-50/50':''?>">
            <div class="flex items-start gap-3">
                <img src="https://ui-avatars.com/api/?name=<?=urlencode($r['user_name'])?>&background=<?=$r['user_role']==='admin'?'2563EB':'6B7280'?>&color=fff&size=36&bold=true" class="w-9 h-9 rounded-lg">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-sm font-semibold text-gray-800"><?=esc($r['user_name'])?></span>
                        <?php if($r['user_role']==='admin'):?><span class="px-1.5 py-0.5 text-[10px] font-bold bg-blue-600 text-white rounded">ADMIN</span><?php endif;?>
                        <span class="text-xs text-gray-400"><?=date('d M Y, H:i',strtotime($r['created_at']))?></span>
                    </div>
                    <div class="text-sm text-gray-600"><?=nl2br(esc($r['message']))?></div>
                </div>
            </div>
        </div>
        <?php endforeach; endif; ?>
    </div>
</div>

<!-- Reply Form -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-sm font-semibold text-gray-700 mb-3">Balas sebagai Admin</h3>
    <form action="<?= base_url('admin/tickets/'.$ticket['code'].'/reply') ?>" method="POST">
        <?= csrf_field() ?>
        <textarea name="message" rows="4" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 resize-none" placeholder="Tulis balasan..."></textarea>
        <div class="flex justify-end mt-3">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700"><i data-feather="send" class="w-4 h-4"></i>Kirim</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>
