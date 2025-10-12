@extends('layouts.app')

@section('title', 'Account Blocked')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 text-center">
        <div class="text-6xl mb-4">🚫</div>
        <h1 class="text-3xl font-bold mb-4">Seller Account Blocked</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Your seller account has been temporarily blocked by our administrators.
        </p>
        <p class="text-gray-600 dark:text-gray-400 mb-8">
            If you believe this is an error, please contact our support team.
        </p>
        <a href="{{ route('home') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold">
            Return to Home
        </a>
    </div>
</div>
@endsection
