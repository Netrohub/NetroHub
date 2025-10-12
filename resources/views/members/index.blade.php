@extends('layouts.app')

@section('content')
<div class="min-h-screen relative overflow-hidden bg-dark-900 py-12">
    <!-- Gaming Background Effects -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-secondary-500/10 rounded-full blur-3xl animate-float animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-neon-blue/5 rounded-full blur-3xl animate-pulse-slow"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12 animate-fade-in">
            <div class="relative inline-flex items-center justify-center w-20 h-20 bg-gaming-gradient rounded-3xl mb-8 shadow-gaming-xl group">
                <div class="absolute inset-0 bg-gaming-gradient rounded-3xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
                <svg class="relative w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h1 class="text-5xl md:text-6xl font-black text-white mb-6 bg-gaming-gradient bg-clip-text text-transparent leading-tight">
                Platform Members
            </h1>
            <p class="text-xl text-muted-300 max-w-2xl mx-auto">
                Discover and connect with our thriving gaming community
            </p>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 animate-fade-in animation-delay-200">
            <div class="card-interactive p-6">
                <div class="flex items-center gap-4">
                    <div class="relative p-4 bg-primary-500/10 rounded-2xl">
                        <div class="absolute inset-0 bg-primary-500/20 rounded-2xl blur-lg"></div>
                        <svg class="relative w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-gradient">{{ $totalMembers }}</p>
                        <p class="text-sm text-muted-400 font-medium">Total Members</p>
                    </div>
                </div>
            </div>
            
            <div class="card-interactive p-6">
                <div class="flex items-center gap-4">
                    <div class="relative p-4 bg-neon-green/10 rounded-2xl">
                        <div class="absolute inset-0 bg-neon-green/20 rounded-2xl blur-lg"></div>
                        <svg class="relative w-8 h-8 text-neon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-gradient-success">{{ $totalSellers }}</p>
                        <p class="text-sm text-muted-400 font-medium">Active Sellers</p>
                    </div>
                </div>
            </div>
            
            <div class="card-interactive p-6">
                <div class="flex items-center gap-4">
                    <div class="relative p-4 bg-secondary-500/10 rounded-2xl">
                        <div class="absolute inset-0 bg-secondary-500/20 rounded-2xl blur-lg"></div>
                        <svg class="relative w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-gradient-purple">{{ $totalBuyers }}</p>
                        <p class="text-sm text-muted-400 font-medium">Active Buyers</p>
                    </div>
                </div>
            </div>
            
            <div class="card-interactive p-6">
                <div class="flex items-center gap-4">
                    <div class="relative p-4 bg-neon-blue/10 rounded-2xl">
                        <div class="absolute inset-0 bg-neon-blue/20 rounded-2xl blur-lg"></div>
                        <svg class="relative w-8 h-8 text-neon-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-white">{{ $totalVerified }}</p>
                        <p class="text-sm text-muted-400 font-medium">Verified</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="card-glass p-6 md:p-8 mb-12 animate-fade-in animation-delay-300">
            <form method="GET" action="{{ route('members.index') }}" class="space-y-6">
                <!-- Filter Buttons -->
                <div>
                    <label class="label mb-3">
                        <svg class="w-4 h-4 inline mr-2 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Filter Members
                    </label>
                    <div class="flex flex-wrap gap-2">
                        <button type="submit" name="filter" value="all" 
                                class="px-5 py-2.5 rounded-xl font-semibold transition-all duration-300 {{ $filter === 'all' ? 'bg-gaming-gradient text-white shadow-gaming scale-105' : 'bg-dark-800/70 text-muted-300 hover:bg-dark-700/70 hover:text-white hover:scale-105 border border-gaming' }}">
                            All Members
                        </button>
                        <button type="submit" name="filter" value="sellers" 
                                class="px-5 py-2.5 rounded-xl font-semibold transition-all duration-300 {{ $filter === 'sellers' ? 'bg-gaming-gradient text-white shadow-gaming scale-105' : 'bg-dark-800/70 text-muted-300 hover:bg-dark-700/70 hover:text-white hover:scale-105 border border-gaming' }}">
                            Sellers Only
                        </button>
                        <button type="submit" name="filter" value="buyers" 
                                class="px-5 py-2.5 rounded-xl font-semibold transition-all duration-300 {{ $filter === 'buyers' ? 'bg-gaming-gradient text-white shadow-gaming scale-105' : 'bg-dark-800/70 text-muted-300 hover:bg-dark-700/70 hover:text-white hover:scale-105 border border-gaming' }}">
                            Buyers Only
                        </button>
                        <button type="submit" name="filter" value="verified" 
                                class="px-5 py-2.5 rounded-xl font-semibold transition-all duration-300 {{ $filter === 'verified' ? 'bg-gaming-gradient text-white shadow-gaming scale-105' : 'bg-dark-800/70 text-muted-300 hover:bg-dark-700/70 hover:text-white hover:scale-105 border border-gaming' }}">
                            Verified
                        </button>
                    </div>
                </div>
                
                <!-- Search and Sort -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="label">
                            <svg class="w-4 h-4 inline mr-2 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Search Members
                        </label>
                        <div class="input-group">
                            <svg class="input-group-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" name="search" value="{{ $search }}" 
                                   placeholder="Search by name, username, or email..." 
                                   class="input input-with-icon"/>
                        </div>
                    </div>
                    <div>
                        <label class="label">
                            <svg class="w-4 h-4 inline mr-2 text-neon-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4"/>
                            </svg>
                            Sort By
                        </label>
                        <select name="sort" class="select">
                            <option value="recent" {{ $sort === 'recent' ? 'selected' : '' }}>Recently Joined</option>
                            <option value="sales" {{ $sort === 'sales' ? 'selected' : '' }}>Most Sales</option>
                            <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Alphabetical</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn-primary w-full md:w-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Apply Filters
                </button>
            </form>
            
            <!-- Results Count -->
            <div class="mt-6 pt-6 border-t border-gaming flex items-center gap-3">
                <div class="w-1 h-8 bg-gaming-gradient rounded-full"></div>
                <p class="text-sm text-muted-400">
                    Showing <span class="text-white font-bold">{{ $members->firstItem() ?? 0 }} - {{ $members->lastItem() ?? 0 }}</span> 
                    of <span class="text-gradient font-bold">{{ $members->total() }}</span> members
                    @if(!empty($search))
                        <span class="text-primary-400"> (filtered by "{{ $search }}")</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Members Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($members as $member)
                <div class="card-interactive text-center group scroll-fade-in">
                    <!-- Avatar with verification badges -->
                    <div class="relative inline-block mb-4">
                        <div class="w-24 h-24 mx-auto rounded-2xl overflow-hidden bg-gaming-gradient shadow-lg group-hover:shadow-gaming transition-all">
                            <img src="{{ $member->avatar_url }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                        </div>
                        
                        <!-- Verification badges -->
                        @if($member->seller && $member->seller->total_sales > 0)
                            <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-neon-green rounded-full border-4 border-dark-800 flex items-center justify-center shadow-lg" title="Verified Seller">
                                <svg class="w-5 h-5 text-dark-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @elseif($member->email_verified_at)
                            <div class="absolute -bottom-1 -right-1 w-8 h-8 bg-neon-blue rounded-full border-4 border-dark-800 flex items-center justify-center shadow-lg" title="Email Verified">
                                <svg class="w-5 h-5 text-dark-900" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Name and handle -->
                    <h3 class="text-lg font-bold text-white group-hover:text-primary-400 transition-colors mb-1">
                        {{ $member->seller->display_name ?? $member->name }}
                    </h3>
                    <p class="text-sm text-muted-400 mb-3">{{ Str::slug($member->seller->display_name ?? $member->name) }}</p>
                    
                    <!-- Bio/tagline -->
                    @if($member->seller && $member->seller->bio)
                        <p class="text-sm text-muted-300 mb-4 line-clamp-2 px-2 min-h-[40px]">{{ $member->seller->bio }}</p>
                    @else
                        <p class="text-sm text-muted-400 mb-4 italic min-h-[40px]">
                            @if($member->seller)
                                No bio yet
                            @else
                                Platform Member
                            @endif
                        </p>
                    @endif
                    
                    <!-- Stats row -->
                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <div class="bg-dark-900/50 rounded-xl p-3 border border-gaming/30">
                            <p class="text-lg font-bold text-white">{{ $member->seller->total_sales ?? 0 }}</p>
                            <p class="text-xs text-muted-400">Sales</p>
                        </div>
                        <div class="bg-dark-900/50 rounded-xl p-3 border border-gaming/30">
                            <p class="text-lg font-bold text-white">{{ $member->seller ? $member->seller->products_count : 0 }}</p>
                            <p class="text-xs text-muted-400">Listings</p>
                        </div>
                        <div class="bg-dark-900/50 rounded-xl p-3 border border-gaming/30">
                            <p class="text-lg font-bold text-white">{{ $member->created_at->format('Y') }}</p>
                            <p class="text-xs text-muted-400">Joined</p>
                        </div>
                    </div>
                    
                    <!-- Seller badge -->
                    @if($member->seller)
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-neon-green/20 text-neon-green border border-neon-green/30">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                                Seller
                            </span>
                        </div>
                    @endif
                    
                    <!-- View Profile button -->
                    <a href="{{ route('members.show', $member) }}" class="btn-primary w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        View Profile
                    </a>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="card-glass text-center py-20">
                        <svg class="w-24 h-24 mx-auto text-muted-400 mb-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <h3 class="text-3xl font-bold text-white mb-4">No Members Found</h3>
                        <p class="text-muted-400 mb-8 max-w-md mx-auto">
                            @if(!empty($search))
                                No members match your search criteria. Try adjusting your filters or search terms.
                            @else
                                No members available at the moment. Check back later!
                            @endif
                        </p>
                        @if(!empty($search) || $filter !== 'all')
                            <a href="{{ route('members.index') }}" class="btn-primary btn-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($members->hasPages())
            <div class="mt-12">
                {{ $members->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
