<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ScopeDocument;
use App\Models\SupervisorProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * GuestModeSeeder
 *
 * Creates three fixed demo accounts (student / supervisor / admin) with
 * realistic data so new visitors can explore the system without registering.
 *
 * Credentials:
 *   demo.student@fyp.demo    / demo_password
 *   demo.supervisor@fyp.demo / demo_password
 *   demo.admin@fyp.demo      / demo_password
 *
 * Run standalone:   php artisan db:seed --class=GuestModeSeeder
 * Included in:      DatabaseSeeder
 */
class GuestModeSeeder extends Seeder
{
    private const PASSWORD = 'demo_password';

    public function run(): void
    {
        $this->command->info('🎭 Seeding demo (guest-mode) accounts...');

        $admin      = $this->seedAdmin();
        $supervisor = $this->seedSupervisor();
        $student    = $this->seedStudent($supervisor);

        $this->command->info('✅ Guest-mode accounts ready!');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin',      'demo.admin@fyp.demo',      self::PASSWORD],
                ['Supervisor', 'demo.supervisor@fyp.demo', self::PASSWORD],
                ['Student',    'demo.student@fyp.demo',    self::PASSWORD],
            ]
        );
    }

    // -------------------------------------------------------------------------
    // Private helpers
    // -------------------------------------------------------------------------

    private function seedAdmin(): User
    {
        return User::updateOrCreate(
            ['email' => 'demo.admin@fyp.demo'],
            [
                'name'              => 'Demo Admin',
                'password'          => Hash::make(self::PASSWORD),
                'role'              => 'admin',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );
    }

    private function seedSupervisor(): User
    {
        $supervisor = User::updateOrCreate(
            ['email' => 'demo.supervisor@fyp.demo'],
            [
                'name'              => 'Dr. Demo Supervisor',
                'password'          => Hash::make(self::PASSWORD),
                'role'              => 'supervisor',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );

        SupervisorProfile::updateOrCreate(
            ['user_id' => $supervisor->id],
            [
                'research_interests' => 'Artificial Intelligence, Machine Learning, Data Science, Cloud Computing',
                'available_slots'    => 5,
            ]
        );

        return $supervisor;
    }

    private function seedStudent(User $supervisor): User
    {
        $student = User::updateOrCreate(
            ['email' => 'demo.student@fyp.demo'],
            [
                'name'              => 'Demo Student',
                'password'          => Hash::make(self::PASSWORD),
                'role'              => 'student',
                'status'            => 'active',
                'email_verified_at' => now(),
            ]
        );

        // Create a sample approved project so the dashboard shows real content.
        $project = Project::updateOrCreate(
            [
                'user_id'     => $student->id,
                'title'       => 'AI-Powered FYP Management System',
            ],
            [
                'user_id'       => $student->id,
                'supervisor_id' => $supervisor->id,
                'description'   => 'A demonstration project showcasing how AI can streamline the Final Year Project management process, including intelligent supervisor matching, automated deadline tracking, and smart document analysis.',
                'status'        => 'approved',
                'current_phase' => 'scope',
                'semester'      => 'Fall 2025',
            ]
        );

        // Attach a sample pending scope document so that section is visible.
        ScopeDocument::updateOrCreate(
            ['project_id' => $project->id, 'version' => 'v1'],
            [
                'project_id' => $project->id,
                'file_path'  => 'demo/scope_document_v1.pdf',
                'version'    => 'v1',
                'status'     => 'pending',
                'user_id'    => $student->id,
            ]
        );

        return $student;
    }
}
