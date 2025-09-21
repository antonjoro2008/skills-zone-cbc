@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#8FC340] via-[#7bb02d] to-[#E368A7] relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, #8FC340 2px, transparent 2px), radial-gradient(circle at 75% 75%, #E368A7 2px, transparent 2px); background-size: 50px 50px;"></div>
    </div>

    <!-- Header -->
    <div class="relative z-10 pt-8 pb-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="javascript:history.back()" class="inline-flex items-center bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full px-6 py-3 transition-all backdrop-blur-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Back to Assessments</span>
                    </a>
                </div>
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-white mb-2" id="assessmentTitle">Loading Questions...</h1>
                    <p class="text-white/80" id="questionCounter">Question 1 of 1</p>
                </div>
                <div class="w-32"></div> <!-- Spacer for centering -->
            </div>
        </div>
    </div>

    <!-- Book Container -->
    <div class="relative z-10 flex-1 flex items-center justify-center px-4 py-8">
        <div class="book-container w-full max-w-4xl mx-auto">
            <!-- Book Spine -->
            <div class="book-spine"></div>
            
            <!-- Book Pages -->
            <div class="book-pages">
                <!-- Left Page (Static) -->
                <div class="page left-page" id="leftPage">
                    <div class="page-content">
                        <div class="question-header">
                            <div class="question-number" id="leftQuestionNumber">1</div>
                            <div class="question-meta">
                                <span class="subject-badge" id="leftSubjectBadge">Subject</span>
                                <span class="difficulty-badge" id="leftDifficultyBadge">Easy</span>
                            </div>
                        </div>
                        <div class="question-content">
                            <div class="question-text" id="leftQuestionText">
                                <div class="loading-spinner">
                                    <div class="spinner"></div>
                                    <p>Loading question...</p>
                                </div>
                            </div>
                            <div class="question-options" id="leftQuestionOptions">
                                <!-- Options will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Page (Flippable) -->
                <div class="page right-page" id="rightPage">
                    <div class="page-front">
                        <div class="page-content">
                            <div class="question-header">
                                <div class="question-number" id="rightQuestionNumber">2</div>
                                <div class="question-meta">
                                    <span class="subject-badge" id="rightSubjectBadge">Subject</span>
                                    <span class="difficulty-badge" id="rightDifficultyBadge">Easy</span>
                                </div>
                            </div>
                        <div class="question-content">
                            <div class="question-text" id="rightQuestionText">
                                <div class="loading-spinner">
                                    <div class="spinner"></div>
                                    <p>Loading question...</p>
                                </div>
                            </div>
                            <div class="question-options" id="rightQuestionOptions">
                                <!-- Options will be loaded here -->
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="page-back">
                        <div class="page-content">
                            <div class="question-header">
                                <div class="question-number" id="nextQuestionNumber">3</div>
                                <div class="question-meta">
                                    <span class="subject-badge" id="nextSubjectBadge">Subject</span>
                                    <span class="difficulty-badge" id="nextDifficultyBadge">Easy</span>
                                </div>
                            </div>
                        <div class="question-content">
                            <div class="question-text" id="nextQuestionText">
                                <div class="loading-spinner">
                                    <div class="spinner"></div>
                                    <p>Loading question...</p>
                                </div>
                            </div>
                            <div class="question-options" id="nextQuestionOptions">
                                <!-- Options will be loaded here -->
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Controls -->
    <div class="relative z-10 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center space-x-6">
                <!-- Previous Button -->
                <button id="prevBtn" class="nav-btn prev-btn" onclick="previousQuestion()" disabled>
                    <i class="fas fa-chevron-left"></i>
                    <span>Previous</span>
                </button>

                <!-- Page Indicator -->
                <div class="page-indicator">
                    <div class="page-dots" id="pageDots">
                        <!-- Dots will be generated here -->
                    </div>
                </div>

                <!-- Next Button -->
                <button id="nextBtn" class="nav-btn next-btn" onclick="nextQuestion()">
                    <span>Next</span>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles for Book Effect -->
<style>
.book-container {
    width: 100%;
    max-width: 800px;
    height: 600px;
    position: relative;
    perspective: 1500px; /* Creates 3D depth */
    margin: 0 auto;
}

.book-spine {
    position: absolute;
    left: -20px;
    top: 0;
    bottom: 0;
    width: 20px;
    background: linear-gradient(to right, #8B4513, #A0522D);
    border-radius: 10px 0 0 10px;
    box-shadow: -5px 0 15px rgba(0,0,0,0.3);
    z-index: 1;
}

.book-pages {
    width: 100%;
    height: 100%;
    position: relative;
    background: #f8f9fa;
    border-radius: 0 15px 15px 0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    overflow: hidden;
}

.page {
    width: 50%;
    height: 100%;
    position: absolute;
    top: 0;
    transform-style: preserve-3d;
    transition: transform 0.7s ease-in-out;
    cursor: pointer;
}

.left-page {
    left: 0;
    z-index: 1;
}

.right-page {
    right: 0;
    transform-origin: left center;
    z-index: 2;
}

.page-front, .page-back {
    width: 100%;
    height: 100%;
    position: absolute;
    backface-visibility: hidden;
    background: white;
    border: 1px solid #e9ecef;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.page-back {
    transform: rotateY(180deg);
}

.page.flipped {
    transform: rotateY(-180deg);
}

/* Page content styling */
.page-content {
    padding: 40px;
    height: 100%;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    overflow-x: hidden;
    box-sizing: border-box;
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
}

/* Ensure each page has independent scrolling */
.left-page .page-content,
.right-page .page-front .page-content,
.right-page .page-back .page-content {
    overflow-y: auto;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
}

/* Question content wrapper - scrollable as a unit */
.question-content {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
    padding-right: 10px; /* Space for scrollbar */
}


.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 2px solid #e9ecef;
}

.question-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #8FC340;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    margin-right: 8px;
}

.question-meta {
    display: flex;
    gap: 10px;
}

.subject-badge, .difficulty-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.subject-badge {
    background: linear-gradient(135deg, #8FC340, #7bb02d);
    color: white;
}

.difficulty-badge {
    background: linear-gradient(135deg, #E368A7, #d15a8a);
    color: white;
}

.question-text {
    font-size: 1.25rem;
    line-height: 1.8;
    color: #2d3748;
    margin-bottom: 30px;
}

.question-options {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.option {
    padding: 20px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    background: #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.option:hover {
    border-color: #8FC340;
    background: #f0fff4;
    transform: translateX(10px);
}

.option::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #8FC340;
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.option:hover::before {
    transform: scaleY(1);
}

.option-label {
    font-weight: 600;
    color: #8FC340;
    margin-right: 15px;
    font-size: 1.1rem;
}

.option-text {
    color: #2d3748;
    font-size: 1rem;
}

.nav-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px 30px;
    background: rgba(255, 255, 255, 0.2);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    cursor: pointer;
}

.nav-btn:hover:not(:disabled) {
    background: rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}

.nav-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.page-indicator {
    display: flex;
    align-items: center;
}

.page-dots {
    display: flex;
    gap: 8px;
}

.page-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transition: all 0.3s ease;
    cursor: pointer;
}

.page-dot.active {
    background: white;
    transform: scale(1.2);
}

.page-dot:hover {
    background: rgba(255, 255, 255, 0.6);
}

.loading-spinner {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 200px;
    color: #8FC340;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #e9ecef;
    border-top: 4px solid #8FC340;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Mobile Touch Gestures */
@media (max-width: 768px) {
    .book-pages {
        min-height: 500px;
    }
    
    /* Mobile: Show only one page at a time */
    .page {
        width: 100% !important; /* Full width on mobile */
    }
    
    .left-page {
        left: 0 !important;
        width: 100% !important;
    }
    
    .right-page {
        right: 0 !important;
        width: 100% !important;
        /* Hide the right page on mobile by default */
        display: none;
    }
    
    /* Show right page only when it's the active page */
    .right-page.active {
        display: block;
    }
    
    /* Hide left page when right page is active */
    .left-page.hidden {
        display: none;
    }
    
    .page-content {
        padding: 20px;
    }
    
    .question-number {
        font-size: 2rem;
    }
    
    .question-text {
        font-size: 1.1rem;
        margin-bottom: 20px;
    }
    
    .question-options {
        gap: 10px;
    }
    
    .question-content {
        padding-right: 5px; /* Less padding on mobile */
    }
    
    .nav-btn {
        padding: 12px 20px;
        font-size: 1rem;
    }
    
    .nav-btn span {
        display: none;
    }
    
    /* Better touch scrolling on mobile */
    .page-content,
    .question-content {
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }
}

/* Touch gesture area */
.touch-area {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 10;
    cursor: grab;
}

.touch-area:active {
    cursor: grabbing;
}
</style>

<script>
// Global state
let currentPage = 0;
let questions = [];
let assessmentData = null;
let isFlipping = false;
let isMobile = window.innerWidth <= 768;

// API Configuration
const QUESTION_VIEWER_API_BASE_URL = 'https://admin.skillszone.africa';

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    const assessmentId = {{ $assessmentId }};
    loadAssessmentQuestions(assessmentId);
    
    // Add touch gesture support
    addTouchGestures();
    
    // Add click handlers for pages
    const leftPage = document.getElementById('leftPage');
    const rightPage = document.getElementById('rightPage');
    
    if (leftPage) {
        leftPage.addEventListener('click', () => {
            flipPrevious();
        });
    }
    
    if (rightPage) {
        rightPage.addEventListener('click', () => {
            flipNext();
        });
    }
    
    // Handle window resize to update mobile detection
    window.addEventListener('resize', function() {
        const wasMobile = isMobile;
        isMobile = window.innerWidth <= 768;
        
        // If mobile state changed, reload pages
        if (wasMobile !== isMobile) {
            loadQuestionsIntoPages();
        }
    });
});

