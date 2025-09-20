@extends('layouts.app')

@section('title', 'FAQ - Gravity CBC')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Frequently Asked Questions</h1>
            <p class="text-xl text-gray-100">Find answers to common questions about Gravity CBC</p>
        </div>
    </div>
    
    <!-- FAQ Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="space-y-6">
            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <button class="w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                    <h3 class="text-lg font-semibold text-gray-900">How does the token system work?</h3>
                    <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                </button>
                <div class="faq-content hidden mt-4 text-gray-600">
                    <p>Our token system allows you to pay only for the assessments you take. Purchase tokens in packages and use them to access any assessment. No monthly fees or subscriptions required.</p>
                </div>
            </div>
            
            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <button class="w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                    <h3 class="text-lg font-semibold text-gray-900">What payment methods do you accept?</h3>
                    <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                </button>
                <div class="faq-content hidden mt-4 text-gray-600">
                    <p>We currently accept M-PESA payments for Kenyan users. We're working on adding more payment options for other African countries.</p>
                </div>
            </div>
            
            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <button class="w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                    <h3 class="text-lg font-semibold text-gray-900">Can I retake assessments?</h3>
                    <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                </button>
                <div class="faq-content hidden mt-4 text-gray-600">
                    <p>Yes, you can retake assessments to improve your score. Each retake requires a new token, but you'll get different questions to ensure fair evaluation.</p>
                </div>
            </div>
            
            <!-- FAQ Item 4 -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <button class="w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                    <h3 class="text-lg font-semibold text-gray-900">How long do I have to complete an assessment?</h3>
                    <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                </button>
                <div class="faq-content hidden mt-4 text-gray-600">
                    <p>Assessment duration varies by topic. Most assessments take 30-60 minutes to complete. You can pause and resume within 24 hours of starting.</p>
                </div>
            </div>
            
            <!-- FAQ Item 5 -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <button class="w-full text-left flex justify-between items-center" onclick="toggleFAQ(this)">
                    <h3 class="text-lg font-semibold text-gray-900">Do you offer certificates?</h3>
                    <i class="fas fa-chevron-down text-blue-600 transition-transform"></i>
                </button>
                <div class="faq-content hidden mt-4 text-gray-600">
                    <p>Yes! Upon successful completion of an assessment, you'll receive a digital certificate that you can download and share on your professional profiles.</p>
                </div>
            </div>
        </div>
        
        <!-- Contact Support -->
        <div class="mt-12 text-center">
            <p class="text-gray-600 mb-4">Still have questions?</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all">
                <i class="fas fa-envelope mr-2"></i>
                Contact Support
            </a>
        </div>
    </div>
@endsection
