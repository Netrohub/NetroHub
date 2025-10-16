@extends('admin.layout')

@section('title', __('CMS Pages'))

@section('content')
    <div class="admin-card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">{{ __('Manage Pages') }}</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="admin-table w-full">
                <thead>
                    <tr>
                        <th>{{ __('Slug') }}</th>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Version') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $p)
                        <tr>
                            <td class="font-mono text-sm">/{{ $p->slug }}</td>
                            <td>{{ $p->title }}</td>
                            <td>
                                <span class="badge {{ $p->status === 'published' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($p->status) }}</span>
                            </td>
                            <td>{{ $p->version ?? 0 }}</td>
                            <td>
                                <a href="{{ route('admin.cms.edit', $p) }}" class="btn-sm">{{ __('Edit') }}</a>
                                <a href="/{{ $p->slug }}" target="_blank" class="btn-secondary btn-sm">{{ __('View') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


