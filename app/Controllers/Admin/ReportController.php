<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\CategoryModel;

class ReportController extends BaseController
{
    public function index()
    {
        $type  = $this->request->getGet('type') ?? 'monthly';
        $month = $this->request->getGet('month') ?? date('n');
        $year  = $this->request->getGet('year') ?? date('Y');

        $db = \Config\Database::connect();

        // ── Statistics ──
        $statQuery = $db->table('tickets');
        if ($type === 'monthly' || $type === 'daily' || $type === 'weekly') {
            $statQuery->where('YEAR(created_at)', $year)->where('MONTH(created_at)', $month);
        } elseif ($type === 'yearly') {
            $statQuery->where('YEAR(created_at)', $year);
        }
        $tickets = $statQuery->get()->getResultArray();

        $totalTickets = count($tickets);
        $resolvedTickets = count(array_filter($tickets, fn($t) => $t['status'] === 'resolved'));

        // Avg resolution time
        $avgQuery = $db->table('tickets');
        if ($type === 'monthly' || $type === 'daily' || $type === 'weekly') {
            $avgQuery->where('YEAR(created_at)', $year)->where('MONTH(created_at)', $month);
        } elseif ($type === 'yearly') {
            $avgQuery->where('YEAR(created_at)', $year);
        }
        $avgQuery->where('status', 'resolved');
        $avgQuery->select('ROUND(AVG(TIMESTAMPDIFF(HOUR, created_at, updated_at)), 1) as avg_hours');
        $avgRow = $avgQuery->get()->getRowArray();
        $avgResolutionTime = $avgRow['avg_hours'] ?? 0;

        $satisfactionRate = 92; // Placeholder

        $trendData = $this->getTicketTrend($type, $year, $month);
        $categoryData = $this->getCategoryDistribution($type, $year, $month);

        return view('admin/reports/index', [
            'title'         => 'Laporan & Statistik — TickTrack',
            'pageTitle'     => 'Laporan & Statistik',
            'reportType'    => $type,
            'selectedMonth' => (int)$month,
            'selectedYear'  => (int)$year,
            'stats'         => [
                'total_tickets'       => $totalTickets,
                'resolved_tickets'    => $resolvedTickets,
                'avg_resolution_time' => $avgResolutionTime,
                'satisfaction_rate'   => $satisfactionRate,
            ],
            'trendData'    => json_encode($trendData),
            'categoryData' => json_encode($categoryData),
        ]);
    }

    private function getTicketTrend($type, $year, $month)
    {
        $db = \Config\Database::connect();
        
        if ($type === 'yearly') {
            $created = $db->table('tickets')
                ->select('MONTH(created_at) as month, COUNT(*) as count')
                ->where('YEAR(created_at)', $year)
                ->groupBy('month')
                ->get()->getResultArray();
                
            $resolved = $db->table('tickets')
                ->select('MONTH(updated_at) as month, COUNT(*) as count')
                ->where('YEAR(updated_at)', $year)
                ->where('status', 'resolved')
                ->groupBy('month')
                ->get()->getResultArray();
                
            $createdMap = array_column($created, 'count', 'month');
            $resolvedMap = array_column($resolved, 'count', 'month');

            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $createdData = [];
            $resolvedData = [];

            for ($i = 1; $i <= 12; $i++) {
                $createdData[] = $createdMap[$i] ?? 0;
                $resolvedData[] = $resolvedMap[$i] ?? 0;
            }

            return [
                'labels' => $labels,
                'created' => $createdData,
                'resolved' => $resolvedData,
            ];
        }

        // fallback to monthly for chart
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        $created = $db->table('tickets')
            ->select('DAY(created_at) as day, COUNT(*) as count')
            ->where('YEAR(created_at)', $year)
            ->where('MONTH(created_at)', $month)
            ->groupBy('day')
            ->get()->getResultArray();

        $resolved = $db->table('tickets')
            ->select('DAY(updated_at) as day, COUNT(*) as count')
            ->where('YEAR(updated_at)', $year)
            ->where('MONTH(updated_at)', $month)
            ->where('status', 'resolved')
            ->groupBy('day')
            ->get()->getResultArray();

        $createdMap = array_column($created, 'count', 'day');
        $resolvedMap = array_column($resolved, 'count', 'day');

        $labels = [];
        $createdData = [];
        $resolvedData = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $labels[] = $i;
            $createdData[] = $createdMap[$i] ?? 0;
            $resolvedData[] = $resolvedMap[$i] ?? 0;
        }

        return [
            'labels' => $labels,
            'created' => $createdData,
            'resolved' => $resolvedData,
        ];
    }

    private function getCategoryDistribution($type, $year, $month)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tickets t')
            ->join('categories c', 'c.id = t.category_id', 'left')
            ->select('c.name, c.color, COUNT(t.id) as tickets_count')
            ->groupBy('c.id');
            
        if ($type === 'monthly' || $type === 'daily' || $type === 'weekly') {
            $builder->where('YEAR(t.created_at)', $year)->where('MONTH(t.created_at)', $month);
        } elseif ($type === 'yearly') {
            $builder->where('YEAR(t.created_at)', $year);
        }
        
        $categories = $builder->get()->getResultArray();

        $labels = [];
        $data = [];
        $colors = [];
        
        foreach ($categories as $c) {
            if ($c['tickets_count'] > 0) {
                $labels[] = $c['name'] ?? 'Tanpa Kategori';
                $data[] = $c['tickets_count'];
                $colors[] = $c['color'] ?? '#6B7280';
            }
        }

        return [
            'labels' => $labels,
            'data'   => $data,
            'colors' => $colors,
        ];
    }
}
