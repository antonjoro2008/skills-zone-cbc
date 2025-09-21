@extends('layouts.app')

@section('title', 'Contact Us - Gravity CBC')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 text-center">
            <h1 class="text-4xl font-bold mb-4">Contact Us</h1>
            <p class="text-xl text-gray-100">Get in touch with our support team</p>
        </div>
    </div>
    
    <!-- Contact Content -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div class="bg-white rounded-3xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a message</h2>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option>General Inquiry</option>
                            <option>Technical Support</option>
                            <option>Billing Question</option>
                            <option>Feature Request</option>
                            <option>Partnership</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all">
                        Send Message
                    </button>
                </form>
            </div>
            
            <!-- Contact Information -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Get in touch</h2>
                    <p class="text-gray-600 mb-6">We're here to help! Reach out to us through any of these channels and we'll get back to you as soon as possible.</p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-envelope text-blue-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Email Support</h3>
                            <p class="text-gray-600">support@assessments.gravitycbc.co.ke</p>
                            <p class="text-sm text-gray-500">Response within 24 hours</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-phone text-green-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Phone Support</h3>
                            <p class="text-gray-600">+254 700 123 456</p>
                            <p class="text-sm text-gray-500">Mon-Fri, 8AM-6PM EAT</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                            <i class="fas fa-comments text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Live Chat</h3>
                            <p class="text-gray-600">Available on our website</p>
                            <p class="text-sm text-gray-500">Instant responses</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-6">
                    <h3 class="font-semibold text-gray-900 mb-3">Office Address</h3>
                    <p class="text-gray-600">
                        Gravity CBC Africa<br>
                        Westlands, Nairobi<br>
                        Kenya
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection 