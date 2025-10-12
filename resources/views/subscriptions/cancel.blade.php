@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center">
        <div class="w-20 h-20 bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-white mb-4">Subscription Cancelled</h1>
        <p class="text-gray-400 mb-8">Your subscription process was cancelled. No charges have been made.</p>
        
        <div class="space-y-4">
            <a href="{{ route('pricing') }}" class="block w-full py-3 px-6 rounded-lg font-semibold bg-blue-600 hover:bg-blue-700 text-white transition">
                View Plans Again
            </a>
            <a href="{{ route('home') }}" class="block w-full py-3 px-6 rounded-lg font-semibold bg-gray-800 hover:bg-gray-700 text-white transition">
                Go to Homepage
            </a>
        </div>
    </div>
</div>
@endsection

