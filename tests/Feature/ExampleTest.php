<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_opening_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));
    }

    public function test_admin_is_redirected_to_admin_dashboard_after_login(): void
    {
        $user = $this->makeUser(User::ROLE_ADMIN);

        $this->post('/login', ['email' => $user->email, 'password' => 'Password123!'])
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_bendahara_is_redirected_to_bendahara_dashboard_after_login(): void
    {
        $user = $this->makeUser(User::ROLE_BENDAHARA);

        $this->post('/login', ['email' => $user->email, 'password' => 'Password123!'])
            ->assertRedirect(route('bendahara.dashboard'));
    }

    public function test_warga_is_redirected_to_warga_dashboard_after_login(): void
    {
        $user = $this->makeUser(User::ROLE_WARGA);

        $this->post('/login', ['email' => $user->email, 'password' => 'Password123!'])
            ->assertRedirect(route('warga.dashboard'));
    }

    public function test_warga_and_bendahara_cannot_access_admin_routes(): void
    {
        $this->actingAs($this->makeUser(User::ROLE_WARGA))
            ->get('/admin/kepala-keluarga')
            ->assertForbidden();

        $this->actingAs($this->makeUser(User::ROLE_BENDAHARA))
            ->get('/admin/dashboard')
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $this->actingAs($this->makeUser(User::ROLE_ADMIN))
            ->get('/admin/dashboard')
            ->assertOk();
    }

    public function test_logout_ends_the_authenticated_session(): void
    {
        $user = $this->makeUser(User::ROLE_WARGA);

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    private function makeUser(string $role): User
    {
        return User::factory()->create([
            'role' => $role,
            'password' => Hash::make('Password123!'),
        ]);
    }
}
