<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        return view('admin/categories/index', [
            'title'      => 'Kategori — TickTrack',
            'pageTitle'  => 'Kelola Kategori',
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        if (!$this->validate(['name' => 'required|min_length[2]'])) {
            return redirect()->back()->with('error', 'Nama kategori minimal 2 karakter.');
        }

        $this->categoryModel->insert([
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'color'       => $this->request->getPost('color') ?: '#3B82F6',
        ]);

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update($id)
    {
        if (!$this->validate(['name' => 'required|min_length[2]'])) {
            return redirect()->back()->with('error', 'Nama kategori minimal 2 karakter.');
        }

        $this->categoryModel->update($id, [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'color'       => $this->request->getPost('color') ?: '#3B82F6',
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->categoryModel->delete($id);
        return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil dihapus.');
    }
}
