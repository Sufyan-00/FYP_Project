@php($role = auth()->user()?->role)
<nav class="flex items-center gap-4 text-sm">
    @if ($role === 'student')
        <a href="{{ route('student.dashboard') }}" class="text-blue-700 hover:underline">Dashboard</a>
        <a href="{{ route('projects.index') }}" class="hover:underline">My Projects</a>
        <a href="{{ route('supervisors.directory') }}" class="hover:underline">Supervisors</a>
    @elseif ($role === 'supervisor')
        <a href="{{ route('supervisor.dashboard') }}" class="text-blue-700 hover:underline">Dashboard</a>
        <a href="{{ route('supervisor.projects') }}" class="hover:underline">Assigned Projects</a>
        <a href="{{ route('supervisor.history') }}" class="hover:underline">History</a>
    @elseif ($role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="text-blue-700 hover:underline">Dashboard</a>
        <a href="{{ route('admin.projects.index') }}" class="hover:underline">Projects</a>
        <a href="{{ route('admin.templates.index') }}" class="hover:underline">Templates</a>
        <a href="{{ route('admin.users.index') }}" class="hover:underline">Users</a>
    @endif

    <a href="{{ route('profile.edit') }}" class="hover:underline">Profile</a>
</nav>