@extends('layouts.app')

@section('title', 'Subscription Cancelled')

@section('content')
<div class="min-h-screen bg-gray-900 flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-gray-800 rounded-lg p-8 text-center">
        <div class="mb-6">
            <svg class="w-20 h-20 mx-auto text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-white mb-4">Subscription Cancelled</h1>
        <p class="text-gray-400 mb-8">
            You cancelled the checkout process. No charges were made.
        </p>
        
        <div class="space-y-3">
            <a href="{{ route('pricing.index') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors">
                View Plans Again
            </a>
            <a href="{{ route('home') }}" class="block w-full bg-gray-700 hover:bg-gray-600 text-white py-3 rounded-lg font-medium transition-colors">
                Go to Homepage
            </a>
        </div>
    </div>
</div>
@endsection

