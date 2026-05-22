<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>
<?php
$statusColors = ['open'=>'text-blue-700 bg-blue-100','in_progress'=>'text-yellow-700 bg-yellow-100','resolved'=>'text-green-700 bg-green-100','rejected'=>'text-red-700 bg-red-100'];
$priorityColors = ['low'=>'text-gray-600 bg-gray-100','medium'=>'text-blue-600 bg-blue-100','high'=>'text-orange-600 bg-orange-100','urgent'=>'text-red-600 bg-red-100'];
?>

<!-- Ticket Header -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="text-sm font-mono text-gray-400">#<?= esc($ticket['code']) ?></span>
                <span class="px-2.5 py-1 text-xs font-medium rounded-full <?= $statusColors[$ticket['status']] ?? '' ?>"><?= ucfirst(str_replace('_',' ',$ticket['status'])) ?></span>
                <span class="px-2.5 py-1 text-xs font-medium rounded-full <?= $priorityColors[$ticket['priority']] ?? '' ?>"><?= ucfirst($ticket['priority']) ?></span>
            </div>
            <h2 class="text-xl font-bold text-gray-800"><?= esc($ticket['title']) ?></h2>
            <p class="text-sm text-gray-500 mt-1">Dibuat pada <?= date('d M Y, H:i', strtotime($ticket['created_at'])) ?></p>
        </div>
        <a href="<?= base_url('user/tickets') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">
            <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>
</div>

<!-- Description -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-sm font-semibold text-gray-700 mb-3">Deskripsi</h3>
    <div class="prose prose-sm max-w-none text-gray-600"><?= nl2br(esc($ticket['description'])) ?></div>
    <?php if (!empty($attachments)): ?>
    <div class="mt-4 pt-4 border-t border-gray-100">
        <p class="text-xs font-semibold text-gray-500 mb-2">Lampiran:</p>
        <?php foreach ($attachments as $att): ?>
        <a href="<?= base_url($att['file_path']) ?>" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-50 rounded-lg text-xs text-blue-600 hover:bg-blue-50 mr-2 mb-2">
            <i data-feather="paperclip" class="w-3 h-3"></i><?= esc($att['file_name']) ?>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Replies -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="p-6 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700">Percakapan (<?= count($replies) ?>)</h3>
    </div>
    <div class="divide-y divide-gray-100">
        <?php if (empty($replies)): ?>
        <div class="p-8 text-center"><p class="text-sm text-gray-400">Belum ada balasan.</p></div>
        <?php else: ?>
        <?php foreach ($replies as $reply): ?>
        <div class="p-5 <?= $reply['user_role'] === 'admin' ? 'bg-blue-50/50' : '' ?>">
            <div class="flex items-start gap-3">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($reply['user_name']) ?>&background=<?= $reply['user_role']==='admin'?'2563EB':'6B7280' ?>&color=fff&size=36&bold=true" class="w-9 h-9 rounded-lg">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-sm font-semibold text-gray-800"><?= esc($reply['user_name']) ?></span>
                        <?php if ($reply['user_role'] === 'admin'): ?>
                        <span class="px-1.5 py-0.5 text-[10px] font-bold bg-blue-600 text-white rounded">ADMIN</span>
                        <?php endif; ?>
                        <span class="text-xs text-gray-400"><?= date('d M Y, H:i', strtotime($reply['created_at'])) ?></span>
                    </div>
                    <div class="text-sm text-gray-600"><?= nl2br(esc($reply['message'])) ?></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Reply Form -->
<?php if (in_array($ticket['status'], ['open', 'in_progress'])): ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-sm font-semibold text-gray-700 mb-3">Kirim Balasan</h3>
    <form action="<?= base_url('user/tickets/' . $ticket['code'] . '/reply') ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <textarea name="message" rows="4" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 resize-none" placeholder="Tulis balasan Anda..."></textarea>
        <div class="flex items-center justify-between mt-3">
            <label for="reply_attachment" class="inline-flex items-center gap-2 text-sm text-gray-500 cursor-pointer hover:text-blue-600">
                <i data-feather="paperclip" class="w-4 h-4"></i> Lampirkan file
                <input type="file" name="attachment" id="reply_attachment" class="hidden">
            </label>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition-colors">
                <i data-feather="send" class="w-4 h-4"></i> Kirim
            </button>
        </div>
    </form>
</div>
<?php else: ?>
<div class="bg-gray-50 rounded-xl border border-gray-200 p-6 text-center">
    <p class="text-sm text-gray-500">Tiket ini sudah <strong><?= $ticket['status'] === 'resolved' ? 'diselesaikan' : 'ditolak' ?></strong>. Tidak bisa mengirim balasan.</p>
</div>
<?php endif; ?>
<?= $this->endSection() ?>
