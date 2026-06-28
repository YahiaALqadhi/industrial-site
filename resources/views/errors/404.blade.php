@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">404</h1>
            <h2 class="mt-2 text-2xl font-semibold text-gray-700">Page Not Found</h2>
            <p class="mt-4 text-gray-600">The page you're looking for doesn't exist or has been moved.</p>
        </div>
        
        <div class="mt-8">
            <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Return to Homepage
            </a>
            <a href="{{ url('/products') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Browse Products
            </a>
        </div>
    </div>
</div>
@endsection
