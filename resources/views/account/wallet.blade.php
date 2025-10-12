@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ twofa:false }">
    <div class="mb-6">
        <h1 class="text-3xl font-black text-white">Wallet</h1>
        <p class="text-muted-300">Manage your balance and payouts.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <x-ui.card variant="glass"><p class="text-xs text-muted-400">Available</p><p class="text-2xl font-bold text-white">${{ number_format($stats['available'],2) }}</p></x-ui.card>
        <x-ui.card variant="glass"><p class="text-xs text-muted-400">Pending</p><p class="text-2xl font-bold text-white">${{ number_format($stats['pending'],2) }}</p></x-ui.card>
        <x-ui.card variant="glass"><p class="text-xs text-muted-400">Total Earned</p><p class="text-2xl font-bold text-white">${{ number_format($stats['earned'],2) }}</p></x-ui.card>
        <x-ui.card variant="glass"><p class="text-xs text-muted-400">Fees</p><p class="text-2xl font-bold text-white">${{ number_format($stats['fees'],2) }}</p></x-ui.card>
    </div>

    <div class="flex flex-wrap gap-3 mb-6">
        <button @click="twofa=true" class="px-4 py-2 bg-gaming-gradient text-white rounded-xl font-bold {{ $stats['available'] <= 0 ? 'opacity-50 pointer-events-none' : '' }}">Request Payout</button>
        <button @click="twofa=true" class="px-4 py-2 bg-dark-800 border border-gaming text-white rounded-xl">Add Funds</button>
    </div>

    <x-ui.card variant="glass" class="p-0 mb-6">
        <nav class="flex overflow-x-auto text-sm">
            @php($tabs=['all'=>'All','sales'=>'Sales','payouts'=>'Payouts','refunds'=>'Adjustments/Refunds'])
            @foreach($tabs as $key=>$label)
                <a href="{{ route('account.wallet', ['tab'=>$key]) }}" class="px-5 py-3 border-b-2 {{ $tab === $key ? 'border-primary-500 text-white' : 'border-transparent text-muted-300 hover:text-white' }} whitespace-nowrap">{{ $label }}</a>
            @endforeach
        </nav>
    </x-ui.card>

    <x-ui.card variant="glass">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-left text-muted-400">
                    <tr>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Amount</th>
                        <th class="px-4 py-3">Reference</th>
                        <th class="px-4 py-3">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gaming">
                    @forelse($transactions as $t)
                        <tr class="hover:bg-dark-800/50">
                            <td class="px-4 py-3 text-muted-300">{{ optional($t->created_at)->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-white">{{ Str::title($t->type) }}</td>
                            <td class="px-4 py-3 {{ in_array($t->type,['sale','adjustment']) ? 'text-green-400' : 'text-red-400' }}">{{ $t->amount >= 0 ? '+' : '' }}${{ number_format($t->amount,2) }}</td>
                            <td class="px-4 py-3 text-muted-300">{{ $t->reference ?? '-' }}</td>
                            <td class="px-4 py-3 text-muted-300">{{ $t->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-muted-400">No transactions.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ method_exists($transactions,'links') ? $transactions->links() : '' }}</div>
    </x-ui.card>

    <!-- 2FA Modal -->
    <div x-show="twofa" x-cloak class="fixed inset-0 z-50">
        <div class="absolute inset-0 bg-black/60" @click="twofa=false"></div>
        <div class="relative max-w-md mx-auto mt-24 bg-dark-800/90 backdrop-blur-xl border border-gaming rounded-2xl shadow-2xl">
            <div class="px-6 py-4 border-b border-gaming flex items-center justify-between">
                <h3 class="text-lg font-bold text-white">Verification</h3>
                <button class="text-muted-400" @click="twofa=false">✕</button>
            </div>
            <div class="p-6 space-y-4">
                <label class="block text-sm text-white">Verification Code</label>
                <input class="w-full px-4 py-3 bg-dark-900 border border-gaming rounded-xl text-white" placeholder="#####"/>
                <div class="flex gap-3">
                    <button class="px-4 py-2 bg-gaming-gradient text-white rounded-xl">Confirm</button>
                    <button class="px-4 py-2 bg-dark-800 border border-gaming text-white rounded-xl">Send/Resend Code</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


