<?php

namespace Tests\Feature\Api;

use App\Models\Dosen;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DosenApiTest extends TestCase
{
    use RefreshDatabase;

    /** Pengaman: RefreshDatabase mengosongkan seluruh tabel. */
    protected function setUp(): void
    {
        if (($_ENV['DB_DATABASE'] ?? getenv('DB_DATABASE')) !== 'siakad_test') {
            $this->markTestSkipped(
                'DB_DATABASE bukan siakad_test; periksa phpunit.xml.'
            );
        }

        parent::setUp();
    }

    private function loginSebagai(string $role): User
    {
        $user = User::factory()->create(['role' => $role]);
        Sanctum::actingAs($user);

        return $user;
    }

    public function test_tamu_ditolak_dengan_401(): void
    {
        $this->getJson('/api/v1/dosen')->assertUnauthorized();
    }

    public function test_pengguna_login_melihat_daftar_berpaginasi(): void
    {
        Dosen::factory()->count(15)->create();
        $this->loginSebagai('mahasiwa');

        $this->getJson('/api/v1/dosen?per_page=5')
            ->assertOk()
            ->assertJsonCount(5, 'data')
            ->assertJsonPath('meta.total', 15)
            ->assertJsonStructure([
                'data' => [['id', 'nidn', 'nama', 'email', 'telepon', 'alamat']],
                'links',
                'meta',
            ]);
    }

    public function test_admin_dapat_menambah_dosen(): void
    {
        $this->loginSebagai('admin');

        $this->postJson('/api/v1/dosen', [
            'nidn' => '0099000101',
            'nama' => 'Dosen Uji',
            'email' => 'uji@siakad.test',
        ])
            ->assertCreated()
            ->assertHeader('Location')
            ->assertJsonPath('data.nidn', '0099000101');

        $this->assertDatabaseHas('dosen', ['email' => 'uji@siakad.test']);
    }

    public function test_validasi_gagal_menjawab_422(): void
    {
        $this->loginSebagai('admin');

        $this->postJson('/api/v1/dosen', ['email' => 'bukan-email'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['nidn', 'nama', 'email']);
    }

    public function test_patch_hanya_mengubah_kolom_yang_dikirim(): void
    {
        $dosen = Dosen::factory()->create();
        $this->loginSebagai('admin');

        $this->patchJson("/api/v1/dosen/{$dosen->id}", ['nama' => 'Nama Baru'])
            ->assertOk()
            ->assertJsonPath('data.nama', 'Nama Baru')
            ->assertJsonPath('data.email', $dosen->email);
    }

    public function test_non_admin_tidak_dapat_menghapus(): void
    {
        $dosen = Dosen::factory()->create();
        $this->loginSebagai('dosen');

        $this->deleteJson("/api/v1/dosen/{$dosen->id}")->assertForbidden();
        $this->assertDatabaseHas('dosen', ['id' => $dosen->id]);
    }

    public function test_admin_dapat_menghapus_dosen(): void
    {
        $dosen = Dosen::factory()->create();
        $this->loginSebagai('admin');

        $this->deleteJson("/api/v1/dosen/{$dosen->id}")->assertNoContent();
        $this->assertDatabaseMissing('dosen', ['id' => $dosen->id]);
    }
}