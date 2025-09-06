@extends('layouts.app')

@section('title', 'Refund Policy - SkillsZone')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Refund Policy</h1>
            <p class="text-xl text-gray-100">Our policy on refunds and cancellations</p>
        </div>
    </div>
    
    <!-- Refund Policy Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <div class="prose prose-lg max-w-none">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Token Purchase Policy</h2>
                <p class="text-gray-600 mb-6">Tokens purchased on SkillsZone are non-refundable once they have been used to access assessments. This policy ensures fair usage of our platform.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Unused Tokens</h2>
                <p class="text-gray-600 mb-6">If you have unused tokens and wish to request a refund, you may do so within 30 days of purchase, provided the tokens have not been used.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Technical Issues</h2>
                <p class="text-gray-600 mb-6">If you experience technical issues that prevent you from completing an assessment, we will provide a replacement token or full refund upon verification.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Refund Process</h2>
                <p class="text-gray-600 mb-6">To request a refund, contact our support team with your order details. Refunds will be processed within 5-7 business days.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Exceptions</h2>
                <p class="text-gray-600 mb-6">Refunds may be granted in exceptional circumstances at our discretion, such as duplicate charges or system errors.</p>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Us</h2>
                <p class="text-gray-600 mb-6">For refund requests or questions about this policy, please contact us at support@skills-zone.africa</p>
                
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
