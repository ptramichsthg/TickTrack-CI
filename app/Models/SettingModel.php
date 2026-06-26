<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table         = 'settings';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = ['key', 'value'];

    /**
     * Ambil semua setting sebagai key => value array
     */
    public function getAllSettings(): array
    {
        $rows = $this->findAll();
        $result = [];
        foreach ($rows as $row) {
            $result[$row['key']] = $row['value'];
        }
        return $result;
    }

    /**
     * Simpan satu setting berdasarkan key
     */
    public function setSetting(string $key, $value): void
    {
        $existing = $this->where('key', $key)->first();
        if ($existing) {
            $this->update($existing['id'], ['value' => $value]);
        } else {
            $this->insert(['key' => $key, 'value' => $value]);
        }
    }

    /**
     * Simpan banyak setting sekaligus dari array ['key' => 'value']
     */
    public function saveMany(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->setSetting($key, $value);
        }
    }
}
