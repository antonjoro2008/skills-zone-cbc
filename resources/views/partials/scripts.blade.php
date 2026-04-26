    <script>
        // Global state
        let currentUser = null;
        let resetPhoneNumber = null; // Store phone number for password reset flow
        let tokenBalanceInterval = null; // Store interval for token balance updates
        let assessmentTrackingInterval = null; // Store interval for assessment progress tracking
        let currentAttemptId = null; // Store current assessment attempt ID
        let assessmentMinutesElapsed = 0; // Track minutes elapsed in current assessment
        
        // API Configuration
        // Change this URL to match your API server
        const API_BASE_URL = 'https://admin.skillszone.africa';
        
        // Balance Checking Functions
        async function checkMinuteBalance() {
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    return { hasMinutes: false, minutes: 0, message: 'Authentication required' };
                }

                const response = await fetch(`${API_BASE_URL}/api/token-balance`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    const minutes = data.data.minutes_balance || 0;
                    return { 
                        hasMinutes: minutes > 0, 
                        minutes: minutes, 
                        message: minutes > 0 ? 'Sufficient minutes' : 'No minutes available' 
                    };
                } else {
                    return { hasMinutes: false, minutes: 0, message: data.message || 'Failed to check balance' };
                }
            } catch (error) {
                console.error('Error checking minute balance:', error);
                return { hasMinutes: false, minutes: 0, message: 'Network error' };
            }
        }

        function showInsufficientMinutesPopup() {
            showAlert(
                'Insufficient Minutes', 
                'You need to top up your minutes to start or continue assessments. Click OK to buy minutes.', 
                'warning',
                () => {
                    // Redirect to buy tokens page or show buy tokens modal
                    if (typeof showBuyTokensModal === 'function') {
                        showBuyTokensModal();
                    } else {
                        window.location.href = '/dashboard';
                    }
                }
            );
        }

        function showBuyTokensModal() {
            showModal('buyTokensModal');
        }

        // Error Message Extraction Helper
        function extractErrorMessage(apiResponse, fallbackMessage = 'An error occurred. Please try again.') {
            // Priority 1: Check for specific field errors in the errors object
            if (apiResponse.errors && typeof apiResponse.errors === 'object') {
                const errorMessages = [];
                
                // Collect all error messages from all fields
                Object.keys(apiResponse.errors).forEach(field => {
                    if (Array.isArray(apiResponse.errors[field])) {
                        errorMessages.push(...apiResponse.errors[field]);
                    } else if (typeof apiResponse.errors[field] === 'string') {
                        errorMessages.push(apiResponse.errors[field]);
                    }
                });
                
                // Return the first error message if any exist
                if (errorMessages.length > 0) {
                    return errorMessages[0];
                }
            }
            
            // Priority 2: Use the general message from the API response
            if (apiResponse.message && typeof apiResponse.message === 'string') {
                return apiResponse.message;
            }
            
            // Priority 3: Use the error field if it exists
            if (apiResponse.error && typeof apiResponse.error === 'string') {
                return apiResponse.error;
            }
            
            // Priority 4: Fallback to provided default message
            return fallbackMessage;
        }

        /**
         * Kenya CBC/CBE performance levels — full wording plus acronym (stakeholder standard).
         * BE Below Expectation · AE Approaching Expectation · ME Meeting Expectation · EE Exceeding Expectation
         */
        function getCompetencyFromPercent(percent) {
            const p = Math.max(0, Math.min(100, Number(percent) || 0));

            if (p < 50) {
                return {
                    code: 'BE',
                    label: 'Below Expectation',
                    descriptor: 'Below Expectation (BE)',
                    displayFull: 'Below Expectation (BE)',
                    feedback: 'Prioritise foundational skills and targeted support before the next assessment.',
                };
            }

            if (p <= 70) {
                return {
                    code: 'AE',
                    label: 'Approaching Expectation',
                    descriptor: 'Approaching Expectation (AE)',
                    displayFull: 'Approaching Expectation (AE)',
                    feedback: 'On the right track; consolidate gaps and practise applied tasks.',
                };
            }

            if (p <= 85) {
                return {
                    code: 'ME',
                    label: 'Meeting Expectation',
                    descriptor: 'Meeting Expectation (ME)',
                    displayFull: 'Meeting Expectation (ME)',
                    feedback: 'Meets grade-level competency; extend depth and independence.',
                };
            }

            return {
                code: 'EE',
                label: 'Exceeding Expectation',
                descriptor: 'Exceeding Expectation (EE)',
                displayFull: 'Exceeding Expectation (EE)',
                feedback: 'Above grade-level evidence; offer enrichment and leadership of peers.',
            };
        }

        function formatCompetencyLevel(percent) {
            const c = getCompetencyFromPercent(percent);
            const p = Math.max(0, Math.min(100, Number(percent) || 0));
            return `${c.displayFull} · ${p.toFixed(1)}% · ${c.feedback}`;
        }

        // Expose helpers for page scripts
        window.getCompetencyFromPercent = getCompetencyFromPercent;
        window.formatCompetencyLevel = formatCompetencyLevel;

        // Token Balance Functions
        async function fetchTokenBalance() {
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    return null;
                }

                const response = await fetch(`${API_BASE_URL}/api/token-balance`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    return data.data;
                } else {
                    console.error('Failed to fetch token balance:', data.message);
                    return null;
                }
            } catch (error) {
                console.error('Error fetching token balance:', error);
                return null;
            }
        }

        async function updateTokenBalanceDisplay() {
            const balanceData = await fetchTokenBalance();
            if (!balanceData) {
                return;
            }

            // Update all token balance elements on the page
            const tokenBalanceElements = document.querySelectorAll('#tokenBalance');
            tokenBalanceElements.forEach(element => {
                element.textContent = `${balanceData.token_balance || 0} Tokens`;
            });

            // Update institution dashboard total tokens
            const totalTokens = document.getElementById('totalTokens');
            if (totalTokens) {
                totalTokens.textContent = balanceData.token_balance || 0;
            }

            // Update available minutes elements
            const availableMinutesElements = document.querySelectorAll('#availableMinutes');
            availableMinutesElements.forEach(element => {
                element.textContent = `${balanceData.minutes_balance || 0} Minutes`;
            });

            // Update localStorage with new balance data
            const storedDashboard = localStorage.getItem('dashboard');
            if (storedDashboard) {
                try {
                    const dashboard = JSON.parse(storedDashboard);
                    dashboard.token_balance = balanceData.token_balance;
                    dashboard.available_minutes = balanceData.minutes_balance;
                    localStorage.setItem('dashboard', JSON.stringify(dashboard));
                } catch (e) {
                    console.error('Error updating dashboard in localStorage:', e);
                }
            }
        }

        function startTokenBalanceUpdates() {
            // Clear any existing interval
            if (tokenBalanceInterval) {
                clearInterval(tokenBalanceInterval);
            }

            // Update immediately
            updateTokenBalanceDisplay();

            // Set up interval to update every 10 seconds (10000ms)
            tokenBalanceInterval = setInterval(updateTokenBalanceDisplay, 10000);
        }

        function stopTokenBalanceUpdates() {
            if (tokenBalanceInterval) {
                clearInterval(tokenBalanceInterval);
                tokenBalanceInterval = null;
            }
        }

        // Assessment Progress Tracking Functions
        async function trackAssessmentProgress() {
            if (!currentAttemptId) {
                console.warn('No active assessment attempt to track');
                return;
            }

            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    console.error('No authentication token available');
                    return;
                }

                assessmentMinutesElapsed += 1;

                const response = await fetch(`${API_BASE_URL}/api/assessments/track-progress`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: JSON.stringify({
                        attempt_id: currentAttemptId,
                        minutes_elapsed: assessmentMinutesElapsed
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    console.log('Assessment progress tracked:', data.data);
                    
                    // Update token balance display with new balances
                    updateTokenBalanceFromTracking(data.data);
                    
                    // Check if user has sufficient minutes balance to continue
                    if (data.data.remaining_minutes_balance <= 0) {
                        console.warn('Insufficient minutes balance to continue assessment');
                        handleInsufficientMinutes();
                        return; // Stop further tracking
                    }
                    
                    // Check if user has sufficient token balance to continue
                    if (data.data.remaining_token_balance <= 0) {
                        console.warn('Insufficient token balance to continue assessment');
                        handleInsufficientTokens();
                        return; // Stop further tracking
                    }
                } else {
                    console.error('Failed to track assessment progress:', data.message);
                }
            } catch (error) {
                console.error('Error tracking assessment progress:', error);
            }
        }

        function updateTokenBalanceFromTracking(trackingData) {
            // Update all token balance elements on the page
            const tokenBalanceElements = document.querySelectorAll('#tokenBalance');
            tokenBalanceElements.forEach(element => {
                element.textContent = `${trackingData.remaining_token_balance || 0} Tokens`;
            });

            // Update available minutes elements
            const availableMinutesElements = document.querySelectorAll('#availableMinutes');
            availableMinutesElements.forEach(element => {
                element.textContent = `${trackingData.remaining_minutes_balance || 0} Minutes`;
            });

            // Update localStorage with new balance data
            const storedDashboard = localStorage.getItem('dashboard');
            if (storedDashboard) {
                try {
                    const dashboard = JSON.parse(storedDashboard);
                    dashboard.token_balance = trackingData.remaining_token_balance;
                    dashboard.available_minutes = trackingData.remaining_minutes_balance;
                    localStorage.setItem('dashboard', JSON.stringify(dashboard));
                } catch (e) {
                    console.error('Error updating dashboard in localStorage:', e);
                }
            }
        }

        function handleInsufficientMinutes() {
            // Stop assessment tracking immediately
            stopAssessmentTracking();
            
            // Clear assessment data to prevent confusion
            localStorage.removeItem('currentAssessment');
            localStorage.removeItem('currentAttemptId');
            localStorage.removeItem('assessmentStartTime');
            
            // Show attention popup
            showAlert(
                'Insufficient Minutes',
                'You have run out of minutes to continue this assessment. Your progress has been saved and you can resume later after purchasing more minutes.',
                'warning',
                () => {
                    // Redirect to assessments page after user clicks OK
                    window.location.href = '/assessments';
                }
            );
        }

        function handleInsufficientTokens() {
            // Stop assessment tracking immediately
            stopAssessmentTracking();
            
            // Clear assessment data to prevent confusion
            localStorage.removeItem('currentAssessment');
            localStorage.removeItem('currentAttemptId');
            localStorage.removeItem('assessmentStartTime');
            
            // Show attention popup
            showAlert(
                'Insufficient Tokens',
                'You have run out of tokens to continue this assessment. Your progress has been saved and you can resume later after purchasing more tokens.',
                'warning',
                () => {
                    // Redirect to assessments page after user clicks OK
                    window.location.href = '/assessments';
                }
            );
        }

        function startAssessmentTracking(attemptId) {
            // Clear any existing tracking interval
            if (assessmentTrackingInterval) {
                clearInterval(assessmentTrackingInterval);
            }

            // Set current attempt ID and reset elapsed time
            currentAttemptId = attemptId;
            assessmentMinutesElapsed = 0;

            // Start tracking immediately (for the first minute)
            trackAssessmentProgress();

            // Set up interval to track every minute (60000ms)
            assessmentTrackingInterval = setInterval(trackAssessmentProgress, 60000);
            
            console.log(`Started tracking assessment progress for attempt ID: ${attemptId}`);
        }

        function stopAssessmentTracking() {
            if (assessmentTrackingInterval) {
                clearInterval(assessmentTrackingInterval);
                assessmentTrackingInterval = null;
            }
            
            // Reset tracking variables
            currentAttemptId = null;
            assessmentMinutesElapsed = 0;
            
            console.log('Stopped assessment progress tracking');
        }


        // Phone number standardization function
        function standardizePhoneNumber(phone) {
            if (!phone) return phone;
            
            // Remove all non-digit characters
            let cleanPhone = phone.replace(/\D/g, '');
            
            // Handle different formats
            if (cleanPhone.startsWith('254')) {
                // Already in 254 format
                return cleanPhone;
            } else if (cleanPhone.startsWith('07') && cleanPhone.length === 10) {
                // 07... format (10 digits)
                return '254' + cleanPhone.substring(1);
            } else if (cleanPhone.startsWith('7') && cleanPhone.length === 9) {
                // 7... format (9 digits)
                return '254' + cleanPhone;
            } else if (cleanPhone.length === 9 && !cleanPhone.startsWith('0')) {
                // 9 digits starting with 7
                return '254' + cleanPhone;
            } else if (cleanPhone.length === 10 && cleanPhone.startsWith('0')) {
                // 10 digits starting with 0
                return '254' + cleanPhone.substring(1);
            }
            
            // Return as is if no pattern matches
            return cleanPhone;
        }
        
        // Password toggle function
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('active');
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const menuButton = event.target.closest('.fa-bars');
            
            if (!mobileMenu.contains(event.target) && !menuButton && mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
            }
        });
        
        // Smooth scroll reveal animations
        function revealOnScroll() {
            const reveals = document.querySelectorAll('.card-hover, .stat-counter');
            
            for (let i = 0; i < reveals.length; i++) {
                const windowHeight = window.innerHeight;
                const elementTop = reveals[i].getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add('animate-fade-in-up');
                }
            }
        }
        
        window.addEventListener('scroll', revealOnScroll);
        
        // Add ripple effect to buttons
        function createRipple(event) {
            const button = event.currentTarget;
            const circle = document.createElement('span');
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;
            
            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
            circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
            circle.classList.add('ripple');
            
            const ripple = button.getElementsByClassName('ripple')[0];
            if (ripple) {
                ripple.remove();
            }
            
            button.appendChild(circle);
        }
        
        // Apply ripple effect to all buttons
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.addEventListener('click', createRipple);
            });
        });
        
        // FAQ toggle functionality
        function toggleFAQ(button) {
            const content = button.parentElement.querySelector('.faq-content');
            const icon = button.querySelector('i');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
        
        // Page navigation functionality
        function showSection(sectionId) {
            // Hide all page sections
            const sections = document.querySelectorAll('.page-section');
            sections.forEach(section => {
                section.classList.add('hidden');
            });
            
            // Show the requested section
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.classList.remove('hidden');
                // Scroll to top
                window.scrollTo(0, 0);
            }
            
            // Close mobile menu if open
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu && mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
            }
        }
        
        // Modal functionality
        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                // Add animation class to content
                const content = modal.querySelector('[id$="Content"]');
                if (content) {
                    setTimeout(() => {
                        content.style.transform = 'scale(1)';
                        content.style.opacity = '1';
                    }, 10);
                }
                
                // Initialize specific modals
                if (modalId === 'buyTokensModal') {
                    initializeBuyTokensModal();
                } else if (modalId === 'successModal') {
                    // Hide start assessment button for institution users
                    const startBtn = document.getElementById('successModalStartBtn');
                    if (startBtn && window.currentUser && window.currentUser.user_type === 'institution') {
                        startBtn.style.display = 'none';
                    } else if (startBtn) {
                        startBtn.style.display = 'block';
                    }
                }
            }
        }
        
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                const content = modal.querySelector('[id$="Content"]');
                if (content) {
                    content.style.transform = 'scale(0.95)';
                    content.style.opacity = '0';
                    setTimeout(() => {
                        modal.classList.add('hidden');
                    }, 300);
                } else {
                    modal.classList.add('hidden');
                }
                
                // Don't automatically clear reset data when closing modals
                // Reset data will be cleared when the process is completed or user goes back to login
                
                // Call callback when alert modal is closed
                if (modalId === 'alertModal' && window.alertModalCallback) {
                    setTimeout(() => {
                        window.alertModalCallback();
                        window.alertModalCallback = null; // Clear the callback after use
                    }, 300); // Wait for animation to complete
                }
            }
        }
        
        function showErrorModal(message, title = 'Error') {
            const errorMessageElement = document.getElementById('errorMessage');
            const errorTitleElement = document.getElementById('errorTitle');
            
            if (errorMessageElement) {
                errorMessageElement.textContent = message;
            }
            
            if (errorTitleElement) {
                errorTitleElement.textContent = title;
            }
            
            showModal('errorModal');
        }

        function showSuccessModal(message, title = 'Success') {
            // Create a temporary success modal content
            const successModal = document.getElementById('successModal');
            if (successModal) {
                // Update the modal content
                const titleElement = successModal.querySelector('h2');
                const messageElement = successModal.querySelector('p');
                const buttonElement = successModal.querySelector('button');
                
                if (titleElement) titleElement.textContent = title;
                if (messageElement) messageElement.textContent = message;
                if (buttonElement) {
                    buttonElement.textContent = 'Continue';
                    buttonElement.onclick = () => closeModal('successModal');
                }
                
                showModal('successModal');
            }
        }
        
        // Authentication functions
        async function login(event) {
            event.preventDefault();
            
            const loginIdentifier = document.getElementById('loginPhone').value;
            const password = document.getElementById('loginPassword').value;
            
            // Format phone number if it's a phone number (numeric)
            let formattedIdentifier = loginIdentifier;
            if (/^[0-9]+$/.test(loginIdentifier)) {
                formattedIdentifier = standardizePhoneNumber(loginIdentifier);
            }
            
            // Show loading state
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Signing In...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(`${API_BASE_URL}/api/login`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        login_identifier: formattedIdentifier,
                        password: password
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Store complete user data, token, and dashboard data
                    localStorage.setItem('user', JSON.stringify(data.data.user));
                    localStorage.setItem('token', data.data.access_token);
                    localStorage.setItem('dashboard', JSON.stringify(data.data.dashboard));
                    
                    // Also store in sessionStorage as backup for mobile devices
                    sessionStorage.setItem('user', JSON.stringify(data.data.user));
                    sessionStorage.setItem('token', data.data.access_token);
                    sessionStorage.setItem('dashboard', JSON.stringify(data.data.dashboard));
                    
                    // Update current user
                    currentUser = data.data.user;
                    console.log('Login successful - currentUser set to:', currentUser);
                    console.log('User has admission_number:', currentUser.admission_number);
                    console.log('User has email:', currentUser.email);
                    console.log('User has phone_number:', currentUser.phone_number);
                    updateAuthState();
                    closeModal('loginModal');
                    
                    // Redirect based on user type
                    if (currentUser.user_type === 'institution') {
                        window.location.href = '/institution-dashboard';
                    } else if (currentUser.user_type === 'teacher') {
                        window.location.href = '/teacher-dashboard';
                    } else if (currentUser.user_type === 'parent') {
                        window.location.href = '/parent-dashboard';
                    } else {
                        window.location.href = '/dashboard';
                    }
                } else {
                    // Show error modal with specific error message from API
                    const errorMessage = extractErrorMessage(data, 'Login failed. Please try again.');
                    showErrorModal(errorMessage, 'Login Failed');
                }
            } catch (error) {
                console.error('Login error:', error);
                showErrorModal('Network error. Please check your connection and try again.', 'Login Failed');
            } finally {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }
        
        async function registerIndividual(event) {
            event.preventDefault();
            
            const name = document.getElementById('registerName').value;
            const phone = document.getElementById('registerPhone').value;
            const email = document.getElementById('registerEmail').value;
            const userType = document.getElementById('registerUserType').value;
            const gradeLevel = document.getElementById('registerGradeLevel').value;
            const password = document.getElementById('registerPassword').value;
            const passwordConfirmation = document.getElementById('registerPasswordConfirmation').value;
            
            // Always format phone number to 2547... or 2541... format
            const formattedPhone = standardizePhoneNumber(phone);
            
            // Validate password confirmation
            if (password !== passwordConfirmation) {
                showErrorModal('Passwords do not match. Please try again.', 'Registration Failed');
                return;
            }
            
            // Show loading state
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Account...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(`${API_BASE_URL}/api/register`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        name: name,
                        phone_number: formattedPhone,
                        email: email || null,
                        password: password,
                        password_confirmation: passwordConfirmation,
                        user_type: userType,
                        grade_level: gradeLevel || null
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Store complete user data, token, and dashboard data
                    localStorage.setItem('user', JSON.stringify(data.data.user));
                    localStorage.setItem('token', data.data.access_token);
                    localStorage.setItem('dashboard', JSON.stringify(data.data.dashboard));
                    
                    // Also store in sessionStorage as backup for mobile devices
                    sessionStorage.setItem('user', JSON.stringify(data.data.user));
                    sessionStorage.setItem('token', data.data.access_token);
                    sessionStorage.setItem('dashboard', JSON.stringify(data.data.dashboard));
                    
                    // Update current user
                    currentUser = data.data.user;
                    updateAuthState();
                    closeModal('registerModal');
                    
                    // Small delay to ensure UI updates before redirect
                    setTimeout(() => {
                        if (currentUser.user_type === 'institution') {
                            window.location.href = '/institution-dashboard';
                        } else if (currentUser.user_type === 'teacher') {
                            window.location.href = '/teacher-dashboard';
                        } else if (currentUser.user_type === 'parent') {
                            window.location.href = '/parent-dashboard';
                        } else {
                            window.location.href = '/dashboard';
                        }
                    }, 100);
                } else {
                    // Show error modal with specific error message from API
                    const errorMessage = extractErrorMessage(data, 'Registration failed. Please try again.');
                    showErrorModal(errorMessage, 'Registration Failed');
                }
            } catch (error) {
                console.error('Registration error:', error);
                showErrorModal('Network error. Please check your connection and try again.', 'Registration Failed');
            } finally {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        async function registerInstitution(event) {
            event.preventDefault();
            
            const institutionName = document.getElementById('institutionName').value;
            const institutionEmail = document.getElementById('institutionEmail').value;
            const institutionPhone = document.getElementById('institutionPhone').value;
            const institutionAddress = document.getElementById('institutionAddress').value;
            const adminName = document.getElementById('adminName').value;
            const adminPhone = document.getElementById('adminPhone').value;
            const adminEmail = document.getElementById('adminEmail').value;
            const adminPassword = document.getElementById('adminPassword').value;
            const adminPasswordConfirmation = document.getElementById('adminPasswordConfirmation').value;
            
            // Always format phone numbers to 2547... or 2541... format
            const formattedInstitutionPhone = standardizePhoneNumber(institutionPhone);
            const formattedAdminPhone = standardizePhoneNumber(adminPhone);
            
            // Validate password confirmation
            if (adminPassword !== adminPasswordConfirmation) {
                showErrorModal('Admin passwords do not match. Please try again.', 'Institution Registration Failed');
                return;
            }
            
            // Show loading state
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Institution...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(`${API_BASE_URL}/api/institution/register`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        institution_name: institutionName,
                        institution_email: institutionEmail,
                        institution_phone: formattedInstitutionPhone,
                        institution_address: institutionAddress,
                        admin_name: adminName,
                        admin_phone_number: formattedAdminPhone,
                        admin_email: adminEmail,
                        admin_password: adminPassword,
                        admin_password_confirmation: adminPasswordConfirmation
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Store complete user data, token, and dashboard data
                    localStorage.setItem('user', JSON.stringify(data.data.user));
                    localStorage.setItem('token', data.data.access_token);
                    localStorage.setItem('dashboard', JSON.stringify(data.data.dashboard));
                    
                    // Also store in sessionStorage as backup for mobile devices
                    sessionStorage.setItem('user', JSON.stringify(data.data.user));
                    sessionStorage.setItem('token', data.data.access_token);
                    sessionStorage.setItem('dashboard', JSON.stringify(data.data.dashboard));
                    
                    // Update current user
                    currentUser = data.data.user;
                    updateAuthState();
                    closeModal('registerModal');
                    
                    // Small delay to ensure UI updates before redirect
                    setTimeout(() => {
                        window.location.href = '/institution-dashboard';
                    }, 100);
                } else {
                    // Show error modal with specific error message from API
                    const errorMessage = extractErrorMessage(data, 'Institution registration failed. Please try again.');
                    showErrorModal(errorMessage, 'Institution Registration Failed');
                }
            } catch (error) {
                console.error('Institution registration error:', error);
                showErrorModal('Network error. Please check your connection and try again.', 'Institution Registration Failed');
            } finally {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        function switchRegistrationType(type) {
            const individualForm = document.getElementById('individualForm');
            const institutionForm = document.getElementById('institutionForm');
            const individualTab = document.getElementById('individualTab');
            const institutionTab = document.getElementById('institutionTab');
            
            if (type === 'individual') {
                individualForm.classList.remove('hidden');
                institutionForm.classList.add('hidden');
                individualTab.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                individualTab.classList.remove('text-gray-600');
                institutionTab.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                institutionTab.classList.add('text-gray-600');
            } else {
                individualForm.classList.add('hidden');
                institutionForm.classList.remove('hidden');
                institutionTab.classList.add('bg-white', 'text-blue-600', 'shadow-sm');
                institutionTab.classList.remove('text-gray-600');
                individualTab.classList.remove('bg-white', 'text-blue-600', 'shadow-sm');
                individualTab.classList.add('text-gray-600');
            }
        }
        
        function forgotPassword(event) {
            event.preventDefault();
            const email = document.getElementById('forgotEmail').value;
            
            // Simulate password reset
            console.log('Password reset requested for:', email);
            
            closeModal('forgotModal');
            showModal('passwordResetSuccessModal');
        }
        
        function logout() {
            console.log('Logging out user...');
            currentUser = null;
            localStorage.removeItem('user');
            localStorage.removeItem('token');
            localStorage.removeItem('dashboard');
            // Also clear sessionStorage
            sessionStorage.removeItem('user');
            sessionStorage.removeItem('token');
            sessionStorage.removeItem('dashboard');
            
            // Stop token balance updates and assessment tracking
            stopTokenBalanceUpdates();
            stopAssessmentTracking();
            
            console.log('User data cleared, redirecting to home page...');
            updateAuthState();
            
            // Always redirect to home page after logout
            window.location.href = '/';
        }
        
        function updateAuthState() {
            const loginBtn = document.getElementById('loginBtn');
            const registerBtn = document.getElementById('registerBtn');
            const logoutBtn = document.getElementById('logoutBtn');
            const buyTokensBtn = document.getElementById('buyTokensBtn');
            const dashboardLink = document.getElementById('dashboardLink');
            const institutionDashboardLink = document.getElementById('institutionDashboardLink');
            const teacherDashboardLink = document.getElementById('teacherDashboardLink');
            const parentDashboardLink = document.getElementById('parentDashboardLink');
            const transactionsLink = document.getElementById('transactionsLink');
            const assessmentsLink = document.getElementById('assessmentsLink');
            const profileLink = document.getElementById('profileLink');
            const sampleReportPdfBtn = document.getElementById('sampleReportPdfBtn');
            
            const loginBtnMobile = document.getElementById('loginBtnMobile');
            const registerBtnMobile = document.getElementById('registerBtnMobile');
            const logoutBtnMobile = document.getElementById('logoutBtnMobile');
            const buyTokensBtnMobile = document.getElementById('buyTokensBtnMobile');
            const dashboardLinkMobile = document.getElementById('dashboardLinkMobile');
            const institutionDashboardLinkMobile = document.getElementById('institutionDashboardLinkMobile');
            const teacherDashboardLinkMobile = document.getElementById('teacherDashboardLinkMobile');
            const parentDashboardLinkMobile = document.getElementById('parentDashboardLinkMobile');
            const transactionsLinkMobile = document.getElementById('transactionsLinkMobile');
            const assessmentsLinkMobile = document.getElementById('assessmentsLinkMobile');
            const profileLinkMobile = document.getElementById('profileLinkMobile');
            const sampleReportPdfBtnMobile = document.getElementById('sampleReportPdfBtnMobile');
            
            // Ensure currentUser is properly set and not just an empty object
            // Check for any valid identifier: email, phone_number, or admission_number
            const isLoggedIn = currentUser && currentUser.id && (currentUser.email || currentUser.phone_number || currentUser.admission_number);
            console.log('updateAuthState called - currentUser:', currentUser);
            console.log('User ID:', currentUser?.id);
            console.log('User email:', currentUser?.email);
            console.log('User phone_number:', currentUser?.phone_number);
            console.log('User admission_number:', currentUser?.admission_number);
            console.log('isLoggedIn:', isLoggedIn);
            
            if (isLoggedIn) {
                // Check if user is an institutional learner (student with institution_id)
                const isInstitutionalLearner = currentUser.user_type === 'student' && currentUser.institution_id;
                const hidePurchasesPilot = isInstitutionalLearner || currentUser.user_type === 'teacher';
                
                // User is logged in
                if (loginBtn) loginBtn.style.display = 'none';
                if (registerBtn) registerBtn.style.display = 'none';
                if (logoutBtn) logoutBtn.style.display = 'block';
                if (sampleReportPdfBtn) sampleReportPdfBtn.style.display = 'inline-flex';
                if (sampleReportPdfBtnMobile) sampleReportPdfBtnMobile.style.display = 'block';
                
                // Hide Buy Tokens for institutional learners and pilot phase
                if (buyTokensBtn) buyTokensBtn.style.display = 'none'; // Hidden for pilot phase
                if (transactionsLink) transactionsLink.style.display = hidePurchasesPilot ? 'none' : 'block';
                if (assessmentsLink) assessmentsLink.style.display = 'block';
                if (profileLink) profileLink.style.display = 'block';
                
                if (loginBtnMobile) loginBtnMobile.style.display = 'none';
                if (registerBtnMobile) registerBtnMobile.style.display = 'none';
                if (logoutBtnMobile) logoutBtnMobile.style.display = 'block';
                
                // Hide Buy Tokens for institutional learners and pilot phase (mobile)
                if (buyTokensBtnMobile) buyTokensBtnMobile.style.display = 'none'; // Hidden for pilot phase
                if (transactionsLinkMobile) transactionsLinkMobile.style.display = hidePurchasesPilot ? 'none' : 'block';
                if (assessmentsLinkMobile) assessmentsLinkMobile.style.display = 'block';
                if (profileLinkMobile) profileLinkMobile.style.display = 'block';
                
                // Show appropriate dashboard link based on user type
                if (currentUser.user_type === 'institution') {
                    if (institutionDashboardLink) institutionDashboardLink.style.display = 'block';
                    if (institutionDashboardLinkMobile) institutionDashboardLinkMobile.style.display = 'block';
                    if (teacherDashboardLink) teacherDashboardLink.style.display = 'none';
                    if (teacherDashboardLinkMobile) teacherDashboardLinkMobile.style.display = 'none';
                    if (dashboardLink) dashboardLink.style.display = 'none';
                    if (dashboardLinkMobile) dashboardLinkMobile.style.display = 'none';
                } else if (currentUser.user_type === 'teacher') {
                    if (teacherDashboardLink) teacherDashboardLink.style.display = 'block';
                    if (teacherDashboardLinkMobile) teacherDashboardLinkMobile.style.display = 'block';
                    if (institutionDashboardLink) institutionDashboardLink.style.display = 'none';
                    if (institutionDashboardLinkMobile) institutionDashboardLinkMobile.style.display = 'none';
                    if (parentDashboardLink) parentDashboardLink.style.display = 'none';
                    if (parentDashboardLinkMobile) parentDashboardLinkMobile.style.display = 'none';
                    if (dashboardLink) dashboardLink.style.display = 'none';
                    if (dashboardLinkMobile) dashboardLinkMobile.style.display = 'none';
                } else if (currentUser.user_type === 'parent') {
                    // For parents, show parent dashboard link
                    if (parentDashboardLink) parentDashboardLink.style.display = 'block';
                    if (parentDashboardLinkMobile) parentDashboardLinkMobile.style.display = 'block';
                    if (dashboardLink) dashboardLink.style.display = 'none';
                    if (dashboardLinkMobile) dashboardLinkMobile.style.display = 'none';
                    if (institutionDashboardLink) institutionDashboardLink.style.display = 'none';
                    if (institutionDashboardLinkMobile) institutionDashboardLinkMobile.style.display = 'none';
                    if (teacherDashboardLink) teacherDashboardLink.style.display = 'none';
                    if (teacherDashboardLinkMobile) teacherDashboardLinkMobile.style.display = 'none';
                } else {
                    if (dashboardLink) dashboardLink.style.display = 'block';
                    if (dashboardLinkMobile) dashboardLinkMobile.style.display = 'block';
                    if (institutionDashboardLink) institutionDashboardLink.style.display = 'none';
                    if (institutionDashboardLinkMobile) institutionDashboardLinkMobile.style.display = 'none';
                    if (teacherDashboardLink) teacherDashboardLink.style.display = 'none';
                    if (teacherDashboardLinkMobile) teacherDashboardLinkMobile.style.display = 'none';
                }

                // Start token balance updates for logged-in users
                startTokenBalanceUpdates();
            } else {
                // User is logged out
                if (loginBtn) loginBtn.style.display = 'block';
                if (registerBtn) registerBtn.style.display = 'block';
                if (logoutBtn) logoutBtn.style.display = 'none';
                if (sampleReportPdfBtn) sampleReportPdfBtn.style.display = 'none';
                if (sampleReportPdfBtnMobile) sampleReportPdfBtnMobile.style.display = 'none';
                if (buyTokensBtn) buyTokensBtn.style.display = 'none';
                if (dashboardLink) dashboardLink.style.display = 'none';
                if (institutionDashboardLink) institutionDashboardLink.style.display = 'none';
                if (teacherDashboardLink) teacherDashboardLink.style.display = 'none';
                if (parentDashboardLink) parentDashboardLink.style.display = 'none';
                if (transactionsLink) transactionsLink.style.display = 'none';
                if (assessmentsLink) assessmentsLink.style.display = 'none';
                if (profileLink) profileLink.style.display = 'none';
                
                if (loginBtnMobile) loginBtnMobile.style.display = 'block';
                if (registerBtnMobile) registerBtnMobile.style.display = 'block';
                if (logoutBtnMobile) logoutBtnMobile.style.display = 'none';
                if (sampleReportPdfBtnMobile) sampleReportPdfBtnMobile.style.display = 'none';
                if (buyTokensBtnMobile) buyTokensBtnMobile.style.display = 'none';
                if (dashboardLinkMobile) dashboardLinkMobile.style.display = 'none';
                if (institutionDashboardLinkMobile) institutionDashboardLinkMobile.style.display = 'none';
                if (teacherDashboardLinkMobile) teacherDashboardLinkMobile.style.display = 'none';
                if (parentDashboardLinkMobile) parentDashboardLinkMobile.style.display = 'none';
                if (transactionsLinkMobile) transactionsLinkMobile.style.display = 'none';
                if (assessmentsLinkMobile) assessmentsLinkMobile.style.display = 'none';
                if (profileLinkMobile) profileLinkMobile.style.display = 'none';

                // Stop token balance updates for logged-out users
                stopTokenBalanceUpdates();
            }
        }
        
        // Assessment functions
        function purchaseAssessment(name, price) {
            if (!currentUser) {
                showModal('loginModal');
                return;
            }
            
            document.getElementById('paymentAssessment').textContent = name;
            document.getElementById('paymentAmount').textContent = `KSH ${price.toLocaleString()}`;
            showModal('paymentModal');
        }
        
        function processMpesaPayment() {
            const phone = document.getElementById('mpesaPhone').value;
            if (!phone) {
                showAlert('Validation Error', 'Please enter a valid phone number', 'error');
                return;
            }
            
            // Simulate payment processing
            console.log('Processing M-PESA payment for:', phone);
            
            closeModal('paymentModal');
            showModal('successModal');
        }
        
        function startAssessment() {
            closeModal('successModal');
            showSection('takeAssessment');
        }
        
        // Initialize auth state
        document.addEventListener('DOMContentLoaded', function() {
            // Load user from localStorage if available
            const storedUser = localStorage.getItem('user');
            if (storedUser) {
                try {
                    currentUser = JSON.parse(storedUser);
                    console.log('Loaded user from localStorage:', currentUser);
                } catch (e) {
                    console.error('Error parsing stored user data:', e);
                    localStorage.removeItem('user');
                    localStorage.removeItem('token');
                    localStorage.removeItem('dashboard');
                    currentUser = null;
                }
            } else {
                console.log('No stored user found, setting currentUser to null');
                currentUser = null;
            }
            updateAuthState();
            
            // Handle user type selection for grade level visibility
            const userTypeSelect = document.getElementById('registerUserType');
            const gradeLevelDiv = document.getElementById('gradeLevelDiv');
            
            if (userTypeSelect && gradeLevelDiv) {
                userTypeSelect.addEventListener('change', function() {
                    if (this.value === 'student') {
                        gradeLevelDiv.style.display = 'block';
                        document.getElementById('registerGradeLevel').required = true;
                    } else {
                        gradeLevelDiv.style.display = 'none';
                        document.getElementById('registerGradeLevel').required = false;
                        document.getElementById('registerGradeLevel').value = '';
                    }
                });
            }
        });

        // Token calculation function
        function calculateTokens() {
            const amount = parseFloat(document.getElementById('buyTokensAmount').value) || 0;
            
            // Get settings from dashboard data stored in localStorage
            let tokensPerShilling = 1; // Default fallback
            let minutesPerToken = 1; // Default fallback
            
            try {
                const dashboardData = localStorage.getItem('dashboard');
                if (dashboardData) {
                    const dashboard = JSON.parse(dashboardData);
                    if (dashboard.settings) {
                        tokensPerShilling = dashboard.settings.tokens_per_shilling || 1;
                        minutesPerToken = dashboard.settings.minutes_per_token || 1;
                    }
                }
            } catch (e) {
                console.warn('Could not load settings from dashboard data, using defaults');
            }
            
            const tokens = Math.floor(amount * tokensPerShilling);
            const minutes = tokens * minutesPerToken;
            
            document.getElementById('displayAmount').textContent = `KES ${amount.toLocaleString()}`;
            document.getElementById('displayTokens').textContent = `${tokens} token${tokens !== 1 ? 's' : ''}`;
            
            // Update minutes display if element exists
            const minutesDisplay = document.getElementById('displayMinutes');
            if (minutesDisplay) {
                minutesDisplay.textContent = `${minutes} minute${minutes !== 1 ? 's' : ''}`;
            }
        }

        // Function to update token purchase info with dynamic settings
        function updateTokenPurchaseInfo() {
            const tokenRateInfo = document.getElementById('tokenRateInfo');
            if (!tokenRateInfo) return;
            
            // Get settings from dashboard data stored in localStorage
            let tokensPerShilling = 1; // Default fallback
            let minutesPerToken = 1; // Default fallback
            
            try {
                const dashboardData = localStorage.getItem('dashboard');
                if (dashboardData) {
                    const dashboard = JSON.parse(dashboardData);
                    if (dashboard.settings) {
                        tokensPerShilling = dashboard.settings.tokens_per_shilling || 1;
                        minutesPerToken = dashboard.settings.minutes_per_token || 1;
                    }
                }
            } catch (e) {
                console.warn('Could not load settings from dashboard data, using defaults');
            }
            
            // Update the rate information
            const rateText = `1 Token = KES ${(1/tokensPerShilling).toFixed(2)} | ${minutesPerToken} min/token`;
            tokenRateInfo.textContent = rateText;
        }

        // Buy tokens function
        async function buyTokens(event) {
            event.preventDefault();
            
            if (!currentUser) {
                showAlert('Authentication Required', 'Please log in to purchase tokens.', 'warning');
                return;
            }
            
            // Some users reported "Invalid amount" even for valid input.
            // Send a clean integer amount to the API to avoid float/format issues.
            const rawAmount = document.getElementById('buyTokensAmount').value;
            const amount = Number.parseInt(String(rawAmount).replace(/[^\d]/g, ''), 10);
            const phoneNumber = document.getElementById('buyTokensMpesaPhone').value;
            
            // Always format phone number to 2547... or 2541... format
            const formattedPhoneNumber = standardizePhoneNumber(phoneNumber);
            
            // Validate inputs
            if (!Number.isFinite(amount) || amount < 1) {
                showAlert('Invalid Amount', 'Please enter an amount of at least KES 1.', 'error');
                return;
            }
            
            if (!formattedPhoneNumber || !formattedPhoneNumber.match(/^254[0-9]{9}$/)) {
                showAlert('Invalid Phone Number', 'Please enter a valid M-PESA phone number.', 'error');
                return;
            }
            
            // Get settings from dashboard data stored in localStorage
            let tokensPerShilling = 1; // Default fallback
            
            try {
                const dashboardData = localStorage.getItem('dashboard');
                if (dashboardData) {
                    const dashboard = JSON.parse(dashboardData);
                    if (dashboard.settings) {
                        tokensPerShilling = dashboard.settings.tokens_per_shilling || 1;
                    }
                }
            } catch (e) {
                console.warn('Could not load settings from dashboard data, using defaults');
            }
            
            const tokens = Math.floor(amount * tokensPerShilling);
            if (!Number.isFinite(tokens) || tokens <= 0) {
                showAlert('Invalid Amount', 'Amount results in 0 tokens. Please try a higher amount.', 'error');
                return;
            }
            
            // Show loading state
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing Payment...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(`${API_BASE_URL}/api/payments`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    },
                    body: JSON.stringify({
                        amount: amount,
                        channel: 'mpesa',
                        currency: 'KES',
                        tokens: tokens,
                        phone_number: formattedPhoneNumber,
                        user_id: currentUser.id
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Show success message
                    showAlert('Payment Successful', data.message, 'success');
                    closeModal('buyTokensModal');
                    
                    // Update user data if provided
                    if (data.data && data.data.user) {
                        localStorage.setItem('user', JSON.stringify(data.data.user));
                        currentUser = data.data.user;
                        updateAuthState();
                    }
                } else {
                    // Show error message
                    const errorMessage = extractErrorMessage(data, 'Payment could not be processed. Please try again.');
                    showAlert('Payment Failed', errorMessage, 'error');
                }
            } catch (error) {
                console.error('Buy tokens error:', error);
                showAlert('Network Error', 'Unable to process payment. Please check your connection and try again.', 'error');
            } finally {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        // Forgot Password Functions
        async function forgotPassword(event) {
            event.preventDefault();
            
            const phone = document.getElementById('forgotPhone').value;
            const standardizedPhone = standardizePhoneNumber(phone);
            
            // Store phone number for next steps (regardless of API success)
            resetPhoneNumber = standardizedPhone;
            
            // Show loading state
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending Code...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(`${API_BASE_URL}/api/forgot-password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        phone_number: standardizedPhone
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Show success message and move to verify code modal
                    showSuccessModal(data.message || 'Reset code sent successfully to your phone', 'Code Sent');
                    closeModal('forgotModal');
                    showModal('verifyCodeModal');
                } else {
                    // Show error modal with specific error message from API
                    const errorMessage = extractErrorMessage(data, 'Failed to send reset code. Please try again.');
                    showErrorModal(errorMessage, 'Reset Code Failed');
                }
            } catch (error) {
                console.error('Forgot password error:', error);
                // For development/testing purposes, still proceed to verify code modal
                // In production, you might want to show an error instead
                console.log('API call failed, but proceeding to verify code modal for testing');
                showSuccessModal('Reset code sent successfully to your phone', 'Code Sent');
                closeModal('forgotModal');
                showModal('verifyCodeModal');
            } finally {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        async function verifyResetCode(event) {
            event.preventDefault();
            
            const code = document.getElementById('resetCode').value;
            
            // Debug logging
            console.log('verifyResetCode called');
            console.log('resetPhoneNumber:', resetPhoneNumber);
            console.log('code:', code);
            
            if (!resetPhoneNumber) {
                console.error('resetPhoneNumber is null or undefined');
                showErrorModal('Phone number not found. Please start the reset process again.', 'Verification Failed');
                return;
            }
            
            // Show loading state
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Verifying...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(`${API_BASE_URL}/api/verify-reset-code`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        phone_number: resetPhoneNumber,
                        code: code
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Move directly to reset password modal
                    closeModal('verifyCodeModal');
                    showModal('resetPasswordModal');
                } else {
                    // Show error modal with specific error message from API
                    const errorMessage = extractErrorMessage(data, 'Invalid reset code. Please try again.');
                    showErrorModal(errorMessage, 'Verification Failed');
                }
            } catch (error) {
                console.error('Verify reset code error:', error);
                showErrorModal('Network error. Please check your connection and try again.', 'Verification Failed');
            } finally {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        async function resetPassword(event) {
            event.preventDefault();
            
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmNewPassword').value;
            
            if (!resetPhoneNumber) {
                showErrorModal('Phone number not found. Please start the reset process again.', 'Password Reset Failed');
                return;
            }
            
            // Validate password confirmation
            if (newPassword !== confirmPassword) {
                showErrorModal('Passwords do not match. Please try again.', 'Password Reset Failed');
                return;
            }
            
            // Show loading state
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Resetting...';
            submitBtn.disabled = true;
            
            try {
                const response = await fetch(`${API_BASE_URL}/api/reset-password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        phone_number: resetPhoneNumber,
                        code: document.getElementById('resetCode').value,
                        password: newPassword,
                        password_confirmation: confirmPassword
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Show success message and redirect to login
                    showSuccessModal(data.message || 'Password reset successfully. Please login with your new password.', 'Password Reset');
                    closeModal('resetPasswordModal');
                    
                    // Clear reset data
                    resetPhoneNumber = null;
                    document.getElementById('forgotPhone').value = '';
                    document.getElementById('resetCode').value = '';
                    document.getElementById('newPassword').value = '';
                    document.getElementById('confirmNewPassword').value = '';
                    
                    // Show login modal after a short delay
                    setTimeout(() => {
                        showModal('loginModal');
                    }, 2000);
                } else {
                    // Show error modal with specific error message from API
                    const errorMessage = extractErrorMessage(data, 'Failed to reset password. Please try again.');
                    showErrorModal(errorMessage, 'Password Reset Failed');
                }
            } catch (error) {
                console.error('Reset password error:', error);
                showErrorModal('Network error. Please check your connection and try again.', 'Password Reset Failed');
            } finally {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        async function resendResetCode() {
            if (!resetPhoneNumber) {
                showErrorModal('Phone number not found. Please start the reset process again.', 'Resend Failed');
                return;
            }
            
            try {
                const response = await fetch(`${API_BASE_URL}/api/forgot-password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        phone_number: resetPhoneNumber
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showAlert('Code Resent', data.message || 'Reset code resent successfully to your phone', 'success');
                } else {
                    const errorMessage = extractErrorMessage(data, 'Failed to resend reset code. Please try again.');
                    showErrorModal(errorMessage, 'Resend Failed');
                }
            } catch (error) {
                console.error('Resend reset code error:', error);
                showErrorModal('Network error. Please check your connection and try again.', 'Resend Failed');
            }
        }

        // Initialize buy tokens modal with user's phone number
        function initializeBuyTokensModal() {
            if (currentUser && currentUser.phone_number) {
                document.getElementById('buyTokensMpesaPhone').value = currentUser.phone_number;
            }
            calculateTokens(); // Initialize the display
            updateTokenPurchaseInfo(); // Update token purchase info with dynamic settings
        }

        // Auto-format reset code input (numbers only)
        function formatResetCode(input) {
            // Remove any non-numeric characters
            let value = input.value.replace(/\D/g, '');
            
            // Limit to 6 digits
            if (value.length > 6) {
                value = value.substring(0, 6);
            }
            
            input.value = value;
            
            // Auto-submit when 6 digits are entered
            if (value.length === 6) {
                const form = input.closest('form');
                if (form) {
                    form.dispatchEvent(new Event('submit'));
                }
            }
        }

        // Clear reset data when modals are closed
        function clearResetData() {
            resetPhoneNumber = null;
            const forgotPhone = document.getElementById('forgotPhone');
            const resetCode = document.getElementById('resetCode');
            const newPassword = document.getElementById('newPassword');
            const confirmNewPassword = document.getElementById('confirmNewPassword');
            
            if (forgotPhone) forgotPhone.value = '';
            if (resetCode) resetCode.value = '';
            if (newPassword) newPassword.value = '';
            if (confirmNewPassword) confirmNewPassword.value = '';
        }

        // Custom alert function
        function showAlert(title, message, type = 'warning', onConfirm = null) {
            console.log('showAlert called with:', title, message, type);
            
            // Check if alert modal exists
            const alertModal = document.getElementById('alertModal');
            console.log('Alert modal found:', alertModal);
            
            if (!alertModal) {
                console.error('Alert modal not found. Falling back to default alert.');
                alert(`${title}: ${message}`);
                return;
            }
            
            const alertTitle = document.getElementById('alertTitle');
            const alertMessage = document.getElementById('alertMessage');
            const alertIcon = document.querySelector('#alertModal .text-center .w-16 i');
            const alertContainer = document.querySelector('#alertModal .text-center .w-16');
            
            console.log('Alert elements found:', {
                title: alertTitle,
                message: alertMessage,
                icon: alertIcon,
                container: alertContainer
            });
            
            // Check if all required elements exist
            if (!alertTitle || !alertMessage || !alertIcon || !alertContainer) {
                console.error('Alert modal elements not found. Falling back to default alert.');
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
            
            // Store the callback function for when the modal is closed
            if (onConfirm) {
                window.alertModalCallback = onConfirm;
            } else {
                window.alertModalCallback = null;
            }
            
            showModal('alertModal');
        }

        const SITE_LOGO_URL = @json(asset('images/logo.png'));

        /**
         * Branded sample learner performance report (PDF) — for demos and stakeholder previews.
         */
        async function downloadSamplePerformanceReportPdf() {
            if (!(window.jspdf && window.jspdf.jsPDF)) {
                if (typeof showAlert === 'function') {
                    showAlert('PDF', 'The PDF library is still loading. Please wait a moment and try again.', 'warning');
                } else {
                    alert('PDF library not ready.');
                }
                return;
            }
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ unit: 'mm', format: 'a4', compress: true });
            const W = doc.internal.pageSize.getWidth();
            const H = doc.internal.pageSize.getHeight();
            const M = 14;

            // Brand strip (Gravity CBC colours)
            const stripH = 18;
            doc.setFillColor(236, 40, 52);
            doc.rect(0, 0, W / 3, stripH, 'F');
            doc.setFillColor(143, 195, 64);
            doc.rect(W / 3, 0, W / 3, stripH, 'F');
            doc.setFillColor(227, 104, 167);
            doc.rect((2 * W) / 3, 0, W / 3, stripH, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(12);
            doc.text('Gravity CBC', M, 12);

            try {
                const res = await fetch(SITE_LOGO_URL, { credentials: 'same-origin' });
                if (res.ok) {
                    const blob = await res.blob();
                    const dataUrl = await new Promise((resolve, reject) => {
                        const r = new FileReader();
                        r.onload = () => resolve(r.result);
                        r.onerror = reject;
                        r.readAsDataURL(blob);
                    });
                    doc.addImage(dataUrl, 'PNG', W - M - 24, 3, 20, 12);
                }
            } catch (e) { /* optional logo */ }

            doc.setTextColor(33, 37, 41);
            doc.setFontSize(17);
            doc.setFont('helvetica', 'bold');
            doc.text('Learning performance report', M, stripH + 12);
            doc.setFont('helvetica', 'italic');
            doc.setFontSize(9);
            doc.setTextColor(100, 116, 139);
            doc.text('Sample document — illustrative layout only. Not an official school record.', M, stripH + 18);

            let y = stripH + 26;
            doc.setDrawColor(226, 232, 240);
            doc.setFillColor(248, 250, 252);
            doc.roundedRect(M, y, W - 2 * M, 30, 2, 2, 'FD');
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(9);
            doc.setTextColor(71, 85, 105);
            doc.text('Learner', M + 4, y + 8);
            doc.setFont('helvetica', 'normal');
            doc.text('Amina W. (sample)', M + 28, y + 8);
            doc.setFont('helvetica', 'bold');
            doc.text('Grade / pathway', M + 4, y + 16);
            doc.setFont('helvetica', 'normal');
            doc.text('Grade 5 · CBC (integrated)', M + 42, y + 16);
            doc.setFont('helvetica', 'bold');
            doc.text('Reporting period', M + 4, y + 24);
            doc.setFont('helvetica', 'normal');
            doc.text('Term 2 · ' + new Date().getFullYear(), M + 42, y + 24);
            y += 36;

            // Overall competency badge
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(10);
            doc.setTextColor(30, 41, 59);
            doc.text('Overall competency (sample)', M, y);
            y += 6;
            doc.setFillColor(143, 195, 64);
            doc.roundedRect(M, y, W - 2 * M, 14, 2, 2, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(11);
            doc.text('Meeting Expectation (ME) — sample overall band for this report.', M + 4, y + 9);
            y += 22;

            const rows = [
                ['Literacy & languages', '78%', 'Meeting Expectation (ME)', 'Stretch: compare viewpoints in informational texts'],
                ['Mathematics', '72%', 'Meeting Expectation (ME)', 'Reinforce multi-step word problems with bar models'],
                ['Integrated science', '65%', 'Approaching Expectation (AE)', 'Hands-on inquiry on energy & environment'],
                ['Creative arts', '88%', 'Exceeding Expectation (EE)', 'Showcase portfolio piece in school exhibition'],
            ];

            try {
                if (typeof doc.autoTable === 'function') {
                    doc.autoTable({
                        startY: y,
                        head: [['Learning area', 'Score', 'CBE level (Kenya)', 'Suggested next step']],
                        body: rows,
                        theme: 'plain',
                        styles: { fontSize: 8.5, cellPadding: 3, textColor: [30, 41, 59], lineColor: [226, 232, 240], lineWidth: 0.2 },
                        headStyles: { fillColor: [51, 65, 85], textColor: [255, 255, 255], fontStyle: 'bold' },
                        columnStyles: {
                            0: { cellWidth: 42 },
                            1: { cellWidth: 18, halign: 'center' },
                            2: { cellWidth: 32, halign: 'center' },
                            3: { cellWidth: 'auto' },
                        },
                        didParseCell: function (data) {
                            if (data.section !== 'body' || data.column.index !== 2) return;
                            const v = String(data.cell.raw || '');
                            if (v.includes('(EE)')) {
                                data.cell.styles.fillColor = [37, 99, 235];
                                data.cell.styles.textColor = [255, 255, 255];
                            } else if (v.includes('(ME)')) {
                                data.cell.styles.fillColor = [143, 195, 64];
                                data.cell.styles.textColor = [255, 255, 255];
                            } else if (v.includes('(AE)')) {
                                data.cell.styles.fillColor = [245, 158, 11];
                                data.cell.styles.textColor = [30, 41, 59];
                            } else if (v.includes('(BE)')) {
                                data.cell.styles.fillColor = [239, 68, 68];
                                data.cell.styles.textColor = [255, 255, 255];
                            }
                        },
                    });
                    y = (doc.lastAutoTable && doc.lastAutoTable.finalY) ? doc.lastAutoTable.finalY + 8 : y + 40;
                } else {
                    throw new Error('autoTable missing');
                }
            } catch (e) {
                doc.setFont('helvetica', 'bold');
                doc.setFontSize(9);
                doc.text('Learning areas (sample)', M, y);
                y += 5;
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(8.5);
                rows.forEach((row) => {
                    doc.setTextColor(30, 41, 59);
                    doc.text(row[0] + ' — ' + row[1] + ' — ' + row[2], M, y);
                    y += 5;
                    doc.setTextColor(100, 116, 139);
                    const w = doc.splitTextToSize(row[3], W - 2 * M);
                    doc.text(w, M, y);
                    y += w.length * 4 + 3;
                });
                y += 4;
            }

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(9);
            doc.setTextColor(71, 85, 105);
            doc.text('Inclusion snapshot (sample)', M, y);
            y += 5;
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(8.5);
            doc.setTextColor(100, 116, 139);
            const inc = 'Gender-segmented cohort metrics are available in teacher and institution views when schools record optional demographic fields, in line with Kenya’s Data Protection Act, 2019.';
            const splitInc = doc.splitTextToSize(inc, W - 2 * M);
            doc.text(splitInc, M, y);
            y += splitInc.length * 4.2 + 6;

            doc.setDrawColor(226, 232, 240);
            doc.line(M, y, W - M, y);
            y += 5;
            doc.setFontSize(8);
            doc.setTextColor(148, 163, 184);
            doc.text('Gravity CBC · CBC-aligned assessments · assessments.gravitycbc.co.ke', M, y);
            y += 4;
            doc.text('Generated ' + new Date().toLocaleString(), M, y);

            doc.save('GravityCBC-Sample-Performance-Report.pdf');
        }
        window.downloadSamplePerformanceReportPdf = downloadSamplePerformanceReportPdf;
    </script>