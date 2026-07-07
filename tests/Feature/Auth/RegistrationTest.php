<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_standard_registration_is_disabled(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(404);

        $responsePost = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $responsePost->assertStatus(404);
    }

    public function test_admin_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin/register');

        $response->assertStatus(200);
    }

    public function test_new_admin_can_register(): void
    {
        $response = $this->post('/admin/register', [
            'name' => 'Admin User',
            'email' => 'admin@company.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        
        $admin = User::where('email', 'admin@company.com')->first();
        $this->assertNotNull($admin);
        $this->assertEquals('admin', $admin->role);
        
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_guest_cannot_access_employee_creation(): void
    {
        $response = $this->get('/admin/employees/create');
        $response->assertRedirect('/login');
    }

    public function test_employee_cannot_access_employee_creation(): void
    {
        $employee = User::factory()->create(['role' => 'employee']);

        $response = $this->actingAs($employee)->get('/admin/employees/create');
        $response->assertStatus(403);
    }

    public function test_admin_can_create_employee(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/employees/create');
        $response->assertStatus(200);

        $responseStore = $this->actingAs($admin)->post('/admin/employees/store', [
            'name' => 'New Hire',
            'email' => 'hire@company.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'department' => 'Engineering',
            'position' => 'Developer',
        ]);

        $responseStore->assertRedirect(route('admin.employees'));
        
        $this->assertDatabaseHas('users', [
            'email' => 'hire@company.com',
            'role' => 'employee',
            'department' => 'Engineering',
            'position' => 'Developer',
        ]);
    }
}

