<?php

if (!function_exists('format_status')) {
    function format_status(string $status): string
    {
        $map = [
            'open'        => 'Buka',
            'in_progress' => 'Diproses',
            'resolved'    => 'Selesai',
            'rejected'    => 'Ditolak',
        ];
        return $map[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }
}

if (!function_exists('format_priority')) {
    function format_priority(string $priority): string
    {
        $map = [
            'low'    => 'Rendah',
            'medium' => 'Sedang',
            'high'   => 'Tinggi',
            'urgent' => 'Mendesak',
        ];
        return $map[$priority] ?? ucfirst($priority);
    }
}
