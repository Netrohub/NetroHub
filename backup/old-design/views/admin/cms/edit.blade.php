@extends('admin.layout')

@section('title', __('Edit Page'))

@section('content')
    <form method="POST" action="{{ route('admin.cms.update', $page) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="admin-card p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">{{ __('Title') }}</label>
                    <input type="text" name="title" class="form-input w-full" value="{{ old('title', $page->title) }}" required>
                    @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">{{ __('Status') }}</label>
                    <select name="status" class="form-select w-full">
                        <option value="draft" @selected(old('status', $page->status)==='draft')>{{ __('Draft') }}</option>
                        <option value="published" @selected(old('status', $page->status)==='published')>{{ __('Published') }}</option>
                    </select>
                    @error('status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <label class="form-label">{{ __('Content (HTML)') }}</label>
                    <textarea name="content" rows="14" class="form-textarea w-full">{{ old('content', $page->content) }}</textarea>
                    @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="admin-card p-6">
            <h3 class="text-md font-semibold mb-4">{{ __('SEO') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">{{ __('Meta Title') }}</label>
                    <input type="text" name="meta_title" class="form-input w-full" value="{{ old('meta_title', $page->meta_title) }}">
                    @error('meta_title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">{{ __('Meta Description') }}</label>
                    <input type="text" name="meta_description" class="form-input w-full" value="{{ old('meta_description', $page->meta_description) }}">
                    @error('meta_description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a class="btn-secondary" href="{{ route('admin.cms.index') }}">{{ __('Cancel') }}</a>
            <button class="btn" type="submit">{{ __('Save Changes') }}</button>
        </div>
    </form>
@endsection


