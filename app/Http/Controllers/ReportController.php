<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    //
    public function index(Request $request) {
        $query = Report::with('user');
        if ($request->province) {
            $query->where('province', $request->province);
        }
        $reports = $query->latest()->paginate(10);
        return view('report.index', compact('reports'));
    }

    public function createReport()
    {
        return view('report.create');
    }

    // Fungsi untuk menyimpan laporan
    public function storeReport(Request $request)
    {
        // Validasi data yang dikirim dari form
        $validated = $request->validate([
            'description' => 'required|string',
            'type' => 'required|string',
            'province' => 'required|string',
            'regency' => 'required|string',
            'subdistrict' => 'required|string',
            'village' => 'required|string',
            'voting' => 'nullable|array', // Menyesuaikan dengan cast 'voting' yang berupa array
            'viewers' => 'nullable|integer', // Menyesuaikan dengan cast 'viewers' yang berupa integer
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Maksimal ukuran 10MB
            'statement' => 'nullable|boolean', // Menyesuaikan dengan cast 'statement' yang berupa boolean
        ]);

        // Menyimpan gambar jika ada
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('public/reports/', $filename);

        // Menyimpan data laporan ke database
        $report = new Report([
            'user_id' => auth()->user()->id, // Mendapatkan ID user yang sedang login
            'description' => $validated['description'],
            'type' => $validated['type'],
            'province' => $validated['province'],
            'regency' => $validated['regency'],
            'subdistrict' => $validated['subdistrict'],
            'village' => $validated['village'],
            'voting' => $validated['voting'] ?? [], // Menggunakan array kosong jika tidak ada
            'viewers' => $validated['viewers'] ?? 0, // Default ke 0 jika tidak ada nilai
            'image' => $filename, // Menyimpan path gambar
            'statement' => $validated['statement'] ?? false, // Default ke false jika tidak ada nilai
        ]);

        // Simpan ke database
        $report->save();

        // Redirect atau response sesuai kebutuhan
        return redirect()->route('report_me')->with('success', 'Laporan berhasil disimpan!');
    }

    public function deleteReport($id)
    {
        $report = Report::findorFail($id);

        if ($report->Response) {
            return redirect()->route('report_me')->with('error', 'Laporan ini sedang diproses. Tidak bisa di hapus.');
        }

        if ($report->image && Storage::exists('public/reports/' . $report->image)) {
            Storage::delete('public/reports/' . $report->image);
        }
        $report->delete();
        return redirect()->route('report_me')->with('success', 'Laporan berhasil dihapus.');
    }

    public function reportMe()
    {
        $reports = Report::with(['Response', 'response.progress'])
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();
        return view('report.report_me', compact('reports'));
    }

    public function comment($reportId)
    {
        $report = Report::findOrFail($reportId);
        $comments = $report->Comment()->latest()->get();
        $report->increment('viewers');

        // Kirim data ke view
        return view('report.comment', compact('report', 'comments'));
    }

    public function storeComment(Request $request, $reportId)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $report = Report::findOrFail($reportId);
        $comment = Comment::create([
            'report_id' => $report->id,
            'user_id' => auth()->user()->id,
            'comment' =>  $validated['comment'],
        ]);
        return redirect()->route('report_comment', $report->id)->with('success', 'Komentar berhasil ditambahkan.');
    }
}
