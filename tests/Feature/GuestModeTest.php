<?php

use App\Models\Project;
use App\Models\ScopeDocument;
use App\Models\SupervisorProfile;
use App\Models\User;
use Database\Seeders\GuestModeSeeder;
use Illuminate\Support\Facades\Hash;

// ---------------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------------

/**
 * Create (or retrieve) a demo user for a given role.
 * Mirrors what GuestModeSeeder produces.
 */
function demoUser(string $role): User
{
    $email = match ($role) {
        'student'    => 'demo.student@fyp.demo',
        'supervisor' => 'demo.supervisor@fyp.demo',
        'admin'      => 'demo.admin@fyp.demo',
    };

    return User::firstOrCreate(
        ['email' => $email],
        [
            'name'              => "Demo {$role}",
            'password'          => Hash::make('demo_password'),
            'role'              => $role,
            'status'            => 'active',
            'email_verified_at' => now(),
        ]
    );
}

// ===========================================================================
// 1. GuestModeSeeder Tests
// ===========================================================================

test('GuestModeSeeder creates all three demo accounts', function () {
    $this->seed(GuestModeSeeder::class);

    foreach (['demo.student@fyp.demo', 'demo.supervisor@fyp.demo', 'demo.admin@fyp.demo'] as $email) {
        $this->assertDatabaseHas('users', ['email' => $email, 'status' => 'active']);
    }
});

test('GuestModeSeeder creates a SupervisorProfile for demo supervisor', function () {
    $this->seed(GuestModeSeeder::class);

    $supervisor = User::where('email', 'demo.supervisor@fyp.demo')->firstOrFail();
    $this->assertDatabaseHas('supervisor_profiles', ['user_id' => $supervisor->id]);
});

test('GuestModeSeeder creates a sample project for demo student', function () {
    $this->seed(GuestModeSeeder::class);

    $student = User::where('email', 'demo.student@fyp.demo')->firstOrFail();
    $this->assertDatabaseHas('projects', [
        'user_id' => $student->id,
        'status'  => 'approved',
    ]);
});

test('GuestModeSeeder is idempotent (safe to run twice)', function () {
    $this->seed(GuestModeSeeder::class);
    $this->seed(GuestModeSeeder::class);

    $this->assertSame(1, User::where('email', 'demo.student@fyp.demo')->count());
    $this->assertSame(1, User::where('email', 'demo.supervisor@fyp.demo')->count());
    $this->assertSame(1, User::where('email', 'demo.admin@fyp.demo')->count());
});

// ===========================================================================
// 2. Guest Login Route Tests
// ===========================================================================

test('guest login route is accessible without authentication', function () {
    $this->seed(GuestModeSeeder::class);

    $response = $this->get(route('guest.login', ['role' => 'student']));
    // Should redirect (302) to student dashboard after auto-login
    $response->assertRedirect(route('student.dashboard'));
});

test('guest login as student auto-authenticates the demo student', function () {
    $this->seed(GuestModeSeeder::class);

    $response = $this->get(route('guest.login', ['role' => 'student']));

    $this->assertAuthenticated();
    $this->assertSame('demo.student@fyp.demo', auth()->user()->email);
    $response->assertRedirect(route('student.dashboard'));
});

test('guest login as supervisor auto-authenticates the demo supervisor', function () {
    $this->seed(GuestModeSeeder::class);

    $response = $this->get(route('guest.login', ['role' => 'supervisor']));

    $this->assertAuthenticated();
    $this->assertSame('demo.supervisor@fyp.demo', auth()->user()->email);
    $response->assertRedirect(route('supervisor.dashboard'));
});

test('guest login as admin auto-authenticates the demo admin', function () {
    $this->seed(GuestModeSeeder::class);

    $response = $this->get(route('guest.login', ['role' => 'admin']));

    $this->assertAuthenticated();
    $this->assertSame('demo.admin@fyp.demo', auth()->user()->email);
    $response->assertRedirect(route('admin.dashboard'));
});

test('guest login marks session as demo', function () {
    $this->seed(GuestModeSeeder::class);

    $this->get(route('guest.login', ['role' => 'student']));

    $this->assertTrue(session('is_guest_demo'));
});

test('guest login with invalid role returns 404', function () {
    $response = $this->get('/guest/login/hacker');
    $response->assertNotFound();
});

test('guest login returns error when demo account is missing', function () {
    // Do NOT seed demo accounts intentionally
    $response = $this->get(route('guest.login', ['role' => 'student']));

    $response->assertRedirect(route('welcome'));
    $response->assertSessionHas('error');
});

// ===========================================================================
// 3. Guest Logout Route Tests
// ===========================================================================

