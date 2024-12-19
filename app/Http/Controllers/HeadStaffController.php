<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staff_provinces;
use App\Charts\ReportResponChart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class HeadStaffController extends Controller
{
    //
    public function index(ReportResponChart $chart)
    {
        $chartInstance = $chart->build(); // Memanggil chart yang sudah dibuat
        return view('headstaff.index', ['chart' => $chartInstance]);
    }

    public function createAcc()
    {
        $staffUsers = User::where('role', 'STAFF')->get();
        return view('headstaff.createAcc', compact('staffUsers'));
    }

    public function storeAcc(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $headStaff = Auth::user();
        if ($headStaff->role !== 'HEAD_STAFF') {
            return redirect()->back()->with('failed', 'tidak ada akses.');
        }

        $province = Staff_provinces::where('user_id', $headStaff->id)->value('province');

        if (!$province) {
            return redirect()->back()->with('failed', 'Province data not found.');
        }

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'STAFF',
        ]);

        Staff_provinces::create([
            'user_id' => $user->id,
            'province' => $province,
        ]);

        return redirect()->back()->with('success', 'Account successfully created.');
    }

    public function destroyAcc($id)
    {
        $headStaff = Auth::user();
        if ($headStaff->role !== 'HEAD_STAFF') {
            return redirect()->back()->with('failed', 'tidak ada akses.');
        }
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('failed', 'Akun tidak ditemukan.');
        }
        if ($user->role !== 'STAFF') {
            return redirect()->back()->with('failed', 'cuma bisa menghapus akun staff.');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }


    public function resetPassword($id)
    {
        $headStaff = Auth::user(); 
        if ($headStaff->role !== 'HEAD_STAFF') {
            return redirect()->back()->with('failed', 'tidak ada akses.');
        }

        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('failed', 'Akun tidak ditemukan.');
        }

        $emailPrefix = substr($user->email, 0, 4);
        $newPassword = $emailPrefix . '123';

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        return redirect()->back()->with('success', "Password berhasil direset.");
    }
}
