@extends('layouts.app')

@section('title', 'Help Center - Gravity CBC')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 text-center">
            <h1 class="text-4xl font-bold mb-4">Help Center</h1>
            <p class="text-xl text-gray-100">Get help and support for all your Gravity CBC needs</p>
        </div>
    </div>
    
    <!-- Help Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Getting Started -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-rocket text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Getting Started</h3>
                <p class="text-gray-600 mb-4">Learn the basics of using Gravity CBC for assessments and skill development.</p>
                <a href="#" class="text-blue-600 font-semibold hover:text-blue-800 transition-colors">View Guide →</a>
            </div>
            
            <!-- Assessment Guide -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-clipboard-check text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Assessment Guide</h3>
                <p class="text-gray-600 mb-4">Step-by-step instructions for taking and completing assessments.</p>
                <a href="#" class="text-green-600 font-semibold hover:text-green-800 transition-colors">View Guide →</a>
            </div>
            
            <!-- Payment Help -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-credit-card text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Payment & Tokens</h3>
                <p class="text-gray-600 mb-4">Learn about our token system and payment methods including M-PESA.</p>
                <a href="#" class="text-purple-600 font-semibold hover:text-purple-800 transition-colors">View Guide →</a>
            </div>
            
            <!-- Technical Support -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-tools text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Technical Support</h3>
                <p class="text-gray-600 mb-4">Troubleshoot common technical issues and platform problems.</p>
                <a href="#" class="text-orange-600 font-semibold hover:text-orange-800 transition-colors">View Guide →</a>
            </div>
            
            <!-- Account Management -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-user-cog text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Account Management</h3>
                <p class="text-gray-600 mb-4">Manage your profile, settings, and account preferences.</p>
                <a href="#" class="text-red-600 font-semibold hover:text-red-800 transition-colors">View Guide →</a>
            </div>
            
            <!-- Mobile App -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fas fa-mobile-alt text-teal-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Mobile App</h3>
                <p class="text-gray-600 mb-4">Get the most out of Gravity CBC on your mobile device.</p>
                <a href="#" class="text-teal-600 font-semibold hover:text-teal-800 transition-colors">View Guide →</a>
            </div>
        </div>
        
        <!-- Contact Support -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-3xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Still Need Help?</h2>
                <p class="text-gray-600 mb-6">Our support team is here to help you succeed with Gravity CBC</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('contact') }}" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all">
                        <i class="fas fa-envelope mr-2"></i>
                        Contact Support
                    </a>
                    <a href="{{ route('faq') }}" class="inline-flex items-center bg-white text-blue-600 border-2 border-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all">
                        <i class="fas fa-question-circle mr-2"></i>
                        View FAQ
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
