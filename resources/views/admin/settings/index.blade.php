@extends('admin.layout')

@section('title', __('Site Settings'))

@section('content')
    <div class="max-w-5xl mx-auto">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="admin-card p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('General') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">{{ __('Site Name') }}</label>
                        <input type="text" name="site_name" class="form-input w-full" value="{{ old('site_name', $general['site_name']) }}" required>
                        @error('site_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">{{ __('Company Name') }}</label>
                        <input type="text" name="company_name" class="form-input w-full" value="{{ old('company_name', $general['company_name']) }}">
                        @error('company_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="admin-card p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('SEO') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">{{ __('SEO Title') }}</label>
                        <input type="text" name="seo_title" class="form-input w-full" value="{{ old('seo_title', $seo['seo_title']) }}">
                        @error('seo_title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">{{ __('SEO Keywords') }}</label>
                        <input type="text" name="seo_keywords" class="form-input w-full" value="{{ old('seo_keywords', $seo['seo_keywords']) }}">
                        @error('seo_keywords')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label">{{ __('SEO Description') }}</label>
                        <textarea name="seo_description" rows="3" class="form-textarea w-full">{{ old('seo_description', $seo['seo_description']) }}</textarea>
                        @error('seo_description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="admin-card p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('Social & Links') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Twitter</label>
                        <input type="text" name="twitter_handle" class="form-input w-full" placeholder="@netrohub" value="{{ old('twitter_handle', $social['twitter_handle']) }}">
                    </div>
                    <div>
                        <label class="form-label">Facebook URL</label>
                        <input type="url" name="facebook_url" class="form-input w-full" value="{{ old('facebook_url', $social['facebook_url']) }}">
                    </div>
                    <div>
                        <label class="form-label">Instagram URL</label>
                        <input type="url" name="instagram_url" class="form-input w-full" value="{{ old('instagram_url', $social['instagram_url']) }}">
                    </div>
                    <div>
                        <label class="form-label">Discord URL</label>
                        <input type="url" name="discord_url" class="form-input w-full" value="{{ old('discord_url', $social['discord_url']) }}">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="btn-secondary">{{ __('Cancel') }}</a>
                <button type="submit" class="btn">{{ __('Save Changes') }}</button>
            </div>
        </form>
    </div>
@endsection


