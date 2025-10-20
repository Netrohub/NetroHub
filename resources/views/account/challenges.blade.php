<x-layouts.app>
    <x-slot name="title">{{ __('Challenges') }} - {{ config('app.name') }}</x-slot>

    <section class="relative pt-32 pb-12 md:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <h1 class="h2 bg-clip-text text-transparent bg-gradient-to-r from-slate-200/60 via-slate-200 to-slate-200/60 mb-8">
                {{ __('التحديات') }}
            </h1>

            <div class="lg:flex lg:gap-8">
                
                <!-- Sidebar -->
                <x-account-sidebar />

                <!-- Main Content -->
                <div class="flex-1 min-w-0 space-y-8">
                    
                    <!-- Progress Overview -->
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-purple-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                                <div class="text-3xl font-bold text-white mb-1">{{ $completedChallenges ?? 0 }}</div>
                                <div class="text-sm text-slate-400">{{ __('Completed') }}</div>
                            </div>
                        </div>

                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up" data-aos-delay="100">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <div class="text-3xl font-bold text-white mb-1">{{ $activeChallenges ?? 0 }}</div>
                                <div class="text-sm text-slate-400">{{ __('In Progress') }}</div>
                            </div>
                        </div>

                        <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50" data-aos="fade-up" data-aos-delay="200">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                </div>
                                <div class="text-3xl font-bold text-white mb-1">{{ $totalPoints ?? 0 }}</div>
                                <div class="text-sm text-slate-400">{{ __('Points Earned') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Challenges -->
                    <div class="bg-slate-800/50 rounded-2xl p-6 lg:p-8 border border-slate-700/50" data-aos="fade-up" data-aos-delay="300">
                        <h2 class="text-xl font-bold text-slate-100 mb-6">{{ __('Available Challenges') }}</h2>
                        
                        <div class="space-y-4">
                            @php
                            $sampleChallenges = [
                                ['title' => __('First Purchase'), 'description' => __('Make your first purchase'), 'reward' => '100', 'progress' => 0, 'total' => 1],
                                ['title' => __('Early Bird'), 'description' => __('Complete 5 orders'), 'reward' => '500', 'progress' => auth()->user()->orders()->count(), 'total' => 5],
                                ['title' => __('Power Buyer'), 'description' => __('Spend $500 total'), 'reward' => '1000', 'progress' => auth()->user()->orders()->sum('total'), 'total' => 500],
                            ];
                            @endphp

                            @foreach($sampleChallenges as $challenge)
                                <div class="p-6 bg-slate-700/30 rounded-xl">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-slate-100 mb-1">{{ $challenge['title'] }}</h3>
                                            <p class="text-sm text-slate-400">{{ $challenge['description'] }}</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-xs text-purple-400 bg-purple-500/20 px-3 py-1 rounded-full">
                                                +{{ $challenge['reward'] }} {{ __('pts') }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Progress Bar -->
                                    <div>
                                        <div class="flex items-center justify-between text-sm text-slate-400 mb-2">
                                            <span>{{ __('Progress') }}</span>
                                            <span>{{ min($challenge['progress'], $challenge['total']) }}/{{ $challenge['total'] }}</span>
                                        </div>
                                        <div class="w-full bg-slate-700 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-purple-500 to-purple-400 h-2 rounded-full transition-all duration-500" 
                                                 style="width: {{ min(($challenge['progress'] / $challenge['total']) * 100, 100) }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
