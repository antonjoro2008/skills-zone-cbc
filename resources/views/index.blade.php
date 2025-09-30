@extends('layouts.app')

@section('title', 'Gravity CBC - Skills Assessment for Competency Based Curriculum')

@section('content')
    <!-- Landing Page -->
    <section id="landing" class="page-section">
        <!-- Hero Section -->
        <div class="gradient-bg text-white overflow-hidden relative">
            <!-- Floating elements -->
            <div class="absolute top-20 left-10 w-20 h-20 bg-white bg-opacity-10 rounded-full animate-float"></div>
            <div class="absolute top-40 right-20 w-16 h-16 bg-white bg-opacity-10 rounded-full animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-white bg-opacity-10 rounded-full animate-float" style="animation-delay: 2s;"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 py-12 relative z-10">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="text-center lg:text-left animate-fade-in-left">
                        <div class="inline-flex items-center bg-yellow-400 bg-opacity-90 text-gray-900 rounded-full px-4 py-2 mb-6 shadow-lg">
                            <i class="fas fa-star text-yellow-600 mr-2"></i>
                            <span class="text-sm font-bold">Trusted by 50,000+ learners across the country</span>
                        </div>
                        <h1 class="text-4xl md:text-6xl lg:text-5xl font-bold mb-6 leading-tight text-white">
                            Unlocking CBC
                            <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">
                                Learners Potential
                            </span>
                            <br>with Gravity CBC 
                        </h1>
                        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto lg:mx-0 text-gray-100 leading-relaxed">
                            Affordable, token-based assessments for CBC Based learners. Build skills, track progress, and excel in your academic journey.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                            <a href="{{ route('subjects') }}" class="group bg-white text-blue-600 hover:bg-gray-50 px-8 py-4 rounded-full text-lg font-semibold transition-all shadow-xl hover:shadow-2xl transform hover:scale-105 hover:-translate-y-1 inline-block">
                                <i class="fas fa-rocket mr-2 group-hover:animate-bounce"></i>
                                Explore Assessments
                            </a>
                            <button id="joinFreeBtn" class="group border-2 border-yellow-400 text-yellow-400 hover:bg-yellow-400 hover:text-gray-900 px-8 py-4 rounded-full text-lg font-semibold transition-all hover:scale-105 hover:-translate-y-1 shadow-lg" onclick="showModal('registerModal')">
                                <i class="fas fa-user-plus mr-2 group-hover:rotate-12 transition-transform"></i>
                                Join Free
                            </button>
                            <button id="buyTokensBtn" class="group border-2 border-[#8FC340] text-[#8FC340] hover:bg-[#8FC340] hover:text-white px-8 py-4 rounded-full text-lg font-semibold transition-all hover:scale-105 hover:-translate-y-1 shadow-lg hidden" onclick="showModal('buyTokensModal')">
                                <i class="fas fa-coins mr-2 group-hover:animate-pulse"></i>
                                Buy Tokens
                            </button>
                        </div>
                    </div>
                    
                    <div class="hidden lg:block animate-fade-in-right">
                        <div class="relative">
                            <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-3xl p-8 transform rotate-6 hover:rotate-3 transition-transform duration-500">
                                <div class="bg-gradient-to-br from-[#8FC340] to-[#E368A7] rounded-2xl p-6 mb-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <h3 class="text-white font-bold text-lg">Assessment Progress</h3>
                                        <span class="bg-white text-[#8FC340] px-3 py-1 rounded-full text-sm font-bold">85%</span>
                                    </div>
                                    <div class="bg-white bg-opacity-20 rounded-full h-3 mb-4">
                                        <div class="bg-white rounded-full h-3 w-4/5 animate-pulse"></div>
                                    </div>
                                    <p class="text-gray-200 text-sm">KJSEA Mathematics</p>
                                </div>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between bg-white bg-opacity-20 rounded-lg p-3">
                                        <span class="text-white text-sm">✅ Algebra & Equations</span>
                                        <i class="fas fa-check text-green-300"></i>
                                    </div>
                                    <div class="flex items-center justify-between bg-white bg-opacity-20 rounded-lg p-3">
                                        <span class="text-white text-sm">📝 Integrated Science</span>
                                        <i class="fas fa-clock text-yellow-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-24 bg-gradient-to-br from-gray-50 to-white relative overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-blue-50 to-transparent opacity-50"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 relative z-10">
                <div class="text-center mb-20">
                    <div class="inline-flex items-center bg-blue-100 rounded-full px-4 py-2 mb-4">
                        <i class="fas fa-magic text-blue-600 mr-2"></i>
                        <span class="text-blue-600 font-medium text-sm">Why Choose Gravity CBC Assessments?</span>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Features that make us
                        <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">extraordinary</span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">Discover the affordable, accessible features that make us the leading assessment platform for Competency Based Curriculum Based Curriculum learners practicing with us</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="group bg-white rounded-3xl p-8 shadow-lg card-hover border border-gray-100 hover:border-blue-200">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-brain"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900 group-hover:text-blue-600 transition-colors">Token-Based Access</h3>
                        <p class="text-gray-600 leading-relaxed">Pay only for what you use with our flexible token system. No monthly fees, just affordable per-assessment pricing.</p>
                        <div class="mt-6 text-blue-600 font-medium text-sm opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('pricing') }}">Learn more →</a>
                        </div>
                    </div>
                    
                    <div class="group bg-white rounded-3xl p-8 shadow-lg card-hover border border-gray-100 hover:border-green-200">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900 group-hover:text-green-600 transition-colors">Affordable Learning</h3>
                        <p class="text-gray-600 leading-relaxed">Designed for CBC Based learners with competitive pricing and flexible payment options.</p>
                        <div class="mt-6 text-green-600 font-medium text-sm opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('subjects') }}">View certificates →</a>
                        </div>
                    </div>
                    
                    <div class="group bg-white rounded-3xl p-8 shadow-lg card-hover border border-gray-100 hover:border-purple-200">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900 group-hover:text-purple-600 transition-colors">Progress Tracking</h3>
                        <p class="text-gray-600 leading-relaxed">Detailed analytics and progress reports help you identify strengths and areas for improvement.</p>
                        <div class="mt-6 text-purple-600 font-medium text-sm opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('dashboard') }}">See analytics →</a>
                        </div>
                    </div>
                    
                    <div class="group bg-white rounded-3xl p-8 shadow-lg card-hover border border-gray-100 hover:border-orange-200">
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900 group-hover:text-orange-600 transition-colors">Mobile Friendly</h3>
                        <p class="text-gray-600 leading-relaxed">Take assessments anywhere, anytime on any device with our responsive platform.</p>
                        <div class="mt-6 text-orange-600 font-medium text-sm opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('subjects') }}">Try mobile →</a>
                        </div>
                    </div>
                    
                    <div class="group bg-white rounded-3xl p-8 shadow-lg card-hover border border-gray-100 hover:border-red-200">
                        <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900 group-hover:text-red-600 transition-colors">Secure & Reliable</h3>
                        <p class="text-gray-600 leading-relaxed">Bank-level security ensures your data and assessment results are always protected.</p>
                        <div class="mt-6 text-red-600 font-medium text-sm opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('privacy') }}">Security details →</a>
                        </div>
                    </div>
                    
                    <div class="group bg-white rounded-3xl p-8 shadow-lg card-hover border border-gray-100 hover:border-teal-200">
                        <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl flex items-center justify-center text-white text-2xl mb-6 group-hover:scale-110 transition-transform">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-gray-900 group-hover:text-teal-600 transition-colors">Expert Support</h3>
                        <p class="text-gray-600 leading-relaxed">Get help from our team of assessment experts and career counselors.</p>
                        <div class="mt-6 text-teal-600 font-medium text-sm opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('help') }}">Contact support →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Guide Video Section -->
        <div class="py-24 bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 relative overflow-hidden">
            <!-- Background decoration -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-purple-600/10"></div>
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-20 left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-xl"></div>
                <div class="absolute bottom-20 right-10 w-24 h-24 bg-purple-500/20 rounded-full blur-xl"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 relative z-10">
                <div class="text-center mb-16">
                    <div class="inline-flex items-center bg-blue-500/20 backdrop-blur-sm rounded-full px-6 py-3 mb-6 border border-blue-400/30">
                        <i class="fas fa-play-circle text-blue-400 mr-3 text-xl"></i>
                        <span class="text-blue-300 font-medium">Quick Start Guide</span>
                    </div>
                    <h2 class="text-4xl md:text-4xl font-bold text-white mb-6">
                        How to Navigate
                        <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Gravity CBC Assessments Portal</span>
                    </h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto leading-relaxed">
                        Watch this quick guide to learn how to get started with assessments, purchase tokens, and track your progress.
                    </p>
                </div>
                
                <!-- Video Container -->
                <div class="max-w-4xl mx-auto">
                    <div class="relative bg-black rounded-3xl overflow-hidden shadow-2xl border border-gray-700">
                        <!-- Video Loading Placeholder -->
                        <div id="videoPlaceholder" class="aspect-video bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-blue-500/20 rounded-full flex items-center justify-center mb-4 mx-auto animate-pulse">
                                    <i class="fas fa-play text-blue-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-400 text-lg">Loading navigation guide...</p>
                            </div>
                        </div>
                        
                        <!-- Video Element -->
                        <video 
                            id="navigationVideo"
                            class="w-full h-full object-cover hidden"
                            preload="metadata"
                            poster="/images/video-poster.jpg"
                            controls
                            playsinline
                            webkit-playsinline>
                            <source src="/videos/navigation-guide.mp4" type="video/mp4">
                            <p class="text-white p-8 text-center">
                                Your browser doesn't support HTML5 video. 
                                <a href="/videos/navigation-guide.mp4" class="text-blue-400 underline">Download the video</a> instead.
                            </p>
                        </video>
                        
                        <!-- Custom Play Button -->
                        <div id="playButton" class="absolute inset-0 flex items-center justify-center bg-black/30 backdrop-blur-sm cursor-pointer group transition-all duration-300 hover:bg-black/20">
                            <div class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300 shadow-2xl">
                                <i class="fas fa-play text-white text-3xl ml-1"></i>
                            </div>
                        </div>
                        
                        <!-- Video Controls Overlay -->
                        <div id="videoControls" class="absolute bottom-4 left-4 right-4 hidden">
                            <div class="flex items-center justify-between bg-black/50 backdrop-blur-sm rounded-lg px-4 py-2">
                                <div class="flex items-center space-x-4">
                                    <button id="playPauseBtn" class="text-white hover:text-blue-400 transition-colors">
                                        <i class="fas fa-play text-xl"></i>
                                    </button>
                                    <div class="flex items-center space-x-2">
                                        <span id="currentTime" class="text-white text-sm">0:00</span>
                                        <span class="text-gray-400">/</span>
                                        <span id="duration" class="text-gray-400 text-sm">0:00</span>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button id="muteBtn" class="text-white hover:text-blue-400 transition-colors">
                                        <i class="fas fa-volume-up text-lg"></i>
                                    </button>
                                    <button id="fullscreenBtn" class="text-white hover:text-blue-400 transition-colors">
                                        <i class="fas fa-expand text-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Video Description -->
                    <div class="mt-8 text-center">
                        <p class="text-gray-300 text-lg leading-relaxed max-w-2xl mx-auto">
                            This guide covers everything you need to know: creating an account, purchasing tokens, 
                            taking assessments, and understanding your results. Perfect for new users!
                        </p>
                        <div class="mt-6 flex flex-wrap justify-center gap-4">
                            <div class="flex items-center text-blue-300">
                                <i class="fas fa-clock mr-2"></i>
                                <span>3-5 minutes</span>
                            </div>
                            <div class="flex items-center text-blue-300">
                                <i class="fas fa-mobile-alt mr-2"></i>
                                <span>Mobile & Desktop</span>
                            </div>
                            <div class="flex items-center text-blue-300">
                                <i class="fas fa-closed-captioning mr-2"></i>
                                <span>Subtitles Available</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="bg-gradient-to-r from-gray-900 via-blue-900 to-gray-900 py-20 relative overflow-hidden">
            <!-- Background pattern -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-purple-600/10"></div>
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-purple-500/5 rounded-full blur-3xl"></div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 relative z-10">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Trusted by education actors in the country</h2>
                    <p class="text-blue-200 text-lg">Join thousands of learners across the country who practice with Gravity CBC Assessments</p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="stat-counter rounded-2xl p-6 text-center group hover:scale-105 transition-all duration-300">
                        <div class="text-4xl md:text-5xl font-bold text-transparent bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text mb-2 group-hover:scale-110 transition-transform">
                            50K+
                        </div>
                        <p class="text-gray-300 font-medium">Learners Assessed</p>
                        <div class="w-12 h-1 bg-gradient-to-r from-yellow-400 to-orange-400 mx-auto mt-3 rounded-full"></div>
                    </div>
                    <div class="stat-counter rounded-2xl p-6 text-center group hover:scale-105 transition-all duration-300">
                        <div class="text-4xl md:text-5xl font-bold text-transparent bg-gradient-to-r from-green-400 to-blue-400 bg-clip-text mb-2 group-hover:scale-110 transition-transform">
                            200+
                        </div>
                        <p class="text-gray-300 font-medium">Assessment Categories</p>
                        <div class="w-12 h-1 bg-gradient-to-r from-green-400 to-blue-400 mx-auto mt-3 rounded-full"></div>
                    </div>
                    <div class="stat-counter rounded-2xl p-6 text-center group hover:scale-105 transition-all duration-300">
                        <div class="text-4xl md:text-5xl font-bold text-transparent bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text mb-2 group-hover:scale-110 transition-transform">
                            95%
                        </div>
                        <p class="text-gray-300 font-medium">Reported Improvement</p>
                        <div class="w-12 h-1 bg-gradient-to-r from-purple-400 to-pink-400 mx-auto mt-3 rounded-full"></div>
                    </div>
                    <div class="stat-counter rounded-2xl p-6 text-center group hover:scale-105 transition-all duration-300">
                        <div class="text-4xl md:text-5xl font-bold text-transparent bg-gradient-to-r from-red-400 to-yellow-400 bg-clip-text mb-2 group-hover:scale-110 transition-transform">
                            24/7
                        </div>
                        <p class="text-gray-300 font-medium">Support Available</p>
                        <div class="w-12 h-1 bg-gradient-to-r from-red-400 to-yellow-400 mx-auto mt-3 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if user is logged in
        const user = localStorage.getItem('user');
        const token = localStorage.getItem('token');
        const buyTokensBtn = document.getElementById('buyTokensBtn');
        const joinFreeBtn = document.getElementById('joinFreeBtn');
        
        if (user && token) {
            // User is logged in
            if (buyTokensBtn) {
                // Show the Buy Tokens button
                buyTokensBtn.classList.remove('hidden');
            }
            if (joinFreeBtn) {
                // Hide the Join Free button
                joinFreeBtn.style.display = 'none';
            }
        }
    });

    // Video Navigation Guide Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const video = document.getElementById('navigationVideo');
        const placeholder = document.getElementById('videoPlaceholder');
        const playButton = document.getElementById('playButton');
        const videoControls = document.getElementById('videoControls');
        const playPauseBtn = document.getElementById('playPauseBtn');
        const muteBtn = document.getElementById('muteBtn');
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const currentTimeEl = document.getElementById('currentTime');
        const durationEl = document.getElementById('duration');

        // Exit early if video element doesn't exist
        if (!video) {
            console.warn('Navigation video element not found');
            return;
        }

        // Progressive loading - load video metadata first
        video.addEventListener('loadedmetadata', function() {
            if (placeholder) {
                placeholder.style.display = 'none';
            }
            video.classList.remove('hidden');
            if (videoControls) {
                videoControls.classList.remove('hidden');
            }
            
            // Format and display duration
            if (durationEl) {
                const duration = formatTime(video.duration);
                durationEl.textContent = duration;
            }
        });

        // Handle play button click
        if (playButton) {
            playButton.addEventListener('click', function() {
                video.play();
                playButton.style.display = 'none';
            });
        }

        // Handle play/pause button
        if (playPauseBtn) {
            playPauseBtn.addEventListener('click', function() {
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }
            });
        }

        // Handle mute button
        if (muteBtn) {
            muteBtn.addEventListener('click', function() {
                video.muted = !video.muted;
                const icon = muteBtn.querySelector('i');
                if (icon) {
                    icon.className = video.muted ? 'fas fa-volume-mute text-lg' : 'fas fa-volume-up text-lg';
                }
            });
        }

        // Handle fullscreen button
        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', function() {
                if (video.requestFullscreen) {
                    video.requestFullscreen();
                } else if (video.webkitRequestFullscreen) {
                    video.webkitRequestFullscreen();
                } else if (video.msRequestFullscreen) {
                    video.msRequestFullscreen();
                }
            });
        }

        // Update play/pause button icon
        video.addEventListener('play', function() {
            if (playPauseBtn) {
                const icon = playPauseBtn.querySelector('i');
                if (icon) {
                    icon.className = 'fas fa-pause text-xl';
                }
            }
        });

        video.addEventListener('pause', function() {
            if (playPauseBtn) {
                const icon = playPauseBtn.querySelector('i');
                if (icon) {
                    icon.className = 'fas fa-play text-xl';
                }
            }
        });

        // Update current time
        video.addEventListener('timeupdate', function() {
            if (currentTimeEl) {
                currentTimeEl.textContent = formatTime(video.currentTime);
            }
        });

        // Show play button when video ends
        video.addEventListener('ended', function() {
            if (playButton) {
                playButton.style.display = 'flex';
            }
            if (playPauseBtn) {
                const icon = playPauseBtn.querySelector('i');
                if (icon) {
                    icon.className = 'fas fa-play text-xl';
                }
            }
        });

        // Format time helper function
        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs.toString().padStart(2, '0')}`;
        }

        // Intersection Observer for lazy loading
        const videoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Start loading video when it comes into view
                    video.load();
                    videoObserver.unobserve(entry.target);
                }
            });
        }, { rootMargin: '50px' });

        // Observe the video container
        const videoContainer = document.querySelector('.max-w-4xl.mx-auto');
        if (videoContainer) {
            videoObserver.observe(videoContainer);
        }
    });
</script>
@endsection