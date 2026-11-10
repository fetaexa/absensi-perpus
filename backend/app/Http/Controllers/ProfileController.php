<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $profile = $request->user()->profile()->firstOrCreate([]);

        return response()->json([
            'status' => 'success',
            'data' => $this->profileData($profile),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['nullable', 'string', 'max:255'],
            'nisn' => ['nullable', 'string', 'max:255'],
            'kelas' => ['nullable', 'string', 'max:255'],
            'sekolah' => ['nullable', 'string', 'max:255'],
        ]);

        $profile = $request->user()->profile()->firstOrCreate([]);
        $profile->fill($validated)->save();

        return response()->json([
            'status' => 'success',
            'data' => $this->profileData($profile),
        ]);
    }

    private function profileData(Profile $profile): array
    {
        return [
            'nama' => $profile->nama ?? '',
            'nisn' => $profile->nisn ?? '',
            'kelas' => $profile->kelas ?? '',
            'sekolah' => $profile->sekolah ?? '',
        ];
    }
}
