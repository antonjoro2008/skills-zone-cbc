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
                        <span class="hidden sm:inline">Back to Assessments</span>
                    </a>
                </div>
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-white mb-2" id="assessmentTitle">Loading Questions...</h1>
                    <p class="text-white/80" id="questionCounter">Question 1 of 1</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Sound Toggle Button -->
                    <button id="soundToggle" class="inline-flex items-center bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full p-3 transition-all backdrop-blur-sm" title="Toggle Sound">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i id="soundIconOn" class="fas fa-volume-up text-white"></i>
                            <i id="soundIconOff" class="fas fa-volume-off text-white" style="display: none;"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Flip Container -->
    <div class="mobile-flip-container" id="mobileFlipContainer">
        <div class="mobile-page" id="mobilePage">
            <div class="mobile-page-content" id="mobilePageContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="mobile-page-back" id="mobilePageBack">
                <!-- Back content will be loaded here -->
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

    <!-- Navigation Controls - Desktop Only -->
    <div class="relative z-10 pb-8 hidden sm:block">
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

/* Remove fixed height on mobile */
@media (max-width: 768px) {
    .book-container {
        height: auto;
        min-height: auto;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
}

/* Sound toggle button styling */
#soundToggle {
    transition: all 0.2s ease;
}

#soundToggle:hover {
    transform: scale(1.05);
}

#soundIcon {
    font-size: 1.2rem;
    transition: all 0.2s ease;
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

