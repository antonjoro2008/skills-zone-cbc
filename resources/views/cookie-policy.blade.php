@extends('layouts.app')

@section('title', 'Cookie Policy - Gravity CBC')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 text-center">
            <h1 class="text-4xl font-bold mb-4">Cookie Policy</h1>
            <p class="text-xl text-gray-100">How we use cookies to improve your experience</p>
        </div>
    </div>
    
    <!-- Cookie Policy Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <div class="prose prose-lg max-w-none">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">What Are Cookies?</h2>
                <p class="text-gray-600 mb-6">Cookies are small text files that are placed on your device when you visit our website. They help us provide you with a better experience.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">How We Use Cookies</h2>
                <p class="text-gray-600 mb-6">We use cookies to remember your preferences, analyze how our website is used, and provide personalized content and advertisements.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Types of Cookies We Use</h2>
                <ul class="list-disc list-inside text-gray-600 mb-6 space-y-2">
                    <li><strong>Essential Cookies:</strong> Required for basic website functionality</li>
                    <li><strong>Performance Cookies:</strong> Help us understand how visitors interact with our website</li>
                    <li><strong>Functional Cookies:</strong> Remember your preferences and settings</li>
                    <li><strong>Marketing Cookies:</strong> Used to deliver relevant advertisements</li>
                </ul>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Managing Cookies</h2>
                <p class="text-gray-600 mb-6">You can control and manage cookies through your browser settings. However, disabling certain cookies may affect the functionality of our website.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Third-Party Cookies</h2>
                <p class="text-gray-600 mb-6">Some cookies are placed by third-party services that appear on our pages. We do not control these cookies.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Updates to This Policy</h2>
                <p class="text-gray-600 mb-6">We may update this Cookie Policy from time to time. Any changes will be posted on this page.</p>
                
                <div class="mt-8 p-4 bg-blue-50 rounded-xl">
                    <p class="text-sm text-blue-800">
                        <strong>Last updated:</strong> March 15, 2025<br>
                        This policy is effective as of the date above.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
