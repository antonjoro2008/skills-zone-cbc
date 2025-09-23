@extends('layouts.app')

@section('title', 'Institution Dashboard - Gravity CBC')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 text-center">
            <h1 class="text-4xl font-bold mb-4">Institution Dashboard</h1>
            <p class="text-xl text-gray-100">Manage your learners and track their progress</p>
            
            <!-- Institution Information -->
            <div class="mt-6 bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 max-w-4xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                    <div>
                        <h3 class="text-lg font-semibold mb-2 text-white">Institution Details</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-school w-5 mr-3 text-blue-300"></i>
                                <span id="institutionName" class="text-white font-medium">Loading...</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-envelope w-5 mr-3 text-blue-300"></i>
                                <span id="institutionEmail" class="text-white font-medium">Loading...</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone w-5 mr-3 text-blue-300"></i>
                                <span id="institutionPhone" class="text-white font-medium">Loading...</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt w-5 mr-3 text-blue-300"></i>
                                <span id="institutionAddress" class="text-white font-medium">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2 text-white">Admin Information</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center">
                                <i class="fas fa-user w-5 mr-3 text-blue-300"></i>
                                <span id="adminName" class="text-white font-medium">Loading...</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-envelope w-5 mr-3 text-blue-300"></i>
                                <span id="adminEmail" class="text-white font-medium">Loading...</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-coins w-5 mr-3 text-yellow-300"></i>
                                <span id="tokenBalance" class="text-yellow-200 font-semibold">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 py-16">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-users text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Learners</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalLearners">
                            <i class="fas fa-spinner fa-spin text-gray-400"></i>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-user-check text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Active Learners</p>
                        <p class="text-2xl font-bold text-gray-900" id="activeLearners">
                            <i class="fas fa-spinner fa-spin text-gray-400"></i>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-coins text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Tokens</p>
                        <p class="text-2xl font-bold text-gray-900" id="totalTokens">
                            <i class="fas fa-spinner fa-spin text-gray-400"></i>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-chart-line text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Avg Tokens</p>
                        <p class="text-2xl font-bold text-gray-900" id="averageTokens">
                            <i class="fas fa-spinner fa-spin text-gray-400"></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-4">
                <button onclick="showAddLearnerModal()" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="fas fa-user-plus mr-2"></i>
                    Add New Learner
                </button>
                <button onclick="showBulkUploadModal()" class="bg-gradient-to-r from-green-600 to-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-green-700 hover:to-blue-700 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="fas fa-upload mr-2"></i>
                    Bulk Upload
                </button>
                <button onclick="refreshLearners()" class="bg-white border-2 border-blue-600 text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-blue-50 transition-all">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh
                </button>
            </div>
        </div>
        
        <!-- Learners Table -->
        <div class="bg-white rounded-3xl shadow-lg p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-900">Learners Management</h3>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" id="searchLearners" placeholder="Search learners..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Name</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Email</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Grade Level</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="learnersTableBody">
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                <i class="fas fa-spinner fa-spin text-2xl mb-2"></i>
                                <p>Loading learners...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let learnersData = [];
    
    document.addEventListener('DOMContentLoaded', function() {
        // Load current user data
        loadCurrentUser();
        loadDashboardData();
        loadLearners();
        
        // Search functionality
        document.getElementById('searchLearners').addEventListener('input', function(e) {
            filterLearners(e.target.value);
        });
    });
    
    function loadCurrentUser() {
        try {
            const userData = localStorage.getItem('user');
            if (userData) {
                // currentUser is already declared globally in scripts.blade.php
                window.currentUser = JSON.parse(userData);
                console.log('Current user loaded:', window.currentUser);
                
                // Display institution and admin information
                displayInstitutionInfo();
            } else {
                console.warn('No user data found in localStorage');
            }
        } catch (error) {
            console.error('Error loading current user:', error);
        }
    }
    
    function displayInstitutionInfo() {
        if (!window.currentUser) return;
        
        // Display institution information
        const institution = window.currentUser.institution;
        if (institution) {
            document.getElementById('institutionName').textContent = institution.name || 'N/A';
            document.getElementById('institutionEmail').textContent = institution.email || 'N/A';
            document.getElementById('institutionPhone').textContent = institution.phone || 'N/A';
            document.getElementById('institutionAddress').textContent = institution.address || 'N/A';
        }
        
        // Display admin information
        document.getElementById('adminName').textContent = window.currentUser.name || 'N/A';
        document.getElementById('adminEmail').textContent = window.currentUser.email || 'N/A';
        
        // Display token balance from dashboard data
        const dashboardData = localStorage.getItem('dashboard');
        if (dashboardData) {
            try {
                const dashboard = JSON.parse(dashboardData);
                document.getElementById('tokenBalance').textContent = `${dashboard.token_balance || 0} Tokens`;
            } catch (error) {
                console.error('Error parsing dashboard data:', error);
                document.getElementById('tokenBalance').textContent = '0 Tokens';
            }
        } else {
            document.getElementById('tokenBalance').textContent = '0 Tokens';
        }
    }
    
    function standardizePhoneNumber(phone) {
        if (!phone) return '';
        
        // Remove all non-numeric characters
        let cleanPhone = phone.replace(/\D/g, '');
        
        // Handle different formats
        if (cleanPhone.startsWith('254')) {
            return cleanPhone; // Already in correct format
        } else if (cleanPhone.startsWith('07') && cleanPhone.length === 10) {
            return '254' + cleanPhone.substring(1); // 07XXXXXXXX -> 254XXXXXXXX
        } else if (cleanPhone.startsWith('7') && cleanPhone.length === 9) {
            return '254' + cleanPhone; // 7XXXXXXXX -> 2547XXXXXXXX
        } else if (cleanPhone.startsWith('01') && cleanPhone.length === 10) {
            return '254' + cleanPhone.substring(1); // 01XXXXXXXX -> 254XXXXXXXX
        } else if (cleanPhone.startsWith('1') && cleanPhone.length === 9) {
            return '254' + cleanPhone; // 1XXXXXXXX -> 2541XXXXXXXX
        }
        
        return cleanPhone; // Return as-is if no pattern matches
    }
    
    function showAlert(title, message, type = 'info') {
        // Create custom alert modal directly
        const alertModal = document.createElement('div');
        alertModal.className = 'fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-4';
        alertModal.innerHTML = `
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 relative">
                <div class="text-center">
                    <div class="w-16 h-16 ${type === 'success' ? 'bg-green-100' : type === 'error' ? 'bg-red-100' : 'bg-blue-100'} rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas ${type === 'success' ? 'fa-check text-green-600' : type === 'error' ? 'fa-times text-red-600' : 'fa-info text-blue-600'} text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">${title}</h3>
                    <p class="text-gray-600 mb-6">${message}</p>
                    <button onclick="this.closest('.fixed').remove()" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all">
                        OK
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(alertModal);
    }
    
    async function loadDashboardData() {
        try {
            // For now, we'll use the user data from localStorage to populate dashboard stats
            // The dashboard data is already available from the login response
            const dashboardData = localStorage.getItem('dashboard');
            if (dashboardData) {
                const dashboard = JSON.parse(dashboardData);
                updateDashboardStats(dashboard);
            } else {
                // Set default values if no dashboard data is available
                setDefaultDashboardStats();
            }
        } catch (error) {
            console.error('Error loading dashboard:', error);
            setDefaultDashboardStats();
        }
    }
    
    function setDefaultDashboardStats() {
        document.getElementById('totalLearners').textContent = '0';
        document.getElementById('activeLearners').textContent = '0';
        document.getElementById('totalTokens').textContent = '0';
        document.getElementById('averageTokens').textContent = '0';
    }
    
    async function loadLearners() {
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/institution/students`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                learnersData = data.data.data; // The students are in data.data.data due to pagination
                renderLearnersTable(learnersData);
                updateLearnerStats(learnersData);
            } else {
                showError('Failed to load learners');
            }
        } catch (error) {
            console.error('Error loading learners:', error);
            showError('Error loading learners');
        }
    }
    
    function updateLearnerStats(learners) {
        const totalLearners = learners.length;
        const activeLearners = learners.filter(learner => learner.is_active !== false).length;
        
        document.getElementById('totalLearners').textContent = totalLearners;
        document.getElementById('activeLearners').textContent = activeLearners;
        
        // Update token stats from dashboard data
        const dashboardData = localStorage.getItem('dashboard');
        if (dashboardData) {
            const dashboard = JSON.parse(dashboardData);
            document.getElementById('totalTokens').textContent = dashboard.token_balance || 0;
            document.getElementById('averageTokens').textContent = totalLearners > 0 ? Math.round((dashboard.token_balance || 0) / totalLearners) : 0;
        }
    }
    
    function updateDashboardStats(data) {
        // Handle the actual dashboard data structure from login response
        // The dashboard data contains token_balance and assessment_stats
        const tokenBalance = data.token_balance || 0;
        const assessmentStats = data.assessment_stats || {};
        
        // Set token balance
        document.getElementById('totalTokens').textContent = tokenBalance;
        
        // For now, set default values for learner stats since they're not in the dashboard data
        // These will be updated when learners are loaded
        document.getElementById('totalLearners').textContent = '0';
        document.getElementById('activeLearners').textContent = '0';
        document.getElementById('averageTokens').textContent = '0';
    }
    
    function renderLearnersTable(learners) {
        const tbody = document.getElementById('learnersTableBody');
        
        if (learners.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-500">
                        <i class="fas fa-users text-4xl mb-4"></i>
                        <p>No learners found. Add your first learner to get started!</p>
                    </td>
                </tr>
            `;
            return;
        }
        
        tbody.innerHTML = learners.map(learner => `
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="py-4 px-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <span class="font-medium text-gray-900">${learner.name}</span>
                            <div class="text-xs text-gray-500">${learner.admission_number || 'N/A'}</div>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-4 text-gray-600">${learner.email || 'N/A'}</td>
                <td class="py-4 px-4">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                        ${learner.grade_level || 'N/A'}
                    </span>
                </td>
                <td class="py-4 px-4">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold ${learner.is_active !== false ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                        ${learner.is_active !== false ? 'Active' : 'Inactive'}
                    </span>
                </td>
                <td class="py-4 px-4">
                    <div class="flex items-center space-x-2">
                        <button onclick="editLearner(${learner.id}, '${learner.name}', '${learner.admission_number || ''}', '${learner.email || ''}', '${learner.grade_level || ''}')" class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded-lg transition-all" title="Edit Learner">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="deleteLearner(${learner.id}, '${learner.name}')" class="text-red-600 hover:text-red-800 p-2 hover:bg-red-50 rounded-lg transition-all" title="Delete Learner">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }
    
    function filterLearners(searchTerm) {
        const filtered = learnersData.filter(learner => 
            learner.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
            (learner.email && learner.email.toLowerCase().includes(searchTerm.toLowerCase())) ||
            (learner.admission_number && learner.admission_number.toLowerCase().includes(searchTerm.toLowerCase())) ||
            (learner.grade_level && learner.grade_level.toLowerCase().includes(searchTerm.toLowerCase()))
        );
        renderLearnersTable(filtered);
    }
    
    function refreshLearners() {
        loadLearners();
        loadDashboardData();
    }
    
    function showError(message) {
        // Use the beautiful showAlert function
        showAlert('Error', message, 'error');
    }
    
    function showAddLearnerModal() {
        showModal('addLearnerModal');
    }
    
    function showBulkUploadModal() {
        showModal('bulkUploadModal');
    }
    
    function showBuyTokensModal() {
        const modal = document.getElementById('buyTokensModal');
        if (modal) {
            modal.classList.remove('hidden');
            // Initialize the modal with user data
            if (window.currentUser && window.currentUser.phone_number) {
                const phoneInput = document.getElementById('buyTokensMpesaPhone');
                if (phoneInput) {
                    phoneInput.value = window.currentUser.phone_number;
                }
            }
            // Initialize token calculation
            calculateTokens();
        } else {
            console.error('Buy tokens modal not found');
        }
    }
    
    function calculateTokens() {
        const amount = parseFloat(document.getElementById('buyTokensAmount').value) || 0;
        const tokens = Math.floor(amount / 1); // 1 KES = 1 token
        
        const displayAmount = document.getElementById('displayAmount');
        const displayTokens = document.getElementById('displayTokens');
        
        if (displayAmount) {
            displayAmount.textContent = `KES ${amount.toLocaleString()}`;
        }
        if (displayTokens) {
            displayTokens.textContent = `${tokens} token${tokens !== 1 ? 's' : ''}`;
        }
    }
    
    function closeBuyTokensModal() {
        const modal = document.getElementById('buyTokensModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }
    
    async function buyTokens(event) {
        event.preventDefault();
        
        if (!window.currentUser) {
            showAlert('Authentication Required', 'Please log in to purchase tokens.', 'warning');
            return;
        }
        
        const amount = parseFloat(document.getElementById('buyTokensAmount').value);
        const phoneNumber = document.getElementById('buyTokensMpesaPhone').value;
        
        // Always format phone number to 2547... or 2541... format
        const formattedPhoneNumber = standardizePhoneNumber(phoneNumber);
        
        // Validate inputs
        if (!amount || amount < 1) {
            showAlert('Invalid Amount', 'Please enter an amount of at least KES 1.', 'error');
            return;
        }
        
        if (!formattedPhoneNumber || !formattedPhoneNumber.match(/^254[0-9]{9}$/)) {
            showAlert('Invalid Phone Number', 'Please enter a valid M-PESA phone number.', 'error');
            return;
        }
        
        const tokens = Math.floor(amount / 1);
        
        // Show loading state
        const submitBtn = event.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
        submitBtn.disabled = true;
        
        try {
            const response = await fetch(`${API_BASE_URL}/api/payments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify({
                    amount: amount,
                    channel: 'mpesa',
                    currency: 'KES',
                    tokens: tokens,
                    phone_number: formattedPhoneNumber,
                    user_id: window.currentUser.id
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                showAlert('Payment Initiated', data.message || 'Payment request sent to your phone. Please complete the payment to receive your tokens.', 'success');
                closeBuyTokensModal();
                
                // Clear form
                document.getElementById('buyTokensAmount').value = '';
                document.getElementById('buyTokensMpesaPhone').value = '';
                calculateTokens();
            } else {
                const errorMessage = extractErrorMessage(data, 'Failed to initiate payment. Please try again.');
                showAlert('Payment Failed', errorMessage, 'error');
            }
        } catch (error) {
            console.error('Payment error:', error);
            showAlert('Network Error', 'Unable to process payment. Please check your connection and try again.', 'error');
        } finally {
            // Restore button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }
    
    async function addLearner(event) {
        event.preventDefault();
        
        const name = document.getElementById('learnerName').value;
        const admissionNumber = document.getElementById('learnerAdmissionNumber').value;
        const email = document.getElementById('learnerEmail').value;
        const gradeLevel = document.getElementById('learnerGradeLevel').value;
        const password = document.getElementById('learnerPassword').value;
        
        // Validate required fields (email is optional)
        if (!name || !admissionNumber || !gradeLevel || !password) {
            showAlert('Validation Error', 'Please fill in all required fields.', 'error');
            return;
        }
        
        // Validate password length
        if (password.length < 6) {
            showAlert('Validation Error', 'Password must be at least 6 characters long.', 'error');
            return;
        }
        
        // Show loading state
        const submitBtn = event.target.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Student...';
        submitBtn.disabled = true;
        
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/institution/students`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    name: name,
                    admission_number: admissionNumber,
                    email: email || null,
                    password: password,
                    password_confirmation: password,
                    grade_level: gradeLevel
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                showAlert('Success', data.message || 'Student created successfully!', 'success');
                closeModal('addLearnerModal');
                refreshLearners();
                
                // Clear form
                document.getElementById('learnerName').value = '';
                document.getElementById('learnerAdmissionNumber').value = '';
                document.getElementById('learnerEmail').value = '';
                document.getElementById('learnerGradeLevel').value = '';
                document.getElementById('learnerPassword').value = '';
            } else {
                const errorMessage = extractErrorMessage(data, 'Failed to create student. Please try again.');
                showAlert('Error', errorMessage, 'error');
            }
        } catch (error) {
            console.error('Error creating student:', error);
            showAlert('Network Error', 'Unable to create student. Please check your connection and try again.', 'error');
        } finally {
            // Restore button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }
    
    async function processBulkUpload() {
        const fileInput = document.getElementById('csvFile');
        const file = fileInput.files[0];
        
        if (!file) {
            showAlert('Validation Error', 'Please select a CSV file', 'error');
            return;
        }
        
        // Show loading state
        const submitBtn = document.querySelector('#bulkUploadModal button[onclick="processBulkUpload()"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
        submitBtn.disabled = true;
        
        try {
            const text = await file.text();
            const lines = text.split('\n').filter(line => line.trim()); // Remove empty lines
            
            if (lines.length < 2) {
                showAlert('Validation Error', 'CSV file must have at least a header and one data row', 'error');
                return;
            }
            
            // Simple CSV parsing function
            function parseCSVLine(line) {
                const result = [];
                let current = '';
                let inQuotes = false;
                
                for (let i = 0; i < line.length; i++) {
                    const char = line[i];
                    if (char === '"') {
                        inQuotes = !inQuotes;
                    } else if (char === ',' && !inQuotes) {
                        result.push(current.trim());
                        current = '';
                    } else {
                        current += char;
                    }
                }
                result.push(current.trim());
                return result;
            }
            
            const headers = parseCSVLine(lines[0]);
            
            // Validate headers - updated for new API format
            const expectedHeaders = ['name', 'admission_number', 'email', 'grade_level', 'password'];
            if (!expectedHeaders.every(header => headers.includes(header))) {
                showAlert('Validation Error', 'Invalid CSV format. Required headers: name, admission_number, email, grade_level, password', 'error');
                return;
            }
            
            const students = [];
            for (let i = 1; i < lines.length; i++) {
                const line = lines[i].trim();
                if (!line) continue;
                
                const values = parseCSVLine(line);
                if (values.length >= 5) {
                    // Validate required fields
                    if (!values[0] || !values[1] || !values[3] || !values[4]) {
                        showAlert('Validation Error', `Row ${i + 1}: All required fields (name, admission_number, grade_level, password) must be filled`, 'error');
                        return;
                    }
                    
                    // Validate password length
                    if (values[4].length < 8) {
                        showAlert('Validation Error', `Row ${i + 1}: Password must be at least 8 characters long`, 'error');
                        return;
                    }
                    
                    students.push({
                        name: values[0],
                        admission_number: values[1],
                        email: values[2] || null, // Email is optional
                        grade_level: values[3],
                        password: values[4]
                    });
                }
            }
            
            if (students.length === 0) {
                showAlert('Validation Error', 'No valid students found in the CSV file', 'error');
                return;
            }
            
            if (students.length > 100) {
                showAlert('Validation Error', 'Maximum 100 students allowed per upload', 'error');
                return;
            }
            
            // Upload students using the multiple students API
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/institution/students/multiple`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ students })
            });
            
            const data = await response.json();
            
            if (data.success) {
                showAlert('Success', data.message || `${students.length} students created successfully!`, 'success');
                closeModal('bulkUploadModal');
                refreshLearners();
                
                // Clear file input
                fileInput.value = '';
            } else {
                const errorMessage = extractErrorMessage(data, 'Failed to process bulk upload');
                showAlert('Error', errorMessage, 'error');
            }
        } catch (error) {
            console.error('Error processing bulk upload:', error);
            showAlert('Network Error', 'Error processing CSV file. Please check the format and try again.', 'error');
        } finally {
            // Restore button state
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }

    // Edit learner function
    function editLearner(id, name, admissionNumber, email, gradeLevel) {
        // Create edit modal
        const editModal = document.createElement('div');
        editModal.className = 'fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-2 sm:p-4';
        editModal.id = 'editLearnerModal';
        editModal.innerHTML = `
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full relative modal-content flex flex-col max-h-[95vh] sm:max-h-[80vh]">
                <!-- Sticky Header -->
                <div class="sticky top-0 bg-white rounded-t-2xl p-4 sm:p-6 pb-3 sm:pb-4 border-b border-gray-100 z-10">
                    <button class="absolute top-3 right-3 sm:top-4 sm:right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-all" onclick="closeEditModal(this.closest('.fixed'))">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                    
                    <div class="text-center pr-8">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-2 sm:mb-3">
                            <i class="fas fa-edit text-white text-lg sm:text-xl"></i>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1">Edit Learner</h3>
                        <p class="text-gray-600 text-xs sm:text-sm">Update learner information</p>
                    </div>
                </div>
                
                <!-- Scrollable Content -->
                <div class="flex-1 overflow-y-auto p-4 sm:p-6 pt-3 sm:pt-4">
                    <form id="editLearnerForm" class="space-y-3 sm:space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" id="editLearnerName" class="form-input w-full px-3 py-2.5 sm:py-2 rounded-lg text-sm" value="${name}" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Admission Number <span class="text-red-500">*</span></label>
                                <input type="text" id="editLearnerAdmissionNumber" class="form-input w-full px-3 py-2.5 sm:py-2 rounded-lg text-sm" value="${admissionNumber}" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Email</label>
                                <input type="email" id="editLearnerEmail" class="form-input w-full px-3 py-2.5 sm:py-2 rounded-lg text-sm" value="${email}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 sm:mb-2">Grade Level <span class="text-red-500">*</span></label>
                                <select id="editLearnerGradeLevel" class="form-input w-full px-3 py-2.5 sm:py-2 rounded-lg text-sm" required>
                                    <option value="">Select grade level</option>
                                    <option value="Grade 1" ${gradeLevel === 'Grade 1' ? 'selected' : ''}>Grade 1</option>
                                    <option value="Grade 2" ${gradeLevel === 'Grade 2' ? 'selected' : ''}>Grade 2</option>
                                    <option value="Grade 3" ${gradeLevel === 'Grade 3' ? 'selected' : ''}>Grade 3</option>
                                    <option value="Grade 4" ${gradeLevel === 'Grade 4' ? 'selected' : ''}>Grade 4</option>
                                    <option value="Grade 5" ${gradeLevel === 'Grade 5' ? 'selected' : ''}>Grade 5</option>
                                    <option value="Grade 6" ${gradeLevel === 'Grade 6' ? 'selected' : ''}>Grade 6</option>
                                    <option value="Grade 7" ${gradeLevel === 'Grade 7' ? 'selected' : ''}>Grade 7</option>
                                    <option value="Grade 8" ${gradeLevel === 'Grade 8' ? 'selected' : ''}>Grade 8</option>
                                    <option value="Grade 9" ${gradeLevel === 'Grade 9' ? 'selected' : ''}>Grade 9</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-3 sm:pt-4">
                            <button type="button" onclick="closeEditModal(this.closest('.fixed'))" class="w-full sm:flex-1 px-4 py-2.5 sm:py-2 border border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition-all text-sm">
                                Cancel
                            </button>
                            <button type="submit" class="w-full sm:flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2.5 sm:py-2 rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 transition-all text-sm">
                                Update Learner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        `;
        document.body.appendChild(editModal);

        // Add form submission handler
        document.getElementById('editLearnerForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            await updateLearner(id);
        });
    }

    // Close edit modal with smooth animation
    function closeEditModal(modal) {
        if (!modal) return;
        
        modal.style.transition = 'opacity 0.3s ease-out';
        modal.style.opacity = '0';
        setTimeout(() => {
            if (modal && modal.parentNode) {
                modal.remove();
            }
        }, 300);
    }

    // Update learner function
    async function updateLearner(learnerId) {
        const name = document.getElementById('editLearnerName').value.trim();
        const admissionNumber = document.getElementById('editLearnerAdmissionNumber').value.trim();
        const email = document.getElementById('editLearnerEmail').value.trim();
        const gradeLevel = document.getElementById('editLearnerGradeLevel').value;

        if (!name || !admissionNumber || !gradeLevel) {
            showAlert('Validation Error', 'Please fill in all required fields.', 'error');
            return;
        }

        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/institution/students/${learnerId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    name: name,
                    admission_number: admissionNumber,
                    email: email || null,
                    grade_level: gradeLevel
                })
            });

            const data = await response.json();

            if (data.success) {
                showAlert('Success', data.message || 'Learner updated successfully!', 'success');
                // Close modal with smooth animation after a short delay
                setTimeout(() => {
                    const editModal = document.getElementById('editLearnerModal');
                    if (editModal) {
                        closeEditModal(editModal);
                    }
                }, 100);
                // Reload learners
                loadLearners();
            } else {
                const errorMessage = extractErrorMessage(data, 'Failed to update learner');
                showAlert('Error', errorMessage, 'error');
            }
        } catch (error) {
            console.error('Error updating learner:', error);
            showAlert('Network Error', 'Unable to update learner. Please check your connection and try again.', 'error');
        }
    }

    // Delete learner function
    async function deleteLearner(learnerId, learnerName) {
        showConfirmDialog(
            'Delete Learner',
            `Are you sure you want to delete ${learnerName}? This action cannot be undone.`,
            'warning',
            async () => {
                await performDeleteLearner(learnerId);
            }
        );
    }

    // Perform delete learner function
    async function performDeleteLearner(learnerId) {
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/institution/students/${learnerId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();

            if (data.success) {
                showAlert('Success', data.message || 'Learner deleted successfully!', 'success');
                // Reload learners
                loadLearners();
            } else {
                const errorMessage = extractErrorMessage(data, 'Failed to delete learner');
                showAlert('Error', errorMessage, 'error');
            }
        } catch (error) {
            console.error('Error deleting learner:', error);
            showAlert('Network Error', 'Unable to delete learner. Please check your connection and try again.', 'error');
        }
    }

    // Custom confirmation dialog function
    function showConfirmDialog(title, message, type = 'warning', onConfirm = null) {
        const confirmModal = document.createElement('div');
        confirmModal.className = 'fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-4';
        confirmModal.innerHTML = `
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 relative">
                <div class="text-center">
                    <div class="w-16 h-16 ${type === 'warning' ? 'bg-yellow-100' : type === 'error' ? 'bg-red-100' : 'bg-blue-100'} rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas ${type === 'warning' ? 'fa-exclamation-triangle text-yellow-600' : type === 'error' ? 'fa-times text-red-600' : 'fa-info text-blue-600'} text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">${title}</h3>
                    <p class="text-gray-600 mb-6">${message}</p>
                    <div class="flex space-x-3">
                        <button id="cancelBtn" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                            Cancel
                        </button>
                        <button id="confirmBtn" class="flex-1 bg-gradient-to-r from-red-600 to-red-700 text-white py-3 rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(confirmModal);

        document.getElementById('cancelBtn').addEventListener('click', () => {
            confirmModal.remove();
        });

        document.getElementById('confirmBtn').addEventListener('click', () => {
            confirmModal.remove();
            if (onConfirm) {
                onConfirm();
            }
        });
    }
    
    function showSuccess(message) {
        // Use the beautiful showAlert function
        showAlert('Success', message, 'success');
    }
</script>
@endsection

