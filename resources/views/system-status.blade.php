@extends('layouts.app')

@section('title', 'System Status - Gravity CBC')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">System Status</h1>
            <p class="text-xl text-gray-100">Real-time status of our services and systems</p>
        </div>
    </div>
    
    <!-- System Status Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Overall Status -->
        <div class="bg-white rounded-3xl shadow-lg p-8 mb-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-green-600 text-4xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">All Systems Operational</h2>
                <p class="text-green-600 font-semibold">Last updated: Just now</p>
            </div>
        </div>
        
        <!-- Service Status -->
        <div class="bg-white rounded-3xl shadow-lg p-8 mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Service Status</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="font-medium text-gray-900">Website</span>
                    </div>
                    <span class="text-green-600 font-semibold">Operational</span>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="font-medium text-gray-900">Assessment Engine</span>
                    </div>
                    <span class="text-green-600 font-semibold">Operational</span>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="font-medium text-gray-900">Payment System</span>
                    </div>
                    <span class="text-green-600 font-semibold">Operational</span>
                </div>
                
                <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                        <span class="font-medium text-gray-900">User Authentication</span>
                    </div>
                    <span class="text-green-600 font-semibold">Operational</span>
                </div>
            </div>
        </div>
        
        <!-- Recent Incidents -->
        <div class="bg-white rounded-3xl shadow-lg p-8 mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Recent Incidents</h3>
            <div class="space-y-4">
                <div class="p-4 bg-blue-50 rounded-xl">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-medium text-gray-900">Scheduled Maintenance</span>
                        <span class="text-sm text-gray-500">March 10, 2025</span>
                    </div>
                    <p class="text-gray-600 text-sm">Completed successfully. No issues reported.</p>
                </div>
                
                <div class="p-4 bg-green-50 rounded-xl">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-medium text-gray-900">Performance Update</span>
                        <span class="text-sm text-gray-500">March 5, 2025</span>
                    </div>
                    <p class="text-gray-600 text-sm">System performance improvements deployed successfully.</p>
                </div>
            </div>
        </div>
        
        <!-- Subscribe to Updates -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-3xl p-8 text-center">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Stay Updated</h3>
            <p class="text-gray-600 mb-6">Get notified about system status updates and maintenance schedules</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-md mx-auto">
                <input type="email" placeholder="Enter your email" class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all">
                    Subscribe
                </button>
            </div>
        </div>
    </div>
@endsection 