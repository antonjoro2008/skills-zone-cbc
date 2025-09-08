@extends('layouts.app')

@section('title', 'Assessment Summary - SkillsZone')

@section('content')
    <!-- Assessment Summary Page -->
    <div id="assessmentSummaryPage" class="min-h-screen bg-gray-50">
        <!-- Header -->
        <div class="gradient-bg text-white py-8">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trophy text-white text-3xl"></i>
                </div>
                <h1 class="text-4xl font-bold mb-2">Assessment Complete!</h1>
                <p class="text-gray-200 text-lg" id="assessmentTitle">Loading assessment details...</p>
            </div>
        </div>

        <!-- Summary Content -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Score Overview -->
            <div class="bg-white rounded-3xl shadow-lg p-8 mb-8">
                <div class="text-center mb-8">
                    <div class="relative inline-block">
                        <div class="w-32 h-32 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white" id="finalScore">0%</div>
                                <div class="text-sm text-white opacity-90">Score</div>
                            </div>
                        </div>
                        <!-- Score Ring -->
                        <svg class="absolute inset-0 w-32 h-32 transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8" fill="none" class="text-gray-200"></circle>
                            <circle cx="50" cy="50" r="40" stroke="currentColor" stroke-width="8" fill="none" 
                                    stroke-dasharray="251.2" stroke-dashoffset="0" 
                                    class="text-green-500 transition-all duration-1000 ease-in-out" 
                                    id="scoreRing"></circle>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2" id="scoreDescription">Great job!</h2>
                    <p class="text-gray-600" id="scoreDetails">You answered questions correctly</p>
                </div>

                <!-- Score Breakdown Grid -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-green-50 rounded-2xl p-6 text-center border border-green-200">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-check text-green-600 text-xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-green-600" id="correctAnswers">0</div>
                        <div class="text-sm text-gray-600">Correct</div>
                    </div>
                    <div class="bg-red-50 rounded-2xl p-6 text-center border border-red-200">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-times text-red-600 text-xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-red-600" id="incorrectAnswers">0</div>
                        <div class="text-sm text-gray-600">Incorrect</div>
                    </div>
                    <div class="bg-blue-50 rounded-2xl p-6 text-center border border-blue-200">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-clock text-blue-600 text-xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-blue-600" id="timeTaken">0:00</div>
                        <div class="text-sm text-gray-600">Time Taken</div>
                    </div>
                    <div class="bg-purple-50 rounded-2xl p-6 text-center border border-purple-200">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-question-circle text-purple-600 text-xl"></i>
                        </div>
                        <div class="text-3xl font-bold text-purple-600" id="totalQuestions">0</div>
                        <div class="text-sm text-gray-600">Total Questions</div>
                    </div>
                </div>
            </div>

            <!-- Detailed Statistics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Performance Metrics -->
                <div class="bg-white rounded-3xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-chart-bar text-blue-600 mr-3"></i>
                        Performance Metrics
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Questions Answered</span>
                            <span class="font-semibold text-gray-900" id="questionsAnswered">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Auto-marked Questions</span>
                            <span class="font-semibold text-gray-900" id="autoMarkedQuestions">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Manual Review Required</span>
                            <span class="font-semibold text-gray-900" id="manualReviewQuestions">0</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Score (Auto-marked)</span>
                            <span class="font-semibold text-gray-900" id="autoMarkedScore">0/0</span>
                        </div>
                    </div>
                </div>

                <!-- Assessment Details -->
                <div class="bg-white rounded-3xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-info-circle text-green-600 mr-3"></i>
                        Assessment Details
                    </h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Assessment ID</span>
                            <span class="font-semibold text-gray-900" id="assessmentId">-</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Attempt ID</span>
                            <span class="font-semibold text-gray-900" id="attemptId">-</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Submission Time</span>
                            <span class="font-semibold text-gray-900" id="submissionTime">-</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Duration</span>
                            <span class="font-semibold text-gray-900" id="assessmentDuration">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Review Section -->
            <div class="bg-white rounded-3xl shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-list-check text-purple-600 mr-3"></i>
                    Question Review & Feedback
                </h3>
                
                <!-- Filter Tabs -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <button class="filter-tab active px-4 py-2 rounded-lg font-semibold transition-all" data-filter="all">
                        All Questions
                    </button>
                    <button class="filter-tab px-4 py-2 rounded-lg font-semibold transition-all" data-filter="correct">
                        <i class="fas fa-check mr-2"></i>Correct
                    </button>
                    <button class="filter-tab px-4 py-2 rounded-lg font-semibold transition-all" data-filter="incorrect">
                        <i class="fas fa-times mr-2"></i>Incorrect
                    </button>
                    <button class="filter-tab px-4 py-2 rounded-lg font-semibold transition-all" data-filter="manual">
                        <i class="fas fa-user-check mr-2"></i>Manual Review
                    </button>
                </div>

                <!-- Questions List -->
                <div id="questionReview" class="space-y-6">
                    <!-- Question reviews will be dynamically generated -->
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="text-center mt-8 space-x-4">
                <button onclick="window.location.href='/assessments'" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                    <i class="fas fa-list mr-2"></i>Back to Assessments
                </button>
                <button onclick="window.location.href='/dashboard'" class="bg-gray-100 text-gray-700 px-8 py-4 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </button>
                <button onclick="downloadResults()" class="bg-green-100 text-green-700 px-8 py-4 rounded-xl font-semibold hover:bg-green-200 transition-all">
                    <i class="fas fa-download mr-2"></i>Download Results
                </button>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-8 text-center">
            <div class="w-16 h-16 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
            <p class="text-gray-600">Loading your results...</p>
        </div>
    </div>