/* Mobile Flip Effect - Heyzine Style */
.mobile-flip-container {
    position: relative;
    width: 100%;
    height: auto;
    min-height: auto;
    perspective: 1200px;
    perspective-origin: center center;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.mobile-page {
    position: relative;
    width: 100%;
    height: auto;
    min-height: auto;
    background: white;
    backface-visibility: hidden;
    transform-style: preserve-3d;
    transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: -8px 0 20px rgba(0, 0, 0, 0.15);
    border-radius: 0 8px 8px 0;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.mobile-page.flipping {
    transform: rotateY(-180deg);
    box-shadow: 8px 0 20px rgba(0, 0, 0, 0.15);
}

.mobile-page-content {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    padding: 20px;
    padding-bottom: 80px; /* Space for navigation buttons */
    box-sizing: border-box;
    overflow-y: auto;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
    scroll-behavior: smooth;
    display: flex;
    flex-direction: column;
}

.mobile-page-back {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: white;
    transform: rotateY(180deg);
    backface-visibility: hidden;
    padding: 20px;
    padding-bottom: 80px; /* Space for navigation buttons */
    box-sizing: border-box;
    overflow-y: auto;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
    scroll-behavior: smooth;
    border-radius: 8px 0 0 8px;
    display: flex;
    flex-direction: column;
}

/* Mobile question content styling */
.mobile-question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e9ecef;
}

.mobile-question-number {
    font-size: 2rem;
    font-weight: bold;
    color: #8FC340;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    margin-right: 8px;
}

.mobile-question-meta {
    display: flex;
    gap: 8px;
}

.mobile-subject-badge, .mobile-difficulty-badge {
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.mobile-subject-badge {
    background: linear-gradient(135deg, #8FC340, #7bb02d);
    color: white;
}

.mobile-difficulty-badge {
    background: linear-gradient(135deg, #E368A7, #d15a8a);
    color: white;
}

.mobile-question-text {
    font-size: 1.1rem;
    line-height: 1.7;
    color: #2d3748;
    margin-bottom: 20px;
    word-wrap: break-word;
    overflow-wrap: break-word;
    flex-shrink: 0;
}

.mobile-question-options {
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
    margin-bottom: 20px;
}

.mobile-option {
    padding: 15px;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    background: #f8f9fa;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 12px;
}

.mobile-option-letter {
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #8FC340, #7bb02d);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: bold;
    flex-shrink: 0;
}

.mobile-option-text {
    flex: 1;
    font-size: 0.95rem;
    line-height: 1.5;
    color: #2d3748;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/* Mobile end of assessment styling */
.mobile-end-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    text-align: center;
    padding: 20px;
}

.mobile-end-icon {
    font-size: 4rem;
    color: #8FC340;
    margin-bottom: 20px;
}

.mobile-end-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #8FC340;
    margin-bottom: 15px;
}

.mobile-end-message {
    font-size: 1rem;
    color: #6b7280;
    margin-bottom: 10px;
    line-height: 1.5;
}

.mobile-end-subtitle {
    font-size: 0.875rem;
    color: #9ca3af;
    line-height: 1.4;
}

/* Mobile Touch Gestures */
@media (max-width: 768px) {
    .book-pages {
        min-height: 500px;
    }
    
    /* Mobile: Use flip container instead of book pages */
    .book-pages {
        display: none;
    }
    
    .mobile-flip-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: auto;
        min-height: auto;
        flex: 1;
    }
    
    .page-content {
        padding: 20px;
    }
    
    /* Adjust mobile page content spacing */
    .mobile-page-content,
    .mobile-page-back {
        padding: 15px;
        display: flex;
        flex-direction: column;
        height: auto;
        min-height: auto;
        flex: 1;
        background: white;
    }
    
    /* Mobile question content wrapper */
    .mobile-question-content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    /* Mobile end content wrapper */
    .mobile-end-content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .mobile-question-header {
        margin-bottom: 12px;
        padding-bottom: 8px;
    }
    
    .mobile-question-text {
        margin-bottom: 12px;
        font-size: 1rem;
    }
    
    .mobile-question-options {
        gap: 8px;
        margin-bottom: 12px;
    }
    
    .mobile-option {
        padding: 10px;
    }
    
    /* Mobile navigation buttons */
    .mobile-nav-buttons {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: auto;
        padding-top: 15px;
        flex-shrink: 0;
    }
    
    .mobile-nav-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .mobile-nav-btn:hover:not(:disabled) {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    
    .mobile-nav-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #9ca3af;
    }
    
    .mobile-prev-btn {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    }
    
    .mobile-prev-btn:hover:not(:disabled) {
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.4);
    }
    
    /* Mobile end of assessment adjustments */
    .mobile-end-container {
        padding: 15px;
        height: auto;
        min-height: 300px;
    }
    
    .mobile-end-icon {
        font-size: 3rem;
        margin-bottom: 15px;
    }
    
    .mobile-end-title {
        font-size: 1.25rem;
        margin-bottom: 12px;
    }
    
    .mobile-end-message {
        font-size: 0.9rem;
        margin-bottom: 8px;
    }
    
    .mobile-end-subtitle {
        font-size: 0.8rem;
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

/* Desktop: Hide mobile flip container */
@media (min-width: 769px) {
    .mobile-flip-container {
        display: none;
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

// Page flip sound
const pageFlipSound = new Audio('/sounds/flip-sm.mp3');
let soundEnabled = true;

// API Configuration
const QUESTION_VIEWER_API_BASE_URL = 'https://admin.skillszone.africa';

// Mobile flip animation functions - Heyzine style
function playPageFlipSound() {
    if (!soundEnabled) return;
    
    try {
        pageFlipSound.currentTime = 0;
        pageFlipSound.volume = 0.3;
        pageFlipSound.play().catch(e => {
            // Ignore autoplay restrictions
            console.log('Audio autoplay prevented:', e);
        });
    } catch (e) {
        console.log('Audio not available:', e);
    }
}

// Sound toggle functionality
function toggleSound() {
    soundEnabled = !soundEnabled;
    const soundIconOn = document.getElementById('soundIconOn');
    const soundIconOff = document.getElementById('soundIconOff');
    const soundToggle = document.getElementById('soundToggle');
    
    if (soundEnabled) {
        soundIconOn.style.display = 'inline';
        soundIconOff.style.display = 'none';
        soundToggle.title = 'Mute Sound';
    } else {
        soundIconOn.style.display = 'none';
        soundIconOff.style.display = 'inline';
        soundToggle.title = 'Enable Sound';
    }
}

function showMobileFlipAnimation(direction = 'next') {
    const mobilePage = document.getElementById('mobilePage');
    if (!mobilePage) return;
    
    // Play flip sound
    playPageFlipSound();
    
    // Prepare next content on the back
    const nextQuestion = direction === 'next' ? questions[currentPage + 1] : questions[currentPage - 1];
    if (nextQuestion) {
        updateMobilePageContent('back', nextQuestion, direction === 'next' ? currentPage + 2 : currentPage);
    }
    
    // Reset any existing flip state first
    mobilePage.classList.remove('flipping');
    
    // Force a reflow to ensure the class removal takes effect
    mobilePage.offsetHeight;
    
    // Start flip animation with proper timing
    requestAnimationFrame(() => {
        mobilePage.classList.add('flipping');
    });
    
    // After flip completes, update content and reset
    setTimeout(() => {
        // Update the front content
        const currentQuestion = questions[currentPage];
        if (currentQuestion) {
            updateMobilePageContent('front', currentQuestion, currentPage + 1);
        }
        
        // Reset flip state
        mobilePage.classList.remove('flipping');
    }, 600);
}

function updateMobilePageContent(side, question, questionNumber) {
    const contentEl = side === 'front' ? 
        document.getElementById('mobilePageContent') : 
        document.getElementById('mobilePageBack');
    
    if (!contentEl) return;
    
    if (!question) {
        // End of assessment - mobile optimized
        contentEl.innerHTML = `
            <div class="mobile-end-content">
                <div class="mobile-end-container">
                    <div class="mobile-end-icon">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    <h3 class="mobile-end-title">Assessment Complete!</h3>
                    <p class="mobile-end-message">You've reached the end of this assessment.</p>
                    <p class="mobile-end-subtitle">Thank you for viewing all the questions.</p>
                </div>
                
                <!-- Mobile Navigation Buttons for End Page -->
                <div class="mobile-nav-buttons">
                    <button class="mobile-nav-btn mobile-prev-btn" onclick="flipPrevious()">
                        <i class="fas fa-chevron-left"></i>
                        <span>Previous</span>
                    </button>
                    <button class="mobile-nav-btn mobile-next-btn" disabled>
                        <span>End</span>
                        <i class="fas fa-flag-checkered"></i>
                    </button>
                </div>
            </div>
        `;
        return;
    }
    
    // Get subject name from assessment data
    const subjectName = assessmentData && assessmentData.subject ? assessmentData.subject.name : 'Subject';
    
    // Update difficulty based on question type (same as desktop)
    const difficultyMap = {
        'mcq': 'Multiple Choice',
        'true_false': 'True/False',
        'short_answer': 'Short Answer',
        'essay': 'Essay',
        'matching': 'Matching',
        'fill_blank': 'Fill in Blank'
    };
    const difficultyText = difficultyMap[question.question_type] || 'Question';
    
    // Generate options based on question type (mobile-specific styling)
    let optionsHtml = '';
    if (question.question_type === 'mcq' && question.answers && question.answers.length > 0) {
        // Multiple choice questions
        optionsHtml = question.answers.map((answer, index) => `
            <div class="mobile-option">
                <div class="mobile-option-letter">${String.fromCharCode(65 + index)}</div>
                <div class="mobile-option-text">${answer.answer_text}</div>
            </div>
        `).join('');
    } else if (question.question_type === 'true_false') {
        // True/False questions
        optionsHtml = `
            <div class="mobile-option">
                <div class="mobile-option-letter">A</div>
                <div class="mobile-option-text">True</div>
            </div>
            <div class="mobile-option">
                <div class="mobile-option-letter">B</div>
                <div class="mobile-option-text">False</div>
            </div>
        `;
    } else if (['short_answer', 'essay'].includes(question.question_type)) {
        // Text input questions
        optionsHtml = `
            <div class="mobile-option">
                <div class="mobile-option-text" style="font-style: italic; color: #6b7280;">This is a text input question. Type your answer in the text box.</div>
            </div>
        `;
    } else if (question.question_type === 'matching') {
        // Matching questions
        optionsHtml = `
            <div class="mobile-option">
                <div class="mobile-option-text" style="font-style: italic; color: #6b7280;">This is a matching question. Match items from column A to column B.</div>
            </div>
        `;
    } else {
        // Default case
        optionsHtml = `
            <div class="mobile-option">
                <div class="mobile-option-text" style="font-style: italic; color: #6b7280;">No options available for this question type.</div>
            </div>
        `;
    }
    
    contentEl.innerHTML = `
        <div class="mobile-question-content">
            <div class="mobile-question-header">
                <div class="mobile-question-number">${questionNumber}</div>
                <div class="mobile-question-meta">
                    <span class="mobile-subject-badge">${subjectName}</span>
                    <span class="mobile-difficulty-badge">${difficultyText}</span>
                </div>
            </div>
            <div class="mobile-question-text">${question.question_text || 'No question text available'}</div>
            <div class="mobile-question-options">${optionsHtml}</div>
        </div>
        
        <!-- Mobile Navigation Buttons -->
        <div class="mobile-nav-buttons">
            <button class="mobile-nav-btn mobile-prev-btn" onclick="flipPrevious()" ${currentPage === 0 ? 'disabled' : ''}>
                <i class="fas fa-chevron-left"></i>
                <span>Previous</span>
            </button>
            <button class="mobile-nav-btn mobile-next-btn" onclick="flipNext()" ${currentPage >= questions.length - 1 ? 'disabled' : ''}>
                <span>Next</span>
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    `;
}

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    const assessmentId = {{ $assessmentId }};
    loadAssessmentQuestions(assessmentId);
    
    // Add touch gesture support
    addTouchGestures();
    
    // Add click handlers for pages
    const leftPage = document.getElementById('leftPage');
    const rightPage = document.getElementById('rightPage');
    const mobilePage = document.getElementById('mobilePage');
    
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
    
    // Mobile page click and touch handlers
    if (mobilePage) {
        let touchStartX = 0;
        let touchStartY = 0;
        let touchEndX = 0;
        let touchEndY = 0;
        
        // Touch start
        mobilePage.addEventListener('touchstart', (e) => {
            if (isMobile && !isFlipping) {
                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
            }
        }, { passive: true });
        
        // Touch end
        mobilePage.addEventListener('touchend', (e) => {
            if (isMobile && !isFlipping) {
                touchEndX = e.changedTouches[0].clientX;
                touchEndY = e.changedTouches[0].clientY;
                
                const deltaX = touchEndX - touchStartX;
                const deltaY = touchEndY - touchStartY;
                
                // More sensitive swipe detection - reduce threshold and improve horizontal detection
                if (Math.abs(deltaX) > 30 && Math.abs(deltaX) > Math.abs(deltaY) * 1.5) {
                    if (deltaX > 0) {
                        // Swipe right - go to previous
                        flipPrevious();
                    } else {
                        // Swipe left - go to next
                        flipNext();
                    }
                }
            }
        }, { passive: true });
        
        // Click handlers for non-touch devices
        mobilePage.addEventListener('click', (e) => {
            if (isMobile && !isFlipping) {
                const rect = mobilePage.getBoundingClientRect();
                const clickX = e.clientX - rect.left;
                const centerX = rect.width / 2;
                
                if (clickX < centerX) {
                    flipPrevious();
                } else {
                    flipNext();
                }
            }
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
    
    // Sound toggle button
    const soundToggle = document.getElementById('soundToggle');
    if (soundToggle) {
        soundToggle.addEventListener('click', toggleSound);
        // Initialize sound button state
        initializeSoundButton();
    }
});

// Initialize sound button state
function initializeSoundButton() {
    const soundIconOn = document.getElementById('soundIconOn');
    const soundIconOff = document.getElementById('soundIconOff');
    const soundToggle = document.getElementById('soundToggle');
    
    if (soundEnabled) {
        soundIconOn.style.display = 'inline';
        soundIconOff.style.display = 'none';
        soundToggle.title = 'Mute Sound';
    } else {
        soundIconOn.style.display = 'none';
        soundIconOff.style.display = 'inline';
        soundToggle.title = 'Enable Sound';
    }
}

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
    
    // Update mobile page content
    if (currentQuestion) {
        updateMobilePageContent('front', currentQuestion, currentPage + 1);
    } else {
        // At the end - show end message
        updateMobilePageContent('front', null, 'End of Assessment');
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
        // Mobile: Heyzine-style flip animation
        currentPage++;
        
        // Check if we've reached the end
        if (currentPage >= questions.length) {
            // Show end of assessment page
            showMobileFlipAnimation('next');
            setTimeout(() => {
                updateMobilePageContent('front', null, 'End of Assessment');
                updateNavigation();
                updatePageDots();
                isFlipping = false;
            }, 300);
        } else {
            showMobileFlipAnimation('next');
            
            // Update navigation and page dots
            updateNavigation();
            updatePageDots();
            
            // Reset flipping state after animation
            setTimeout(() => {
                isFlipping = false;
            }, 600);
        }
    } else {
        // Desktop: Flip animation
        const rightPage = document.getElementById('rightPage');
        
        // Play flip sound for desktop
        playPageFlipSound();
        
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
            // Mobile: Heyzine-style flip animation
            currentPage--;
            showMobileFlipAnimation('previous');
            
            // Update navigation and page dots
            updateNavigation();
            updatePageDots();
            
            // Reset flipping state after animation
            setTimeout(() => {
                isFlipping = false;
            }, 600);
        } else {
            // Desktop: Flip animation
            const rightPage = document.getElementById('rightPage');
            
            // Play flip sound for desktop
            playPageFlipSound();
            
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
    const questionCounter = document.getElementById('questionCounter');
    
    // Update question counter in header (works for both desktop and mobile)
    if (questionCounter) {
        questionCounter.textContent = `Question ${currentPage + 1} of ${questions.length}`;
    }
    
    // Update desktop navigation buttons
    if (prevBtn && nextBtn) {
        prevBtn.disabled = currentPage === 0;
        nextBtn.disabled = currentPage >= questions.length - 1;
        
        // Update button text when at the end
        if (currentPage >= questions.length - 1) {
            nextBtn.innerHTML = '<span>End Reached</span><i class="fas fa-flag-checkered ml-2"></i>';
        } else {
            nextBtn.innerHTML = '<span>Next</span><i class="fas fa-chevron-right ml-2"></i>';
        }
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

