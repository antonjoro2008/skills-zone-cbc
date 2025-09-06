    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 modal-backdrop z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative transform scale-95 opacity-0 transition-all duration-300 modal-content" id="loginModalContent">
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all" onclick="closeModal('loginModal')">
                    <i class="fas fa-times text-lg"></i>
                </button>
                
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
                    <p class="text-gray-600">Sign in to your account</p>
                </div>
                
                <form class="space-y-6" onsubmit="login(event)">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="loginEmail" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter your email" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" id="loginPassword" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter your password" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center group cursor-pointer">
                            <input type="checkbox" class="rounded text-blue-600 group-hover:scale-110 transition-transform">
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-blue-600 transition-colors">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800 hover:underline transition-all" onclick="showModal('forgotModal')">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl hover:scale-105 relative overflow-hidden">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </button>
                </form>
                
                <p class="text-center text-gray-600 mt-6">
                    Don't have an account? 
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium hover:underline transition-all" onclick="showModal('registerModal')">Sign up</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="fixed inset-0 modal-backdrop z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative transform scale-95 opacity-0 transition-all duration-300 modal-content" id="registerModalContent">
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all" onclick="closeModal('registerModal')">
                    <i class="fas fa-times text-lg"></i>
                </button>
                
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
                    <p class="text-gray-600">Join thousands of successful learners</p>
                </div>

                <!-- Registration Type Toggle -->
                <div class="mb-6">
                    <div class="flex bg-gray-100 rounded-xl p-1">
                        <button type="button" id="individualTab" class="flex-1 py-2 px-4 rounded-lg font-medium transition-all bg-white text-blue-600 shadow-sm" onclick="switchRegistrationType('individual')">
                            <i class="fas fa-user mr-2"></i>Individual
                        </button>
                        <button type="button" id="institutionTab" class="flex-1 py-2 px-4 rounded-lg font-medium transition-all text-gray-600 hover:text-gray-800" onclick="switchRegistrationType('institution')">
                            <i class="fas fa-building mr-2"></i>Institution
                        </button>
                    </div>
                </div>
                
                <!-- Individual Registration Form -->
                <form id="individualForm" class="space-y-5" onsubmit="registerIndividual(event)">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="registerName" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter your full name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="registerEmail" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter your email" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level</label>
                        <select id="registerGradeLevel" class="form-input w-full px-4 py-3 rounded-xl" required>
                            <option value="">Select your grade level</option>
                            <option value="Grade 1">Grade 1</option>
                            <option value="Grade 2">Grade 2</option>
                            <option value="Grade 3">Grade 3</option>
                            <option value="Grade 4">Grade 4</option>
                            <option value="Grade 5">Grade 5</option>
                            <option value="Grade 6">Grade 6</option>
                            <option value="Grade 7">Grade 7</option>
                            <option value="Grade 8">Grade 8</option>
                            <option value="Grade 9">Grade 9</option>
                            <option value="Grade 10">Grade 10</option>
                            <option value="Grade 11">Grade 11</option>
                            <option value="Grade 12">Grade 12</option>
                            <option value="University">University</option>
                            <option value="Professional">Professional</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" id="registerPassword" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Create a strong password" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                        <input type="password" id="registerPasswordConfirmation" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Confirm your password" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">M-PESA Phone Number</label>
                        <input type="tel" id="registerMpesaPhone" class="form-input w-full px-4 py-3 rounded-xl" placeholder="254700123456" required>
                        <p class="text-xs text-gray-500 mt-1">Enter your M-PESA registered phone number (e.g., 254700123456)</p>
                    </div>
                    <div>
                        <label class="flex items-center group cursor-pointer">
                            <input type="checkbox" class="rounded text-blue-600 group-hover:scale-110 transition-transform" required>
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-blue-600 transition-colors">I agree to the <a href="{{ route('terms') }}" class="text-blue-600 hover:text-blue-800 underline">Terms & Conditions</a></span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl hover:scale-105 relative overflow-hidden">
                        <i class="fas fa-rocket mr-2"></i>Create Account
                    </button>
                </form>

                <!-- Institution Registration Form -->
                <form id="institutionForm" class="space-y-5 hidden" onsubmit="registerInstitution(event)">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Institution Name</label>
                        <input type="text" id="institutionName" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter institution name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="institutionEmail" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter institution email" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" id="institutionPhone" class="form-input w-full px-4 py-3 rounded-xl" placeholder="254700123456" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <input type="text" id="institutionAddress" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter institution address" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Motto</label>
                        <input type="text" id="institutionMotto" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter institution motto (optional)">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Theme Color</label>
                        <input type="color" id="institutionThemeColor" class="form-input w-full px-4 py-3 rounded-xl h-12" value="#3b82f6">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" id="institutionPassword" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Create a strong password" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">M-PESA Phone Number</label>
                        <input type="tel" id="institutionMpesaPhone" class="form-input w-full px-4 py-3 rounded-xl" placeholder="254700123456" required>
                        <p class="text-xs text-gray-500 mt-1">Enter your M-PESA registered phone number (e.g., 254700123456)</p>
                    </div>
                    <div>
                        <label class="flex items-center group cursor-pointer">
                            <input type="checkbox" class="rounded text-blue-600 group-hover:scale-110 transition-transform" required>
                            <span class="ml-2 text-sm text-gray-600 group-hover:text-blue-600 transition-colors">I agree to the <a href="{{ route('terms') }}" class="text-blue-600 hover:text-blue-800 underline">Terms & Conditions</a></span>
                        </label>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl hover:scale-105 relative overflow-hidden">
                        <i class="fas fa-building mr-2"></i>Create Institution Account
                    </button>
                </form>
                
                <p class="text-center text-gray-600 mt-6">
                    Already have an account? 
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium hover:underline transition-all" onclick="showModal('loginModal')">Sign in</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative modal-content">
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" onclick="closeModal('forgotModal')">
                    <i class="fas fa-times text-xl"></i>
                </button>
                
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Reset Password</h2>
                    <p class="text-gray-600">Enter your email to receive reset instructions</p>
                </div>
                
                <form class="space-y-6" onsubmit="forgotPassword(event)">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="forgotEmail" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg">
                        Send Reset Link
                    </button>
                </form>
                
                <p class="text-center text-gray-600 mt-6">
                    Remember your password? 
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium" onclick="showModal('loginModal')">Sign in</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8 relative modal-content">
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" onclick="closeModal('paymentModal')">
                    <i class="fas fa-times text-xl"></i>
                </button>
                
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Complete Payment</h2>
                    <p class="text-gray-600">Pay securely with M-PESA</p>
                </div>
                
                <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-600">Assessment:</span>
                        <span class="font-semibold" id="paymentAssessment">JavaScript Fundamentals</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Amount:</span>
                        <span class="text-2xl font-bold text-green-600" id="paymentAmount">KSH 1,500</span>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-center justify-center mb-6">
                        <div class="bg-green-500 text-white px-4 py-2 rounded-lg font-bold text-lg">
                            M-PESA
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" id="mpesaPhone" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="254700123456" required>
                    </div>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Payment Instructions:</p>
                                <p>1. Enter your M-PESA registered phone number</p>
                                <p>2. Click "Pay Now" to initiate payment</p>
                                <p>3. Check your phone for M-PESA prompt</p>
                                <p>4. Enter your M-PESA PIN to complete</p>
                            </div>
                        </div>
                    </div>
                    
                    <button type="button" class="w-full bg-green-500 text-white py-4 rounded-xl font-semibold hover:bg-green-600 transition-all shadow-lg text-lg" onclick="processMpesaPayment()">
                        <i class="fas fa-mobile-alt mr-2"></i>
                        Pay Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative text-center modal-content">
                <div class="text-green-500 text-6xl mb-6 animate-bounce-slow">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Payment Successful!</h2>
                <p class="text-gray-600 mb-6">You can now access your assessment. Good luck!</p>
                <button class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all" onclick="startAssessment()">
                    Start Assessment
                </button>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative text-center modal-content">
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all" onclick="closeModal('errorModal')">
                    <i class="fas fa-times text-lg"></i>
                </button>
                <div class="text-red-500 text-6xl mb-6">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Registration Failed</h2>
                <p class="text-gray-600 mb-6" id="errorMessage">An error occurred during registration. Please try again.</p>
                <button class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white py-3 rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all" onclick="closeModal('errorModal')">
                    Try Again
                </button>
            </div>
        </div>
    </div>

    <!-- Logout Success Modal -->
    <div id="logoutSuccessModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative text-center modal-content">
                <div class="text-green-500 text-6xl mb-6 animate-bounce-slow">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Logged Out Successfully</h2>
                <p class="text-gray-600 mb-6">You have been logged out of your account. Thank you for using SkillsZone!</p>
                <div class="space-y-3">
                    <button class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl hover:scale-105" onclick="closeModal('logoutSuccessModal'); updateAuthState();">
                        <i class="fas fa-home mr-2"></i>
                        Go to Home
                    </button>
                    <button class="w-full bg-white border-2 border-blue-600 text-blue-600 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all" onclick="closeModal('logoutSuccessModal'); updateAuthState(); showModal('loginModal')">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In Again
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Reset Success Modal -->
    <div id="passwordResetSuccessModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative text-center modal-content">
                <div class="text-blue-500 text-6xl mb-6 animate-bounce-slow">
                    <i class="fas fa-envelope"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Reset Link Sent!</h2>
                <p class="text-gray-600 mb-6">We've sent a password reset link to your email address. Please check your inbox and follow the instructions.</p>
                <div class="space-y-3">
                    <button class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl hover:scale-105" onclick="closeModal('passwordResetSuccessModal')">
                        <i class="fas fa-check mr-2"></i>
                        Got It
                    </button>
                    <button class="w-full bg-white border-2 border-blue-600 text-blue-600 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all" onclick="closeModal('passwordResetSuccessModal'); showModal('loginModal')">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Back to Sign In
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Learner Modal -->
    <div id="addLearnerModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative modal-content">
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all" onclick="closeModal('addLearnerModal')">
                    <i class="fas fa-times text-lg"></i>
                </button>
                
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Add New Learner</h2>
                    <p class="text-gray-600">Create a new learner account</p>
                </div>
                
                <form class="space-y-6" onsubmit="addLearner(event)">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="learnerName" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter learner's full name" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="learnerEmail" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter learner's email" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level</label>
                        <select id="learnerGradeLevel" class="form-input w-full px-4 py-3 rounded-xl" required>
                            <option value="">Select grade level</option>
                            <option value="Grade 1">Grade 1</option>
                            <option value="Grade 2">Grade 2</option>
                            <option value="Grade 3">Grade 3</option>
                            <option value="Grade 4">Grade 4</option>
                            <option value="Grade 5">Grade 5</option>
                            <option value="Grade 6">Grade 6</option>
                            <option value="Grade 7">Grade 7</option>
                            <option value="Grade 8">Grade 8</option>
                            <option value="Grade 9">Grade 9</option>
                            <option value="Grade 10">Grade 10</option>
                            <option value="Grade 11">Grade 11</option>
                            <option value="Grade 12">Grade 12</option>
                            <option value="University">University</option>
                            <option value="Professional">Professional</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Initial Tokens</label>
                        <input type="number" id="learnerInitialTokens" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter initial token amount" min="0" max="1000" value="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">M-PESA Phone Number</label>
                        <input type="tel" id="learnerMpesaPhone" class="form-input w-full px-4 py-3 rounded-xl" placeholder="254700123456" required>
                        <p class="text-xs text-gray-500 mt-1">Enter learner's M-PESA registered phone number</p>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white py-3 rounded-xl font-semibold hover:from-green-700 hover:to-blue-700 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <i class="fas fa-user-plus mr-2"></i>Add Learner
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Upload Modal -->
    <div id="bulkUploadModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full p-8 relative modal-content">
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all" onclick="closeModal('bulkUploadModal')">
                    <i class="fas fa-times text-lg"></i>
                </button>
                
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-upload text-white text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Bulk Upload Learners</h2>
                    <p class="text-gray-600">Upload multiple learners at once</p>
                </div>
                
                <div class="space-y-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-2">Upload Instructions:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Upload a CSV file with columns: Name, Email, Grade Level, Initial Tokens, M-PESA Phone</li>
                                    <li>First row should contain headers</li>
                                    <li>Maximum 100 learners per upload</li>
                                    <li>Default password will be "password123" for all learners</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">CSV File</label>
                        <input type="file" id="csvFile" accept=".csv" class="form-input w-full px-4 py-3 rounded-xl" required>
                    </div>
                    
                    <div class="bg-gray-50 rounded-xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Sample CSV Format:</h4>
                        <div class="bg-white rounded-lg p-3 font-mono text-sm">
                            Name,Email,Grade Level,Initial Tokens,M-PESA Phone<br>
                            John Doe,john@example.com,Grade 5,50,254700123456<br>
                            Jane Smith,jane@example.com,Grade 6,75,254700789012
                        </div>
                    </div>
                    
                    <button type="button" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all shadow-lg hover:shadow-xl hover:scale-105" onclick="processBulkUpload()">
                        <i class="fas fa-upload mr-2"></i>Upload Learners
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Buy Tokens Modal -->
    <div id="buyTokensModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative modal-content">
                <button class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all" onclick="closeModal('buyTokensModal')">
                    <i class="fas fa-times text-lg"></i>
                </button>
                
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-coins text-white text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">Buy Tokens</h2>
                    <p class="text-gray-600">Purchase tokens using M-PESA</p>
                </div>
                
                <form class="space-y-6" onsubmit="buyTokens(event)">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">M-PESA Phone Number</label>
                        <input type="tel" id="buyTokensMpesaPhone" class="form-input w-full px-4 py-3 rounded-xl" placeholder="254700123456" required>
                        <p class="text-xs text-gray-500 mt-1">Enter your M-PESA registered phone number (format: 254XXXXXXXXX)</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Amount (KES)</label>
                        <input type="number" id="buyTokensAmount" class="form-input w-full px-4 py-3 rounded-xl" placeholder="Enter amount in KES" min="1" max="100000" step="1" required oninput="calculateTokens()">
                        <p class="text-xs text-gray-500 mt-1">Minimum: KES 1, Maximum: KES 100,000</p>
                    </div>
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-2">Token Purchase Info:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>1 Token = KES 1</li>
                                    <li>You will receive a payment prompt on your phone</li>
                                    <li>Enter your M-PESA PIN to complete the transaction</li>
                                    <li>Tokens will be added to your account immediately</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Amount:</span>
                            <span class="font-semibold text-gray-900" id="displayAmount">KES 0</span>
                        </div>
                        <div class="flex justify-between items-center mt-2">
                            <span class="text-gray-600">Tokens to receive:</span>
                            <span class="font-bold text-blue-600" id="displayTokens">0 tokens</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-blue-600 text-white py-3 rounded-xl font-semibold hover:from-green-700 hover:to-blue-700 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <i class="fas fa-mobile-alt mr-2"></i>Buy Tokens with M-PESA
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom Alert Modal -->
    <div id="alertModal" class="fixed inset-0 modal-backdrop z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4 modal-container">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative transform scale-95 opacity-0 transition-all duration-300 modal-content" id="alertModalContent">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2" id="alertTitle">Alert</h3>
                    <p class="text-gray-600 mb-6" id="alertMessage">This is an alert message.</p>
                    <button onclick="closeModal('alertModal')" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <i class="fas fa-check mr-2"></i>OK
                    </button>
                </div>
            </div>
        </div>
    </div> 