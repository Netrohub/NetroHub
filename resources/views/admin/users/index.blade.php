@extends('admin.layout')

@section('title', 'Users Management')

@section('content')
<!-- Page header -->
<div class="sm:flex sm:justify-between sm:items-center mb-8">
    <!-- Left: Title -->
    <div class="mb-4 sm:mb-0">
        <h1 class="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Users Management</h1>
    </div>
    
    <!-- Right: Actions -->
    <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2">
            <input
                type="search"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search users..."
                class="admin-input"
            />
            <button type="submit" class="btn-primary">Search</button>
        </form>
    </div>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700/60 p-4 mb-6">
    <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
            <select name="role" class="admin-select">
                <option value="">All Roles</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="seller" {{ request('role') === 'seller' ? 'selected' : '' }}>Seller</option>
                <option value="buyer" {{ request('role') === 'buyer' ? 'selected' : '' }}>Buyer</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-secondary">Apply Filters</button>
        </div>
    </form>
</div>

<!-- Users Table -->
<div class="admin-card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-violet-100 dark:bg-violet-500/10 flex items-center justify-center text-violet-600 dark:text-violet-400 font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="ml-3">
                                    <div class="font-medium text-gray-800 dark:text-gray-100">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge badge-info mr-1">{{ $role->name }}</span>
                            @endforeach
                            @if($user->roles->isEmpty())
                                <span class="text-gray-500 dark:text-gray-400 text-sm">No roles</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge badge-success">Verified</span>
                            @else
                                <span class="badge badge-warning">Unverified</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-violet-500 hover:text-violet-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 dark:text-gray-400">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection

