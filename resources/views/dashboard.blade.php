@extends('layouts.app')

@section('title', 'Dashboard - SkillsZone')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome, <span id="userName">User</span>!</h1>
            <p class="text-xl text-gray-100">Track your progress and manage your account</p>
            <div class="mt-4 text-sm text-gray-200">
                <span id="userGradeLevel">Grade Level: Not specified</span> | 
                <span id="userEmail">Email: Not available</span>
            </div>
        </div>
    </div>
    
    <!-- Dashboard Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-coins text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Token Balance</p>
                        <p class="text-2xl font-bold text-gray-900" id="tokenBalance">
                            <i class="fas fa-spinner fa-spin text-gray-400"></i>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Completed</p>
                        <p class="text-2xl font-bold text-gray-900" id="completedAssessments">
                            <i class="fas fa-spinner fa-spin text-gray-400"></i>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-purple-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">In Progress</p>
                        <p class="text-2xl font-bold text-gray-900" id="inProgressAssessments">
                            <i class="fas fa-spinner fa-spin text-gray-400"></i>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-trophy text-orange-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Average Score</p>
                        <p class="text-2xl font-bold text-gray-900" id="averageScore">
                            <i class="fas fa-spinner fa-spin text-gray-400"></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white rounded-3xl shadow-lg p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Recent Assessments</h3>
                <div class="space-y-4" id="recentAssessmentsContainer">
                    <!-- Dynamic content will be loaded here -->
                    <div class="text-center text-gray-500 py-8" id="loadingAssessments">
                        <i class="fas fa-spinner fa-spin text-4xl mb-4"></i>
                        <p>Loading assessments...</p>
                    </div>
                    <div class="text-center text-gray-500 py-8 hidden" id="noAssessmentsMessage">
                        <i class="fas fa-clipboard-list text-4xl mb-4"></i>
                        <p>No assessments yet. Start your first assessment!</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-3xl shadow-lg p-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h3>
                <div class="space-y-4">
                    <a href="{{ route('assessments') }}" class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 rounded-xl text-center font-semibold hover:from-blue-700 hover:to-purple-700 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Start New Assessment
                    </a>
                    
                    <button onclick="showBuyTokensModal()" class="block w-full bg-white border-2 border-blue-600 text-blue-600 p-4 rounded-xl text-center font-semibold hover:bg-blue-50 transition-all">
                        <i class="fas fa-coins mr-2"></i>
                        Buy More Tokens
                    </button>
                    
                    <a href="{{ route('transactions') }}" class="block w-full bg-white border-2 border-gray-300 text-gray-700 p-4 rounded-xl text-center font-semibold hover:bg-gray-50 transition-all">
                        <i class="fas fa-history mr-2"></i>
                        View History
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load user data and dashboard data from localStorage
        const storedUser = localStorage.getItem('user');
        const storedDashboard = localStorage.getItem('dashboard');
        
        // Add event listener for amount input to update token display
        const amountInput = document.getElementById('buyTokensAmount');
        if (amountInput) {
            amountInput.addEventListener('input', updateTokenDisplay);
        }
        
        if (storedUser) {
            try {
                const user = JSON.parse(storedUser);
                const dashboard = storedDashboard ? JSON.parse(storedDashboard) : null;
                
                // Update user information
                updateUserInfo(user);
                
                // Update dashboard statistics
                if (dashboard) {
                    updateDashboardStats(dashboard);
                    updateRecentAssessments(dashboard.recent_assessments || []);
                } else {
                    // Set default values if no dashboard data
                    setDefaultDashboardValues();
                }
                
            } catch (e) {
                console.error('Error parsing stored data:', e);
                // Show error message instead of redirecting immediately
                showDashboardError('Failed to load user data. Please try logging in again.');
                
                // Clear corrupted data after a delay
                setTimeout(() => {
                    localStorage.removeItem('user');
                    localStorage.removeItem('token');
                    localStorage.removeItem('dashboard');
                    window.location.href = '/';
                }, 3000);
            }
        } else {
            // No user data found, redirect to home
            window.location.href = '/';
        }
    });
    
    function updateUserInfo(user) {
        const userNameElement = document.getElementById('userName');
        const userGradeLevelElement = document.getElementById('userGradeLevel');
        const userEmailElement = document.getElementById('userEmail');
        
        if (userNameElement) userNameElement.textContent = user.name || 'User';
        if (userGradeLevelElement) userGradeLevelElement.textContent = `Grade Level: ${user.grade_level || 'Not specified'}`;
        if (userEmailElement) userEmailElement.textContent = `Email: ${user.email || 'Not available'}`;
    }
    
    function updateDashboardStats(dashboard) {
        // Update token balance
        const tokenBalanceElement = document.getElementById('tokenBalance');
        if (tokenBalanceElement) {
            tokenBalanceElement.textContent = dashboard.token_balance || 0;
        }
        
        // Update assessment statistics
        const completedElement = document.getElementById('completedAssessments');
        const inProgressElement = document.getElementById('inProgressAssessments');
        const averageScoreElement = document.getElementById('averageScore');
        
        if (completedElement && dashboard.assessment_stats) {
            completedElement.textContent = dashboard.assessment_stats.completed_attempts || 0;
        }
        
        if (inProgressElement && dashboard.assessment_stats) {
            inProgressElement.textContent = dashboard.assessment_stats.in_progress_attempts || 0;
        }
        
        if (averageScoreElement && dashboard.assessment_stats) {
            averageScoreElement.textContent = `${dashboard.assessment_stats.average_score || 0}%`;
        }
    }
    
    function updateRecentAssessments(assessments) {
        const container = document.getElementById('recentAssessmentsContainer');
        const loadingMessage = document.getElementById('loadingAssessments');
        const noAssessmentsMessage = document.getElementById('noAssessmentsMessage');
        
        if (!container) return;
        
        // Hide loading message
        if (loadingMessage) {
            loadingMessage.style.display = 'none';
        }
        
        if (assessments && assessments.length > 0) {
            // Hide the no assessments message
            if (noAssessmentsMessage) {
                noAssessmentsMessage.style.display = 'none';
            }
            
            // Clear existing content
            container.innerHTML = '';
            
            // Add each assessment
            assessments.forEach(assessment => {
                const assessmentElement = createAssessmentElement(assessment);
                container.appendChild(assessmentElement);
            });
        } else {
            // Show no assessments message
            if (noAssessmentsMessage) {
                noAssessmentsMessage.style.display = 'block';
            }
        }
    }
    
    function createAssessmentElement(assessment) {
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between p-4 bg-gray-50 rounded-xl';
        
        // Get icon and color based on assessment type or status
        const iconClass = getAssessmentIcon(assessment.name);
        const statusColor = getStatusColor(assessment.status);
        const statusText = getStatusText(assessment.status, assessment.completed_at);
        
        div.innerHTML = `
            <div class="flex items-center">
                <div class="w-10 h-10 ${iconClass.bg} rounded-lg flex items-center justify-center mr-3">
                    <i class="${iconClass.icon} ${iconClass.text}"></i>
                </div>
                <div>
                    <p class="font-medium text-gray-900">${assessment.name}</p>
                    <p class="text-sm text-gray-500">${statusText}</p>
                </div>
            </div>
            <span class="${statusColor.bg} ${statusColor.text} px-3 py-1 rounded-full text-sm font-semibold">${assessment.score}%</span>
        `;
        
        return div;
    }
    
    function getAssessmentIcon(assessmentName) {
        if(assessmentName === null || assessmentName === '' || assessmentName === undefined) {
            return { icon: 'fas fa-clipboard-list', bg: 'bg-gray-100', text: 'text-gray-600' };
        }
        const name = assessmentName.toLowerCase();
        if (name.includes('javascript') || name.includes('js')) {
            return { icon: 'fas fa-code', bg: 'bg-blue-100', text: 'text-blue-600' };
        } else if (name.includes('python')) {
            return { icon: 'fab fa-python', bg: 'bg-green-100', text: 'text-green-600' };
        } else if (name.includes('design') || name.includes('ui') || name.includes('ux')) {
            return { icon: 'fas fa-palette', bg: 'bg-purple-100', text: 'text-purple-600' };
        } else if (name.includes('data') || name.includes('analysis')) {
            return { icon: 'fas fa-chart-bar', bg: 'bg-orange-100', text: 'text-orange-600' };
        } else {
            return { icon: 'fas fa-clipboard-list', bg: 'bg-gray-100', text: 'text-gray-600' };
        }
    }
    
    function getStatusColor(status) {
        switch (status) {
            case 'completed':
                return { bg: 'bg-green-100', text: 'text-green-800' };
            case 'in_progress':
                return { bg: 'bg-blue-100', text: 'text-blue-800' };
            case 'pending':
                return { bg: 'bg-yellow-100', text: 'text-yellow-800' };
            default:
                return { bg: 'bg-gray-100', text: 'text-gray-800' };
        }
    }
    
    function getStatusText(status, completedAt) {
        if (status === 'completed' && completedAt) {
            const date = new Date(completedAt);
            const now = new Date();
            const diffTime = Math.abs(now - date);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays === 1) {
                return 'Completed yesterday';
            } else if (diffDays < 7) {
                return `Completed ${diffDays} days ago`;
            } else if (diffDays < 30) {
                const weeks = Math.floor(diffDays / 7);
                return `Completed ${weeks} week${weeks > 1 ? 's' : ''} ago`;
            } else {
                return `Completed on ${date.toLocaleDateString()}`;
            }
        } else if (status === 'in_progress') {
            return 'In progress';
        } else if (status === 'pending') {
            return 'Not started';
        } else {
            return 'Status unknown';
        }
    }
    
    function setDefaultDashboardValues() {
        // Set default values when no dashboard data is available
        const tokenBalanceElement = document.getElementById('tokenBalance');
        const completedElement = document.getElementById('completedAssessments');
        const inProgressElement = document.getElementById('inProgressAssessments');
        const averageScoreElement = document.getElementById('averageScore');
        
        if (tokenBalanceElement) tokenBalanceElement.textContent = '0';
        if (completedElement) completedElement.textContent = '0';
        if (inProgressElement) inProgressElement.textContent = '0';
        if (averageScoreElement) averageScoreElement.textContent = '0%';
        
        // Show no assessments message
        const loadingMessage = document.getElementById('loadingAssessments');
        const noAssessmentsMessage = document.getElementById('noAssessmentsMessage');
        
        if (loadingMessage) loadingMessage.style.display = 'none';
        if (noAssessmentsMessage) noAssessmentsMessage.style.display = 'block';
    }
    
    function showDashboardError(message) {
        // Show error message in dashboard
        const container = document.getElementById('recentAssessmentsContainer');
        if (container) {
            container.innerHTML = `
                <div class="text-center text-red-500 py-8">
                    <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
                    <p>Error loading dashboard data</p>
                    <p class="text-sm mt-2">${message}</p>
                    <button onclick="location.reload()" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Retry
                    </button>
                </div>
            `;
        }
    }
    
    function showBuyTokensModal() {
        // Pre-populate M-PESA phone if available
        const storedUser = localStorage.getItem('user');
        if (storedUser) {
            try {
                const user = JSON.parse(storedUser);
                if (user.mpesa_phone) {
                    document.getElementById('buyTokensMpesaPhone').value = user.mpesa_phone;
                }
            } catch (e) {
                console.error('Error parsing user data:', e);
            }
        }
        
        showModal('buyTokensModal');
    }
    
    async function buyTokens(event) {
        event.preventDefault();
        
        const mpesaPhone = document.getElementById('buyTokensMpesaPhone').value;
        const amount = parseFloat(document.getElementById('buyTokensAmount').value);
        
        if (!mpesaPhone || !amount) {
            showAlert('Validation Error', 'Please fill in all required fields', 'error');
            return;
        }
        
        if (amount < 100 || amount > 100000) {
            showAlert('Invalid Amount', 'Amount must be between KES 100 and KES 100,000', 'error');
            return;
        }
        
        // Validate phone number format
        if (!mpesaPhone.match(/^254[0-9]{9}$/)) {
            showAlert('Invalid Phone Number', 'Please enter a valid M-PESA phone number in format 254XXXXXXXXX', 'error');
            return;
        }
        
        // Calculate tokens (1 token = KES 100)
        const tokens = Math.floor(amount / 100);
        
        // Get current user data
        const storedUser = localStorage.getItem('user');
        if (!storedUser) {
            showAlert('Authentication Error', 'User data not found. Please log in again.', 'error');
            return;
        }
        
        const currentUser = JSON.parse(storedUser);
        
        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`${API_BASE_URL}/api/payments`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    amount: amount,
                    channel: 'mpesa',
                    currency: 'KES',
                    tokens: tokens,
                    phone_number: mpesaPhone,
                    user_id: currentUser.id
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                showAlert('Payment Successful', `Payment initiated successfully! You will receive ${tokens} tokens. Check your phone for M-PESA prompt.`, 'success');
                closeModal('buyTokensModal');
                
                // Clear form
                document.getElementById('buyTokensMpesaPhone').value = '';
                document.getElementById('buyTokensAmount').value = '';
                updateTokenDisplay();
                
                // Refresh dashboard data
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                showAlert('Payment Failed', data.message || 'Payment failed. Please try again.', 'error');
            }
        } catch (error) {
            console.error('Error processing payment:', error);
            showAlert('Network Error', 'Error processing payment. Please try again.', 'error');
        }
    }
    
    function updateTokenDisplay() {
        const amountInput = document.getElementById('buyTokensAmount');
        const displayAmount = document.getElementById('displayAmount');
        const displayTokens = document.getElementById('displayTokens');
        
        if (amountInput && displayAmount && displayTokens) {
            const amount = parseFloat(amountInput.value) || 0;
            const tokens = Math.floor(amount / 100); // 100 KES = 1 token
            
            displayAmount.textContent = `KES ${amount.toLocaleString()}`;
            displayTokens.textContent = `${tokens} token${tokens !== 1 ? 's' : ''}`;
        }
    }
    
</script>
@endsection 