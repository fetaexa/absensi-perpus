<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_login_with_school_email_and_shared_password(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'siswa.123@student.stembayo.sch.id',
            'password' => 'stembayo123',
        ]);

        $response->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('user.email', 'siswa.123@student.stembayo.sch.id')
            ->assertJsonStructure(['token']);

        $this->assertDatabaseHas('users', [
            'email' => 'siswa.123@student.stembayo.sch.id',
        ]);
    }

    public function test_login_rejects_wrong_domain_or_password(): void
    {
        $this->postJson('/api/login', [
            'email' => 'student@example.com',
            'password' => 'stembayo123',
        ])->assertUnprocessable();

        $this->postJson('/api/login', [
            'email' => 'siswa@student.stembayo.sch.id',
            'password' => 'wrong-password',
        ])->assertUnprocessable();
    }

    public function test_existing_student_account_can_login_with_shared_password(): void
    {
        User::factory()->create([
            'email' => 'siswa.lama@student.stembayo.sch.id',
            'password' => 'password-lama',
        ]);

        $this->postJson('/api/login', [
            'email' => 'siswa.lama@student.stembayo.sch.id',
            'password' => 'stembayo123',
        ])->assertOk()->assertJsonPath('user.email', 'siswa.lama@student.stembayo.sch.id');
    }

    public function test_profile_is_saved_and_available_after_logging_in_again(): void
    {
        $email = 'siswa@student.stembayo.sch.id';
        $login = fn () => $this->postJson('/api/login', [
            'email' => $email,
            'password' => 'stembayo123',
        ])->assertOk()->json('token');

        $firstToken = $login();
        $profile = [
            'nama' => 'Siswa Contoh',
            'nisn' => '12345',
            'kelas' => 'XI SIJA A',
            'sekolah' => 'SMK Negeri 2 Depok Sleman',
        ];

        $this->withToken($firstToken)
            ->putJson('/api/profile', $profile)
            ->assertOk()
            ->assertJsonPath('data.nama', 'Siswa Contoh');

        $secondToken = $login();

        $this->withToken($secondToken)
            ->getJson('/api/profile')
            ->assertOk()
            ->assertJsonPath('data', $profile);
    }

    public function test_profile_requires_authentication(): void
    {
        $this->getJson('/api/profile')->assertUnauthorized();
        $this->putJson('/api/profile', ['nama' => 'Siswa'])->assertUnauthorized();
    }

    public function test_browser_request_to_protected_api_returns_unauthorized_instead_of_redirecting_to_web_login(): void
    {
        $this->get('/api/profile')->assertUnauthorized();
    }

    public function test_github_pages_origin_is_allowed_to_call_the_api(): void
    {
        $this->withHeaders([
            'Origin' => 'https://fetaexa.github.io',
            'Access-Control-Request-Method' => 'POST',
            'Access-Control-Request-Headers' => 'content-type',
        ])->options('/api/login')
            ->assertNoContent()
            ->assertHeader('Access-Control-Allow-Origin', 'https://fetaexa.github.io');
    }

    public function test_vercel_origin_is_allowed_to_call_the_api(): void
    {
        $origin = 'https://absensi-perpus-ghyhcnecv-aulian2036s-projects.vercel.app';

        $this->withHeaders([
            'Origin' => $origin,
            'Access-Control-Request-Method' => 'POST',
            'Access-Control-Request-Headers' => 'content-type',
        ])->options('/api/login')
            ->assertNoContent()
            ->assertHeader('Access-Control-Allow-Origin', $origin);
    }
}
