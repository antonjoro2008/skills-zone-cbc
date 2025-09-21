@extends('layouts.app')

@section('title', 'Educational Blog - Gravity CBC')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 text-center">
            <h1 class="text-4xl font-bold mb-4">Educational Blog</h1>
            <p class="text-xl text-gray-100">Latest insights and tips for effective student assessment</p>
        </div>
    </div>
    
    <!-- Blog Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Featured Article -->
            <div class="md:col-span-2 lg:col-span-3 bg-white rounded-3xl shadow-lg overflow-hidden mb-8">
                <div class="md:flex">
                    <div class="md:w-1/2">
                        <div class="h-64 md:h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white text-6xl"></i>
                        </div>
                    </div>
                    <div class="md:w-1/2 p-8">
                        <div class="text-sm text-blue-600 font-semibold mb-2">FEATURED ARTICLE</div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Best Practices for Digital Assessment in Primary Schools</h2>
                        <p class="text-gray-600 mb-6">Discover how modern schools are transforming student evaluation through technology-enhanced assessments that engage young learners while providing valuable insights.</p>
                        <div class="flex items-center text-sm text-gray-500 mb-6">
                            <span>By Fred Aringol</span>
                            <span class="mx-2">•</span>
                            <span>March 15, 2025</span>
                            <span class="mx-2">•</span>
                            <span>5 min read</span>
                        </div>
                        <button class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all">
                            Read More
                        </button>
                    </div>
                </div>
            </div>

            <!-- Blog Articles -->
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-br from-green-500 to-blue-500 flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Using Data to Improve Student Outcomes</h3>
                    <p class="text-gray-600 mb-4">Learn how assessment analytics can help teachers identify learning gaps and personalize instruction.</p>
                    <div class="text-sm text-gray-500 mb-4">March 10, 2025 • 3 min read</div>
                    <button class="text-blue-600 font-semibold hover:text-blue-800 transition-colors">Read Article →</button>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                    <i class="fas fa-mobile-alt text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Mobile Assessment Solutions</h3>
                    <p class="text-gray-600 mb-4">Explore how tablets and smartphones are revolutionizing classroom assessments in developing regions.</p>
                    <div class="text-sm text-gray-500 mb-4">March 8, 2025 • 4 min read</div>
                    <button class="text-blue-600 font-semibold hover:text-blue-800 transition-colors">Read Article →</button>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center">
                    <i class="fas fa-users text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Engaging Parents in Assessment</h3>
                    <p class="text-gray-600 mb-4">Strategies for involving parents in the assessment process and sharing meaningful progress reports.</p>
                    <div class="text-sm text-gray-500 mb-4">March 5, 2025 • 6 min read</div>
                    <button class="text-blue-600 font-semibold hover:text-blue-800 transition-colors">Read Article →</button>
                </div>
            </div>
        </div>
    </div>
@endsection
