    <script>
        // Global state
        let currentUser = null;
        let resetPhoneNumber = null; // Store phone number for password reset flow
        
        // API Configuration
        // Change this URL to match your API server
        const API_BASE_URL = 'https://admin.skillszone.africa';
        
        // Load institutions for registration form
        async function loadInstitutions() {
            try {
                const response = await fetch(`${API_BASE_URL}/api/institutions`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    }
                });
                
                const data = await response.json();
                
                if (data.success && data.data) {
                    const institutionSelect = document.getElementById('registerInstitutionId');
                    if (institutionSelect) {
                        // Clear existing options except the first one
                        institutionSelect.innerHTML = '<option value="">Select your institution</option>';
                        
                        // Add institutions from API
                        data.data.forEach(institution => {
                            const option = document.createElement('option');
                            option.value = institution.id;
                            option.textContent = institution.name;
                            institutionSelect.appendChild(option);
                        });
                    }
                }
            } catch (error) {
                console.error('Error loading institutions:', error);
                // Keep the default options if API fails
            }
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
                
                // Clear reset data when closing forgot password modals
                if (['forgotModal', 'verifyCodeModal', 'resetPasswordModal'].includes(modalId)) {
                    clearResetData();
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
        
        // Authentication functions
        async function login(event) {
            event.preventDefault();
            
            const phone = document.getElementById('loginPhone').value;
            const password = document.getElementById('loginPassword').value;
            
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
                        phone_number: standardizePhoneNumber(phone),
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
                    updateAuthState();
                    closeModal('loginModal');
                    
                    // Redirect to dashboard
                    window.location.href = '/dashboard';
                } else {
                    // Show error modal with specific error message from API
                    const errorMessage = data.message || data.error || 'Login failed. Please try again.';
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
            const institutionId = document.getElementById('registerInstitutionId').value;
            const gradeLevel = document.getElementById('registerGradeLevel').value;
            const password = document.getElementById('registerPassword').value;
            const passwordConfirmation = document.getElementById('registerPasswordConfirmation').value;
            const mpesaPhone = document.getElementById('registerMpesaPhone').value;
            
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
                        phone_number: standardizePhoneNumber(phone),
                        email: email || null,
                        password: password,
                        password_confirmation: passwordConfirmation,
                        mpesa_phone: standardizePhoneNumber(mpesaPhone),
                        institution_id: parseInt(institutionId),
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
                    
                    // Redirect to dashboard
                    window.location.href = '/dashboard';
                } else {
                    // Show error modal with specific error message from API
                    const errorMessage = data.message || data.error || 'Registration failed. Please try again.';
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
            const mpesaPhone = document.getElementById('institutionMpesaPhone').value;
            const adminName = document.getElementById('adminName').value;
            const adminPhone = document.getElementById('adminPhone').value;
            const adminEmail = document.getElementById('adminEmail').value;
            const adminPassword = document.getElementById('adminPassword').value;
            const adminPasswordConfirmation = document.getElementById('adminPasswordConfirmation').value;
            
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
                        institution_phone: standardizePhoneNumber(institutionPhone),
                        institution_address: institutionAddress,
                        mpesa_phone: standardizePhoneNumber(mpesaPhone),
                        admin_name: adminName,
                        admin_phone_number: standardizePhoneNumber(adminPhone),
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
                    
                    // Redirect to institution dashboard
                    window.location.href = '/institution-dashboard';
                } else {
                    // Show error modal with specific error message from API
                    const errorMessage = data.message || data.error || 'Institution registration failed. Please try again.';
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
            console.log('User data cleared, updating auth state...');
            updateAuthState();
            showModal('logoutSuccessModal');
        }
        
        function updateAuthState() {
            const loginBtn = document.getElementById('loginBtn');
            const registerBtn = document.getElementById('registerBtn');
            const logoutBtn = document.getElementById('logoutBtn');
            const dashboardLink = document.getElementById('dashboardLink');
            const institutionDashboardLink = document.getElementById('institutionDashboardLink');
            const transactionsLink = document.getElementById('transactionsLink');
            
            const loginBtnMobile = document.getElementById('loginBtnMobile');
            const registerBtnMobile = document.getElementById('registerBtnMobile');
            const logoutBtnMobile = document.getElementById('logoutBtnMobile');
            const dashboardLinkMobile = document.getElementById('dashboardLinkMobile');
            const institutionDashboardLinkMobile = document.getElementById('institutionDashboardLinkMobile');
            const transactionsLinkMobile = document.getElementById('transactionsLinkMobile');
            
            // Ensure currentUser is properly set and not just an empty object
            const isLoggedIn = currentUser && currentUser.id && currentUser.email;
            console.log('updateAuthState called - currentUser:', currentUser, 'isLoggedIn:', isLoggedIn);
            
            if (isLoggedIn) {
                // User is logged in
                if (loginBtn) loginBtn.style.display = 'none';
                if (registerBtn) registerBtn.style.display = 'none';
                if (logoutBtn) logoutBtn.style.display = 'block';
                if (transactionsLink) transactionsLink.style.display = 'block';
                
                if (loginBtnMobile) loginBtnMobile.style.display = 'none';
                if (registerBtnMobile) registerBtnMobile.style.display = 'none';
                if (logoutBtnMobile) logoutBtnMobile.style.display = 'block';
                if (transactionsLinkMobile) transactionsLinkMobile.style.display = 'block';
                
                // Show appropriate dashboard link based on user type
                if (currentUser.user_type === 'institution') {
                    if (institutionDashboardLink) institutionDashboardLink.style.display = 'block';
                    if (institutionDashboardLinkMobile) institutionDashboardLinkMobile.style.display = 'block';
                    if (dashboardLink) dashboardLink.style.display = 'none';
                    if (dashboardLinkMobile) dashboardLinkMobile.style.display = 'none';
                } else {
                    if (dashboardLink) dashboardLink.style.display = 'block';
                    if (dashboardLinkMobile) dashboardLinkMobile.style.display = 'block';
                    if (institutionDashboardLink) institutionDashboardLink.style.display = 'none';
                    if (institutionDashboardLinkMobile) institutionDashboardLinkMobile.style.display = 'none';
                }
            } else {
                // User is logged out
                if (loginBtn) loginBtn.style.display = 'block';
                if (registerBtn) registerBtn.style.display = 'block';
                if (logoutBtn) logoutBtn.style.display = 'none';
                if (dashboardLink) dashboardLink.style.display = 'none';
                if (institutionDashboardLink) institutionDashboardLink.style.display = 'none';
                if (transactionsLink) transactionsLink.style.display = 'none';
                
                if (loginBtnMobile) loginBtnMobile.style.display = 'block';
                if (registerBtnMobile) registerBtnMobile.style.display = 'block';
                if (logoutBtnMobile) logoutBtnMobile.style.display = 'none';
                if (dashboardLinkMobile) dashboardLinkMobile.style.display = 'none';
                if (institutionDashboardLinkMobile) institutionDashboardLinkMobile.style.display = 'none';
                if (transactionsLinkMobile) transactionsLinkMobile.style.display = 'none';
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
            // Load institutions for registration form
            loadInstitutions();
            
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
        });

        // Token calculation function
        function calculateTokens() {
            const amount = parseFloat(document.getElementById('buyTokensAmount').value) || 0;
            const tokens = Math.floor(amount / 1); // 1 KES = 1 token
            
            document.getElementById('displayAmount').textContent = `KES ${amount.toLocaleString()}`;
            document.getElementById('displayTokens').textContent = `${tokens} token${tokens !== 1 ? 's' : ''}`;
        }

        // Buy tokens function
        async function buyTokens(event) {
            event.preventDefault();
            
            if (!currentUser) {
                showAlert('Authentication Required', 'Please log in to purchase tokens.', 'warning');
                return;
            }
            
            const amount = parseFloat(document.getElementById('buyTokensAmount').value);
            const phoneNumber = document.getElementById('buyTokensMpesaPhone').value;
            
            // Validate inputs
            if (!amount || amount < 1) {
                showAlert('Invalid Amount', 'Please enter an amount of at least KES 1.', 'error');
                return;
            }
            
            if (!phoneNumber || !phoneNumber.match(/^254[0-9]{9}$/)) {
                showAlert('Invalid Phone Number', 'Please enter a valid M-PESA phone number in format 254XXXXXXXXX.', 'error');
                return;
            }
            
            const tokens = Math.floor(amount / 1);
            
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
                        phone_number: phoneNumber,
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
                    showAlert('Payment Failed', data.message || 'Payment could not be processed. Please try again.', 'error');
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
                        phone_number: standardizePhoneNumber(phone)
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Store phone number for next steps
                    resetPhoneNumber = standardizePhoneNumber(phone);
                    
                    // Show success message and move to verify code modal
                    showAlert('Code Sent', data.message || 'Reset code sent successfully to your phone', 'success');
                    closeModal('forgotModal');
                    showModal('verifyCodeModal');
                } else {
                    // Show error modal with specific error message from API
                    const errorMessage = data.message || data.error || 'Failed to send reset code. Please try again.';
                    showErrorModal(errorMessage, 'Reset Code Failed');
                }
            } catch (error) {
                console.error('Forgot password error:', error);
                showErrorModal('Network error. Please check your connection and try again.', 'Reset Code Failed');
            } finally {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        }

        async function verifyResetCode(event) {
            event.preventDefault();
            
            const code = document.getElementById('resetCode').value;
            
            if (!resetPhoneNumber) {
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
                    // Show success message and move to reset password modal
                    showAlert('Code Verified', data.message || 'Reset code verified successfully', 'success');
                    closeModal('verifyCodeModal');
                    showModal('resetPasswordModal');
                } else {
                    // Show error modal with specific error message from API
                    const errorMessage = data.message || data.error || 'Invalid reset code. Please try again.';
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
                    showAlert('Password Reset', data.message || 'Password reset successfully. Please login with your new password.', 'success');
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
                    const errorMessage = data.message || data.error || 'Failed to reset password. Please try again.';
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
                    const errorMessage = data.message || data.error || 'Failed to resend reset code. Please try again.';
                    showErrorModal(errorMessage, 'Resend Failed');
                }
            } catch (error) {
                console.error('Resend reset code error:', error);
                showErrorModal('Network error. Please check your connection and try again.', 'Resend Failed');
            }
        }

        // Initialize buy tokens modal with user's phone number
        function initializeBuyTokensModal() {
            if (currentUser && currentUser.mpesa_phone) {
                document.getElementById('buyTokensMpesaPhone').value = currentUser.mpesa_phone;
            }
            calculateTokens(); // Initialize the display
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
        function showAlert(title, message, type = 'warning') {
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
            
            showModal('alertModal');
        }
    </script>
</body>
</html> 