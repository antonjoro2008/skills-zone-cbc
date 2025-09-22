@extends('layouts.app')

@section('title', 'Parent Dashboard - Manage Learners')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-3xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Parent Dashboard</h1>
                    <p class="text-blue-100 text-lg">Manage your learners and track their progress</p>
                </div>
                <div class="text-right">
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-yellow-300 rounded-full flex items-center justify-center">
                                <i class="fas fa-coins text-yellow-800 text-xl"></i>
                            </div>
                            <div>
                                <p class="text-yellow-200 font-semibold">Token Balance</p>
                                <p class="text-white text-2xl font-bold" id="tokenBalance">0</p>
                            </div>
                        </div>
                        <div class="text-sm text-blue-100">
                            <p class="text-white font-medium">Parent: <span id="parentName">Loading...</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 mb-8">
            <button onclick="showAddLearnerModal()" class="bg-gradient-to-r from-green-600 to-emerald-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-green-700 hover:to-emerald-700 transition-all flex items-center space-x-2">
                <i class="fas fa-plus"></i>
                <span>Add Learner</span>
            </button>
            <button onclick="showBulkUploadModal()" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all flex items-center space-x-2">
                <i class="fas fa-upload"></i>
                <span>Bulk Upload</span>
            </button>
            <button onclick="showBuyTokensModal()" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all flex items-center space-x-2">
                <i class="fas fa-coins"></i>
                <span>Buy Tokens</span>
            </button>
        </div>

        <!-- Learners Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">My Learners</h2>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" id="searchLearners" placeholder="Search learners..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade Level</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Added Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="learnersTableBody" class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                                    <p class="text-lg font-medium">No learners found</p>
                                    <p class="text-sm">Add your first learner to get started</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Learner Modal -->