@endsection

@section('scripts')
<style>
    .filter-tab {
        background-color: #f3f4f6;
        color: #6b7280;
    }
    .filter-tab.active {
        background-color: #3b82f6;
        color: white;
    }
    .filter-tab:hover {
        background-color: #e5e7eb;
    }
    .filter-tab.active:hover {
        background-color: #2563eb;
    }
</style>

<script>
    let assessmentResults = null;
    let allQuestions = [];

    document.addEventListener('DOMContentLoaded', function() {
        loadAssessmentResults();
    });

    function loadAssessmentResults() {
        // Get results from localStorage
        const resultsData = localStorage.getItem('assessmentResults');
        if (!resultsData) {
            showAlert('Error', 'No assessment results found. Please try taking the assessment again.', 'error');
            window.location.href = '/assessments';
            return;
        }

        try {
            assessmentResults = JSON.parse(resultsData);
            displayResults();
        } catch (error) {
            console.error('Error parsing assessment results:', error);
            showAlert('Error', 'Failed to load assessment results.', 'error');
            window.location.href = '/assessments';
        }
    }

    function displayResults() {
        if (!assessmentResults) return;

        // Hide loading overlay
        document.getElementById('loadingOverlay').classList.add('hidden');

        // Update basic info
        document.getElementById('assessmentTitle').textContent = 'Assessment Results';
        document.getElementById('assessmentId').textContent = assessmentResults.assessment_id || '-';
        document.getElementById('attemptId').textContent = assessmentResults.attempt_id || '-';
        
        // Update submission time
        const submissionTime = new Date().toLocaleString();
        document.getElementById('submissionTime').textContent = submissionTime;

        // Update summary data
        const summary = assessmentResults.summary || {};
        const percentage = summary.percentage || 0;
        
        document.getElementById('finalScore').textContent = `${percentage.toFixed(1)}%`;
        document.getElementById('scoreDescription').textContent = getScoreDescription(percentage);
        document.getElementById('scoreDetails').textContent = `You scored ${summary.correct_answers || 0} out of ${summary.auto_marked_questions || 0} auto-marked questions`;
        
        // Update breakdown
        document.getElementById('correctAnswers').textContent = summary.correct_answers || 0;
        document.getElementById('incorrectAnswers').textContent = summary.incorrect_answers || 0;
        document.getElementById('totalQuestions').textContent = summary.total_questions || 0;
        document.getElementById('questionsAnswered').textContent = summary.questions_answered || 0;
        document.getElementById('autoMarkedQuestions').textContent = summary.auto_marked_questions || 0;
        document.getElementById('manualReviewQuestions').textContent = summary.not_auto_marked_questions || 0;
        document.getElementById('autoMarkedScore').textContent = `${summary.score || 0}/${summary.out_of || 0}`;

        // Update time taken
        const timeTaken = assessmentResults.submission_data?.time_taken_seconds || 0;
        document.getElementById('timeTaken').textContent = formatTime(timeTaken);
        document.getElementById('assessmentDuration').textContent = formatTime(timeTaken);

        // Animate score ring
        animateScoreRing(percentage);

        // Generate question reviews
        generateQuestionReviews(assessmentResults.feedback || []);

        // Setup filter functionality
        setupFilters();
    }

    function getScoreDescription(score) {
        if (score >= 90) return 'Outstanding Performance!';
        if (score >= 80) return 'Excellent Work!';
        if (score >= 70) return 'Great Job!';
        if (score >= 60) return 'Good Effort!';
        if (score >= 50) return 'Keep Practicing!';
        return 'Room for Improvement';
    }

    function formatTime(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const remainingSeconds = seconds % 60;
        
        if (hours > 0) {
            return `${hours}:${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
        }
        return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
    }

    function animateScoreRing(percentage) {
        const ring = document.getElementById('scoreRing');
        const circumference = 2 * Math.PI * 40; // radius = 40
        const offset = circumference - (percentage / 100) * circumference;
        
        ring.style.strokeDashoffset = offset;
    }

    function generateQuestionReviews(feedback) {
        const reviewContainer = document.getElementById('questionReview');
        reviewContainer.innerHTML = '';

        allQuestions = feedback;

        feedback.forEach((review, index) => {
            const reviewElement = document.createElement('div');
            const isCorrect = review.is_correct;
            const isManualReview = !review.is_correct && !review.correct_answer;
            
            reviewElement.className = `question-review p-6 rounded-2xl border-2 transition-all ${
                isCorrect ? 'border-green-200 bg-green-50' : 
                isManualReview ? 'border-yellow-200 bg-yellow-50' : 
                'border-red-200 bg-red-50'
            }`;
            
            reviewElement.setAttribute('data-status', 
                isCorrect ? 'correct' : 
                isManualReview ? 'manual' : 
                'incorrect'
            );

            reviewElement.innerHTML = `
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 ${
                            isCorrect ? 'bg-green-100' : 
                            isManualReview ? 'bg-yellow-100' : 
                            'bg-red-100'
                        }">
                            <span class="text-sm font-bold ${
                                isCorrect ? 'text-green-600' : 
                                isManualReview ? 'text-yellow-600' : 
                                'text-red-600'
                            }">${index + 1}</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900">Question ${review.question_number}</h4>
                    </div>
                    <div class="flex items-center">
                        <i class="fas ${
                            isCorrect ? 'fa-check-circle text-green-600' : 
                            isManualReview ? 'fa-clock text-yellow-600' : 
                            'fa-times-circle text-red-600'
                        } text-xl mr-2"></i>
                        <span class="font-semibold ${
                            isCorrect ? 'text-green-600' : 
                            isManualReview ? 'text-yellow-600' : 
                            'text-red-600'
                        }">
                            ${isCorrect ? 'Correct' : isManualReview ? 'Pending Review' : 'Incorrect'}
                        </span>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="text-gray-700 leading-relaxed" id="questionText_${index}">
                        ${review.question_text}
                    </div>
                </div>

                ${review.media && review.media.length > 0 ? `
                    <div class="mb-4">
                        ${review.media.map(media => `
                            <div class="mb-2">
                                ${media.media_type === 'image' ? `
                                    <img src="https://admin.skillszone.africa/storage/${media.file_path}" 
                                         alt="Question media" 
                                         class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                                ` : media.media_type === 'video' ? `
                                    <video controls class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                                        <source src="https://admin.skillszone.africa/storage/${media.file_path}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                ` : media.media_type === 'audio' ? `
                                    <audio controls class="w-full">
                                        <source src="https://admin.skillszone.africa/storage/${media.file_path}" type="audio/mpeg">
                                        Your browser does not support the audio tag.
                                    </audio>
                                ` : ''}
                                ${media.caption ? `<p class="text-sm text-gray-600 mt-1 italic">${media.caption}</p>` : ''}
                            </div>
                        `).join('')}
                    </div>
                ` : ''}

                <div class="space-y-3">
                    <div class="flex items-start">
                        <span class="font-semibold text-gray-600 w-24 flex-shrink-0">Your Answer:</span>
                        <span class="flex-1 ${
                            isCorrect ? 'text-green-600' : 
                            isManualReview ? 'text-yellow-600' : 
                            'text-red-600'
                        }">${review.selected_answer || 'No answer provided'}</span>
                    </div>
                    
                    ${!isCorrect && review.correct_answer ? `
                        <div class="flex items-start">
                            <span class="font-semibold text-gray-600 w-24 flex-shrink-0">Correct Answer:</span>
                            <span class="flex-1 text-green-600">${review.correct_answer}</span>
                        </div>
                    ` : ''}
                    
                    ${review.explanation ? `
                        <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="flex items-start">
                                <i class="fas fa-lightbulb text-blue-600 mr-2 mt-1"></i>
                                <div>
                                    <span class="font-semibold text-blue-800">Explanation:</span>
                                    <p class="text-blue-700 mt-1 leading-relaxed">${review.explanation}</p>
                                </div>
                            </div>
                        </div>
                    ` : ''}
                </div>
            `;
            
            reviewContainer.appendChild(reviewElement);
        });
    }

    function setupFilters() {
        const filterTabs = document.querySelectorAll('.filter-tab');
        const questionReviews = document.querySelectorAll('.question-review');

        filterTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Update active tab
                filterTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // Filter questions
                const filter = tab.getAttribute('data-filter');
                questionReviews.forEach(review => {
                    const status = review.getAttribute('data-status');
                    if (filter === 'all' || status === filter) {
                        review.style.display = 'block';
                    } else {
                        review.style.display = 'none';
                    }
                });
            });
        });
    }

    function downloadResults() {
        if (!assessmentResults) return;

        const dataStr = JSON.stringify(assessmentResults, null, 2);
        const dataBlob = new Blob([dataStr], {type: 'application/json'});
        const url = URL.createObjectURL(dataBlob);
        
        const link = document.createElement('a');
        link.href = url;
        link.download = `assessment-results-${assessmentResults.attempt_id || 'unknown'}.json`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    }

    // Custom alert function for assessment summary page
    function showAlert(title, message, type = 'warning') {
        // Use the existing showAlert function from main scripts
        if (typeof window.showAlert === 'function') {
            window.showAlert(title, message, type);
        } else {
            alert(`${title}: ${message}`);
        }
    }
</script>
@endsection
