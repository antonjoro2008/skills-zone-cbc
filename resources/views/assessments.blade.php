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
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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

    <!-- Assessments Alert Modal -->
    <div id="assessmentsAlertModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative transform scale-95 opacity-0 transition-all duration-300" id="assessmentsAlertModalContent">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4" id="assessmentsAlertContainer">
                        <i class="fas fa-exclamation-triangle text-white text-2xl" id="assessmentsAlertIcon"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2" id="assessmentsAlertTitle">Alert</h3>
                    <p class="text-gray-600 mb-6" id="assessmentsAlertMessage">This is an alert message.</p>
                    <button onclick="closeAssessmentsAlert()" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <i class="fas fa-check mr-2"></i>OK
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Time tracking functions (copied from assessment.blade.php)
    function loadTimeTracking() {
        try {
            const timeData = localStorage.getItem('assessmentTimeTracking');
            if (timeData) {
                return JSON.parse(timeData);
            }
        } catch (e) {
            console.error('Error loading time tracking data:', e);
        }
        return null;
    }

    function calculateRemainingTime(timeData) {
        if (!timeData || !timeData.lastUpdate || !timeData.timeRemaining) {
            return null;
        }

        const lastUpdate = new Date(timeData.lastUpdate);
        const now = new Date();
        const elapsedSeconds = Math.floor((now - lastUpdate) / 1000);
        const newTimeRemaining = Math.max(0, timeData.timeRemaining - elapsedSeconds);
        
        return newTimeRemaining;
    }

    function isAssessmentInProgress(assessmentId) {
        const timeData = loadTimeTracking();
        if (!timeData) return false;
        
        // Check if this is the same assessment
        if (timeData.assessmentId !== assessmentId) return false;
        
        // Check if this is the same attempt (if attempt ID exists)
        const currentAttemptId = localStorage.getItem('currentAttemptId');
        if (timeData.attemptId && currentAttemptId && timeData.attemptId !== currentAttemptId) {
            console.log('Different attempt detected, clearing old time tracking data');
            localStorage.removeItem('assessmentTimeTracking');
            return false;
        }
        
        // Check if time hasn't expired
        const remainingTime = calculateRemainingTime(timeData);
        return remainingTime > 0;
    }

    // Custom alert function for assessments page
    function showAlert(title, message, type = 'warning') {
        // Check if assessments alert modal exists
        const alertModal = document.getElementById('assessmentsAlertModal');
        
        if (!alertModal) {
            console.error('Assessments alert modal not found. Falling back to default alert.');
            alert(`${title}: ${message}`);
            return;
        }
        
        const alertTitle = document.getElementById('assessmentsAlertTitle');
        const alertMessage = document.getElementById('assessmentsAlertMessage');
        const alertIcon = document.getElementById('assessmentsAlertIcon');
        const alertContainer = document.getElementById('assessmentsAlertContainer');
        
        // Check if all required elements exist
        if (!alertTitle || !alertMessage || !alertIcon || !alertContainer) {
            console.error('Assessments alert modal elements not found. Falling back to default alert.');
            alert(`${title}: ${message}`);
            return;
        }
        
        // Set title and message
        alertTitle.textContent = title;
        alertMessage.textContent = message;
        
        // Set icon and colors based on type
        if (type === 'error') {
            alertIcon.className = 'fas fa-times-circle text-white text-2xl';
            alertContainer.className = 'w-16 h-16 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center mx-auto mb-4';
        } else if (type === 'success') {
            alertIcon.className = 'fas fa-check-circle text-white text-2xl';
            alertContainer.className = 'w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4';
        } else if (type === 'info') {
            alertIcon.className = 'fas fa-info-circle text-white text-2xl';
            alertContainer.className = 'w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4';
        } else {
            // Default warning
            alertIcon.className = 'fas fa-exclamation-triangle text-white text-2xl';
            alertContainer.className = 'w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4';
        }
        
        // Show the modal
        alertModal.classList.remove('hidden');
        const content = document.getElementById('assessmentsAlertModalContent');
        if (content) {
            setTimeout(() => {
                content.style.transform = 'scale(1)';
                content.style.opacity = '1';
            }, 10);
        }
    }

    // Close assessments alert function
    function closeAssessmentsAlert() {
        const alertModal = document.getElementById('assessmentsAlertModal');
        const content = document.getElementById('assessmentsAlertModalContent');
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
        const questions = assessment.questions_count ? `${assessment.questions_count} Questions` : 'Multiple Choice';
        const tokens = assessment.token_cost || 5; // Use token_cost from API or default to 5
        
        // Check if user has enough tokens
        const storedDashboard = localStorage.getItem('dashboard');
        let userTokenBalance = 0;
        if (storedDashboard) {
            try {
                const dashboard = JSON.parse(storedDashboard);
                userTokenBalance = dashboard.token_balance || 0;
            } catch (e) {
                console.error('Error parsing dashboard data:', e);
            }
        }
        
        // Check if assessment is in progress
        const isInProgress = isAssessmentInProgress(assessment.id);
        const timeData = loadTimeTracking();
        let remainingTime = null;
        
        if (isInProgress && timeData) {
            remainingTime = calculateRemainingTime(timeData);
        }

        const hasEnoughTokens = userTokenBalance >= tokens;
        let buttonText, buttonIcon, buttonClass;
        
        if (isInProgress && remainingTime > 0) {
            // Show resume button for in-progress assessments
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            const timeString = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            buttonText = `Resume Assessment (${timeString})`;
            buttonIcon = 'fas fa-play';
            buttonClass = 'w-full bg-gradient-to-r from-orange-600 to-red-600 text-white py-3 rounded-xl font-semibold hover:from-orange-700 hover:to-red-700 transition-all hover:scale-105 hover:shadow-xl group-hover:animate-pulse';
        } else if (hasEnoughTokens) {
            buttonText = 'Start Assessment';
            buttonIcon = 'fas fa-play';
            buttonClass = 'w-full bg-gradient-to-r from-green-600 to-blue-600 text-white py-3 rounded-xl font-semibold hover:from-green-700 hover:to-blue-700 transition-all hover:scale-105 hover:shadow-xl group-hover:animate-pulse';
        } else {
            buttonText = 'Purchase & Start';
            buttonIcon = 'fas fa-shopping-cart';
            buttonClass = 'w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all hover:scale-105 hover:shadow-xl group-hover:animate-pulse';
        }
        
        return `
            <div class="assessment-card rounded-3xl shadow-lg overflow-hidden card-hover group">
                <div class="bg-gradient-to-br ${gradient} h-48 flex items-center justify-center text-white text-6xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    <i class="${icon} group-hover:scale-110 transition-transform duration-300"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">${assessment.title || 'Assessment'}</h3>
                        <div class="w-3 h-3 ${isInProgress && remainingTime > 0 ? 'bg-orange-400' : 'bg-green-400'} rounded-full animate-pulse"></div>
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
                    ${isInProgress && remainingTime > 0 ? `
                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-3 mb-4">
                            <div class="flex items-center text-orange-800 text-sm">
                                <i class="fas fa-clock mr-2"></i>
                                <span>Assessment in progress - ${Math.floor(remainingTime / 60)}:${(remainingTime % 60).toString().padStart(2, '0')} remaining</span>
                            </div>
                        </div>
                    ` : hasEnoughTokens ? `
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
                            <div class="flex items-center text-green-800 text-sm">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>This assessment will use ${tokens} tokens from your balance</span>
                            </div>
                        </div>
                    ` : ''}
                    <button class="${buttonClass}" 
                            onclick="${isInProgress && remainingTime > 0 ? `startAssessment(${assessment.id}, ${tokens})` : hasEnoughTokens ? `startAssessment(${assessment.id}, ${tokens})` : `purchaseAssessment('${assessment.title || 'Assessment'}', ${assessment.id}, ${tokens})`}"
                            ontouchstart=""
                            style="min-height: 48px; touch-action: manipulation;">
                        <i class="${buttonIcon} mr-2"></i>${buttonText}
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

    async function startAssessment(assessmentId, tokenCost = 1) {
        try {
            // Debug mobile localStorage access
            console.log('Starting assessment for ID:', assessmentId);
            console.log('Available localStorage keys:', Object.keys(localStorage));
            console.log('Token from localStorage:', localStorage.getItem('token'));
            console.log('User from localStorage:', localStorage.getItem('user'));
            
            const token = localStorage.getItem('token');
            if (!token || token === 'null' || token === 'undefined' || token.length === 0) {
                console.error('No valid token found in localStorage');
                // Try to get token from sessionStorage as fallback
                const sessionToken = sessionStorage.getItem('token');
                if (sessionToken && sessionToken !== 'null' && sessionToken !== 'undefined' && sessionToken.length > 0) {
                    console.log('Found valid token in sessionStorage, using as fallback');
                    localStorage.setItem('token', sessionToken);
                } else {
                    console.error('No valid token found in sessionStorage either');
                    showAlert('Authentication Required', 'Please log in to start assessments', 'warning');
                    return;
                }
            }

            // Call the assessment endpoint to get assessment details
            const response = await fetch(`${API_BASE_URL}/api/assessments/${assessmentId}`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();
            
            if (data.success && data.data) {
                // Add token cost to assessment data
                data.data.token_cost = tokenCost;
                
                // Store assessment data and redirect to assessment page
                localStorage.setItem('currentAssessment', JSON.stringify(data.data));
                window.location.href = `/assessment/${assessmentId}`;
            } else {
                showAlert('Error', data.message || 'Failed to load assessment details', 'error');
            }
        } catch (error) {
            console.error('Error starting assessment:', error);
            showAlert('Error', 'Failed to start assessment. Please try again.', 'error');
        }
    }
</script>
@endsection
