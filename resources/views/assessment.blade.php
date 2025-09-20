@extends('layouts.app')

@section('title', 'Assessment - Gravity CBC')

@section('content')
    <!-- Assessment Start Page -->
    <div id="assessmentStartPage" class="min-h-screen">
        <!-- Header -->
        <div class="gradient-bg text-white py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2" id="assessmentTitle">Assessment</h1>
                        <p class="text-gray-200" id="assessmentSubject">Loading...</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-200">Duration</div>
                        <div class="text-xl font-bold" id="assessmentDuration">Loading...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assessment Details -->
        <div class="bg-gray-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="bg-white rounded-3xl shadow-lg p-6">
                <!-- Assessment Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-[#8FC340]/10 rounded-2xl p-4 text-center">
                        <div class="w-12 h-12 bg-[#8FC340]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-clock text-[#8FC340] text-xl"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900" id="durationDisplay">0 min</div>
                        <div class="text-sm text-gray-600">Duration</div>
                    </div>
                    <div class="bg-[#E368A7]/10 rounded-2xl p-4 text-center">
                        <div class="w-12 h-12 bg-[#E368A7]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-question-circle text-[#E368A7] text-xl"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900" id="questionsCount">0</div>
                        <div class="text-sm text-gray-600">Questions</div>
                    </div>
                    <div class="bg-[#8FC340]/10 rounded-2xl p-4 text-center">
                        <div class="w-12 h-12 bg-[#8FC340]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-coins text-[#8FC340] text-xl"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900" id="tokenCost">0</div>
                        <div class="text-sm text-gray-600">Tokens</div>
                    </div>
                </div>

                <!-- Instructions -->
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-3">Instructions</h2>
                    <div class="bg-gray-50 rounded-2xl p-4">
                        <div id="assessmentInstructions">
                            <p class="text-gray-700 mb-4">Please read the following instructions carefully before starting the assessment:</p>
                            <ul class="list-disc list-inside space-y-2 text-gray-700">
                                <li>You have a limited time to complete this assessment</li>
                                <li>Answer all questions to the best of your ability</li>
                                <li>You can navigate between questions using the Next/Previous buttons</li>
                                <li>Your answers are automatically saved as you progress</li>
                                <li>Once you submit or time runs out, you cannot change your answers</li>
                                <li>Make sure you have a stable internet connection</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Start Button -->
                <div class="text-center">
                    <button id="startAssessmentBtn" class="bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white px-12 py-4 rounded-2xl text-lg font-semibold hover:from-[#7bb02d] hover:to-[#d15a8a] transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <i class="fas fa-play mr-3"></i>Start Assessment
                    </button>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Assessment Questions Page -->
    <div id="assessmentQuestionsPage" class="min-h-screen bg-gray-50 hidden">
        <!-- Header with Timer -->
        <div class="bg-white shadow-lg py-4 sticky top-0 z-40">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button id="backToStartBtn" class="text-gray-600 hover:text-gray-800 transition-colors">
                            <i class="fas fa-arrow-left text-xl"></i>
                        </button>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900" id="questionAssessmentTitle">Assessment</h1>
                            <p class="text-sm text-gray-600">Question <span id="currentQuestionNumber">1</span> of <span id="totalQuestions">0</span></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <div class="text-sm text-gray-600">Time Remaining</div>
                            <div class="text-xl font-bold" id="timerDisplay">00:00</div>
                        </div>
                        <div class="w-12 h-12 bg-[#8FC340]/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-[#8FC340] text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Question Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="bg-white rounded-3xl shadow-lg p-6">
                <!-- Question -->
                <div class="mb-6">
                    <!-- Section Info -->
                    <div id="sectionInfo">
                        <!-- Section information will be displayed here -->
                    </div>
                    
                    <!-- Question Text -->
                    <div class="text-sm text-gray-900 mb-4 leading-relaxed">
                        <span id="questionText">Loading question...</span>
                    </div>
                    
                    <!-- Question Options -->
                    <div id="questionOptions" class="space-y-3">
                        <!-- Options will be dynamically generated -->
                    </div>
                </div>

                <!-- Navigation -->
                <!-- Desktop Layout -->
                <div class="hidden sm:flex items-center justify-between pt-4">
                    <button id="prevQuestionBtn" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        <i class="fas fa-arrow-left mr-2"></i>Previous
                    </button>
                    
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Progress:</span>
                        <div class="w-32 bg-gray-200 rounded-full h-2">
                            <div id="progressBar" class="bg-[#8FC340] h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                        <span id="progressText" class="text-sm text-gray-600">0%</span>
                    </div>
                    
                    <button id="nextQuestionBtn" class="bg-[#8FC340] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#7bb02d] transition-all">
                        Next<i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>

                <!-- Mobile Layout -->
                <div class="sm:hidden pt-4 space-y-4">
                    <!-- Progress Bar Row -->
                    <div class="flex items-center justify-center space-x-2">
                        <span class="text-sm text-gray-600">Progress:</span>
                        <div class="w-40 bg-gray-200 rounded-full h-2">
                            <div id="progressBarMobile" class="bg-[#8FC340] h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                        </div>
                        <span id="progressTextMobile" class="text-sm text-gray-600">0%</span>
                    </div>
                    
                    <!-- Navigation Buttons Row -->
                    <div class="flex items-center justify-between">
                        <button id="prevQuestionBtnMobile" class="bg-gray-100 text-gray-700 px-4 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex-1 mr-2" disabled>
                            <i class="fas fa-arrow-left mr-2"></i>Previous
                        </button>
                        
                        <button id="nextQuestionBtnMobile" class="bg-[#8FC340] text-white px-4 py-3 rounded-xl font-semibold hover:bg-[#7bb02d] transition-all flex-1 ml-2">
                            Next<i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button (shown on last question) -->
                <div id="submitSection" class="mt-6 text-center hidden">
                    <button id="submitAssessmentBtn" class="bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white px-12 py-4 rounded-2xl text-lg font-semibold hover:from-[#7bb02d] hover:to-[#d15a8a] transition-all shadow-lg hover:shadow-xl hover:scale-105">
                        <i class="fas fa-check mr-3"></i>Submit Assessment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Assessment Results Page -->
    <div id="assessmentResultsPage" class="min-h-screen bg-gray-50 hidden">
        <!-- Header -->
        <div class="gradient-bg text-white py-8">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-3xl font-bold mb-2">Assessment Complete!</h1>
                <p class="text-gray-200">Here are your results</p>
            </div>
        </div>

        <!-- Results Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Score Summary -->
            <div class="bg-white rounded-3xl shadow-lg p-8 mb-8">
                <div class="text-center mb-8">
                    <div class="w-24 h-24 bg-gradient-to-r from-[#8FC340] to-[#EC2834] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-trophy text-white text-3xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Your Score</h2>
                    <div class="text-6xl font-bold text-transparent bg-gradient-to-r from-[#8FC340] to-[#EC2834] bg-clip-text mb-2" id="finalScore">0%</div>
                    <p class="text-gray-600" id="scoreDescription">Great job!</p>
                </div>

                <!-- Score Breakdown -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-[#8FC340]/10 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-bold text-[#8FC340]" id="correctAnswers">0</div>
                        <div class="text-sm text-gray-600">Correct</div>
                    </div>
                    <div class="bg-[#EC2834]/10 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-bold text-[#EC2834]" id="incorrectAnswers">0</div>
                        <div class="text-sm text-gray-600">Incorrect</div>
                    </div>
                    <div class="bg-[#E368A7]/10 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-bold text-[#E368A7]" id="totalTime">0</div>
                        <div class="text-sm text-gray-600">Time Taken</div>
                    </div>
                </div>
            </div>

            <!-- Question Review -->
            <div class="bg-white rounded-3xl shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Question Review</h3>
                <div id="questionReview" class="space-y-6">
                    <!-- Question reviews will be dynamically generated -->
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center mt-8">
                <button onclick="window.location.href='/assessments'" class="bg-gradient-to-r from-[#8FC340] to-[#E368A7] text-white px-8 py-3 rounded-xl font-semibold hover:from-[#7bb02d] hover:to-[#d15a8a] transition-all shadow-lg hover:shadow-xl hover:scale-105 mr-4">
                    <i class="fas fa-list mr-2"></i>Back to Assessments
                </button>
                <button onclick="window.location.href='/dashboard'" class="bg-gray-100 text-gray-700 px-8 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </button>
            </div>
        </div>
    </div>

    <!-- Assessment Alert Modal -->
    <div id="assessmentAlertModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4" id="assessmentAlertIcon">
                    <i class="fas fa-exclamation-triangle text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2" id="assessmentAlertTitle">Alert</h3>
                <p class="text-gray-600 mb-6" id="assessmentAlertMessage">This is an alert message.</p>
                <button onclick="closeAssessmentAlert()" class="bg-[#8FC340] text-white px-6 py-3 rounded-xl font-semibold hover:bg-[#7bb02d] transition-all">
                    OK
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    let currentAssessment = null;
    let currentQuestionIndex = 0;
    let answers = {};
    let startTime = null;
    let timerInterval = null;
    let timeRemaining = 0;
    let lastTimeUpdate = null;

    // Time tracking functions
    function saveTimeTracking() {
        if (currentAssessment && timeRemaining > 0) {
            const timeData = {
                assessmentId: currentAssessment.id,
                attemptId: localStorage.getItem('currentAttemptId'), // Include attempt ID for better isolation
                timeRemaining: timeRemaining,
                lastUpdate: new Date().toISOString(),
                startTime: startTime ? startTime.toISOString() : null
            };
            localStorage.setItem('assessmentTimeTracking', JSON.stringify(timeData));
            console.log('Time tracking saved for assessment:', currentAssessment.id, 'attempt:', timeData.attemptId);
        }
    }

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

    function clearTimeTracking() {
        localStorage.removeItem('assessmentTimeTracking');
        console.log('Time tracking data cleared');
    }

    function clearAllAssessmentData() {
        // Clear all assessment-related data to prevent overlap between attempts
        localStorage.removeItem('assessmentTimeTracking');
        localStorage.removeItem('assessmentAnswers');
        localStorage.removeItem('currentAttemptId');
        localStorage.removeItem('assessmentStartTime');
        console.log('All assessment data cleared for new attempt');
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

    function isAssessmentInProgress() {
        const timeData = loadTimeTracking();
        if (!timeData || !currentAssessment) return false;
        
        // Check if this is the same assessment
        if (timeData.assessmentId !== currentAssessment.id) return false;
        
        // Check if this is the same attempt (if attempt ID exists)
        const currentAttemptId = localStorage.getItem('currentAttemptId');
        if (timeData.attemptId && currentAttemptId && timeData.attemptId !== currentAttemptId) {
            console.log('Different attempt detected, clearing old time tracking data');
            clearTimeTracking();
            return false;
        }
        
        // Check if time hasn't expired
        const remainingTime = calculateRemainingTime(timeData);
        return remainingTime > 0;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Debug localStorage data - enhanced for mobile debugging
        console.log('=== ASSESSMENT PAGE LOAD DEBUG ===');
        console.log('User Agent:', navigator.userAgent);
        console.log('Available localStorage keys:', Object.keys(localStorage));
        console.log('user in localStorage:', localStorage.getItem('user'));
        console.log('token in localStorage:', localStorage.getItem('token'));
        console.log('currentAssessment in localStorage:', localStorage.getItem('currentAssessment'));
        console.log('=== END DEBUG ===');
        
        // Save time tracking when user navigates away
        window.addEventListener('beforeunload', function() {
            if (timeRemaining > 0 && currentAssessment) {
                saveTimeTracking();
            }
        });
        
        // Check if user is logged in
        let user = localStorage.getItem('user');
        let token = localStorage.getItem('token');
        
        // Fallback to sessionStorage for mobile devices
        if (!user) {
            user = sessionStorage.getItem('user');
            if (user) {
                localStorage.setItem('user', user);
                console.log('Restored user from sessionStorage');
            }
        }
        
        if (!token) {
            token = sessionStorage.getItem('token');
            if (token) {
                localStorage.setItem('token', token);
                console.log('Restored token from sessionStorage');
            }
        }
        
        // More robust authentication check
        const hasValidUser = user && user !== 'null' && user !== 'undefined';
        const hasValidToken = token && token !== 'null' && token !== 'undefined' && token.length > 0;
        
        console.log('Authentication check:');
        console.log('- User exists:', hasValidUser, user);
        console.log('- Token exists:', hasValidToken, token ? `${token.substring(0, 20)}...` : 'null');
        
        if (!hasValidUser || !hasValidToken) {
            console.error('Authentication failed - missing valid user or token');
            console.error('User valid:', hasValidUser);
            console.error('Token valid:', hasValidToken);
            showAssessmentAlert('Authentication Required', 'Please log in to access assessments', 'warning');
            setTimeout(() => {
                window.location.href = '/';
            }, 2000);
            return;
        }
        
        loadAssessmentData();
    });

    async function loadAssessmentData() {
        // Get assessment ID from URL
        const pathParts = window.location.pathname.split('/');
        const assessmentId = pathParts[pathParts.length - 1];
        
        if (!assessmentId || isNaN(assessmentId)) {
            showAssessmentAlert('Error', 'Invalid assessment ID. Please try again.', 'error');
            window.location.href = '/assessments';
            return;
        }

        try {
            const token = localStorage.getItem('token');
            if (!token) {
                showAssessmentAlert('Authentication Required', 'Please log in to access assessments', 'warning');
                window.location.href = '/';
                return;
            }

            // Fetch fresh assessment data from API
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
                currentAssessment = data.data;
                
                // Preserve token_cost from localStorage if it exists
                const storedAssessment = localStorage.getItem('currentAssessment');
                if (storedAssessment) {
                    try {
                        const stored = JSON.parse(storedAssessment);
                        if (stored.token_cost) {
                            currentAssessment.token_cost = stored.token_cost;
                            console.log('Preserved token_cost:', stored.token_cost);
                        }
                    } catch (e) {
                        console.error('Error parsing stored assessment:', e);
                    }
                }
                
                // Update localStorage with fresh data (including preserved token_cost)
                localStorage.setItem('currentAssessment', JSON.stringify(currentAssessment));
                
                // Check if there's existing time tracking data for this assessment
                const existingTimeData = loadTimeTracking();
                if (existingTimeData && existingTimeData.assessmentId === currentAssessment.id) {
                    const calculatedTime = calculateRemainingTime(existingTimeData);
                    if (calculatedTime > 0) {
                        // Restore time tracking data
                        timeRemaining = calculatedTime;
                        startTime = existingTimeData.startTime ? new Date(existingTimeData.startTime) : new Date();
                        console.log('Restored time tracking data. Remaining time:', calculatedTime);
                    } else {
                        // Time has expired, clear the tracking data
                        clearTimeTracking();
                        console.log('Time tracking data expired, cleared');
                    }
                }
                
                displayAssessmentStart();
            } else {
                showAssessmentAlert('Error', data.message || 'Failed to load assessment details', 'error');
                window.location.href = '/assessments';
            }
        } catch (error) {
            console.error('Error loading assessment data:', error);
            showAssessmentAlert('Error', 'Failed to load assessment. Please try again.', 'error');
            window.location.href = '/assessments';
        }
    }

    function displayAssessmentStart() {
        if (!currentAssessment) return;

        // Calculate total questions from sections
        let totalQuestions = 0;
        if (currentAssessment.sections) {
            currentAssessment.sections.forEach(section => {
                if (section.questions && section.questions.length > 0) {
                    totalQuestions += section.questions.length;
                }
            });
        }

        // Check if assessment is in progress
        const isInProgress = isAssessmentInProgress();
        const timeData = loadTimeTracking();
        let remainingTime = null;
        
        if (isInProgress && timeData) {
            remainingTime = calculateRemainingTime(timeData);
        }

        // Update assessment details
        document.getElementById('assessmentTitle').textContent = currentAssessment.title || 'Assessment';
        document.getElementById('assessmentSubject').textContent = currentAssessment.subject ? currentAssessment.subject.name : 'General';
        
        // Show remaining time if in progress, otherwise show total duration
        if (isInProgress && remainingTime > 0) {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            const timeString = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            document.getElementById('assessmentDuration').textContent = `${timeString} remaining`;
            document.getElementById('durationDisplay').textContent = `${timeString} remaining`;
        } else {
            document.getElementById('assessmentDuration').textContent = `${currentAssessment.duration_minutes || 0} minutes`;
            document.getElementById('durationDisplay').textContent = `${currentAssessment.duration_minutes || 0} min`;
        }
        
        document.getElementById('questionsCount').textContent = totalQuestions;
        const tokenCost = currentAssessment.token_cost || 1;
        console.log('Displaying token cost:', tokenCost, 'from currentAssessment:', currentAssessment.token_cost);
        document.getElementById('tokenCost').textContent = tokenCost;

        // Update start button text and icon
        const startBtn = document.getElementById('startAssessmentBtn');
        if (isInProgress && remainingTime > 0) {
            startBtn.innerHTML = '<i class="fas fa-play mr-3"></i>Resume Assessment';
        } else {
            startBtn.innerHTML = '<i class="fas fa-play mr-3"></i>Start Assessment';
        }

        // Update instructions if available
        if (currentAssessment.instructions) {
            document.getElementById('assessmentInstructions').innerHTML = currentAssessment.instructions;
        }
    }

    async function startAssessment() {
        if (!currentAssessment) return;

        try {
            // Show loading state on start button
            const startBtn = document.getElementById('startAssessmentBtn');
            const originalText = startBtn.innerHTML;
            startBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Starting Assessment...';
            startBtn.disabled = true;

            const token = localStorage.getItem('token');
            if (!token) {
                // Reset button state before redirect
                startBtn.innerHTML = originalText;
                startBtn.disabled = false;
                showAssessmentAlert('Authentication Required', 'Please log in to start assessments', 'warning');
                window.location.href = '/';
                return;
            }

            // Call the start assessment API endpoint
            const response = await fetch(`${API_BASE_URL}/api/assessments/${currentAssessment.id}/start`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();

            if (data.success) {
                // Check if assessment is already completed
                if (data.data.status === 'completed') {
                    // Reset button state before showing alert
                    const startBtn = document.getElementById('startAssessmentBtn');
                    startBtn.innerHTML = '<i class="fas fa-play mr-3"></i>Start Assessment';
                    startBtn.disabled = false;
                    
                    showAssessmentAlert('Assessment Already Completed', `You have already completed this assessment with a score of ${data.data.score}%. You cannot retake it.`, 'info');
                    return;
                }

                // Check if we're resuming an in-progress assessment
                const isResuming = isAssessmentInProgress();
                const timeData = loadTimeTracking();
                let calculatedRemainingTime = null;
                
                console.log('=== ASSESSMENT START CHECK ===');
                console.log('isResuming:', isResuming);
                console.log('timeData:', timeData);
                console.log('currentAttemptId:', localStorage.getItem('currentAttemptId'));
                console.log('=== END ASSESSMENT START CHECK ===');
                
                if (isResuming && timeData) {
                    calculatedRemainingTime = calculateRemainingTime(timeData);
                    
                    // Check if time has expired while away
                    if (calculatedRemainingTime <= 0) {
                        showAssessmentAlert('Time Expired', 'The assessment time has expired while you were away. The assessment will be submitted automatically.', 'warning');
                        clearTimeTracking();
                        // Auto-submit the assessment
                        setTimeout(() => {
                            autoSubmitAssessment();
                        }, 2000);
                        return;
                    }
                } else {
                    // Starting a new assessment - clear all previous data to prevent overlap
                    clearAllAssessmentData();
                }

                // Update token balance in localStorage (only if tokens were deducted)
                if (data.data.tokens_deducted > 0) {
                    const currentUser = JSON.parse(localStorage.getItem('user') || '{}');
                    if (currentUser.wallet) {
                        currentUser.wallet.balance = data.data.remaining_balance;
                        localStorage.setItem('user', JSON.stringify(currentUser));
                    }
                }

                // Store attempt data for later use
                localStorage.setItem('currentAttemptId', data.data.attempt_id);
                localStorage.setItem('assessmentStartTime', data.data.started_at);

                // Initialize assessment
                startTime = new Date(data.data.started_at);
                
                if (isResuming && calculatedRemainingTime !== null) {
                    // Use calculated remaining time for resumed assessment
                    timeRemaining = calculatedRemainingTime;
                    console.log('Resuming assessment with remaining time:', timeRemaining);
                } else {
                    // For new assessments, always use full duration
                    const totalDurationSeconds = (currentAssessment.duration_minutes || 60) * 60;
                    timeRemaining = totalDurationSeconds;
                    
                    // Debug logging for new assessment
                    console.log('=== NEW ASSESSMENT TIME SETUP ===');
                    console.log('Assessment duration (minutes):', currentAssessment.duration_minutes);
                    console.log('Total duration (seconds):', totalDurationSeconds);
                    console.log('Setting timeRemaining to:', timeRemaining);
                    console.log('=== END TIME SETUP ===');
                }
                
                currentQuestionIndex = 0;
                
                // Load saved answers if any
                const savedAnswers = localStorage.getItem('assessmentAnswers');
                answers = savedAnswers ? JSON.parse(savedAnswers) : {};

                // Hide start page and show questions page
                document.getElementById('assessmentStartPage').classList.add('hidden');
                document.getElementById('assessmentQuestionsPage').classList.remove('hidden');

                // Check if time has already expired
                console.log('Final timeRemaining check:', timeRemaining);
                if (timeRemaining <= 0) {
                    console.log('Time expired immediately after start - this should not happen for new assessments');
                    showAssessmentAlert('Time Expired', 'The assessment time has already expired. Submitting automatically.', 'warning');
                    setTimeout(() => {
                        autoSubmitAssessment();
                    }, 2000);
                    return;
                }

                // Start timer
                startTimer();

                // Load first question
                loadQuestion();

                // Show appropriate message based on status
                if (data.data.status === 'in_progress' && data.data.tokens_deducted === 0) {
                    showAssessmentAlert('Resuming Assessment', 'Continuing your previous assessment session.', 'info');
                } else {
                    showAssessmentAlert('Assessment Started', `Assessment started successfully! ${data.data.tokens_deducted} token(s) deducted.`, 'success');
                }
            } else {
                // Reset button state for all error cases
                startBtn.innerHTML = originalText;
                startBtn.disabled = false;
                
                // Handle insufficient tokens or other errors
                if (data.message && data.message.includes('Insufficient tokens')) {
                    showAssessmentAlert('Insufficient Tokens', data.message, 'error');
                } else if (data.message && data.message.includes('already completed')) {
                    showAssessmentAlert('Assessment Already Completed', data.message, 'info');
                } else if (data.message && data.message.includes('maximum attempts')) {
                    showAssessmentAlert('Maximum Attempts Reached', data.message, 'error');
                } else {
                    showAssessmentAlert('Error', data.message || 'Failed to start assessment', 'error');
                }
            }
        } catch (error) {
            console.error('Error starting assessment:', error);
            // Reset button state in catch block
            const startBtn = document.getElementById('startAssessmentBtn');
            startBtn.innerHTML = originalText;
            startBtn.disabled = false;
            showAssessmentAlert('Network Error', 'Failed to start assessment. Please check your connection and try again.', 'error');
        }
    }

    function startTimer() {
        updateTimerDisplay();
        timerInterval = setInterval(() => {
            timeRemaining--;
            updateTimerDisplay();
            
            // Save time tracking data every 10 seconds
            if (timeRemaining % 10 === 0) {
                saveTimeTracking();
            }

            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                clearTimeTracking(); // Clear tracking data when time expires
                autoSubmitAssessment();
            }
        }, 1000);
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        document.getElementById('timerDisplay').textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    function loadQuestion() {
        const allQuestions = getAllQuestions();
        if (!currentAssessment || !allQuestions || currentQuestionIndex >= allQuestions.length) {
            return;
        }

        const question = allQuestions[currentQuestionIndex];
        const section = getQuestionSection(question.section_id);
        
        // Update question info
        document.getElementById('questionAssessmentTitle').textContent = currentAssessment.title || 'Assessment';
        document.getElementById('currentQuestionNumber').textContent = currentQuestionIndex + 1;
        document.getElementById('totalQuestions').textContent = allQuestions.length;
        const questionText = question.question_text || 'Question text not available';
        
        // Create a temporary div to parse the HTML content
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = questionText;
        
        // Find the first text node or element and prepend the question number
        const firstChild = tempDiv.firstChild;
        if (firstChild && firstChild.nodeType === Node.TEXT_NODE) {
            // If first child is text, prepend number to it
            firstChild.textContent = `${currentQuestionIndex + 1}. ${firstChild.textContent}`;
        } else if (firstChild && firstChild.nodeType === Node.ELEMENT_NODE) {
            // If first child is an element (like <p>), prepend number to its content
            if (firstChild.tagName === 'P') {
                firstChild.innerHTML = `<span class="font-bold">${currentQuestionIndex + 1}.</span> ${firstChild.innerHTML}`;
            } else {
                firstChild.innerHTML = `<span class="font-bold">${currentQuestionIndex + 1}.</span> ${firstChild.innerHTML}`;
            }
        } else {
            // Fallback: prepend to the entire content
            tempDiv.innerHTML = `<span class="font-bold">${currentQuestionIndex + 1}.</span> ${questionText}`;
        }
        
        document.getElementById('questionText').innerHTML = tempDiv.innerHTML;
        
        // Find the first HTML tag (excluding our question number span) and set its display to inline-block
        const questionElement = document.getElementById('questionText');
        const allChildren = questionElement.children;
        
        // Skip the first child (our question number span) and find the first actual content tag
        for (let i = 1; i < allChildren.length; i++) {
            const child = allChildren[i];
            if (child.tagName && ['P', 'DIV', 'SPAN', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6'].includes(child.tagName)) {
                child.style.display = 'inline-block';
                break;
            }
        }
        
        // If no tag found in children, try querySelector approach
        if (allChildren.length <= 1) {
            const firstTag = questionElement.querySelector('p, div, span, h1, h2, h3, h4, h5, h6');
            if (firstTag && firstTag !== questionElement.querySelector('.font-bold')) {
                firstTag.style.display = 'inline-block';
            }
        }
        
        // Additional fix: Ensure all paragraph tags in the question are inline-block
        const allParagraphs = questionElement.querySelectorAll('p');
        allParagraphs.forEach((p, index) => {
            if (index === 0) {
                p.style.display = 'inline-block';
            }
        });

        // Update section info
        const sectionInfo = document.getElementById('sectionInfo');
        if (section) {
            sectionInfo.innerHTML = `
                <div class="bg-[#8FC340]/10 border border-[#8FC340]/20 rounded-lg p-3 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-layer-group text-[#8FC340] mr-2"></i>
                        <span class="font-semibold text-[#8FC340]">${section.title}</span>
                        ${section.description ? `<span class="text-[#8FC340]/80 ml-2">- ${section.description}</span>` : ''}
                    </div>
                </div>
            `;
        } else {
            sectionInfo.innerHTML = '';
        }

        // Display media if available
        displayQuestionMedia(question);

        // Update progress based on answered questions
        updateProgress();

        // Generate options
        generateQuestionOptions(question);

        // Update navigation buttons
        updateNavigationButtons();

        // Load saved answer if exists
        loadSavedAnswer(question.id);
    }

    function getAllQuestions() {
        if (!currentAssessment) {
            return [];
        }
        
        // Questions are now only in sections (API updated)
        if (currentAssessment.sections) {
            let allQuestions = [];
            
            currentAssessment.sections.forEach(section => {
                if (section.questions && section.questions.length > 0) {
                    allQuestions = allQuestions.concat(section.questions);
                }
            });
            
            return allQuestions;
        }
        
        return [];
    }

    function getQuestionSection(sectionId) {
        if (!currentAssessment || !currentAssessment.sections) {
            return null;
        }
        return currentAssessment.sections.find(section => section.id === sectionId);
    }

    function generateQuestionOptions(question) {
        const optionsContainer = document.getElementById('questionOptions');
        optionsContainer.innerHTML = '';

        if (question.question_type === 'mcq' && question.answers && question.answers.length > 0) {
            // Use real MCQ options from API
            question.answers.forEach((answer, index) => {
                const optionElement = document.createElement('div');
                optionElement.className = 'flex items-center p-2 border border-gray-200 rounded-xl hover:bg-[#8FC340]/10 hover:border-[#8FC340]/30 cursor-pointer transition-all';
                optionElement.innerHTML = `
                    <input type="radio" name="question_${question.id}" value="${answer.id}" id="option_${question.id}_${index}" class="mr-4 text-blue-600">
                    <label for="option_${question.id}_${index}" class="flex-1 cursor-pointer text-sm text-gray-900 leading-relaxed">
                        ${answer.answer_text}
                    </label>
                `;
                optionElement.addEventListener('click', () => {
                    const radio = optionElement.querySelector('input[type="radio"]');
                    radio.checked = true;
                    saveAnswer(question.id, radio.value);
                });
                optionsContainer.appendChild(optionElement);
            });
        } else if (question.question_type === 'mcq') {
            // Fallback: Create standard A, B, C, D options as placeholders if no answers provided
            const standardOptions = ['A', 'B', 'C', 'D'];
            standardOptions.forEach((option, index) => {
                const optionElement = document.createElement('div');
                optionElement.className = 'flex items-center p-2 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all';
                optionElement.innerHTML = `
                    <input type="radio" name="question_${question.id}" value="${option}" id="option_${question.id}_${index}" class="mr-4 text-blue-600">
                    <label for="option_${question.id}_${index}" class="flex-1 cursor-pointer text-sm text-gray-900 leading-relaxed">
                        <span class="font-medium mr-2">${option}.</span>
                        <span class="text-gray-500">Option ${option} - (No options available)</span>
                    </label>
                `;
                optionElement.addEventListener('click', () => {
                    const radio = optionElement.querySelector('input[type="radio"]');
                    radio.checked = true;
                    saveAnswer(question.id, radio.value);
                });
                optionsContainer.appendChild(optionElement);
            });
        } else if (question.question_type === 'true_false') {
            // True/False options
            const trueFalseOptions = [
                { value: 'true', label: 'True' },
                { value: 'false', label: 'False' }
            ];
            trueFalseOptions.forEach((option, index) => {
                const optionElement = document.createElement('div');
                optionElement.className = 'flex items-center p-2 border border-gray-200 rounded-xl hover:bg-[#8FC340]/10 hover:border-[#8FC340]/30 cursor-pointer transition-all';
                optionElement.innerHTML = `
                    <input type="radio" name="question_${question.id}" value="${option.value}" id="option_${question.id}_${index}" class="mr-4 text-blue-600">
                    <label for="option_${question.id}_${index}" class="flex-1 cursor-pointer text-sm text-gray-900 leading-relaxed">
                        ${option.label}
                    </label>
                `;
                optionElement.addEventListener('click', () => {
                    const radio = optionElement.querySelector('input[type="radio"]');
                    radio.checked = true;
                    saveAnswer(question.id, radio.value);
                });
                optionsContainer.appendChild(optionElement);
            });
        } else if (question.question_type === 'matching') {
            // Matching questions - simplified interface for now
            const textInput = document.createElement('div');
            textInput.className = 'p-2 border border-gray-200 rounded-xl';
            textInput.innerHTML = `
                <label class="block text-sm text-gray-700 mb-2">Your Matching (JSON format):</label>
                <textarea name="question_${question.id}" id="text_answer_${question.id}" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 leading-relaxed" 
                    rows="4" placeholder='[{"left_item": "Item 1", "right_item": "Match 1"}, {"left_item": "Item 2", "right_item": "Match 2"}]'></textarea>
                <p class="text-xs text-gray-500 mt-1">Enter your matches in JSON format as shown in the placeholder</p>
            `;
            textInput.addEventListener('input', (e) => {
                saveAnswer(question.id, e.target.value);
            });
            optionsContainer.appendChild(textInput);
        } else if (question.question_type === 'fill_blank') {
            // Fill in the blank questions - simplified interface for now
            const textInput = document.createElement('div');
            textInput.className = 'p-2 border border-gray-200 rounded-xl';
            textInput.innerHTML = `
                <label class="block text-sm text-gray-700 mb-2">Your Answers (JSON format):</label>
                <textarea name="question_${question.id}" id="text_answer_${question.id}" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 leading-relaxed" 
                    rows="4" placeholder='[{"blank_id": 1, "text": "answer1"}, {"blank_id": 2, "text": "answer2"}]'></textarea>
                <p class="text-xs text-gray-500 mt-1">Enter your answers in JSON format as shown in the placeholder</p>
            `;
            textInput.addEventListener('input', (e) => {
                saveAnswer(question.id, e.target.value);
            });
            optionsContainer.appendChild(textInput);
        } else {
            // For short_answer and essay question types, show a text input
            const textInput = document.createElement('div');
            textInput.className = 'p-2 border border-gray-200 rounded-xl';
            const rows = question.question_type === 'essay' ? '6' : '4';
            const placeholder = question.question_type === 'essay' ? 
                'Write your detailed essay answer here...' : 
                'Enter your answer here...';
            textInput.innerHTML = `
                <label class="block text-sm text-gray-700 mb-2">Your Answer:</label>
                <textarea name="question_${question.id}" id="text_answer_${question.id}" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 leading-relaxed" 
                    rows="${rows}" placeholder="${placeholder}"></textarea>
            `;
            textInput.addEventListener('input', (e) => {
                saveAnswer(question.id, e.target.value);
            });
            optionsContainer.appendChild(textInput);
        }
    }

    function displayQuestionMedia(question) {
        let mediaContainer = document.getElementById('questionMedia');
        if (!mediaContainer) {
            // Create media container if it doesn't exist
            const questionTextElement = document.getElementById('questionText');
            const mediaDiv = document.createElement('div');
            mediaDiv.id = 'questionMedia';
            mediaDiv.className = 'mt-3 mb-4';
            questionTextElement.parentNode.insertBefore(mediaDiv, questionTextElement.nextSibling);
            mediaContainer = document.getElementById('questionMedia');
        } else {
            // Update existing container with proper spacing
            mediaContainer.className = 'mt-3 mb-4';
        }
        
        if (question.media && question.media.length > 0) {
            let mediaHTML = '';
            question.media.forEach(media => {
                if (media.media_type === 'image') {
                    mediaHTML += `
                        <div class="mb-4">
                            <img src="https://admin.skillszone.africa/storage/${media.file_path}" 
                                 alt="Question media" 
                                 class="max-w-full h-auto rounded-lg shadow-md border border-gray-200">
                            ${media.caption ? `<p class="text-sm text-gray-600 mt-2 italic">${media.caption}</p>` : ''}
                        </div>
                    `;
                } else if (media.media_type === 'video') {
                    mediaHTML += `
                        <div class="mb-4">
                            <video controls class="max-w-full h-auto rounded-lg shadow-md border border-gray-200">
                                <source src="https://admin.skillszone.africa/storage/${media.file_path}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            ${media.caption ? `<p class="text-sm text-gray-600 mt-2 italic">${media.caption}</p>` : ''}
                        </div>
                    `;
                } else if (media.media_type === 'audio') {
                    mediaHTML += `
                        <div class="mb-4">
                            <audio controls class="w-full">
                                <source src="https://admin.skillszone.africa/storage/${media.file_path}" type="audio/mpeg">
                                Your browser does not support the audio tag.
                            </audio>
                            ${media.caption ? `<p class="text-sm text-gray-600 mt-2 italic">${media.caption}</p>` : ''}
                        </div>
                    `;
                }
            });
            mediaContainer.innerHTML = mediaHTML;
        } else {
            mediaContainer.innerHTML = '';
        }
    }

    function loadSavedAnswer(questionId) {
        if (answers[questionId]) {
            // Try to find radio button first (for MCQ and True/False)
            const radio = document.querySelector(`input[name="question_${questionId}"][value="${answers[questionId]}"]`);
            if (radio) {
                radio.checked = true;
            } else {
                // Try to find text input (for text-based questions)
                const textInput = document.querySelector(`textarea[name="question_${questionId}"]`);
                if (textInput) {
                    textInput.value = answers[questionId];
                }
            }
        }
    }

    function saveAnswer(questionId, answer) {
        answers[questionId] = answer;
        // Auto-save to localStorage
        localStorage.setItem('assessmentAnswers', JSON.stringify(answers));
        // Update progress after saving answer
        updateProgress();
    }

    function updateProgress() {
        const allQuestions = getAllQuestions();
        const answeredCount = Object.keys(answers).length;
        const progress = allQuestions.length > 0 ? (answeredCount / allQuestions.length) * 100 : 0;
        
        // Update desktop progress bar
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        if (progressBar) progressBar.style.width = `${progress}%`;
        if (progressText) progressText.textContent = `${Math.round(progress)}%`;
        
        // Update mobile progress bar
        const progressBarMobile = document.getElementById('progressBarMobile');
        const progressTextMobile = document.getElementById('progressTextMobile');
        if (progressBarMobile) progressBarMobile.style.width = `${progress}%`;
        if (progressTextMobile) progressTextMobile.textContent = `${Math.round(progress)}%`;
    }

    function updateNavigationButtons() {
        const prevBtn = document.getElementById('prevQuestionBtn');
        const nextBtn = document.getElementById('nextQuestionBtn');
        const prevBtnMobile = document.getElementById('prevQuestionBtnMobile');
        const nextBtnMobile = document.getElementById('nextQuestionBtnMobile');
        const submitSection = document.getElementById('submitSection');
        const allQuestions = getAllQuestions();

        // Previous button (desktop)
        if (prevBtn) prevBtn.disabled = currentQuestionIndex === 0;
        
        // Previous button (mobile)
        if (prevBtnMobile) prevBtnMobile.disabled = currentQuestionIndex === 0;

        // Next/Submit button (desktop)
        if (currentQuestionIndex === allQuestions.length - 1) {
            if (nextBtn) nextBtn.classList.add('hidden');
            if (submitSection) submitSection.classList.remove('hidden');
        } else {
            if (nextBtn) nextBtn.classList.remove('hidden');
            if (submitSection) submitSection.classList.add('hidden');
        }
        
        // Next/Submit button (mobile)
        if (currentQuestionIndex === allQuestions.length - 1) {
            if (nextBtnMobile) nextBtnMobile.classList.add('hidden');
            if (submitSection) submitSection.classList.remove('hidden');
        } else {
            if (nextBtnMobile) nextBtnMobile.classList.remove('hidden');
            if (submitSection) submitSection.classList.add('hidden');
        }
    }

    function nextQuestion() {
        const allQuestions = getAllQuestions();
        if (currentQuestionIndex < allQuestions.length - 1) {
            currentQuestionIndex++;
            loadQuestion();
        }
    }

    function previousQuestion() {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            loadQuestion();
        }
    }

    function autoSubmitAssessment() {
        clearInterval(timerInterval);
        // Don't clear assessment data yet - submitAssessment needs it
        showAssessmentAlert('Time Up!', 'Your time has expired. The assessment will be submitted automatically.', 'warning');
        submitAssessment();
    }

    async function submitAssessment() {
        try {
            clearInterval(timerInterval);
            // Don't clear assessment data yet - we need it for submission

            const token = localStorage.getItem('token');
            if (!token) {
                showAssessmentAlert('Error', 'Authentication required', 'error');
                return;
            }

            // Get current user data (stored as 'user' in localStorage)
            const currentUser = JSON.parse(localStorage.getItem('user') || '{}');
            console.log('Current user data:', currentUser);
            
            // Check for user ID in different possible fields
            const userId = currentUser.id || currentUser.user_id || currentUser.userId;
            if (!userId) {
                console.error('User ID not found in localStorage. Available keys:', Object.keys(currentUser));
                showAssessmentAlert('Error', 'User information not found. Please log in again.', 'error');
                return;
            }

            // Calculate time taken and prepare submission data
            const endTime = new Date();
            const timeTaken = Math.floor((endTime - startTime) / 1000);
            const allQuestions = getAllQuestions();
            const answeredQuestions = Object.keys(answers).length;

            // Prepare answers in the required format
            const formattedAnswers = [];
            allQuestions.forEach(question => {
                if (answers[question.id]) {
                    let answerData = {
                        question_id: question.id,
                        question_type: question.question_type,
                        answer: {}
                    };

                    if (question.question_type === 'mcq') {
                        // For MCQ, find the selected answer
                        const selectedAnswerId = answers[question.id];
                        const selectedAnswer = question.answers ? question.answers.find(a => a.id == selectedAnswerId) : null;
                        
                        answerData.answer = {
                            selected_answer_id: parseInt(selectedAnswerId),
                            answer_text: selectedAnswer ? selectedAnswer.answer_text : `Option ${selectedAnswerId}`
                        };
                    } else if (question.question_type === 'true_false') {
                        answerData.answer = {
                            selected_option: answers[question.id],
                            answer_text: answers[question.id]
                        };
                    } else if (['short_answer', 'essay'].includes(question.question_type)) {
                        answerData.answer = {
                            text_response: answers[question.id]
                        };
                    } else if (question.question_type === 'matching') {
                        // For matching questions, parse the JSON string
                        try {
                            const matches = JSON.parse(answers[question.id]);
                            answerData.answer = { matches: matches };
                        } catch (e) {
                            answerData.answer = { matches: [] };
                        }
                    } else if (question.question_type === 'fill_blank') {
                        // For fill in the blank questions, parse the JSON string
                        try {
                            const blanks = JSON.parse(answers[question.id]);
                            answerData.answer = { blanks: blanks };
                        } catch (e) {
                            answerData.answer = { blanks: [] };
                        }
                    }

                    formattedAnswers.push(answerData);
                }
            });

            // Get attempt ID from localStorage (stored when assessment was started)
            const attemptId = localStorage.getItem('currentAttemptId');
            console.log('=== SUBMISSION DEBUG ===');
            console.log('attemptId from localStorage:', attemptId);
            console.log('currentAssessment:', currentAssessment);
            console.log('answers:', answers);
            console.log('startTime:', startTime);
            console.log('=== END SUBMISSION DEBUG ===');
            
            if (!attemptId) {
                console.error('No attempt ID found in localStorage');
                showAssessmentAlert('Error', 'Assessment session not found. Please start the assessment again.', 'error');
                return;
            }

            // Prepare the complete payload
            const payload = {
                attempt_id: parseInt(attemptId),
                assessment_id: currentAssessment.id,
                user_id: userId,
                submission_data: {
                    start_time: startTime.toISOString(),
                    end_time: endTime.toISOString(),
                    time_taken_seconds: timeTaken,
                    total_questions: allQuestions.length,
                    questions_answered: answeredQuestions,
                    answers: formattedAnswers
                },
                metadata: {
                    browser_info: navigator.userAgent,
                    submission_method: 'manual',
                    ip_address: '127.0.0.1', // This would be set by the server
                    user_agent: 'Gravity CBC Assessment Platform'
                }
            };

            console.log('Submitting assessment with payload:', payload);

            // Submit to the correct endpoint
            const response = await fetch(`${API_BASE_URL}/api/assessments/submit`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();

            if (data.success) {
                // Store results first
                localStorage.setItem('assessmentResults', JSON.stringify(data.data));
                
                // Clean up all assessment data after successful submission
                clearAllAssessmentData();
                
                // Redirect to summary page
                window.location.href = `/assessment-summary/${currentAssessment.id}`;
            } else {
                showAssessmentAlert('Error', data.message || 'Failed to submit assessment', 'error');
            }
        } catch (error) {
            console.error('Error submitting assessment:', error);
            showAssessmentAlert('Error', 'Failed to submit assessment. Please try again.', 'error');
        }
    }

    function displayResults(results) {
        // Hide questions page and show results page
        document.getElementById('assessmentQuestionsPage').classList.add('hidden');
        document.getElementById('assessmentResultsPage').classList.remove('hidden');

        // Update score
        const score = results.score || 0;
        document.getElementById('finalScore').textContent = `${score}%`;
        document.getElementById('scoreDescription').textContent = getScoreDescription(score);

        // Update breakdown
        document.getElementById('correctAnswers').textContent = results.correct_count || 0;
        document.getElementById('incorrectAnswers').textContent = results.incorrect_count || 0;
        document.getElementById('totalTime').textContent = formatTime(results.time_taken || 0);

        // Generate question review
        generateQuestionReview(results.question_reviews || []);
    }

    function getScoreDescription(score) {
        if (score >= 90) return 'Excellent work!';
        if (score >= 80) return 'Great job!';
        if (score >= 70) return 'Good effort!';
        if (score >= 60) return 'Not bad!';
        return 'Keep practicing!';
    }

    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    function generateQuestionReview(reviews) {
        const reviewContainer = document.getElementById('questionReview');
        reviewContainer.innerHTML = '';

        reviews.forEach((review, index) => {
            const reviewElement = document.createElement('div');
            reviewElement.className = `p-6 rounded-2xl border-2 ${review.is_correct ? 'border-[#8FC340]/20 bg-[#8FC340]/10' : 'border-[#EC2834]/20 bg-[#EC2834]/10'}`;
            reviewElement.innerHTML = `
                <div class="flex items-start justify-between mb-4">
                    <h4 class="text-lg font-semibold text-gray-900">Question ${index + 1}</h4>
                    <div class="flex items-center">
                        <i class="fas ${review.is_correct ? 'fa-check-circle text-[#8FC340]' : 'fa-times-circle text-[#EC2834]'} text-xl mr-2"></i>
                        <span class="font-semibold ${review.is_correct ? 'text-[#8FC340]' : 'text-[#EC2834]'}">
                            ${review.is_correct ? 'Correct' : 'Incorrect'}
                        </span>
                    </div>
                </div>
                <p class="text-gray-700 mb-4">${review.question}</p>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <span class="font-semibold text-gray-600 w-24">Your Answer:</span>
                        <span class="${review.is_correct ? 'text-[#8FC340]' : 'text-[#EC2834]'}">${review.user_answer}</span>
                    </div>
                    ${!review.is_correct ? `
                        <div class="flex items-center">
                            <span class="font-semibold text-gray-600 w-24">Correct Answer:</span>
                            <span class="text-[#8FC340]">${review.correct_answer}</span>
                        </div>
                    ` : ''}
                    ${review.explanation ? `
                        <div class="mt-3 p-3 bg-[#E368A7]/10 rounded-lg">
                            <span class="font-semibold text-[#E368A7]">Explanation:</span>
                            <p class="text-[#E368A7]/80 mt-1">${review.explanation}</p>
                        </div>
                    ` : ''}
                </div>
            `;
            reviewContainer.appendChild(reviewElement);
        });
    }

    // Event listeners
    document.getElementById('startAssessmentBtn').addEventListener('click', startAssessment);
    document.getElementById('nextQuestionBtn').addEventListener('click', nextQuestion);
    document.getElementById('prevQuestionBtn').addEventListener('click', previousQuestion);
    document.getElementById('submitAssessmentBtn').addEventListener('click', submitAssessment);
    
    // Mobile button event listeners
    document.getElementById('nextQuestionBtnMobile').addEventListener('click', nextQuestion);
    document.getElementById('prevQuestionBtnMobile').addEventListener('click', previousQuestion);
    document.getElementById('backToStartBtn').addEventListener('click', () => {
        if (confirm('Are you sure you want to go back? Your progress will be lost.')) {
            // Clean up all assessment data
            clearAllAssessmentData();
            
            document.getElementById('assessmentQuestionsPage').classList.add('hidden');
            document.getElementById('assessmentStartPage').classList.remove('hidden');
            clearInterval(timerInterval);
        }
    });

    // Custom alert function for assessment page
    function showAssessmentAlert(title, message, type = 'warning') {
        const modal = document.getElementById('assessmentAlertModal');
        const titleElement = document.getElementById('assessmentAlertTitle');
        const messageElement = document.getElementById('assessmentAlertMessage');
        const iconElement = document.getElementById('assessmentAlertIcon');
        
        if (modal && titleElement && messageElement && iconElement) {
            // Update content
            titleElement.textContent = title;
            messageElement.textContent = message;
            
            // Update icon and colors based on type
            let iconClass = 'fas fa-exclamation-triangle';
            let bgClass = 'bg-gradient-to-r from-yellow-500 to-orange-500';
            
            switch (type) {
                case 'success':
                    iconClass = 'fas fa-check-circle';
                    bgClass = 'bg-gradient-to-r from-[#8FC340] to-[#7bb02d]';
                    break;
                case 'error':
                    iconClass = 'fas fa-times-circle';
                    bgClass = 'bg-gradient-to-r from-[#EC2834] to-[#d41e2a]';
                    break;
                case 'info':
                    iconClass = 'fas fa-info-circle';
                    bgClass = 'bg-gradient-to-r from-[#E368A7] to-[#d15a8a]';
                    break;
                default: // warning
                    iconClass = 'fas fa-exclamation-triangle';
                    bgClass = 'bg-gradient-to-r from-yellow-500 to-orange-500';
            }
            
            iconElement.className = `w-16 h-16 ${bgClass} rounded-full flex items-center justify-center mx-auto mb-4`;
            iconElement.innerHTML = `<i class="${iconClass} text-white text-2xl"></i>`;
            
            // Show modal
            modal.classList.remove('hidden');
        } else {
            // Fallback to browser alert
            alert(`${title}: ${message}`);
        }
    }

    function closeAssessmentAlert() {
        const modal = document.getElementById('assessmentAlertModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }
</script>
@endsection
