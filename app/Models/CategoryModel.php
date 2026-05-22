<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    protected $allowedFields = [
        'name', 'description', 'color', 'is_active',
    ];

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
    ];

    // ── Helper: Ambil kategori aktif ──
    public function getActiveCategories(): array
    {
        return $this->where('is_active', 1)->orderBy('name', 'ASC')->findAll();
    }
}
