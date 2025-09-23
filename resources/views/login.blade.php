@extends('layouts.app')

@section('title', 'Login - Gravity CBC')

@section('content')
<style>
    .login-container {
        min-height: calc(100vh - 4rem);
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }
    
    .form-input {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .form-input:focus {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(143, 195, 64, 0.15);
    }
    
    .login-btn {
        background: linear-gradient(135deg, #8FC340 0%, #E368A7 100%);
        transition: all 0.3s ease;
    }
    
    .login-btn:hover {
        background: linear-gradient(135deg, #7bb02d 0%, #d15a8a 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(143, 195, 64, 0.3);
    }
    
    .floating-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 0;
    }
    
    .shape {
        position: absolute;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }
    
    .shape:nth-child(1) {
        width: 80px;
        height: 80px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }
    
    .shape:nth-child(2) {
        width: 120px;
        height: 120px;
        top: 60%;
        right: 10%;
        animation-delay: 2s;
    }
    
    .shape:nth-child(3) {
        width: 60px;
        height: 60px;
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0px) rotate(0deg);
        }
        50% {
            transform: translateY(-20px) rotate(180deg);
        }
    }
</style>

<div class="login-container flex items-center justify-center p-4 relative">
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <div class="login-card rounded-3xl p-8 w-full max-w-md relative z-10">
        <!-- Logo and Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-r from-[#8FC340] to-[#E368A7] rounded-full flex items-center justify-center mx-auto mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Gravity CBC" class="w-12 h-12">
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h1>
            <p class="text-gray-600">Sign in to access your assessments</p>
        </div>
        
        <!-- Login Form -->
        <form id="loginForm" class="space-y-6">
            <div>
                <label for="loginEmail" class="block text-sm font-medium text-gray-700 mb-2">Email, Phone Number, or Admission Number</label>
                <input 
                    type="text" 
                    id="loginEmail" 
                    name="email" 
                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#8FC340]/20 focus:border-[#8FC340] outline-none transition-all duration-300" 
                    placeholder="Enter your email, phone number, or admission number"
                    required
                >
            </div>
            
            <div>
                <label for="loginPassword" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="loginPassword" 
                        name="password" 
                        class="form-input w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#8FC340]/20 focus:border-[#8FC340] outline-none transition-all duration-300" 
                        placeholder="Enter your password"
                        required
                    >
                    <button 
                        type="button" 
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600" 
                        onclick="togglePassword('loginPassword')"
                    >
                        <i class="fas fa-eye" id="loginPasswordIcon"></i>
                    </button>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input 
                        id="rememberMe" 
                        name="remember" 
                        type="checkbox" 
                        class="h-4 w-4 text-[#8FC340] focus:ring-[#8FC340] border-gray-300 rounded"
                    >
                    <label for="rememberMe" class="ml-2 block text-sm text-gray-700">
                        Remember me
                    </label>
                </div>
                <button 
                    type="button" 
                    onclick="showForgotPassword()" 
                    class="text-sm text-[#8FC340] hover:text-[#7bb02d] font-medium"
                >
                    Forgot password?
                </button>
            </div>
            
            <button 
                type="submit" 
                class="login-btn w-full text-white py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300"
            >
                <i class="fas fa-sign-in-alt mr-2"></i>Sign In
            </button>
        </form>
        
        <!-- Divider -->
        <div class="my-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Don't have an account?</span>
                </div>
            </div>
        </div>
        
        <!-- Register Links -->
        <div class="space-y-3">
            <button 
                onclick="showRegisterModal()" 
                class="w-full bg-white border-2 border-[#8FC340] text-[#8FC340] py-3 rounded-xl font-semibold hover:bg-[#8FC340]/10 transition-all duration-300"
            >
                <i class="fas fa-user-plus mr-2"></i>Create Student Account
            </button>
            <button 
                onclick="showInstitutionRegisterModal()" 
                class="w-full bg-white border-2 border-[#E368A7] text-[#E368A7] py-3 rounded-xl font-semibold hover:bg-[#E368A7]/10 transition-all duration-300"
            >
                <i class="fas fa-school mr-2"></i>Create Institution Account
            </button>
        </div>
        
        <!-- Back to Home -->
        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-1"></i>Back to Home
            </a>
        </div>
    </div>
</div>

<!-- Login Alert Modal -->
<div id="loginAlertModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative transform scale-95 opacity-0 transition-all duration-300" id="loginAlertModalContent">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4" id="loginAlertContainer">
                    <i class="fas fa-exclamation-triangle text-white text-2xl" id="loginAlertIcon"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2" id="loginAlertTitle">Alert</h3>
                <p class="text-gray-600 mb-6" id="loginAlertMessage">This is an alert message.</p>
                <button onclick="closeLoginAlert()" class="bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white px-8 py-3 rounded-xl font-semibold hover:from-[#7bb02d] hover:to-[#d15a8a] transition-all shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="fas fa-check mr-2"></i>OK
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Custom alert function for login page
    function showAlert(title, message, type = 'warning') {
        const alertModal = document.getElementById('loginAlertModal');
        
        if (!alertModal) {
            console.error('Login alert modal not found. Falling back to default alert.');
            alert(`${title}: ${message}`);
            return;
        }
        
        const alertTitle = document.getElementById('loginAlertTitle');
        const alertMessage = document.getElementById('loginAlertMessage');
        const alertIcon = document.getElementById('loginAlertIcon');
        const alertContainer = document.getElementById('loginAlertContainer');
        
        if (!alertTitle || !alertMessage || !alertIcon || !alertContainer) {
            console.error('Login alert modal elements not found. Falling back to default alert.');
            alert(`${title}: ${message}`);
            return;
        }
        
        alertTitle.textContent = title;
        alertMessage.textContent = message;
        
        if (type === 'error') {
            alertIcon.className = 'fas fa-times-circle text-white text-2xl';
            alertContainer.className = 'w-16 h-16 bg-gradient-to-r from-[#EC2834] to-[#d41e2a] rounded-full flex items-center justify-center mx-auto mb-4';
        } else if (type === 'success') {
            alertIcon.className = 'fas fa-check-circle text-white text-2xl';
            alertContainer.className = 'w-16 h-16 bg-gradient-to-r from-[#8FC340] to-[#7bb02d] rounded-full flex items-center justify-center mx-auto mb-4';
        } else if (type === 'info') {
            alertIcon.className = 'fas fa-info-circle text-white text-2xl';
            alertContainer.className = 'w-16 h-16 bg-gradient-to-r from-[#E368A7] to-[#d15a8a] rounded-full flex items-center justify-center mx-auto mb-4';
        } else {
            alertIcon.className = 'fas fa-exclamation-triangle text-white text-2xl';
            alertContainer.className = 'w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4';
        }
        
        alertModal.classList.remove('hidden');
        const content = document.getElementById('loginAlertModalContent');
        if (content) {
            setTimeout(() => {
                content.style.transform = 'scale(1)';
                content.style.opacity = '1';
            }, 10);
        }
    }

    function closeLoginAlert() {
        const alertModal = document.getElementById('loginAlertModal');
        const content = document.getElementById('loginAlertModalContent');
        if (content) {
            content.style.transform = 'scale(0.95)';
            content.style.opacity = '0';
            setTimeout(() => {
                alertModal.classList.add('hidden');
            }, 300);
        } else {
            alertModal.classList.add('hidden');
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // Setup form handler
        document.getElementById('loginForm').addEventListener('submit', handleLogin);
        
        // Check if user is already logged in
        checkExistingAuth();
    });
    
    function checkExistingAuth() {
        const token = localStorage.getItem('token') || localStorage.getItem('access_token');
        const user = localStorage.getItem('user');
        
        if (token && user) {
            // Check for return URL parameter
            const urlParams = new URLSearchParams(window.location.search);
            const returnUrl = urlParams.get('return');
            
            if (returnUrl) {
                // Redirect to the original page
                window.location.href = returnUrl;
            } else {
                // User is already logged in, redirect to appropriate dashboard
                const userData = JSON.parse(user);
                if (userData.user_type === 'institution') {
                    window.location.href = '/institution-dashboard';
                } else if (userData.user_type === 'parent') {
                    window.location.href = '/parent-dashboard';
                } else {
                    window.location.href = '/dashboard';
                }
            }
        }
    }
    
    async function handleLogin(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        let loginIdentifier = formData.get('email').trim();
        
        // Standardize phone number if it looks like a phone number
        if (loginIdentifier && /^[0-9+\-\s()]+$/.test(loginIdentifier)) {
            // Remove all non-digit characters
            let phoneNumber = loginIdentifier.replace(/\D/g, '');
            
            // Standardize to 254 format
            if (phoneNumber.startsWith('0')) {
                phoneNumber = '254' + phoneNumber.substring(1);
            } else if (phoneNumber.startsWith('254')) {
                // Already in correct format
            } else if (phoneNumber.length === 9) {
                phoneNumber = '254' + phoneNumber;
            }
            
            loginIdentifier = phoneNumber;
        }
        
        const loginData = {
            login_identifier: loginIdentifier,
            password: formData.get('password'),
            remember: formData.get('remember') === 'on'
        };
        
        try {
            const response = await fetch(`${API_BASE_URL}/api/login`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(loginData)
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Store complete user data, token, and dashboard data (matching popup login exactly)
                localStorage.setItem('user', JSON.stringify(data.data.user));
                localStorage.setItem('token', data.data.access_token);
                localStorage.setItem('dashboard', JSON.stringify(data.data.dashboard));
                
                // Also store in sessionStorage as backup for mobile devices
                sessionStorage.setItem('user', JSON.stringify(data.data.user));
                sessionStorage.setItem('token', data.data.access_token);
                sessionStorage.setItem('dashboard', JSON.stringify(data.data.dashboard));
                
                // Update global currentUser variable if it exists (for consistency with popup login)
                if (typeof window.currentUser !== 'undefined') {
                    window.currentUser = data.data.user;
                    console.log('Updated global currentUser:', window.currentUser);
                }
                
                // Call updateAuthState if it exists (for consistency with popup login)
                if (typeof updateAuthState === 'function') {
                    updateAuthState();
                    console.log('Called updateAuthState');
                } else {
                    console.log('updateAuthState function not available');
                }
                
                // Debug: Log stored data
                console.log('Stored token:', localStorage.getItem('token'));
                console.log('Stored user:', localStorage.getItem('user'));
                
                // Redirect immediately on successful login
                // Check for return URL parameter
                const urlParams = new URLSearchParams(window.location.search);
                const returnUrl = urlParams.get('return');
                
                if (returnUrl) {
                    // Redirect to the original page
                    window.location.href = returnUrl;
                } else {
                    // Default redirect based on user type (matching popup login logic)
                    const user = data.data.user;
                    if (user.user_type === 'institution') {
                        window.location.href = '/institution-dashboard';
                    } else {
                        window.location.href = '/dashboard';
                    }
                }
                
            } else {
                // Handle API error response with detailed error messages
                let errorMessage = data.message || 'Login failed. Please check your credentials.';
                
                // If there are specific field errors, show them
                if (data.errors) {
                    const errorDetails = [];
                    for (const [field, messages] of Object.entries(data.errors)) {
                        if (Array.isArray(messages)) {
                            errorDetails.push(...messages);
                        } else {
                            errorDetails.push(messages);
                        }
                    }
                    if (errorDetails.length > 0) {
                        errorMessage = errorDetails.join('. ');
                    }
                }
                
                showAlert('Login Failed', errorMessage, 'error');
            }
        } catch (error) {
            console.error('Login error:', error);
            showAlert('Error', 'Login failed. Please check your connection and try again.', 'error');
        }
    }
    
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(inputId + 'Icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }
    
    function showForgotPassword() {
        // Use the global showModal function if available, otherwise show alert
        if (typeof showModal === 'function') {
            showModal('forgotPasswordModal');
        } else {
            showAlert('Forgot Password', 'Please contact support for password reset assistance.', 'info');
        }
    }
    
    function showRegisterModal() {
        // Use the global showModal function if available, otherwise redirect
        if (typeof showModal === 'function') {
            showModal('registerModal');
        } else {
            window.location.href = '/';
        }
    }
    
    function showInstitutionRegisterModal() {
        // Use the global showModal function if available, otherwise redirect
        if (typeof showModal === 'function') {
            showModal('institutionRegisterModal');
        } else {
            window.location.href = '/';
        }
    }
</script>
@endsection
