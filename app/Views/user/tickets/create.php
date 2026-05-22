<?= $this->extend('layouts/user') ?>

<?= $this->section('content') ?>
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Tiket Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Sampaikan kendala atau pertanyaan Anda kepada tim support kami.</p>
        </div>
        <a href="<?= base_url('user/dashboard') ?>" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
            <i data-feather="arrow-left" class="w-4 h-4 mr-1"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('errors')): ?>
    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-xl text-sm mb-6">
        <ul class="list-disc list-inside space-y-1">
            <?php foreach (session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="<?= base_url('user/tickets/store') ?>" method="POST" enctype="multipart/form-data" class="p-6 md:p-8 space-y-6">
            <?= csrf_field() ?>

            <!-- Kategori dan Prioritas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori Masalah <span class="text-red-500">*</span></label>
                    <select name="category_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                        <option value="">-- Pilih Kategori --</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= old('category_id') == $category['id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tingkat Prioritas <span class="text-red-500">*</span></label>
                    <select name="priority" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                        <option value="low" <?= old('priority') == 'low' ? 'selected' : '' ?>>Rendah</option>
                        <option value="medium" <?= old('priority', 'medium') == 'medium' ? 'selected' : '' ?>>Sedang</option>
                        <option value="high" <?= old('priority') == 'high' ? 'selected' : '' ?>>Tinggi</option>
                        <option value="urgent" <?= old('priority') == 'urgent' ? 'selected' : '' ?>>Mendesak</option>
                    </select>
                </div>
            </div>

            <!-- Judul -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Tiket <span class="text-red-500">*</span></label>
                <input type="text" name="title" value="<?= old('title') ?>" required placeholder="Contoh: Aplikasi error saat mau upload file" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Detail <span class="text-red-500">*</span></label>
                <textarea name="description" required rows="6" placeholder="Jelaskan secara detail kendala yang Anda alami..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all"><?= old('description') ?></textarea>
            </div>

            <!-- Lampiran -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Lampiran <span class="font-normal text-gray-400">(Opsional)</span></label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-200 border-dashed rounded-xl hover:border-blue-400 transition-colors bg-gray-50 hover:bg-blue-50/50">
                    <div class="space-y-1 text-center">
                        <i data-feather="upload-cloud" class="mx-auto h-12 w-12 text-gray-400"></i>
                        <div class="flex text-sm text-gray-600 justify-center mt-2">
                            <label for="file-upload" class="relative cursor-pointer bg-transparent rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                <span>Pilih file</span>
                                <input id="file-upload" name="attachment" type="file" class="sr-only">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG, PDF maksimal 2MB</p>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="<?= base_url('user/dashboard') ?>" class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Batal</a>
                <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition-colors shadow-sm flex items-center">
                    <i data-feather="send" class="w-4 h-4 mr-2"></i> Kirim Tiket
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('file-upload').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Pilih file';
        e.target.parentElement.nextElementSibling.innerText = fileName;
    });
</script>
<?= $this->endSection() ?>
