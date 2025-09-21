@extends('layouts.app')

@section('title', 'Institution Dashboard - Gravity CBC')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 text-center">
            <h1 class="text-4xl font-bold mb-4">Institution Dashboard</h1>
            <p class="text-xl text-gray-100">Manage your learners and track their progress</p>
            <div class="mt-4 text-sm text-gray-200">
                <span id="institutionName">Loading...</span>
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
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Tokens</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="learnersTableBody">
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
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
    const API_BASE_URL = 'https://admin.skillszone.africa';
    
    document.addEventListener('DOMContentLoaded', function() {
        loadDashboardData();
        loadLearners();
        
        // Search functionality
        document.getElementById('searchLearners').addEventListener('input', function(e) {
            filterLearners(e.target.value);
        });
    });
    
    async function loadDashboardData() {
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/institution/dashboard`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                updateDashboardStats(data.data);
                document.getElementById('institutionName').textContent = data.data.institution?.name || 'Institution';
            } else {
                showError('Failed to load dashboard data');
            }
        } catch (error) {
            console.error('Error loading dashboard:', error);
            showError('Error loading dashboard data');
        }
    }
    
    async function loadLearners() {
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/institution/learners`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                learnersData = data.data;
                renderLearnersTable(learnersData);
            } else {
                showError('Failed to load learners');
            }
        } catch (error) {
            console.error('Error loading learners:', error);
            showError('Error loading learners');
        }
    }
    
    function updateDashboardStats(data) {
        document.getElementById('totalLearners').textContent = data.stats.total_learners;
        document.getElementById('activeLearners').textContent = data.stats.active_learners;
        document.getElementById('totalTokens').textContent = data.stats.total_tokens;
        document.getElementById('averageTokens').textContent = data.stats.average_tokens;
    }
    
    function renderLearnersTable(learners) {
        const tbody = document.getElementById('learnersTableBody');
        
        if (learners.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500">
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
                        <span class="font-medium text-gray-900">${learner.name}</span>
                    </div>
                </td>
                <td class="py-4 px-4 text-gray-600">${learner.email}</td>
                <td class="py-4 px-4">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                        ${learner.grade_level}
                    </span>
                </td>
                <td class="py-4 px-4">
                    <div class="flex items-center">
                        <i class="fas fa-coins text-yellow-500 mr-2"></i>
                        <span class="font-semibold text-gray-900">${learner.tokens}</span>
                    </div>
                </td>
                <td class="py-4 px-4">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold ${learner.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                        ${learner.is_active ? 'Active' : 'Inactive'}
                    </span>
                </td>
                <td class="py-4 px-4">
                    <div class="flex items-center space-x-2">
                        <button onclick="editLearnerTokens(${learner.id}, '${learner.name}', ${learner.tokens})" class="text-blue-600 hover:text-blue-800 p-2 hover:bg-blue-50 rounded-lg transition-all" title="Edit Tokens">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button onclick="toggleLearnerStatus(${learner.id}, ${learner.is_active})" class="text-${learner.is_active ? 'red' : 'green'}-600 hover:text-${learner.is_active ? 'red' : 'green'}-800 p-2 hover:bg-${learner.is_active ? 'red' : 'green'}-50 rounded-lg transition-all" title="${learner.is_active ? 'Deactivate' : 'Activate'}">
                            <i class="fas fa-${learner.is_active ? 'ban' : 'check'}"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }
    
    function filterLearners(searchTerm) {
        const filtered = learnersData.filter(learner => 
            learner.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
            learner.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
            learner.grade_level.toLowerCase().includes(searchTerm.toLowerCase())
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
    
    async function addLearner(event) {
        event.preventDefault();
        
        const name = document.getElementById('learnerName').value;
        const email = document.getElementById('learnerEmail').value;
        const gradeLevel = document.getElementById('learnerGradeLevel').value;
        const initialTokens = parseInt(document.getElementById('learnerInitialTokens').value) || 0;
        const mpesaPhone = document.getElementById('learnerMpesaPhone').value;
        
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/institution/learners`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    name,
                    email,
                    grade_level: gradeLevel,
                    initial_tokens: initialTokens,
                    mpesa_phone: mpesaPhone
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                showSuccess('Learner added successfully');
                closeModal('addLearnerModal');
                refreshLearners();
                
                // Clear form
                document.getElementById('learnerName').value = '';
                document.getElementById('learnerEmail').value = '';
                document.getElementById('learnerGradeLevel').value = '';
                document.getElementById('learnerInitialTokens').value = '0';
                document.getElementById('learnerMpesaPhone').value = '';
            } else {
                showError(data.message || 'Failed to add learner');
            }
        } catch (error) {
            console.error('Error adding learner:', error);
            showError('Error adding learner');
        }
    }
    
    async function processBulkUpload() {
        const fileInput = document.getElementById('csvFile');
        const file = fileInput.files[0];
        
        if (!file) {
            showError('Please select a CSV file');
            return;
        }
        
        try {
            const text = await file.text();
            const lines = text.split('\n');
            const headers = lines[0].split(',').map(h => h.trim());
            
            // Validate headers
            const expectedHeaders = ['Name', 'Email', 'Grade Level', 'Initial Tokens', 'M-PESA Phone'];
            if (!expectedHeaders.every(header => headers.includes(header))) {
                showError('Invalid CSV format. Please check the headers.');
                return;
            }
            
            const learners = [];
            for (let i = 1; i < lines.length; i++) {
                const line = lines[i].trim();
                if (!line) continue;
                
                const values = line.split(',').map(v => v.trim());
                if (values.length >= 5) {
                    learners.push({
                        name: values[0],
                        email: values[1],
                        grade_level: values[2],
                        initial_tokens: parseInt(values[3]) || 0,
                        mpesa_phone: values[4]
                    });
                }
            }
            
            if (learners.length === 0) {
                showError('No valid learners found in the CSV file');
                return;
            }
            
            if (learners.length > 100) {
                showError('Maximum 100 learners allowed per upload');
                return;
            }
            
            // Upload learners
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/institution/learners/bulk-upload`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ learners })
            });
            
            const data = await response.json();
            
            if (data.success) {
                showSuccess(`Bulk upload completed! ${data.data.created_count} learners added successfully.`);
                if (data.data.error_count > 0) {
                    showError(`${data.data.error_count} learners failed to upload. Check console for details.`);
                    console.log('Upload errors:', data.data.errors);
                }
                closeModal('bulkUploadModal');
                refreshLearners();
                
                // Clear file input
                fileInput.value = '';
            } else {
                showError(data.message || 'Failed to process bulk upload');
            }
        } catch (error) {
            console.error('Error processing bulk upload:', error);
            showError('Error processing CSV file');
        }
    }
    
    function editLearnerTokens(learnerId, learnerName, currentTokens) {
        const newTokens = prompt(`Edit tokens for ${learnerName}:\n\nCurrent tokens: ${currentTokens}\n\nEnter new token amount:`, currentTokens);
        
        if (newTokens !== null && newTokens !== '' && !isNaN(newTokens)) {
            updateLearnerTokens(learnerId, parseInt(newTokens));
        }
    }
    
    async function updateLearnerTokens(learnerId, tokens) {
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/institution/learners/${learnerId}/tokens`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ tokens })
            });
            
            const data = await response.json();
            
            if (data.success) {
                showSuccess('Learner tokens updated successfully');
                refreshLearners();
            } else {
                showError(data.message || 'Failed to update tokens');
            }
        } catch (error) {
            console.error('Error updating tokens:', error);
            showError('Error updating tokens');
        }
    }
    
    async function toggleLearnerStatus(learnerId, currentStatus) {
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/institution/learners/${learnerId}/toggle-status`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                showSuccess(`Learner ${data.data.is_active ? 'activated' : 'deactivated'} successfully`);
                refreshLearners();
            } else {
                showError(data.message || 'Failed to update status');
            }
        } catch (error) {
            console.error('Error updating status:', error);
            showError('Error updating status');
        }
    }
    
    function showSuccess(message) {
        // Use the beautiful showAlert function
        showAlert('Success', message, 'success');
    }
</script>
@endsection
