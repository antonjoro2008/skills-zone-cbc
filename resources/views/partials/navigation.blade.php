<!-- Navigation -->
<nav class="fixed top-0 w-full z-50 glass-effect">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <!-- <a href="{{ route('home') }}" class="text-2xl font-bold bg-gradient-to-r from-[#EC2834] via-[#E368A7] to-[#8FC340] bg-clip-text text-transparent animate-pulse-glow"> -->
                    <!-- <i class="fas fa-graduation-cap mr-2"></i>Gravity CBC
                     <img src="{{ asset('images/logo.png') }}" alt="CBC Assessment" class="h-10 w-10"/>
                    </a> -->
                <a href="{{ route('home') }}" class="py-3"> 
                     <img src="{{ asset('images/logo.png') }}" alt="CBC Assessment" width="80px"/>
                </a>
            </div>
            
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-6">
                    <a href="{{ route('home') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-all {{ request()->routeIs('home') ? 'text-blue-600 font-semibold' : '' }}">Home</a>
                    <a href="{{ route('subjects') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-all {{ request()->routeIs('subjects') || request()->routeIs('assessments') ? 'text-blue-600 font-semibold' : '' }}">Assessments</a>
                    {{-- <a href="{{ route('pricing') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-all {{ request()->routeIs('pricing') ? 'text-blue-600 font-semibold' : '' }}">Tokens</a> --}}
                    {{-- <a href="{{ route('blog') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-all {{ request()->routeIs('blog') ? 'text-blue-600 font-semibold' : '' }}">Blog</a> --}}
                    <a href="{{ route('dashboard') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'text-blue-600 font-semibold' : '' }}" id="dashboardLink" style="display:none;">Dashboard</a>
                    <a href="{{ route('institution-dashboard') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-all {{ request()->routeIs('institution-dashboard') ? 'text-blue-600 font-semibold' : '' }}" id="institutionDashboardLink" style="display:none;">Manage Learners</a>
                    <a href="{{ route('parent-dashboard') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-all {{ request()->routeIs('parent-dashboard') ? 'text-blue-600 font-semibold' : '' }}" id="parentDashboardLink" style="display:none;">My Learners</a>
                    <a href="{{ route('transactions') }}" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-all {{ request()->routeIs('transactions') ? 'text-blue-600 font-semibold' : '' }}" id="transactionsLink" style="display:none;">Purchases</a>
                </div>
            </div>
            
            <!-- Mobile menu button and Buy Tokens -->
            <div class="md:hidden flex items-center space-x-2">
                <button class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white hover:from-yellow-600 hover:to-orange-600 px-3 py-2 rounded-full text-xs font-medium transition-all shadow-lg hover:shadow-xl hover:scale-105" onclick="showBuyTokensModal()" id="buyTokensBtnMobile" style="display:none;">
                    <i class="fas fa-coins mr-1"></i>Buy Tokens
                </button>
                <button class="text-gray-700 hover:text-blue-600 p-2" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <div class="hidden md:flex items-center space-x-4">
                <button class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white hover:from-yellow-600 hover:to-orange-600 px-6 py-2 rounded-full text-sm font-medium transition-all shadow-lg hover:shadow-xl hover:scale-105" onclick="showBuyTokensModal()" id="buyTokensBtn" style="display:none;">
                    <i class="fas fa-coins mr-2"></i>Buy Tokens
                </button>
                <button class="bg-white text-[#8FC340] border-2 border-[#8FC340] hover:bg-[#8FC340]/10 px-6 py-2 rounded-full text-sm font-medium transition-all hover:scale-105" onclick="showModal('loginModal')" id="loginBtn">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </button>
                <button class="bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white hover:from-[#7bb02d] hover:to-[#d15a8a] px-6 py-2 rounded-full text-sm font-medium transition-all shadow-lg hover:shadow-xl hover:scale-105" onclick="showModal('registerModal')" id="registerBtn">
                    <i class="fas fa-rocket mr-2"></i>Get Started
                </button>
                <button class="bg-gray-500 text-white hover:bg-gray-600 px-6 py-2 rounded-full text-sm font-medium transition-all hover:scale-105" onclick="logout()" id="logoutBtn" style="display:none;">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu md:hidden fixed top-16 left-0 w-full h-screen bg-white z-40">
        <div class="p-6 space-y-4">
            <a href="{{ route('home') }}" class="block text-lg font-medium text-gray-700 hover:text-[#8FC340] py-2 {{ request()->routeIs('home') ? 'text-[#8FC340] font-semibold' : '' }}">Home</a>
            <a href="{{ route('subjects') }}" class="block text-lg font-medium text-gray-700 hover:text-[#E368A7] py-2 {{ request()->routeIs('subjects') || request()->routeIs('assessments') ? 'text-[#E368A7] font-semibold' : '' }}">Assessments</a>
            {{-- <a href="{{ route('pricing') }}" class="block text-lg font-medium text-gray-700 hover:text-blue-600 py-2 {{ request()->routeIs('pricing') ? 'text-blue-600 font-semibold' : '' }}">Tokens</a> --}}
            {{-- <a href="{{ route('blog') }}" class="block text-lg font-medium text-gray-700 hover:text-[#8FC340] py-2 {{ request()->routeIs('blog') ? 'text-[#8FC340] font-semibold' : '' }}">Blog</a> --}}
            <a href="{{ route('dashboard') }}" class="block text-lg font-medium text-gray-700 hover:text-[#8FC340] py-2 {{ request()->routeIs('dashboard') ? 'text-[#8FC340] font-semibold' : '' }}" id="dashboardLinkMobile" style="display:none;">Dashboard</a>
            <a href="{{ route('institution-dashboard') }}" class="block text-lg font-medium text-gray-700 hover:text-[#E368A7] py-2 {{ request()->routeIs('institution-dashboard') ? 'text-[#E368A7] font-semibold' : '' }}" id="institutionDashboardLinkMobile" style="display:none;">Manage Learners</a>
            <a href="{{ route('parent-dashboard') }}" class="block text-lg font-medium text-gray-700 hover:text-[#8FC340] py-2 {{ request()->routeIs('parent-dashboard') ? 'text-[#8FC340] font-semibold' : '' }}" id="parentDashboardLinkMobile" style="display:none;">My Learners</a>
            <a href="{{ route('transactions') }}" class="block text-lg font-medium text-gray-700 hover:text-[#8FC340] py-2 {{ request()->routeIs('transactions') ? 'text-[#8FC340] font-semibold' : '' }}" id="transactionsLinkMobile" style="display:none;">Purchases</a>
            <div class="pt-4 border-t border-gray-200 space-y-3">
                <button class="w-full bg-white text-[#8FC340] border-2 border-[#8FC340] hover:bg-[#8FC340]/10 px-6 py-3 rounded-full font-medium transition-all" onclick="showModal('loginModal'); toggleMobileMenu()" id="loginBtnMobile">
                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                </button>
                <button class="w-full bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white hover:from-[#7bb02d] hover:to-[#d15a8a] px-6 py-3 rounded-full font-medium transition-all shadow-lg" onclick="showModal('registerModal'); toggleMobileMenu()" id="registerBtnMobile">
                    <i class="fas fa-rocket mr-2"></i>Get Started
                </button>
                <button class="w-full bg-gray-500 text-white hover:bg-gray-600 px-6 py-3 rounded-full font-medium transition-all" onclick="logout(); toggleMobileMenu()" id="logoutBtnMobile" style="display:none;">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </div>
        </div>
    </div>
</nav> 