<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CategoryModel;

/**
 * REST API Controller untuk resource Categories.
 *
 * Endpoint:
 *   GET    /api/categories          → index()
 *   GET    /api/categories/{id}     → show($id)
 *   POST   /api/categories          → create()
 *   PUT    /api/categories/{id}     → update($id)
 *   DELETE /api/categories/{id}     → delete($id)
 */
class Categories extends ResourceController
{
    protected $modelName = CategoryModel::class;
    protected $format    = 'json';

    /**
     * GET /api/categories
     * Menampilkan seluruh data kategori.
     */
    public function index()
    {
        $categories = $this->model->orderBy('name', 'ASC')->findAll();

        return $this->respond([
            'status'  => 'success',
            'message' => 'Data kategori berhasil diambil.',
            'total'   => count($categories),
            'data'    => $categories,
        ]);
    }

    /**
     * GET /api/categories/{id}
     * Menampilkan detail kategori berdasarkan ID.
     */
    public function show($id = null)
    {
        $category = $this->model->find($id);

        if (!$category) {
            return $this->failNotFound('Kategori dengan ID ' . $id . ' tidak ditemukan.');
        }

        return $this->respond([
            'status'  => 'success',
            'message' => 'Detail kategori berhasil diambil.',
            'data'    => $category,
        ]);
    }

    /**
     * POST /api/categories
     * Membuat kategori baru.
     */
    public function create()
    {
        $rules = [
            'name'        => 'required|min_length[2]|max_length[100]',
            'description' => 'permit_empty|max_length[500]',
            'color'       => 'permit_empty|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [
            'name'        => $this->request->getVar('name'),
            'description' => $this->request->getVar('description') ?? '',
            'color'       => $this->request->getVar('color') ?? '#3B82F6',
            'is_active'   => 1,
        ];

        $id = $this->model->insert($data);

        if ($id === false) {
            return $this->failServerError('Gagal menyimpan data kategori.');
        }

        $category = $this->model->find($id);

        return $this->respondCreated([
            'status'  => 'success',
            'message' => 'Kategori berhasil ditambahkan.',
            'data'    => $category,
        ]);
    }

    /**
     * PUT /api/categories/{id}
     * Memperbarui data kategori berdasarkan ID.
     */
    public function update($id = null)
    {
        $category = $this->model->find($id);
        if (!$category) {
            return $this->failNotFound('Kategori dengan ID ' . $id . ' tidak ditemukan.');
        }

        $rules = [
            'name'        => 'permit_empty|min_length[2]|max_length[100]',
            'description' => 'permit_empty|max_length[500]',
            'color'       => 'permit_empty|max_length[20]',
            'is_active'   => 'permit_empty|in_list[0,1]',
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $data = [];
        $fields = ['name', 'description', 'color', 'is_active'];
        foreach ($fields as $field) {
            $value = $this->request->getVar($field);
            if ($value !== null) {
                $data[$field] = $value;
            }
        }

        if (empty($data)) {
            return $this->fail('Tidak ada data yang dikirim untuk diperbarui.', 400);
        }

        $this->model->update($id, $data);

        $updatedCategory = $this->model->find($id);

        return $this->respond([
            'status'  => 'success',
            'message' => 'Kategori berhasil diperbarui.',
            'data'    => $updatedCategory,
        ]);
    }

    /**
     * DELETE /api/categories/{id}
     * Menghapus kategori berdasarkan ID.
     */
    public function delete($id = null)
    {
        $category = $this->model->find($id);
        if (!$category) {
            return $this->failNotFound('Kategori dengan ID ' . $id . ' tidak ditemukan.');
        }

        $this->model->delete($id);

        return $this->respondDeleted([
            'status'  => 'success',
            'message' => 'Kategori "' . $category['name'] . '" berhasil dihapus.',
        ]);
    }
}
