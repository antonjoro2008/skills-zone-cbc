@extends('layouts.app')

@section('title', 'My Profile - Gravity CBC')

@section('content')
<style>
    /* Profile page styling */
    .profile-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid rgba(143, 195, 64, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .profile-card:hover {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }
    
    .profile-avatar {
        background: linear-gradient(135deg, #8FC340 0%, #E368A7 100%);
        box-shadow: 0 8px 25px rgba(143, 195, 64, 0.3);
    }
    
    .form-input {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .form-input:focus {
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(143, 195, 64, 0.12);
    }
    
    .tab-button {
        transition: all 0.3s ease;
    }
    
    .tab-button.active {
        background: linear-gradient(135deg, #8FC340 0%, #E368A7 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(143, 195, 64, 0.3);
    }
    
    .tab-button:hover:not(.active) {
        background: #f3f4f6;
        transform: translateY(-1px);
    }
    
    .password-strength {
        height: 4px;
        border-radius: 2px;
        transition: all 0.3s ease;
    }
    
    .strength-weak { background: #ef4444; }
    .strength-medium { background: #f59e0b; }
    .strength-strong { background: #10b981; }
    
    .modal-backdrop {
        backdrop-filter: blur(8px);
    }
    
    @media (max-width: 768px) {
        .profile-card {
            margin: 1rem;
            padding: 1.5rem;
        }
    }
</style>

<!-- Hero Section -->
<div class="gradient-bg text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 text-center">
        <h1 class="text-4xl font-bold mb-4">My Profile</h1>
        <p class="text-xl text-gray-100">Manage your account settings and preferences</p>
        
        <!-- Token Balance Display -->
        <div class="mt-8 inline-flex items-center bg-white bg-opacity-20 rounded-full px-6 py-3">
            <i class="fas fa-coins text-yellow-300 mr-3 text-xl"></i>
            <div class="text-left">
                <div class="text-sm text-gray-200">Your Token Balance</div>
                <div class="text-xl font-bold" id="tokenBalance">Loading...</div>
                <div class="text-sm font-semibold text-[#333333]" id="availableMinutes">Loading...</div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Profile Card -->
    <div class="profile-card bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
        <!-- Profile Header -->
        <div class="text-center mb-8">
            <div class="profile-avatar w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user text-white text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2" id="userName">Loading...</h2>
            <p class="text-gray-600" id="userEmail">Loading...</p>
            <div class="mt-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-[#8FC340]/10 text-[#8FC340]" id="userType">
                    Loading...
                </span>
            </div>
            
        </div>
        
        <!-- Tabs -->
        <div class="flex flex-wrap justify-center mb-8 border-b border-gray-200">
            <button class="tab-button active px-6 py-3 text-sm font-medium text-gray-700 rounded-t-lg mr-2" onclick="switchTab('profile')">
                <i class="fas fa-user mr-2"></i>Profile Information
            </button>
            <button class="tab-button px-6 py-3 text-sm font-medium text-gray-700 rounded-t-lg" onclick="switchTab('password')">
                <i class="fas fa-lock mr-2"></i>Change Password
            </button>
        </div>
        
        <!-- Profile Information Tab -->
        <div id="profileTab" class="tab-content">
            <form id="profileForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="profileName" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="profileName" name="name" class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#8FC340]/20 focus:border-[#8FC340] outline-none transition-all duration-300" placeholder="Enter your full name">
                    </div>
                    
                    <div>
                        <label for="profileEmail" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="profileEmail" name="email" class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#8FC340]/20 focus:border-[#8FC340] outline-none transition-all duration-300" placeholder="Enter your email">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="profilePhone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" id="profilePhone" name="phone_number" class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#8FC340]/20 focus:border-[#8FC340] outline-none transition-all duration-300" placeholder="Enter your phone number">
                    </div>
                    
                    <div>
                        <label for="profileGrade" class="block text-sm font-medium text-gray-700 mb-2">Grade Level</label>
                        <select id="profileGrade" name="grade_level" class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#8FC340]/20 focus:border-[#8FC340] outline-none transition-all duration-300">
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
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white px-8 py-3 rounded-xl font-semibold hover:from-[#7bb02d] hover:to-[#d15a8a] transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <i class="fas fa-save mr-2"></i>Update Profile
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Change Password Tab -->
        <div id="passwordTab" class="tab-content hidden">
            <form id="passwordForm" class="space-y-6">
                <div>
                    <label for="currentPassword" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                    <div class="relative">
                        <input type="password" id="currentPassword" name="current_password" class="form-input w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#8FC340]/20 focus:border-[#8FC340] outline-none transition-all duration-300" placeholder="Enter current password">
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600" onclick="togglePassword('currentPassword')">
                            <i class="fas fa-eye" id="currentPasswordIcon"></i>
                        </button>
                    </div>
                </div>
                
                <div>
                    <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <div class="relative">
                        <input type="password" id="newPassword" name="password" class="form-input w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#8FC340]/20 focus:border-[#8FC340] outline-none transition-all duration-300" placeholder="Enter new password">
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600" onclick="togglePassword('newPassword')">
                            <i class="fas fa-eye" id="newPasswordIcon"></i>
                        </button>
                    </div>
                    <!-- Password Strength Indicator -->
                    <div class="mt-2">
                        <div class="flex space-x-1">
                            <div class="password-strength flex-1 bg-gray-200" id="strengthBar1"></div>
                            <div class="password-strength flex-1 bg-gray-200" id="strengthBar2"></div>
                            <div class="password-strength flex-1 bg-gray-200" id="strengthBar3"></div>
                            <div class="password-strength flex-1 bg-gray-200" id="strengthBar4"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1" id="passwordStrengthText">Enter a password to see strength</p>
                    </div>
                </div>
                
                <div>
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <div class="relative">
                        <input type="password" id="confirmPassword" name="password_confirmation" class="form-input w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#8FC340]/20 focus:border-[#8FC340] outline-none transition-all duration-300" placeholder="Confirm new password">
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600" onclick="togglePassword('confirmPassword')">
                            <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                        </button>
                    </div>
                    <div class="mt-1" id="passwordMatch"></div>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Password Requirements</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>At least 8 characters long</li>
                                    <li>Contains uppercase and lowercase letters</li>
                                    <li>Contains at least one number</li>
                                    <li>Contains at least one special character</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white px-8 py-3 rounded-xl font-semibold hover:from-[#7bb02d] hover:to-[#d15a8a] transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <i class="fas fa-key mr-2"></i>Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Profile Alert Modal -->
<div id="profileAlertModal" class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative transform scale-95 opacity-0 transition-all duration-300" id="profileAlertModalContent">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4" id="profileAlertContainer">
                    <i class="fas fa-exclamation-triangle text-white text-2xl" id="profileAlertIcon"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2" id="profileAlertTitle">Alert</h3>
                <p class="text-gray-600 mb-6" id="profileAlertMessage">This is an alert message.</p>
                <button onclick="closeProfileAlert()" class="bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white px-8 py-3 rounded-xl font-semibold hover:from-[#7bb02d] hover:to-[#d15a8a] transition-all shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="fas fa-check mr-2"></i>OK
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Use the global currentUser variable from scripts.blade.php
    
    // Custom alert function for profile page
    function showAlert(title, message, type = 'warning') {
        const alertModal = document.getElementById('profileAlertModal');
        
        if (!alertModal) {
            console.error('Profile alert modal not found. Falling back to default alert.');
            alert(`${title}: ${message}`);
            return;
        }
        
        const alertTitle = document.getElementById('profileAlertTitle');
        const alertMessage = document.getElementById('profileAlertMessage');
        const alertIcon = document.getElementById('profileAlertIcon');
        const alertContainer = document.getElementById('profileAlertContainer');
        
        if (!alertTitle || !alertMessage || !alertIcon || !alertContainer) {
            console.error('Profile alert modal elements not found. Falling back to default alert.');
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
        const content = document.getElementById('profileAlertModalContent');
        if (content) {
            setTimeout(() => {
                content.style.transform = 'scale(1)';
                content.style.opacity = '1';
            }, 10);
        }
    }

    function closeProfileAlert() {
        const alertModal = document.getElementById('profileAlertModal');
        const content = document.getElementById('profileAlertModalContent');
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
        // Check if user is logged in
        checkAuthenticationStatus();
        
        // Load token balance
        updateTokenBalance();
        
        
        // Try to load user profile from localStorage first, then from API
        if (!loadUserFromLocalStorage()) {
            loadUserProfile();
        } else {
            // Still try to load from API to get the latest data
            loadUserProfile();
        }
        
        // Setup form handlers
        setupFormHandlers();
        
        // Setup password strength checker
        setupPasswordStrengthChecker();
    });
    
    function checkAuthenticationStatus() {
        const token = localStorage.getItem('token') || localStorage.getItem('access_token');
        const user = localStorage.getItem('user');
        
        if (!token || !user) {
            showAlert('Authentication Required', 'Please log in to access your profile.', 'warning');
            setTimeout(() => {
                window.location.href = '/';
            }, 2000);
            return false;
        }
        
        return true;
    }
    
    
    function updateTokenBalance() {
        const storedDashboard = localStorage.getItem('dashboard');
        const tokenBalanceElement = document.getElementById('tokenBalance');
        const availableMinutesElement = document.getElementById('availableMinutes');
        
        if (storedDashboard) {
            try {
                const dashboard = JSON.parse(storedDashboard);
                if (tokenBalanceElement) {
                    tokenBalanceElement.textContent = `${dashboard.token_balance || 0} Tokens`;
                }
                if (availableMinutesElement) {
                    availableMinutesElement.textContent = `${dashboard.available_minutes || 0} Minutes`;
                }
            } catch (e) {
                console.error('Error parsing dashboard data:', e);
                if (tokenBalanceElement) {
                    tokenBalanceElement.textContent = '0 Tokens';
                }
                if (availableMinutesElement) {
                    availableMinutesElement.textContent = '0 Minutes';
                }
            }
        } else {
            if (tokenBalanceElement) {
                tokenBalanceElement.textContent = '0 Tokens';
            }
            if (availableMinutesElement) {
                availableMinutesElement.textContent = '0 Minutes';
            }
        }
    }
    
    async function loadUserProfile() {
        try {
            const token = localStorage.getItem('token');
            if (!token) {
                throw new Error('No authentication token found');
            }
            
            const response = await fetch(`${API_BASE_URL}/api/profile`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success && data.data) {
                window.currentUser = data.data;
                populateProfileForm(data.data);
            } else {
                console.error('Profile API returned error:', data);
                const errorMessage = data.message || 'Failed to load profile information';
                
                // Try to load from localStorage as fallback
                if (!window.currentUser) {
                    const fallbackLoaded = loadUserFromLocalStorage();
                    if (fallbackLoaded) {
                        showAlert('Warning', 'Using cached profile data. Some information may be outdated.', 'warning');
                        return;
                    }
                }
                
                showAlert('Error', errorMessage, 'error');
            }
        } catch (error) {
            console.error('Error loading profile:', error);
            
            // Try to load from localStorage as fallback
            if (!window.currentUser) {
                const fallbackLoaded = loadUserFromLocalStorage();
                if (fallbackLoaded) {
                    showAlert('Warning', 'Using cached profile data. Some information may be outdated.', 'warning');
                    return;
                }
            }
            
            showAlert('Error', `Failed to load profile information: ${error.message}`, 'error');
        }
    }
    
    function populateProfileForm(user) {
        
        // Update header
        document.getElementById('userName').textContent = user.name || user.full_name || 'User';
        document.getElementById('userEmail').textContent = user.email || user.phone_number || 'No contact info';
        document.getElementById('userType').textContent = user.user_type ? user.user_type.charAt(0).toUpperCase() + user.user_type.slice(1) : 'User';
        
        // Populate form fields
        document.getElementById('profileName').value = user.name || user.full_name || '';
        document.getElementById('profileEmail').value = user.email || '';
        document.getElementById('profilePhone').value = user.phone_number || user.phone || '';
        document.getElementById('profileGrade').value = user.grade_level || user.grade || '';
    }
    
    function loadUserFromLocalStorage() {
        try {
            const storedUser = localStorage.getItem('user');
            if (storedUser) {
                const user = JSON.parse(storedUser);
                window.currentUser = user;
                populateProfileForm(user);
                return true;
            }
        } catch (error) {
            console.error('Error loading user from localStorage:', error);
        }
        return false;
    }
    
    function setupFormHandlers() {
        // Profile form handler
        document.getElementById('profileForm').addEventListener('submit', handleProfileUpdate);
        
        // Password form handler
        document.getElementById('passwordForm').addEventListener('submit', handlePasswordChange);
    }
    
    async function handleProfileUpdate(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const profileData = {
            name: formData.get('name'),
            email: formData.get('email'),
            phone_number: formData.get('phone_number'),
            grade_level: formData.get('grade_level')
        };
        
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/profile`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(profileData)
            });
            
            const data = await response.json();
            
            if (data.success) {
                showAlert('Success', 'Profile updated successfully!', 'success');
                // Update the displayed user info
                if (window.currentUser) {
                    Object.assign(window.currentUser, profileData);
                    populateProfileForm(window.currentUser);
                }
            } else {
                const errorMessage = data.message || 'Failed to update profile';
                showAlert('Error', errorMessage, 'error');
            }
        } catch (error) {
            console.error('Error updating profile:', error);
            showAlert('Error', 'Failed to update profile. Please try again.', 'error');
        }
    }
    
    async function handlePasswordChange(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const passwordData = {
            current_password: formData.get('current_password'),
            password: formData.get('password'),
            password_confirmation: formData.get('password_confirmation')
        };
        
        // Validate passwords match
        if (passwordData.password !== passwordData.password_confirmation) {
            showAlert('Error', 'New passwords do not match', 'error');
            return;
        }
        
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/password`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(passwordData)
            });
            
            const data = await response.json();
            
            if (data.success) {
                showAlert('Success', 'Password changed successfully!', 'success');
                // Clear password form
                event.target.reset();
                resetPasswordStrength();
            } else {
                const errorMessage = data.message || 'Failed to change password';
                showAlert('Error', errorMessage, 'error');
            }
        } catch (error) {
            console.error('Error changing password:', error);
            showAlert('Error', 'Failed to change password. Please try again.', 'error');
        }
    }
    
    function switchTab(tabName) {
        // Update tab buttons
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        event.target.classList.add('active');
        
        // Show/hide tab content
        document.querySelectorAll('.tab-content').forEach(content => content.classList.add('hidden'));
        document.getElementById(tabName + 'Tab').classList.remove('hidden');
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
    
    function setupPasswordStrengthChecker() {
        const newPasswordInput = document.getElementById('newPassword');
        const confirmPasswordInput = document.getElementById('confirmPassword');
        
        newPasswordInput.addEventListener('input', checkPasswordStrength);
        confirmPasswordInput.addEventListener('input', checkPasswordMatch);
    }
    
    function checkPasswordStrength() {
        const password = document.getElementById('newPassword').value;
        const strengthBars = [
            document.getElementById('strengthBar1'),
            document.getElementById('strengthBar2'),
            document.getElementById('strengthBar3'),
            document.getElementById('strengthBar4')
        ];
        const strengthText = document.getElementById('passwordStrengthText');
        
        let strength = 0;
        let strengthLabel = '';
        
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        // Reset all bars
        strengthBars.forEach(bar => {
            bar.className = 'password-strength flex-1 bg-gray-200';
        });
        
        if (strength === 0) {
            strengthLabel = 'Enter a password to see strength';
        } else if (strength <= 2) {
            strengthLabel = 'Weak password';
            strengthBars[0].className = 'password-strength flex-1 strength-weak';
        } else if (strength <= 3) {
            strengthLabel = 'Medium password';
            strengthBars[0].className = 'password-strength flex-1 strength-medium';
            strengthBars[1].className = 'password-strength flex-1 strength-medium';
        } else if (strength <= 4) {
            strengthLabel = 'Strong password';
            strengthBars[0].className = 'password-strength flex-1 strength-strong';
            strengthBars[1].className = 'password-strength flex-1 strength-strong';
            strengthBars[2].className = 'password-strength flex-1 strength-strong';
        } else {
            strengthLabel = 'Very strong password';
            strengthBars.forEach(bar => {
                bar.className = 'password-strength flex-1 strength-strong';
            });
        }
        
        strengthText.textContent = strengthLabel;
    }
    
    function checkPasswordMatch() {
        const password = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const matchDiv = document.getElementById('passwordMatch');
        
        if (confirmPassword === '') {
            matchDiv.innerHTML = '';
            return;
        }
        
        if (password === confirmPassword) {
            matchDiv.innerHTML = '<p class="text-sm text-green-600"><i class="fas fa-check mr-1"></i>Passwords match</p>';
        } else {
            matchDiv.innerHTML = '<p class="text-sm text-red-600"><i class="fas fa-times mr-1"></i>Passwords do not match</p>';
        }
    }
    
    function resetPasswordStrength() {
        const strengthBars = [
            document.getElementById('strengthBar1'),
            document.getElementById('strengthBar2'),
            document.getElementById('strengthBar3'),
            document.getElementById('strengthBar4')
        ];
        const strengthText = document.getElementById('passwordStrengthText');
        const matchDiv = document.getElementById('passwordMatch');
        
        strengthBars.forEach(bar => {
            bar.className = 'password-strength flex-1 bg-gray-200';
        });
        strengthText.textContent = 'Enter a password to see strength';
        matchDiv.innerHTML = '';
    }
</script>
@endsection
