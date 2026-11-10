<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'qr_code' => ['required', 'string', 'max:2000'],
        ]);
        $qrCode = trim($validated['qr_code']);

        if ($qrCode === '') {
            return response()->json(['message' => 'QR code tidak boleh kosong.'], 422);
        }

        $user = $request->user();
        $todayAttendance = $user->absensis()
            ->where('qr_code', $qrCode)
            ->whereDate('created_at', today())
            ->first();

        if ($todayAttendance) {
            return response()->json([
                'status' => 'success',
                'already_recorded' => true,
                'message' => 'Absensi untuk QR ini sudah tercatat hari ini.',
                'data' => $todayAttendance,
            ]);
        }

        $profile = $user->profile()->firstOrCreate([]);
        $attendance = $user->absensis()->create([
            'nama' => $profile->nama ?: $user->name,
            'nim_nis' => $profile->nisn ?? '',
            'tujuan' => 'Absensi Perpustakaan',
            'qr_code' => $qrCode,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Absensi berhasil dicatat!',
            'data' => $attendance,
        ], 201);
    }

    public function index(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()->absensis()->latest()->get(),
        ]);
    }
}
