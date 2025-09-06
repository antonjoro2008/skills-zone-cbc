@extends('layouts.app')

@section('title', 'Assessments - SkillsZone')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Choose Your Assessment</h1>
            <p class="text-xl text-gray-100">Quality assessments designed for African students - pay with tokens</p>
            
            <!-- Token Balance Display -->
            <div class="mt-8 inline-flex items-center bg-white bg-opacity-20 rounded-full px-6 py-3">
                <i class="fas fa-coins text-yellow-300 mr-3 text-xl"></i>
                <div class="text-left">
                    <div class="text-sm text-gray-200">Your Token Balance</div>
                    <div class="text-xl font-bold" id="tokenBalance">Loading...</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Loading State -->
        <div id="assessmentsLoading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Loading Skeleton Cards -->
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden animate-pulse">
                <div class="bg-gray-300 h-48"></div>
                <div class="p-6">
                    <div class="h-6 bg-gray-300 rounded mb-3"></div>
                    <div class="h-4 bg-gray-300 rounded mb-2"></div>
                    <div class="h-4 bg-gray-300 rounded mb-4 w-3/4"></div>
                    <div class="flex justify-between mb-4">
                        <div class="h-6 bg-gray-300 rounded w-16"></div>
                        <div class="h-6 bg-gray-300 rounded w-16"></div>
                        <div class="h-6 bg-gray-300 rounded w-20"></div>
                    </div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                </div>
            </div>
            
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden animate-pulse">
                <div class="bg-gray-300 h-48"></div>
                <div class="p-6">
                    <div class="h-6 bg-gray-300 rounded mb-3"></div>
                    <div class="h-4 bg-gray-300 rounded mb-2"></div>
                    <div class="h-4 bg-gray-300 rounded mb-4 w-3/4"></div>
                    <div class="flex justify-between mb-4">
                        <div class="h-6 bg-gray-300 rounded w-16"></div>
                        <div class="h-6 bg-gray-300 rounded w-16"></div>
                        <div class="h-6 bg-gray-300 rounded w-20"></div>
                    </div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                </div>
            </div>
            
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden animate-pulse">
                <div class="bg-gray-300 h-48"></div>
                <div class="p-6">
                    <div class="h-6 bg-gray-300 rounded mb-3"></div>
                    <div class="h-4 bg-gray-300 rounded mb-2"></div>
                    <div class="h-4 bg-gray-300 rounded mb-4 w-3/4"></div>
                    <div class="flex justify-between mb-4">
                        <div class="h-6 bg-gray-300 rounded w-16"></div>
                        <div class="h-6 bg-gray-300 rounded w-16"></div>
                        <div class="h-6 bg-gray-300 rounded w-20"></div>
                    </div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                </div>
            </div>
        </div>
        
        <!-- Dynamic Assessments Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="assessmentsGrid" style="display: none;">
            <!-- Assessment cards will be dynamically loaded here -->
        </div>
        
        <!-- Error State -->
        <div id="assessmentsError" class="text-center py-16" style="display: none;">
            <div class="max-w-md mx-auto">
                <i class="fas fa-exclamation-triangle text-6xl text-red-500 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Unable to Load Assessments</h3>
                <p class="text-gray-600 mb-6">We're having trouble loading the assessments. Please check your connection and try again.</p>
                <button onclick="loadAssessments()" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                    <i class="fas fa-refresh mr-2"></i>Try Again
                </button>
            </div>
        </div>
        
        <!-- Empty State -->
        <div id="assessmentsEmpty" class="text-center py-16" style="display: none;">
            <div class="max-w-md mx-auto">
                <i class="fas fa-clipboard-list text-6xl text-gray-400 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No Assessments Available</h3>
                <p class="text-gray-600">There are currently no assessments available. Please check back later.</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load token balance from localStorage
        updateTokenBalance();
        
        // Load assessments from API
        loadAssessments();
    });
    
    function updateTokenBalance() {
        const storedDashboard = localStorage.getItem('dashboard');
        const tokenBalanceElement = document.getElementById('tokenBalance');
        
        if (storedDashboard) {
            try {
                const dashboard = JSON.parse(storedDashboard);
                if (tokenBalanceElement) {
                    tokenBalanceElement.textContent = `${dashboard.token_balance || 0} Tokens`;
                }
            } catch (e) {
                console.error('Error parsing dashboard data:', e);
                if (tokenBalanceElement) {
                    tokenBalanceElement.textContent = '0 Tokens';
                }
            }
        } else {
            if (tokenBalanceElement) {
                tokenBalanceElement.textContent = '0 Tokens';
            }
        }
    }
    
    async function loadAssessments() {
        const loadingElement = document.getElementById('assessmentsLoading');
        const gridElement = document.getElementById('assessmentsGrid');
        const errorElement = document.getElementById('assessmentsError');
        const emptyElement = document.getElementById('assessmentsEmpty');
        
        // Show loading state
        if (loadingElement) loadingElement.style.display = 'grid';
        if (gridElement) gridElement.style.display = 'none';
        if (errorElement) errorElement.style.display = 'none';
        if (emptyElement) emptyElement.style.display = 'none';
        
        try {
            const token = localStorage.getItem('token');
            if (!token) {
                throw new Error('No authentication token found');
            }
            
            const response = await fetch(`${API_BASE_URL}/api/assessments`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success && data.data && data.data.data && data.data.data.length > 0) {
                renderAssessments(data.data.data);
                if (loadingElement) loadingElement.style.display = 'none';
                if (gridElement) gridElement.style.display = 'grid';
            } else {
                // No assessments available
                if (loadingElement) loadingElement.style.display = 'none';
                if (emptyElement) emptyElement.style.display = 'block';
            }
        } catch (error) {
            console.error('Error loading assessments:', error);
            if (loadingElement) loadingElement.style.display = 'none';
            if (errorElement) errorElement.style.display = 'block';
        }
    }
    
    function renderAssessments(assessments) {
        const gridElement = document.getElementById('assessmentsGrid');
        if (!gridElement) return;
        
        gridElement.innerHTML = assessments.map(assessment => createAssessmentCard(assessment)).join('');
    }
    
    function createAssessmentCard(assessment) {
        const gradientColors = [
            'from-blue-600 via-blue-700 to-purple-600',
            'from-green-500 to-blue-500',
            'from-purple-500 to-pink-500',
            'from-red-500 to-orange-500',
            'from-indigo-500 to-purple-500',
            'from-teal-500 to-green-500',
            'from-yellow-500 to-orange-500',
            'from-pink-500 to-red-500'
        ];
        
        const icons = [
            'fas fa-code',
            'fab fa-python',
            'fas fa-palette',
            'fas fa-chart-bar',
            'fas fa-database',
            'fas fa-shield-alt',
            'fas fa-mobile-alt',
            'fas fa-cloud'
        ];
        
        // Use assessment ID to consistently select colors and icons
        const colorIndex = assessment.id % gradientColors.length;
        const iconIndex = assessment.id % icons.length;
        
        const gradient = gradientColors[colorIndex];
        const icon = icons[iconIndex];
        
        // Format duration and questions
        const duration = assessment.duration_minutes ? `${assessment.duration_minutes} min` : 'N/A';
        const questions = 'Multiple Choice'; // Default since questions_count is not in API response
        const tokens = 5; // Default token cost since token_cost is not in API response
        
        return `
            <div class="assessment-card rounded-3xl shadow-lg overflow-hidden card-hover group">
                <div class="bg-gradient-to-br ${gradient} h-48 flex items-center justify-center text-white text-6xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    <i class="${icon} group-hover:scale-110 transition-transform duration-300"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">${assessment.title || 'Assessment'}</h3>
                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    </div>
                    <div class="mb-2">
                        <span class="text-sm text-blue-600 font-semibold">${assessment.subject ? assessment.subject.name : 'General'}</span>
                        ${assessment.paper_code ? `<span class="text-sm text-gray-500 ml-2">${assessment.paper_code}</span>` : ''}
                        ${assessment.year ? `<span class="text-sm text-gray-500 ml-2">${assessment.year}</span>` : ''}
                    </div>
                    <p class="text-gray-600 mb-4 leading-relaxed">${assessment.description ? assessment.description.replace(/<[^>]*>/g, '') : 'Take this assessment to test your skills and knowledge.'}</p>
                    <div class="grid grid-cols-3 gap-2 mb-4 text-xs">
                        <div class="bg-blue-50 text-blue-600 px-2 py-1 rounded-lg text-center">
                            <i class="fas fa-clock mr-1"></i>${duration}
                        </div>
                        <div class="bg-purple-50 text-purple-600 px-2 py-1 rounded-lg text-center">
                            <i class="fas fa-question-circle mr-1"></i>${questions}
                        </div>
                        <div class="bg-yellow-50 text-yellow-700 px-2 py-1 rounded-lg text-center font-semibold">
                            ${tokens} Tokens
                        </div>
                    </div>
                    <button class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all hover:scale-105 hover:shadow-xl group-hover:animate-pulse" onclick="purchaseAssessment('${assessment.title || 'Assessment'}', ${assessment.id}, ${tokens})">
                        <i class="fas fa-shopping-cart mr-2"></i>Purchase & Start
                    </button>
                </div>
            </div>
        `;
    }
    
    async function purchaseAssessment(title, assessmentId, tokenCost) {
        try {
            // Check if user has enough tokens
            const storedDashboard = localStorage.getItem('dashboard');
            if (storedDashboard) {
                const dashboard = JSON.parse(storedDashboard);
                if (dashboard.token_balance < tokenCost) {
                    showAlert('Insufficient Tokens', `You need ${tokenCost} tokens but only have ${dashboard.token_balance}. Please buy more tokens first.`, 'warning');
                    return;
                }
            }
            
            const token = localStorage.getItem('token');
            if (!token) {
                showAlert('Authentication Required', 'Please log in to purchase assessments', 'warning');
                return;
            }
            
            // Here you would typically make an API call to purchase the assessment
            // For now, we'll show a success message
            showAlert('Assessment Purchased', `Assessment "${title}" purchased successfully! You can now start the assessment.`, 'success');
            
            // In a real implementation, you would:
            // 1. Call the purchase API endpoint
            // 2. Update the user's token balance
            // 3. Redirect to the assessment or show success message
            
        } catch (error) {
            console.error('Error purchasing assessment:', error);
            showAlert('Purchase Error', 'Error purchasing assessment. Please try again.', 'error');
        }
    }
</script>
@endsection
