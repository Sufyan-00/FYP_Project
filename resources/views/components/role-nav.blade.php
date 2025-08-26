@props(['class' => ''])

@php
    $role = auth()->user()?->role;

    // Map to per-role dashboards; fallback to default 'dashboard'
    $dashboardRoutes = [
        'student' => 'student.dashboard',
        'supervisor' => 'supervisor.dashboard',
        'admin' => 'admin.dashboard',
    ];
    $dashboardRoute = $dashboardRoutes[$role] ?? 'dashboard';
@endphp

<div {{ $attributes->merge(['class' => $class]) }}>
    @if ($role === 'student')
        <x-nav-link :href="route($dashboardRoute)" :active="request()->routeIs($dashboardRoute)">
            Dashboard
        </x-nav-link>

        <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.*')">
            My Projects
        </x-nav-link>

        <x-nav-link :href="route('supervisors.directory')" :active="request()->routeIs('supervisors.directory')">
            Supervisors
        </x-nav-link>

    @elseif ($role === 'supervisor')
        <x-nav-link :href="route($dashboardRoute)" :active="request()->routeIs($dashboardRoute)">
            Dashboard
        </x-nav-link>

        <x-nav-link :href="route('supervisor.projects')" :active="request()->routeIs('supervisor.projects')">
            Assigned Projects
        </x-nav-link>

        <x-nav-link :href="route('supervisor.history')" :active="request()->routeIs('supervisor.history')">
            History
        </x-nav-link>

        <x-nav-link :href="route('supervisor.profile.edit')" :active="request()->routeIs('supervisor.profile.edit')">
            My Profile
        </x-nav-link>

    @elseif ($role === 'admin')
        <x-nav-link :href="route($dashboardRoute)" :active="request()->routeIs($dashboardRoute)">
            Dashboard
        </x-nav-link>

        <x-nav-link :href="route('admin.projects.index')" :active="request()->routeIs('admin.projects.*')">
            Projects
        </x-nav-link>

        <x-nav-link :href="route('admin.templates.index')" :active="request()->routeIs('admin.templates.*')">
            Templates
        </x-nav-link>

        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
            Users
        </x-nav-link>

        <x-nav-link :href="route('admin.committees.index')" :active="request()->routeIs('admin.committees.*')">
            Committees
        </x-nav-link>

        <x-nav-link :href="route('admin.evaluators.index')" :active="request()->routeIs('admin.evaluators.*')">
            Evaluators
        </x-nav-link>
    @endif
</div>