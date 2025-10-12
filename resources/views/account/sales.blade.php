@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-6">
        <h1 class="text-3xl font-black text-white">Sales</h1>
        <p class="text-muted-300">View all sales made from your listings.</p>
    </div>

    <x-ui.card variant="glass" class="p-0 mb-6">
        <nav class="flex overflow-x-auto text-sm">
            @php($tabs=['social'=>'Social','games'=>'Games','services'=>'Services'])
            @foreach($tabs as $key=>$label)
                <a href="{{ route('account.sales', ['tab'=>$key]) }}" class="flex items-center gap-2 px-5 py-3 border-b-2 {{ $tab === $key ? 'border-primary-500 text-white' : 'border-transparent text-muted-300 hover:text-white' }} whitespace-nowrap">
                    <x-platform-icon :category="$label" size="xs" />
                    {{ $label }}
                </a>
            @endforeach
        </nav>
    </x-ui.card>

    <x-ui.card variant="glass">
        <div class="mb-4">
            <h2 class="text-xl font-bold text-white">
                {{ $tab==='games' ? 'Game Accounts' : ($tab==='services' ? 'Services' : 'Social Accounts') }}
            </h2>
            <p class="text-sm text-muted-400">All your sales in this category.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-muted-400">
                    <tr>
                        <th class="px-4 py-3">Account</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Sale Date</th>
                        <th class="px-4 py-3 text-right">Preview</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gaming">
                    @forelse($sales as $item)
                        @php($product = $item->product)
                        <tr class="hover:bg-dark-800/50">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-dark-800 border border-gaming flex-shrink-0">
                                        @if($product->thumbnail_url)
                                            <img src="{{ $product->thumbnail_url }}" class="w-full h-full object-cover"/>
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <x-platform-icon :product="$product" size="sm" />
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-white font-medium line-clamp-1">{{ $product->title }}</div>
                                        @if($product->metadata['platform'] ?? false)
                                        <div class="flex items-center gap-1 text-xs text-muted-400">
                                            <x-platform-icon :product="$product" size="xs" />
                                            <span>{{ $product->metadata['platform'] }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 font-semibold text-white">${{ number_format($item->price ?? $product->price,2) }}</td>
                            <td class="px-4 py-4">
                                @php($status = $item->status ?? 'paid')
                                <x-ui.badge size="sm" variant="{{ $status==='paid' ? 'success' : ($status==='refunded' ? 'warning' : 'default') }}">{{ Str::title($status) }}</x-ui.badge>
                            </td>
                            <td class="px-4 py-4 text-muted-300">{{ optional($item->created_at)->format('M d, Y') }}</td>
                            <td class="px-4 py-4 text-right">
                                <a href="{{ route('seller.products.edit', $product) }}" class="px-3 py-2 rounded-xl border border-gaming text-muted-300 hover:text-white hover:bg-dark-700/50">👁️</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-muted-400">No sales found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ method_exists($sales,'links') ? $sales->links() : '' }}</div>
    </x-ui.card>
</div>
@endsection


