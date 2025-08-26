@php
    $role = auth()->user()?->role;

    $dashboardRoutes = [
        'student' => 'student.dashboard',
        'supervisor' => 'supervisor.dashboard',
        'admin' => 'admin.dashboard',
    ];
    $dashboardRoute = $dashboardRoutes[$role] ?? 'dashboard';
@endphp

@if ($role === 'student')
    <x-responsive-nav-link :href="route($dashboardRoute)" :active="request()->routeIs($dashboardRoute)">
        Dashboard
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')">
        My Projects
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('supervisors.directory')" :active="request()->routeIs('supervisors.directory')">
        Supervisors
    </x-responsive-nav-link>

@elseif ($role === 'supervisor')
    <x-responsive-nav-link :href="route($dashboardRoute)" :active="request()->routeIs($dashboardRoute)">
        Dashboard
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('supervisor.projects')" :active="request()->routeIs('supervisor.projects')">
        Assigned Projects
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('supervisor.history')" :active="request()->routeIs('supervisor.history')">
        History
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('supervisor.profile.edit')" :active="request()->routeIs('supervisor.profile.edit')">
        My Profile
    </x-responsive-nav-link>

@elseif ($role === 'admin')
    <x-responsive-nav-link :href="route($dashboardRoute)" :active="request()->routeIs($dashboardRoute)">
        Dashboard
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('admin.projects.index')" :active="request()->routeIs('admin.projects.*')">
        Projects
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('admin.templates.index')" :active="request()->routeIs('admin.templates.*')">
        Templates
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
        Users
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('admin.evaluators.index')" :active="request()->routeIs('admin.evaluators.*')">
        Evaluators
    </x-responsive-nav-link>
@endif