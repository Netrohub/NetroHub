<!-- Account Navigation Sidebar -->
<aside class="w-full lg:w-64 flex-shrink-0 mb-8 lg:mb-0">
    <!-- Mobile Account Menu -->
    <div class="lg:hidden mb-6" x-data="{ open: false }">
        <button @click="open = !open" class="w-full flex items-center justify-between bg-slate-800/50 hover:bg-slate-800/70 rounded-xl p-4 border border-slate-700/50 hover:border-purple-500/30 transition-all duration-300 group">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <span class="text-slate-100 font-semibold">{{ __('قائمة الحساب') }}</span>
            </div>
            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div x-show="open" 
             x-collapse
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mt-2 bg-slate-800/50 rounded-xl border border-slate-700/50 overflow-hidden">
            @include('components.stellar.account-nav')
        </div>
    </div>

    <!-- Desktop Sidebar -->
    <div class="hidden lg:block bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 sticky top-24">
        @include('components.stellar.account-nav')
    </div>
</aside>

