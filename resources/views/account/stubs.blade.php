<x-layouts.app>
    <x-slot name="title">{{ __('Stubs') }} - {{ config('app.name') }}</x-slot>

<section class="relative pt-32 pb-12">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <x-ui.card variant="glass">
        <h1 class="text-3xl font-bold mb-2">{{ $title ?? 'Account' }}</h1>
        <p class="text-muted-300">This is a placeholder page for {{ $title ?? 'Account' }}. Build your content here.</p>
    </x-ui.card>
</div>
</section>

</x-layouts.app>