async function loadAssessmentQuestions(assessmentId) {
    try {
        // Check for authentication token
        const token = localStorage.getItem('token');
        if (!token || token === 'null' || token === 'undefined' || token.length === 0) {
            // Try to get token from sessionStorage as fallback
            const sessionToken = sessionStorage.getItem('token');
            if (sessionToken && sessionToken !== 'null' && sessionToken !== 'undefined' && sessionToken.length > 0) {
                console.log('Found valid token in sessionStorage, using as fallback');
                localStorage.setItem('token', sessionToken);
            } else {
                console.error('No valid token found');
                showError('Please log in to view questions');
                setTimeout(() => {
                    window.location.href = '/';
                }, 2000);
                return;
            }
        }

        // Load assessment details and questions (same endpoint as start assessment, with auth)
        const response = await fetch(`${QUESTION_VIEWER_API_BASE_URL}/api/assessments/${assessmentId}`, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        });
        
        const data = await response.json();
        
        if (data.success && data.data) {
            assessmentData = data.data;
            
            // Extract all questions from sections (same logic as assessment.blade.php)
            questions = [];
            if (assessmentData.sections) {
                assessmentData.sections.forEach(section => {
                    if (section.questions && section.questions.length > 0) {
                        questions = questions.concat(section.questions);
                    }
                });
            }
            
            // Update page title
            document.getElementById('assessmentTitle').textContent = assessmentData.title || 'Assessment Questions';
            
            // Generate page dots
            generatePageDots();
            
            // Load questions into pages
            if (questions.length > 0) {
                loadQuestionsIntoPages();
                updateNavigation();
            } else {
                showNoQuestions();
            }
        } else {
            showError(data.message || 'Failed to load questions');
        }
    } catch (error) {
        console.error('Error loading questions:', error);
        showError('Network error. Please check your connection.');
    }
}

function loadQuestionsIntoPages() {
    if (isMobile) {
        // Mobile: Show only one page at a time
        loadMobilePages();
    } else {
        // Desktop: Show two pages side by side
        loadDesktopPages();
    }
    
    // Update question counter
    document.getElementById('questionCounter').textContent = `Question ${currentPage + 1} of ${questions.length}`;
    
    // Update page dots
    updatePageDots();
}

function loadMobilePages() {
    const currentQuestion = questions[currentPage];
    const leftPage = document.getElementById('leftPage');
    const rightPage = document.getElementById('rightPage');
    
    // Hide both pages first
    leftPage.classList.add('hidden');
    rightPage.classList.remove('active');
    
    // Show the current page
    if (currentQuestion) {
        updateLeftPageContent(currentQuestion, currentPage + 1);
        leftPage.classList.remove('hidden');
    } else {
        // At the end - show end message
        updateLeftPageContent(null, 'End of Assessment');
        leftPage.classList.remove('hidden');
    }
}

function loadDesktopPages() {
    // Calculate which questions to show based on current page
    const leftQuestionIndex = currentPage;
    const rightQuestionIndex = currentPage + 1;
    
    const leftQuestion = questions[leftQuestionIndex];
    const rightQuestion = questions[rightQuestionIndex];
    const nextQuestion = questions[rightQuestionIndex + 1];
    
    // Update left page (current question)
    if (leftQuestion) {
        updateLeftPageContent(leftQuestion, leftQuestionIndex + 1);
    }
    
    // Check if we're at the end
    if (currentPage === questions.length - 1) {
        // At the end - show current question on left, end message on right
        updateRightPageContent(null, 'End of Assessment');
        updateNextPageContent(null, 'End of Assessment');
    } else {
        // Update right page front (next question)
        if (rightQuestion) {
            updateRightPageContent(rightQuestion, rightQuestionIndex + 1);
        }
        
        // Update right page back (question after next)
        if (nextQuestion) {
            updateNextPageContent(nextQuestion, rightQuestionIndex + 2);
        } else {
            updateNextPageContent(null, 'End of Assessment');
        }
    }
}

function flipNext() {
    // Don't allow flipping if we're at the end
    if (currentPage >= questions.length - 1 || isFlipping) {
        return;
    }
    
    isFlipping = true;
    
    if (isMobile) {
        // Mobile: Simple page transition
        currentPage++;
        loadQuestionsIntoPages();
        updateNavigation();
        isFlipping = false;
    } else {
        // Desktop: Flip animation
        const rightPage = document.getElementById('rightPage');
        
        // Flip the right page
        rightPage.classList.add('flipped');
        
        currentPage++;
        
        // Update question counter
        document.getElementById('questionCounter').textContent = `Question ${currentPage + 1} of ${questions.length}`;
        
        // Update page dots
        updatePageDots();
        
        // Update navigation
        updateNavigation();
        
        // After flip animation completes, reset and prepare for next flip
        setTimeout(() => {
            // Reset the page state
            rightPage.classList.remove('flipped');
            
            // Update all pages for the new position
            loadQuestionsIntoPages();
            
            isFlipping = false;
        }, 700);
    }
}

function flipPrevious() {
    if (currentPage > 0 && !isFlipping) {
        isFlipping = true;
        
        if (isMobile) {
            // Mobile: Simple page transition
            currentPage--;
            loadQuestionsIntoPages();
            updateNavigation();
            isFlipping = false;
        } else {
            // Desktop: Flip animation
            const rightPage = document.getElementById('rightPage');
            
            currentPage--;
            
            // Update question counter
            document.getElementById('questionCounter').textContent = `Question ${currentPage + 1} of ${questions.length}`;
            
            // Update page dots
            updatePageDots();
            
            // Update navigation
            updateNavigation();
            
            // Update all pages first
            loadQuestionsIntoPages();
            
            // Then flip the page to show the previous question
            setTimeout(() => {
                rightPage.classList.add('flipped');
                
                // After flip, reset the state
                setTimeout(() => {
                    rightPage.classList.remove('flipped');
                    isFlipping = false;
                }, 700);
            }, 50);
        }
    }
}

function updateLeftPageContent(question, questionNumber) {
    updatePageContent('left', question, questionNumber);
}

function updateRightPageContent(question, questionNumber) {
    updatePageContent('right', question, questionNumber);
}

function updateNextPageContent(question, questionNumber) {
    updatePageContent('next', question, questionNumber);
}

function updatePageContent(pageType, question, questionNumber) {
    // Handle null question (end of questions)
    if (!question) {
        const questionTextEl = document.getElementById(`${pageType}QuestionText`);
        if (questionTextEl) {
            if (questionNumber === 'End of Assessment') {
                questionTextEl.innerHTML = `
                    <div class="text-center py-20">
                        <i class="fas fa-flag-checkered text-6xl text-[#8FC340] mb-4"></i>
                        <h3 class="text-2xl font-bold text-[#8FC340] mb-2">Assessment Complete!</h3>
                        <p class="text-gray-600 mb-4">You've reached the end of this assessment.</p>
                        <p class="text-sm text-gray-500">Thank you for viewing all the questions.</p>
                    </div>
                `;
            } else {
                questionTextEl.innerHTML = `
                    <div class="text-center py-20">
                        <i class="fas fa-flag-checkered text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-500 mb-2">End of Questions</h3>
                        <p class="text-gray-400">You've reached the end of this assessment.</p>
                    </div>
                `;
            }
        }
        const questionOptionsEl = document.getElementById(`${pageType}QuestionOptions`);
        if (questionOptionsEl) {
            questionOptionsEl.innerHTML = '';
        }
        
        // Clear the question number in header for end of assessment
        if (questionNumber === 'End of Assessment') {
            const questionNumberEl = document.getElementById(`${pageType}QuestionNumber`);
            if (questionNumberEl) questionNumberEl.textContent = '';
        }
        
        return;
    }
    
    // Update question number
    const questionNumberEl = document.getElementById(`${pageType}QuestionNumber`);
    if (questionNumberEl) questionNumberEl.textContent = questionNumber;
    
    // Update subject badge
    const subjectBadgeEl = document.getElementById(`${pageType}SubjectBadge`);
    if (subjectBadgeEl) subjectBadgeEl.textContent = assessmentData.subject ? assessmentData.subject.name : 'General';
    
    // Update difficulty based on question type
    const difficultyMap = {
        'mcq': 'Multiple Choice',
        'true_false': 'True/False',
        'short_answer': 'Short Answer',
        'essay': 'Essay',
        'matching': 'Matching',
        'fill_blank': 'Fill in Blank'
    };
    const difficultyBadgeEl = document.getElementById(`${pageType}DifficultyBadge`);
    if (difficultyBadgeEl) difficultyBadgeEl.textContent = difficultyMap[question.question_type] || 'Question';
    
    // Update question text (use question_text field from API)
    const questionTextEl = document.getElementById(`${pageType}QuestionText`);
    if (questionTextEl) questionTextEl.innerHTML = question.question_text || 'No question text available';
    
    // Update options based on question type
    const questionOptionsEl = document.getElementById(`${pageType}QuestionOptions`);
    if (questionOptionsEl) {
        if (question.question_type === 'mcq' && question.answers && question.answers.length > 0) {
            // Multiple choice questions
            questionOptionsEl.innerHTML = question.answers.map((answer, index) => `
                <div class="option">
                    <span class="option-label">${String.fromCharCode(65 + index)}.</span>
                    <span class="option-text">${answer.answer_text}</span>
                </div>
            `).join('');
        } else if (question.question_type === 'true_false') {
            // True/False questions
            questionOptionsEl.innerHTML = `
                <div class="option">
                    <span class="option-label">A.</span>
                    <span class="option-text">True</span>
                </div>
                <div class="option">
                    <span class="option-label">B.</span>
                    <span class="option-text">False</span>
                </div>
            `;
        } else if (['short_answer', 'essay'].includes(question.question_type)) {
            // Text input questions
            questionOptionsEl.innerHTML = `
                <div class="option">
                    <span class="option-text italic text-gray-500">This is a text input question. Type your answer in the text box.</span>
                </div>
            `;
        } else if (question.question_type === 'matching') {
            // Matching questions
            questionOptionsEl.innerHTML = `
                <div class="option">
                    <span class="option-text italic text-gray-500">This is a matching question. Match items from the left column to the right column.</span>
                </div>
            `;
        } else if (question.question_type === 'fill_blank') {
            // Fill in the blank questions
            questionOptionsEl.innerHTML = `
                <div class="option">
                    <span class="option-text italic text-gray-500">This is a fill-in-the-blank question. Fill in the missing words.</span>
                </div>
            `;
        } else {
            questionOptionsEl.innerHTML = '<p class="text-gray-500 italic">No options available for this question type</p>';
        }
    }
}

function generatePageDots() {
    const dotsContainer = document.getElementById('pageDots');
    dotsContainer.innerHTML = '';
    
    for (let i = 0; i < questions.length; i++) {
        const dot = document.createElement('div');
        dot.className = `page-dot ${i === 0 ? 'active' : ''}`;
        dot.onclick = () => goToQuestion(i);
        dotsContainer.appendChild(dot);
    }
}

function updatePageDots() {
    const dots = document.querySelectorAll('.page-dot');
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentPage);
    });
}

function updateNavigation() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    prevBtn.disabled = currentPage === 0;
    nextBtn.disabled = currentPage >= questions.length - 1;
    
    // Update button text when at the end
    if (currentPage >= questions.length - 1) {
        nextBtn.innerHTML = '<span>End Reached</span><i class="fas fa-flag-checkered ml-2"></i>';
    } else {
        nextBtn.innerHTML = '<span>Next</span><i class="fas fa-chevron-right ml-2"></i>';
    }
}

function nextQuestion() {
    flipNext();
}

function previousQuestion() {
    flipPrevious();
}

function goToQuestion(index) {
    if (index !== currentPage && !isFlipping) {
        // For now, just jump to the question
        currentPage = index;
        loadQuestionsIntoPages();
        updateNavigation();
    }
}

function addTouchGestures() {
    const bookPages = document.querySelector('.book-pages');
    let startX = 0;
    let startY = 0;
    let isDragging = false;
    
    bookPages.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
        isDragging = true;
    });
    
    bookPages.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        
        e.preventDefault();
        const currentX = e.touches[0].clientX;
        const currentY = e.touches[0].clientY;
        const deltaX = currentX - startX;
        const deltaY = currentY - startY;
        
        // Only trigger if horizontal swipe is more significant than vertical
        if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
            if (deltaX > 0) {
                // Swipe right - previous question
                flipPrevious();
            } else {
                // Swipe left - next question
                flipNext();
            }
            isDragging = false;
        }
    });
    
    bookPages.addEventListener('touchend', () => {
        isDragging = false;
    });
    
    // Mouse drag support for desktop
    let mouseStartX = 0;
    let isMouseDragging = false;
    
    bookPages.addEventListener('mousedown', (e) => {
        mouseStartX = e.clientX;
        isMouseDragging = true;
        bookPages.style.cursor = 'grabbing';
    });
    
    bookPages.addEventListener('mousemove', (e) => {
        if (!isMouseDragging) return;
        
        e.preventDefault();
        const deltaX = e.clientX - mouseStartX;
        
        if (Math.abs(deltaX) > 100) {
            if (deltaX > 0) {
                flipPrevious();
            } else {
                flipNext();
            }
            isMouseDragging = false;
            bookPages.style.cursor = 'grab';
        }
    });
    
    bookPages.addEventListener('mouseup', () => {
        isMouseDragging = false;
        bookPages.style.cursor = 'grab';
    });
    
    bookPages.addEventListener('mouseleave', () => {
        isMouseDragging = false;
        bookPages.style.cursor = 'grab';
    });
}

function showNoQuestions() {
    document.getElementById('leftQuestionText').innerHTML = `
        <div class="text-center py-20">
            <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-2xl font-bold text-gray-500 mb-2">No Questions Available</h3>
            <p class="text-gray-400">This assessment doesn't have any questions yet.</p>
        </div>
    `;
}

function showError(message) {
    document.getElementById('leftQuestionText').innerHTML = `
        <div class="text-center py-20">
            <i class="fas fa-exclamation-triangle text-6xl text-red-300 mb-4"></i>
            <h3 class="text-2xl font-bold text-red-500 mb-2">Error</h3>
            <p class="text-red-400">${message}</p>
        </div>
    `;
}
</script>
@endsection
