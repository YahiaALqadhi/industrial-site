@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">500</h1>
            <h2 class="mt-2 text-2xl font-semibold text-gray-700">Server Error</h2>
            <p class="mt-4 text-gray-600">Something went wrong on our end. Our team has been notified.</p>
        </div>
        
        <div class="mt-8">
            <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Return to Homepage
            </a>
            <a href="{{ url('/contact') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Contact Support
            </a>
        </div>
        
        @if(config('app.debug'))
            <div class="mt-8 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-sm text-red-800">{{ $exception->getMessage() }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