<div id="addLearnerModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 relative">
        <button onclick="closeAddLearnerModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="mb-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Add New Learner</h3>
            <p class="text-gray-600">Add a new learner to your account</p>
        </div>
        <form id="addLearnerForm" onsubmit="addLearner(event)">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Learner Name *</label>
                    <input type="text" id="learnerName" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter learner's full name">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Grade Level *</label>
                    <select id="learnerGradeLevel" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Grade Level</option>
                        <option value="Grade 1">Grade 1</option>
                        <option value="Grade 2">Grade 2</option>
                        <option value="Grade 3">Grade 3</option>
                        <option value="Grade 4">Grade 4</option>
                        <option value="Grade 5">Grade 5</option>
                        <option value="Grade 6">Grade 6</option>
                        <option value="Grade 7">Grade 7</option>
                        <option value="Grade 8">Grade 8</option>
                        <option value="Form 1">Form 1</option>
                        <option value="Form 2">Form 2</option>
                        <option value="Form 3">Form 3</option>
                        <option value="Form 4">Form 4</option>
                    </select>
                </div>
            </div>
            <div class="flex space-x-3 mt-6">
                <button type="button" onclick="closeAddLearnerModal()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                    Cancel
                </button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 rounded-xl font-semibold hover:from-green-700 hover:to-emerald-700 transition-all">
                    Add Learner
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Upload Modal -->
<div id="bulkUploadModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 relative">
        <button onclick="closeBulkUploadModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="mb-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Bulk Upload Learners</h3>
            <p class="text-gray-600">Upload multiple learners at once using CSV format</p>
        </div>
        <div class="space-y-6">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <h4 class="font-semibold text-blue-900 mb-2">CSV Format Instructions:</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• CSV should have headers: <code class="bg-blue-100 px-2 py-1 rounded">name, grade_level</code></li>
                    <li>• Each learner must have a unique name</li>
                    <li>• Grade levels should be: Grade 1-8 or Form 1-4</li>
                    <li>• Maximum 50 learners per upload</li>
                </ul>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Select CSV File</label>
                <input type="file" id="csvFile" accept=".csv" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="closeBulkUploadModal()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                    Cancel
                </button>
                <button onclick="processBulkUpload()" class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-pink-700 transition-all">
                    Upload Learners
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let learnersData = [];

    // Load current user and display parent info
    function loadCurrentUser() {
        const userData = localStorage.getItem('currentUser');
        if (userData) {
            window.currentUser = JSON.parse(userData);
            displayParentInfo();
        }
    }

    function displayParentInfo() {
        if (window.currentUser) {
            document.getElementById('parentName').textContent = window.currentUser.name;
            document.getElementById('tokenBalance').textContent = window.currentUser.wallet?.balance || 0;
        }
    }

    // Load learners from API
    async function loadLearners() {
        try {
            const response = await fetch(`${API_BASE_URL}/api/parent/learners`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                if (response.status === 404) {
                    // API endpoint doesn't exist yet
                    showAlert('Feature Coming Soon', 'Parent learner management is currently under development. This feature will be available soon!', 'info');
                    renderLearnersTable([]);
                    return;
                }
                throw new Error('Failed to load learners');
            }

            const result = await response.json();
            if (result.success) {
                learnersData = result.data;
                renderLearnersTable(learnersData);
            }
        } catch (error) {
            console.error('Error loading learners:', error);
            if (error.message.includes('Failed to fetch') || error.message.includes('500')) {
                showAlert('Feature Coming Soon', 'Parent learner management is currently under development. This feature will be available soon!', 'info');
                renderLearnersTable([]);
            } else {
                showAlert('Error', 'Failed to load learners. Please try again.', 'error');
            }
        }
    }

    function renderLearnersTable(learners) {
        const tbody = document.getElementById('learnersTableBody');
        
        if (learners.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                            <p class="text-lg font-medium">No learners found</p>
                            <p class="text-sm">Add your first learner to get started</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = learners.map(learner => `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-semibold">
                            ${learner.name.charAt(0).toUpperCase()}
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">${learner.name}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        ${learner.grade_level}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${new Date(learner.created_at).toLocaleDateString()}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button onclick="showAlert('Feature Coming Soon', 'Learner management features will be available soon.', 'info')" class="text-blue-600 hover:text-blue-900 mr-3">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button onclick="showAlert('Feature Coming Soon', 'Learner removal will be available soon.', 'info')" class="text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </td>
            </tr>
        `).join('');
    }

    // Search functionality
    function filterLearners(searchTerm) {
        const filtered = learnersData.filter(learner => 
            learner.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
            learner.grade_level.toLowerCase().includes(searchTerm.toLowerCase())
        );
        renderLearnersTable(filtered);
    }

    // Modal functions
    function showAddLearnerModal() {
        document.getElementById('addLearnerModal').classList.remove('hidden');
    }

    function closeAddLearnerModal() {
        document.getElementById('addLearnerModal').classList.add('hidden');
        document.getElementById('addLearnerForm').reset();
    }

    function showBulkUploadModal() {
        document.getElementById('bulkUploadModal').classList.remove('hidden');
    }

    function closeBulkUploadModal() {
        document.getElementById('bulkUploadModal').classList.add('hidden');
        document.getElementById('csvFile').value = '';
    }

    // Add learner function
    async function addLearner(event) {
        event.preventDefault();
        
        const name = document.getElementById('learnerName').value.trim();
        const gradeLevel = document.getElementById('learnerGradeLevel').value;

        if (!name || !gradeLevel) {
            showAlert('Validation Error', 'Please fill in all required fields.', 'error');
            return;
        }

        try {
            const response = await fetch(`${API_BASE_URL}/api/parent/learners`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    name: name,
                    grade_level: gradeLevel
                })
            });

            if (!response.ok) {
                if (response.status === 404 || response.status === 500) {
                    showAlert('Feature Coming Soon', 'Parent learner management is currently under development. This feature will be available soon!', 'info');
                    closeAddLearnerModal();
                    return;
                }
            }

            const result = await response.json();

            if (result.success) {
                showAlert('Success', 'Learner added successfully!', 'success');
                closeAddLearnerModal();
                loadLearners(); // Reload the table
            } else {
                showAlert('Error', result.message || 'Failed to add learner', 'error');
            }
        } catch (error) {
            console.error('Error adding learner:', error);
            if (error.message.includes('Failed to fetch') || error.message.includes('500')) {
                showAlert('Feature Coming Soon', 'Parent learner management is currently under development. This feature will be available soon!', 'info');
                closeAddLearnerModal();
            } else {
                showAlert('Error', 'Failed to add learner. Please try again.', 'error');
            }
        }
    }

    // Bulk upload function
    async function processBulkUpload() {
        const fileInput = document.getElementById('csvFile');
        const file = fileInput.files[0];

        if (!file) {
            showAlert('Validation Error', 'Please select a CSV file.', 'error');
            return;
        }

        if (!file.name.toLowerCase().endsWith('.csv')) {
            showAlert('Validation Error', 'Please select a valid CSV file.', 'error');
            return;
        }

        try {
            const text = await file.text();
            const lines = text.split('\n').filter(line => line.trim());
            
            if (lines.length < 2) {
                showAlert('Validation Error', 'CSV file must have at least a header and one data row.', 'error');
                return;
            }

            // Parse CSV
            const headers = lines[0].split(',').map(h => h.trim().toLowerCase());
            const requiredHeaders = ['name', 'grade_level'];
            
            if (!requiredHeaders.every(header => headers.includes(header))) {
                showAlert('Validation Error', 'CSV must have headers: name, grade_level', 'error');
                return;
            }

            const learners = [];
            for (let i = 1; i < lines.length; i++) {
                const values = lines[i].split(',').map(v => v.trim());
                if (values.length >= 2 && values[0] && values[1]) {
                    learners.push({
                        name: values[0],
                        grade_level: values[1]
                    });
                }
            }

            if (learners.length === 0) {
                showAlert('Validation Error', 'No valid learner data found in CSV.', 'error');
                return;
            }

            if (learners.length > 50) {
                showAlert('Validation Error', 'Maximum 50 learners allowed per upload.', 'error');
                return;
            }

            // Send to API
            const response = await fetch(`${API_BASE_URL}/api/parent/learners/multiple`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    learners: learners
                })
            });

            if (!response.ok) {
                if (response.status === 404 || response.status === 500) {
                    showAlert('Feature Coming Soon', 'Parent learner management is currently under development. This feature will be available soon!', 'info');
                    closeBulkUploadModal();
                    return;
                }
            }

            const result = await response.json();

            if (result.success) {
                showAlert('Success', `${learners.length} learners added successfully!`, 'success');
                closeBulkUploadModal();
                loadLearners(); // Reload the table
            } else {
                showAlert('Error', result.message || 'Failed to upload learners', 'error');
            }
        } catch (error) {
            console.error('Error processing bulk upload:', error);
            if (error.message.includes('Failed to fetch') || error.message.includes('500')) {
                showAlert('Feature Coming Soon', 'Parent learner management is currently under development. This feature will be available soon!', 'info');
                closeBulkUploadModal();
            } else {
                showAlert('Error', 'Failed to process CSV file. Please check the format and try again.', 'error');
            }
        }
    }

    // Use global showAlert function if available, otherwise create custom one
    function showAlert(title, message, type = 'info') {
        if (typeof window.showAlert === 'function') {
            window.showAlert(title, message, type);
        } else {
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
    }

    // Buy tokens modal functions
    function showBuyTokensModal() {
        document.getElementById('buyTokensModal').classList.remove('hidden');
        document.getElementById('phoneNumber').value = window.currentUser?.phone_number || '';
        calculateTokens();
    }

    function closeBuyTokensModal() {
        document.getElementById('buyTokensModal').classList.add('hidden');
        document.getElementById('buyTokensForm').reset();
    }

    function calculateTokens() {
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const tokens = Math.floor(amount / 10); // Assuming 10 KES per token
        document.getElementById('tokensToReceive').textContent = tokens;
    }

    async function buyTokens(event) {
        event.preventDefault();
        
        const amount = parseFloat(document.getElementById('amount').value);
        const phoneNumber = document.getElementById('phoneNumber').value.trim();

        if (!amount || amount < 10) {
            showAlert('Validation Error', 'Minimum amount is KES 10', 'error');
            return;
        }

        if (!phoneNumber) {
            showAlert('Validation Error', 'Please enter your phone number', 'error');
            return;
        }

        try {
            const formattedPhone = standardizePhoneNumber(phoneNumber);
            
            const response = await fetch(`${API_BASE_URL}/api/payments`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    amount: amount,
                    phone_number: formattedPhone
                })
            });

            const result = await response.json();

            if (result.success) {
                showAlert('Payment Initiated', 'Please check your phone to complete the payment.', 'success');
                closeBuyTokensModal();
            } else {
                showAlert('Payment Error', result.message || 'Failed to initiate payment', 'error');
            }
        } catch (error) {
            console.error('Error initiating payment:', error);
            showAlert('Error', 'Failed to initiate payment. Please try again.', 'error');
        }
    }

    function standardizePhoneNumber(phone) {
        // Remove all non-digit characters
        let cleanPhone = phone.replace(/\D/g, '');
        
        // Handle different formats
        if (cleanPhone.startsWith('254')) {
            return cleanPhone;
        } else if (cleanPhone.startsWith('07') || cleanPhone.startsWith('01')) {
            return '254' + cleanPhone.substring(1);
        } else if (cleanPhone.startsWith('7') || cleanPhone.startsWith('1')) {
            return '254' + cleanPhone;
        }
        
        return cleanPhone;
    }

    // Search functionality
    document.getElementById('searchLearners').addEventListener('input', function(e) {
        filterLearners(e.target.value);
    });

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        loadCurrentUser();
        loadLearners();
    });
</script>

<!-- Buy Tokens Modal -->
<div id="buyTokensModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 relative">
        <button onclick="closeBuyTokensModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="mb-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Buy Tokens</h3>
            <p class="text-gray-600">Purchase tokens to access assessments</p>
        </div>
        <form id="buyTokensForm" onsubmit="buyTokens(event)">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amount (KES) *</label>
                    <input type="number" id="amount" min="10" step="10" required oninput="calculateTokens()" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter amount">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                    <input type="tel" id="phoneNumber" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Safaricom mobile numbers currently supported">
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <span class="text-blue-900 font-medium">Tokens to receive:</span>
                        <span class="text-2xl font-bold text-blue-600" id="tokensToReceive">0</span>
                    </div>
                    <p class="text-sm text-blue-700 mt-1">Rate: 1 token = KES 10</p>
                </div>
            </div>
            <div class="flex space-x-3 mt-6">
                <button type="button" onclick="closeBuyTokensModal()" class="flex-1 px-4 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                    Cancel
                </button>
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all">
                    Buy Tokens
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
