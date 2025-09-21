@extends('layouts.app')

@section('title', 'Token Packages - Gravity CBC')

@section('additional_head')
<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
        }
        50% {
            box-shadow: 0 0 40px rgba(59, 130, 246, 0.7);
        }
    }
    .hero-pattern {
        background-image: 
            radial-gradient(circle at 25% 25%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 75% 75%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
    }
    .glass-effect {
        backdrop-filter: blur(16px) saturate(180%);
        background-color: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    .card-hover {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .card-hover:hover {
        transform: translateY(-12px) scale(1.02);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }
    .nav-link {
        position: relative;
        overflow: hidden;
    }
    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        transition: width 0.3s ease;
    }
    .nav-link:hover::after {
        width: 100%;
    }
    .mobile-menu {
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
    }
    .mobile-menu.active {
        transform: translateX(0);
    }
</style>
@endsection

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 text-center">
            <h1 class="text-4xl font-bold mb-4">School Pricing Plans</h1>
            <p class="text-xl text-gray-100">Affordable assessment solutions for primary and secondary schools</p>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 py-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Basic Plan -->
            <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-200 hover:shadow-xl transition-all">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Basic School</h3>
                    <p class="text-gray-600">Perfect for small primary schools</p>
                    <div class="mt-4">
                        <span class="text-4xl font-bold text-blue-600">KSH 5,000</span>
                        <span class="text-gray-500">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Up to 200 students</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Basic assessments</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Progress tracking</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Email support</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Monthly reports</li>
                </ul>
                <button class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all">
                    Choose Basic
                </button>
            </div>

            <!-- Premium Plan -->
            <div class="bg-white rounded-3xl shadow-xl p-8 border-2 border-blue-500 relative hover:shadow-2xl transition-all">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-bold">Most Popular</span>
                </div>
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Premium School</h3>
                    <p class="text-gray-600">Ideal for secondary schools</p>
                    <div class="mt-4">
                        <span class="text-4xl font-bold text-blue-600">KSH 15,000</span>
                        <span class="text-gray-500">/month</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Up to 1,000 students</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Advanced assessments</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Detailed analytics</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Priority support</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Custom branding</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Teacher training</li>
                </ul>
                <button class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all">
                    Choose Premium
                </button>
            </div>

            <!-- Enterprise Plan -->
            <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-200 hover:shadow-xl transition-all">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
                    <p class="text-gray-600">For large school districts</p>
                    <div class="mt-4">
                        <span class="text-4xl font-bold text-blue-600">Custom</span>
                        <span class="text-gray-500">pricing</span>
                    </div>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Unlimited students</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>All assessment types</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Advanced reporting</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>Dedicated support</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>API integration</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-3"></i>On-site training</li>
                </ul>
                <button class="w-full bg-gray-600 text-white py-3 rounded-xl font-semibold hover:bg-gray-700 transition-all">
                    Contact Sales
                </button>
            </div>
        </div>
    </div>
@endsection
