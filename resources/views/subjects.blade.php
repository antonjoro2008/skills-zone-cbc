@extends('layouts.app')

@section('title', 'Subjects - Gravity CBC')

@section('content')
    <!-- Hero Section -->
    <div class="gradient-bg text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 text-center">
            <h1 class="text-4xl font-bold mb-4">Choose Your Subject</h1>
            <p class="text-xl text-gray-100">Select a subject to explore available assessments</p>
            
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
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-1 py-8">
        <!-- Loading State -->
        <div id="subjectsLoading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Loading Skeleton Cards -->
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden animate-pulse">
                <div class="bg-gray-300 h-48"></div>
                <div class="p-6">
                    <div class="h-6 bg-gray-300 rounded mb-3"></div>
                    <div class="h-4 bg-gray-300 rounded mb-2"></div>
                    <div class="h-4 bg-gray-300 rounded mb-4 w-3/4"></div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                </div>
            </div>
            
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden animate-pulse">
                <div class="bg-gray-300 h-48"></div>
                <div class="p-6">
                    <div class="h-6 bg-gray-300 rounded mb-3"></div>
                    <div class="h-4 bg-gray-300 rounded mb-2"></div>
                    <div class="h-4 bg-gray-300 rounded mb-4 w-3/4"></div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                </div>
            </div>
            
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden animate-pulse">
                <div class="bg-gray-300 h-48"></div>
                <div class="p-6">
                    <div class="h-6 bg-gray-300 rounded mb-3"></div>
                    <div class="h-4 bg-gray-300 rounded mb-2"></div>
                    <div class="h-4 bg-gray-300 rounded mb-4 w-3/4"></div>
                    <div class="h-12 bg-gray-300 rounded-xl"></div>
                </div>
            </div>
        </div>
        
        <!-- Dynamic Subjects Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="subjectsGrid" style="display: none;">
            <!-- Subject cards will be dynamically loaded here -->
        </div>
        
        <!-- Error State -->
        <div id="subjectsError" class="text-center py-16" style="display: none;">
            <div class="max-w-md mx-auto">
                <i class="fas fa-exclamation-triangle text-6xl text-red-500 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Unable to Load Subjects</h3>
                <p class="text-gray-600 mb-6">We're having trouble loading the subjects. Please check your connection and try again.</p>
                <button onclick="loadSubjects()" class="bg-[#8FC340] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#7bb02d] transition-colors">
                    <i class="fas fa-refresh mr-2"></i>Try Again
                </button>
            </div>
        </div>
        
        <!-- Empty State -->
        <div id="subjectsEmpty" class="text-center py-16" style="display: none;">
            <div class="max-w-md mx-auto">
                <i class="fas fa-book text-6xl text-gray-400 mb-6"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">No Subjects Available</h3>
                <p class="text-gray-600">There are currently no subjects available. Please check back later.</p>
            </div>
        </div>
    </div>

    <!-- Subjects Alert Modal -->
    <div id="subjectsAlertModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-8 relative transform scale-95 opacity-0 transition-all duration-300" id="subjectsAlertModalContent">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4" id="subjectsAlertContainer">
                        <i class="fas fa-exclamation-triangle text-white text-2xl" id="subjectsAlertIcon"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2" id="subjectsAlertTitle">Alert</h3>
                    <p class="text-gray-600 mb-6" id="subjectsAlertMessage">This is an alert message.</p>
                    <button onclick="closeSubjectsAlert()" class="bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white px-8 py-3 rounded-xl font-semibold hover:from-[#7bb02d] hover:to-[#d15a8a] transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <i class="fas fa-check mr-2"></i>OK
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Custom alert function for subjects page
    function showAlert(title, message, type = 'warning') {
        // Check if subjects alert modal exists
        const alertModal = document.getElementById('subjectsAlertModal');
        
        if (!alertModal) {
            console.error('Subjects alert modal not found. Falling back to default alert.');
            alert(`${title}: ${message}`);
            return;
        }
        
        const alertTitle = document.getElementById('subjectsAlertTitle');
        const alertMessage = document.getElementById('subjectsAlertMessage');
        const alertIcon = document.getElementById('subjectsAlertIcon');
        const alertContainer = document.getElementById('subjectsAlertContainer');
        
        // Check if all required elements exist
        if (!alertTitle || !alertMessage || !alertIcon || !alertContainer) {
            console.error('Subjects alert modal elements not found. Falling back to default alert.');
            alert(`${title}: ${message}`);
            return;
        }
        
        // Set title and message
        alertTitle.textContent = title;
        alertMessage.textContent = message;
        
        // Set icon and colors based on type
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
            // Default warning
            alertIcon.className = 'fas fa-exclamation-triangle text-white text-2xl';
            alertContainer.className = 'w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4';
        }
        
        // Show the modal
        alertModal.classList.remove('hidden');
        const content = document.getElementById('subjectsAlertModalContent');
        if (content) {
            setTimeout(() => {
                content.style.transform = 'scale(1)';
                content.style.opacity = '1';
            }, 10);
        }
    }

    // Close subjects alert function
    function closeSubjectsAlert() {
        const alertModal = document.getElementById('subjectsAlertModal');
        const content = document.getElementById('subjectsAlertModalContent');
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
        
        // Load subjects from API
        loadSubjects();
    });
    
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
    
    async function loadSubjects() {
        const loadingElement = document.getElementById('subjectsLoading');
        const gridElement = document.getElementById('subjectsGrid');
        const errorElement = document.getElementById('subjectsError');
        const emptyElement = document.getElementById('subjectsEmpty');
        
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
            
            const response = await fetch(`${API_BASE_URL}/api/subjects`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            });
            
            const data = await response.json();
            
            if (data.success && data.data && data.data.data && data.data.data.length > 0) {
                renderSubjects(data.data.data);
                if (loadingElement) loadingElement.style.display = 'none';
                if (gridElement) gridElement.style.display = 'grid';
            } else {
                // No subjects available
                if (loadingElement) loadingElement.style.display = 'none';
                if (emptyElement) emptyElement.style.display = 'block';
            }
        } catch (error) {
            console.error('Error loading subjects:', error);
            if (loadingElement) loadingElement.style.display = 'none';
            if (errorElement) errorElement.style.display = 'block';
        }
    }
    
    function renderSubjects(subjects) {
        const gridElement = document.getElementById('subjectsGrid');
        if (!gridElement) return;
        
        gridElement.innerHTML = subjects.map(subject => createSubjectCard(subject)).join('');
    }
    
    function createSubjectCard(subject) {
        const gradientColors = [
            'from-[#8FC340] via-[#7bb02d] to-[#E368A7]',
            'from-[#E368A7] to-[#8FC340]',
            'from-[#8FC340] to-[#d15a8a]',
            'from-[#E368A7] to-[#7bb02d]',
            'from-[#8FC340] to-[#E368A7]',
            'from-[#E368A7] to-[#8FC340]',
            'from-[#8FC340] to-[#d15a8a]',
            'from-[#E368A7] to-[#7bb02d]'
        ];
        
        // Subject-specific icons
        const subjectIcons = {
            'mathematics': 'fas fa-calculator',
            'english': 'fas fa-book-open',
            'science': 'fas fa-flask',
            'integrated science': 'fas fa-flask',
            'physics': 'fas fa-atom',
            'chemistry': 'fas fa-vial',
            'biology': 'fas fa-dna',
            'history': 'fas fa-landmark',
            'geography': 'fas fa-globe',
            'computer': 'fas fa-laptop-code',
            'programming': 'fas fa-code',
            'art': 'fas fa-palette',
            'creative arts': 'fas fa-palette',
            'music': 'fas fa-music',
            'sports': 'fas fa-running',
            'physical education': 'fas fa-running',
            'religious studies': 'fas fa-pray',
            'c.r.e': 'fas fa-pray',
            'business': 'fas fa-briefcase',
            'economics': 'fas fa-chart-line',
            'agriculture': 'fas fa-seedling',
            'nutrition': 'fas fa-apple-alt',
            'home science': 'fas fa-home',
            'social studies': 'fas fa-users',
            'kiswahili': 'fas fa-language',
            'pre-technical': 'fas fa-tools',
            'technical': 'fas fa-cogs',
            'multiple': 'fas fa-layer-group',
            'default': 'fas fa-book'
        };
        
        // Use subject ID to consistently select colors
        const colorIndex = subject.id % gradientColors.length;
        const gradient = gradientColors[colorIndex];
        
        // Get subject icon based on name (case insensitive)
        const subjectName = subject.name ? subject.name.toLowerCase() : '';
        let icon = subjectIcons.default;
        
        for (const [key, value] of Object.entries(subjectIcons)) {
            if (subjectName.includes(key)) {
                icon = value;
                break;
            }
        }
        
        // Get subject code if available
        const subjectCode = subject.code || '';
        
        return `
            <div class="subject-card rounded-3xl shadow-lg overflow-hidden card-hover group cursor-pointer" onclick="viewSubjectAssessments(${subject.id})">
                <div class="bg-gradient-to-br ${gradient} h-48 flex items-center justify-center text-white text-6xl relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></div>
                    <i class="${icon} group-hover:scale-110 transition-transform duration-300"></i>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-[#8FC340] transition-colors">${subject.name || 'Subject'}</h3>
                        <div class="w-3 h-3 bg-[#8FC340] rounded-full animate-pulse"></div>
                    </div>
                    <div class="mb-2">
                        <span class="text-sm text-[#8FC340] font-semibold">${subjectCode ? `Code: ${subjectCode}` : 'Subject'}</span>
                    </div>
                    <p class="text-gray-600 mb-4 leading-relaxed">Explore assessments in this subject area.</p>
                    <div class="bg-[#8FC340]/10 border border-[#8FC340]/20 rounded-lg p-3 mb-4">
                        <div class="flex items-center text-[#8FC340] text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            <span>Click to view available assessments</span>
                        </div>
                    </div>
                    <button class="w-full bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white py-3 rounded-xl font-semibold hover:from-[#7bb02d] hover:to-[#d15a8a] transition-all hover:scale-105 hover:shadow-xl group-hover:animate-pulse" 
                            onclick="event.stopPropagation(); viewSubjectAssessments(${subject.id})"
                            ontouchstart=""
                            style="min-height: 48px; touch-action: manipulation;">
                        <i class="fas fa-arrow-right mr-2"></i>View Assessments
                    </button>
                </div>
            </div>
        `;
    }
    
    function viewSubjectAssessments(subjectId) {
        // Navigate to assessments page for this subject
        window.location.href = `/assessments/subject/${subjectId}`;
    }
</script>
@endsection
