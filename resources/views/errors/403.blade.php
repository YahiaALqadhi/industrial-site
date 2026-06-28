<!-- @extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 text-center">
        <div>
            <h1 class="text-4xl font-bold text-gray-900">403</h1>
            <h2 class="mt-2 text-2xl font-semibold text-gray-700">Access Denied</h2>
            <p class="mt-4 text-gray-600">You don't have permission to access this resource.</p>
        </div>
        
        <div class="mt-8">
            <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Return to Homepage
            </a>
            @if(auth()->check())
                <a href="{{ url('/admin') }}" class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Admin Dashboard
                </a>
            @endif
        </div>
    </div>
</div>
@endsection -->
@extends('admin.layout')

@section('page_title', 'Access Denied')
@section('page_subtitle', 'You do not have permission to access this page')

@section('content')
    <div class="rounded-2xl border bg-white shadow-sm p-8" style="border-color: rgba(0,0,0,0.08)">
        <h1 class="text-3xl font-semibold" style="color:#004D80">403 — Forbidden</h1>
        <p class="mt-3 text-slate-700">You don't have permission to access this resource.</p>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ url('/') }}" class="btn btn-outline">Return to Homepage</a>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Admin Dashboard</a>
            @endauth
        </div>
    </div>
@endsection