<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Quick Links
        </x-slot>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($this->getLinks() as $link)
                @php
                    $colorClass = match($link['color']) {
                        'warning' => 'bg-warning-50 dark:bg-warning-400/10 text-warning-600 dark:text-warning-400 border-warning-200 dark:border-warning-400/20',
                        'danger' => 'bg-danger-50 dark:bg-danger-400/10 text-danger-600 dark:text-danger-400 border-danger-200 dark:border-danger-400/20',
                        'success' => 'bg-success-50 dark:bg-success-400/10 text-success-600 dark:text-success-400 border-success-200 dark:border-success-400/20',
                        default => 'bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 border-gray-200 dark:border-gray-700',
                    };
                @endphp
                
                <div class="flex items-center gap-3 rounded-lg border p-4 {{ $colorClass }}">
                    <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-white dark:bg-gray-900">
                        <x-filament::icon
                            :icon="$link['icon']"
                            class="h-6 w-6"
                        />
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium">{{ $link['label'] }}</p>
                        <p class="text-2xl font-bold">{{ $link['count'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

