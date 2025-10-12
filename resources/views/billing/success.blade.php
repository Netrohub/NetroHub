@extends('layouts.app')

@section('title', 'Subscription Successful')

@section('content')
<div class="min-h-screen bg-gray-900 flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-gray-800 rounded-lg p-8 text-center">
        <div class="mb-6">
            <svg class="w-20 h-20 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h1 class="text-3xl font-bold text-white mb-4">Subscription Successful!</h1>
        <p class="text-gray-400 mb-8">
            Welcome to your new plan! Your benefits are now active.
        </p>
        
        <div class="space-y-3">
            <a href="{{ route('billing.index') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-medium transition-colors">
                View Billing Dashboard
            </a>
            <a href="{{ route('home') }}" class="block w-full bg-gray-700 hover:bg-gray-600 text-white py-3 rounded-lg font-medium transition-colors">
                Go to Homepage
            </a>
        </div>
    </div>
</div>
@endsection

