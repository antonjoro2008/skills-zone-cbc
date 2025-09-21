    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 text-yellow-400">Gravity CBC</h3>
                    <p class="text-gray-300 mb-4">Empowering Kenyan learners with accessible, quality assessment tools.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-yellow-400">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('subjects') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Browse Assessments</a></li>
                        <li><a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('pricing') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Token Packages</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-yellow-400">Support</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('help') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Help Center</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Contact Us</a></li>
                        <li><a href="{{ route('faq') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-yellow-400">Legal</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('privacy') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('terms') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Terms & Conditions</a></li>
                        <li><a href="{{ route('cookie-policy') }}" class="text-gray-300 hover:text-yellow-400 transition-colors">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2025 Gravity CBC. All rights reserved. Built with ❤️ for Kenyan Learners | assessments.gravitycbc.co.ke</p>
            </div>
        </div>
    </footer> 