<?php

use App\Models\User;

test('welcome page displays role selection', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('FYP Management System');
    $response->assertSee('Student');
    $response->assertSee('Supervisor');
    $response->assertSee('Administrator');
});

test('role-specific login screen can be rendered', function () {
    $response = $this->get('/login/student');
    $response->assertStatus(200);
    $response->assertSee('Login as Student');

    $response = $this->get('/login/supervisor');
    $response->assertStatus(200);
    $response->assertSee('Login as Supervisor');

    $response = $this->get('/login/admin');
    $response->assertStatus(200);
    $response->assertSee('Login as Administrator');
});

test('legacy login route redirects to welcome page', function () {
    $response = $this->get('/login');
    $response->assertRedirect(route('welcome'));
});

test('student can authenticate through student portal', function () {
    $user = User::factory()->create(['role' => 'student', 'status' => 'active']);

    $response = $this->post('/login/student', [
        'email' => $user->email,
        'password' => 'password',
        'intended_role' => 'student',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('student.dashboard', absolute: false));
});

test('supervisor can authenticate through supervisor portal', function () {
    $user = User::factory()->create(['role' => 'supervisor', 'status' => 'active']);

    $response = $this->post('/login/supervisor', [
        'email' => $user->email,
        'password' => 'password',
        'intended_role' => 'supervisor',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('supervisor.dashboard', absolute: false));
});

test('admin can authenticate through admin portal', function () {
    $user = User::factory()->create(['role' => 'admin', 'status' => 'active']);

    $response = $this->post('/login/admin', [
        'email' => $user->email,
        'password' => 'password',
        'intended_role' => 'admin',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('admin.dashboard', absolute: false));
});

test('student cannot authenticate through admin portal', function () {
    $user = User::factory()->create(['role' => 'student', 'status' => 'active']);

    $response = $this->post('/login/admin', [
        'email' => $user->email,
        'password' => 'password',
        'intended_role' => 'admin',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['email']);
});

test('supervisor cannot authenticate through student portal', function () {
    $user = User::factory()->create(['role' => 'supervisor', 'status' => 'active']);

    $response = $this->post('/login/student', [
        'email' => $user->email,
        'password' => 'password',
        'intended_role' => 'student',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['email']);
});

test('admin cannot authenticate through supervisor portal', function () {
    $user = User::factory()->create(['role' => 'admin', 'status' => 'active']);

    $response = $this->post('/login/supervisor', [
        'email' => $user->email,
        'password' => 'password',
        'intended_role' => 'supervisor',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors(['email']);
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create(['role' => 'student', 'status' => 'active']);

    $this->post('/login/student', [
        'email' => $user->email,
        'password' => 'wrong-password',
        'intended_role' => 'student',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});