test('guest logout logs the demo user out and redirects to welcome', function () {
    $this->seed(GuestModeSeeder::class);

    $demoStudent = demoUser('student');

    $response = $this
        ->actingAs($demoStudent)
        ->withSession(['is_guest_demo' => true])
        ->get(route('guest.logout'));

    $this->assertGuest();
    $response->assertRedirect(route('welcome'));
    $response->assertSessionHas('success');
});

test('guest logout requires authentication', function () {
    $response = $this->get(route('guest.logout'));
    // Unauthenticated users should be redirected to login
    $response->assertRedirect(route('login'));
});

// ===========================================================================
// 4. GuestReadOnly Middleware Tests
// ===========================================================================

test('demo user can access GET (read-only) routes', function () {
    $this->seed(GuestModeSeeder::class);

    $demoStudent = demoUser('student');

    $response = $this
        ->actingAs($demoStudent)
        ->withSession(['is_guest_demo' => true])
        ->get(route('student.dashboard'));

    // Should not be blocked — GET is always allowed
    $response->assertStatus(200);
});

test('demo user cannot perform POST actions and is redirected back with flash', function () {
    $this->seed(GuestModeSeeder::class);

    $demoStudent = demoUser('student');

    // Attempt to create a project (POST) as a demo user.
    // We set a Referer header so Laravel's back() helper resolves correctly.
    $response = $this
        ->actingAs($demoStudent)
        ->withSession(['is_guest_demo' => true])
        ->withHeaders(['Referer' => route('student.dashboard')])
        ->post(route('projects.store'), [
            'title'         => 'Hacked Project',
            'description'   => 'Should not be created',
            'supervisor_id' => 1,
        ]);

    // GuestReadOnly middleware should redirect back with guest_blocked flash
    $response->assertRedirect();
    $response->assertSessionHas('guest_blocked');

    // Verify no project was actually created
    $this->assertDatabaseMissing('projects', ['title' => 'Hacked Project']);
});

test('non-demo authenticated user is not blocked by GuestReadOnly middleware', function () {
    $regularStudent = User::factory()->create([
        'role'   => 'student',
        'status' => 'active',
    ]);

    // Regular session (no is_guest_demo flag) — POST should not be blocked
    // We just check the middleware doesn't add the guest_blocked flash
    $response = $this
        ->actingAs($regularStudent)
        ->post(route('projects.store'), [
            'title'         => 'Real Project',
            'description'   => 'Normal submission',
            'supervisor_id' => 1,
        ]);

    $response->assertSessionMissing('guest_blocked');
});

// ===========================================================================
// 5. Welcome Page Tests
// ===========================================================================

test('welcome page shows demo mode section', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Try a Demo');
    $response->assertSee('demo-student-btn');
    $response->assertSee('demo-supervisor-btn');
    $response->assertSee('demo-admin-btn');
});

test('welcome page demo links point to correct guest login routes', function () {
    $response = $this->get('/');

    $response->assertSee(route('guest.login', ['role' => 'student']));
    $response->assertSee(route('guest.login', ['role' => 'supervisor']));
    $response->assertSee(route('guest.login', ['role' => 'admin']));
});

// ===========================================================================
// 6. Guest Mode Banner Tests
// ===========================================================================

test('guest mode banner is visible on student dashboard during demo session', function () {
    $this->seed(GuestModeSeeder::class);

    $demoStudent = demoUser('student');

    $response = $this
        ->actingAs($demoStudent)
        ->withSession(['is_guest_demo' => true])
        ->get(route('student.dashboard'));

    $response->assertSee('Demo Mode');
    $response->assertSee('Exit Demo');
});

test('guest mode banner is NOT shown for regular authenticated users', function () {
    $regularStudent = User::factory()->create([
        'role'   => 'student',
        'status' => 'active',
    ]);

    $response = $this
        ->actingAs($regularStudent)
        ->get(route('student.dashboard'));

    // Banner renders only when is_guest_demo session flag is present
    $response->assertDontSee('demo-mode-banner', false);
});

// ===========================================================================
// 7. Role Access Control — Demo Users Can View Their Role's Dashboard
// ===========================================================================

test('demo supervisor can view supervisor dashboard', function () {
    $this->seed(GuestModeSeeder::class);

    $demoSupervisor = demoUser('supervisor');

    $response = $this
        ->actingAs($demoSupervisor)
        ->withSession(['is_guest_demo' => true])
        ->get(route('supervisor.dashboard'));

    $response->assertStatus(200);
});

test('demo admin can view admin dashboard', function () {
    $this->seed(GuestModeSeeder::class);

    $demoAdmin = demoUser('admin');

    $response = $this
        ->actingAs($demoAdmin)
        ->withSession(['is_guest_demo' => true])
        ->get(route('admin.dashboard'));

    $response->assertStatus(200);
});
