<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_scanning_qr_saves_attendance_and_shows_it_in_the_signed_in_users_history(): void
    {
        $user = User::factory()->create();
        $user->profile()->create([
            'nama' => 'Siswa Contoh',
            'nisn' => '0099887766',
        ]);
        $token = $user->createToken('test')->plainTextToken;

        $this->withToken($token)
            ->postJson('/api/absensi', [
                'qr_code' => 'room=Ruang Baca;subject=KIK;kode=QR-KIK-01',
            ])
            ->assertCreated()
            ->assertJsonPath('data.nama', 'Siswa Contoh')
            ->assertJsonPath('data.nim_nis', '0099887766')
            ->assertJsonPath('data.tujuan', 'Absensi Perpustakaan')
            ->assertJsonMissingPath('data.room')
            ->assertJsonMissingPath('data.subject');

        $this->withToken($token)
            ->getJson('/api/absensi')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.qr_code', 'room=Ruang Baca;subject=KIK;kode=QR-KIK-01');

        $this->assertDatabaseHas('absensis', [
            'user_id' => $user->id,
            'nim_nis' => '0099887766',
            'qr_code' => 'room=Ruang Baca;subject=KIK;kode=QR-KIK-01',
        ]);
    }

    public function test_scanning_the_same_qr_twice_in_one_day_does_not_duplicate_attendance(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $payload = ['qr_code' => 'room=Perpustakaan;subject=Kunjungan'];

        $this->withToken($token)->postJson('/api/absensi', $payload)->assertCreated();
        $this->withToken($token)
            ->postJson('/api/absensi', $payload)
            ->assertOk()
            ->assertJsonPath('already_recorded', true);

        $this->assertDatabaseCount('absensis', 1);
    }

    public function test_attendance_endpoints_require_login_and_history_is_private(): void
    {
        $this->postJson('/api/absensi', ['qr_code' => 'room=Perpustakaan'])->assertUnauthorized();
        $this->getJson('/api/absensi')->assertUnauthorized();

        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $user->absensis()->create([
            'nama' => $user->name,
            'nim_nis' => '',
            'tujuan' => 'Kunjungan',
            'qr_code' => 'room=Perpustakaan;subject=Kunjungan',
        ]);

        $otherUser = User::factory()->create();
        $otherToken = $otherUser->createToken('test')->plainTextToken;

        $this->withToken($otherToken)
            ->getJson('/api/absensi')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }
}
