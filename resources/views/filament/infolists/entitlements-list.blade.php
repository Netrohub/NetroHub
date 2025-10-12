<div class="space-y-2">
    @php
        $entitlements = $getRecord()->user->entitlements;
    @endphp

    @if($entitlements->isEmpty())
        <p class="text-sm text-gray-500">No entitlements found</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($entitlements as $entitlement)
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $entitlement->key }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Value: <strong>{{ $entitlement->getValue() }}</strong>
                            </p>
                            @if($entitlement->reset_period !== 'never')
                                <p class="text-xs text-gray-400 mt-1">
                                    Resets: {{ ucfirst($entitlement->reset_period) }}
                                </p>
                            @endif
                        </div>
                        @if($entitlement->period_end)
                            <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded">
                                Until {{ $entitlement->period_end->format('M d') }}
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

