<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold">System Health Checks</h2>
            <x-filament::button wire:click="refresh" icon="heroicon-o-arrow-path">
                Refresh
            </x-filament::button>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @foreach ($checks as $name => $check)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-{{ $check['color'] }}-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold capitalize">{{ str_replace('_', ' ', $name) }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $check['message'] }}</p>
                        </div>
                        <div>
                            @if ($check['status'] === 'healthy' || $check['status'] === 'info')
                                <x-heroicon-o-check-circle class="w-8 h-8 text-{{ $check['color'] }}-500" />
                            @elseif ($check['status'] === 'warning')
                                <x-heroicon-o-exclamation-triangle class="w-8 h-8 text-{{ $check['color'] }}-500" />
                            @else
                                <x-heroicon-o-x-circle class="w-8 h-8 text-{{ $check['color'] }}-500" />
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <x-filament::button color="info" wire:click="$dispatch('clear-cache')">
                    Clear Cache
                </x-filament::button>
                <x-filament::button color="warning" wire:click="$dispatch('optimize')">
                    Optimize
                </x-filament::button>
                <x-filament::button color="success" wire:click="$dispatch('view-logs')">
                    View Logs
                </x-filament::button>
                <x-filament::button color="gray" wire:click="$dispatch('queue-status')">
                    Queue Status
                </x-filament::button>
            </div>
        </div>
    </div>
</x-filament-panels::page>

