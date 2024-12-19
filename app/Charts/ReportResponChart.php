<?php
namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Report;

class ReportResponChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $user = auth()->user(); // User yang sedang login
        // Cek jika role adalah HEAD_STAFF
        if ($user->role !== 'HEAD_STAFF') {
            return $this->chart->barChart()->setTitle('Akses Dibatasi');
        }
        
        // Ambil provinsi dari staff_provinces
        $province = $user->staff->province; 
        
        // Menghitung jumlah report yang sesuai dengan provinsi
        $reports = Report::where('province', $province);

        // Total report untuk provinsi
        $totalReports = $reports->count();

        // Total report yang sudah ada respon
        $totalResponses = $reports->whereHas('response')->count();

        // Membuat chart
        return $this->chart->barChart()
            ->setTitle("Report dan Respon - Provinsi: $province")
            ->setSubtitle('Jumlah berdasarkan provinsi user.')
            ->addData('Report', [$totalReports])
            ->addData('Response', [$totalResponses])
            ->setXAxis(['Total'])
            ->setGrid()
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10);
    }
}

