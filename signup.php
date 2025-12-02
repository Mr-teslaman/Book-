<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickify Ticket Secure Authentication</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --nyote-purple: #9b59b6;
            --nyote-blue: #3498db;
            --nyote-green: #2ecc71;
            --nyote-yellow: #f1c40f;
            --nyote-red: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #2ecc71;
            --error-color: #e74c3c;
            --warning-color: #f39c12;
        }

        body {
            background: linear-gradient(135deg, rgba(155, 89, 182, 0.85) 0%, rgba(52, 152, 219, 0.85) 100%), url('https://images.unsplash.com/photo-1461749280684-dccba630e2f6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1769&q=80') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        /* NYOTE Header Styles */
        .header {
            background: linear-gradient(135deg, var(--nyote-purple), var(--nyote-blue));
            color: white;
            text-align: center;
            padding: 25px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 60%);
            transform: rotate(30deg);
        }

        .nyote-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .nyote-star {
            font-size: 32px;
            color: var(--nyote-yellow);
            cursor: pointer;
            transition: all 0.5s ease;
            position: relative;
            text-shadow: 0 0 10px rgba(241, 196, 15, 0.7);
        }

        .nyote-star:hover {
            transform: scale(1.2) rotate(15deg);
            text-shadow: 0 0 20px rgba(241, 196, 15, 1);
        }

        .nyote-star.spin {
            animation: spin 1s ease;
        }

        .nyote-text {
            font-size: 32px;
            font-weight: 800;
            background: linear-gradient(45deg, var(--nyote-yellow), var(--nyote-green), var(--nyote-blue), var(--nyote-purple));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .nyote-text:hover {
            transform: scale(1.05);
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.5);
        }

        .nyote-text.glow {
            animation: glow 1.5s ease-in-out infinite alternate;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
        }

        .security-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--success-color);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
            z-index: 1;
        }

        /* Form Container Styles */
        .form-container {
            padding: 30px;
        }

        .form-toggle {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
        }

        .toggle-btn {
            flex: 1;
            padding: 15px;
            text-align: center;
            background: none;
            border: none;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            color: #777;
            transition: all 0.3s;
        }

        .toggle-btn.active {
            color: var(--nyote-purple);
            border-bottom: 3px solid var(--nyote-purple);
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .form-group label::after {
            content: ' *';
            color: var(--error-color);
        }

        .form-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-group input:focus {
            border-color: var(--nyote-purple);
            box-shadow: 0 0 0 3px rgba(155, 89, 182, 0.2);
            outline: none;
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 43px;
            color: #777;
        }

        .password-strength {
            height: 5px;
            background: #eee;
            border-radius: 3px;
            margin-top: 8px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.5s ease;
        }

        .password-strength-weak {
            background: var(--error-color);
        }

        .password-strength-medium {
            background: var(--warning-color);
        }

        .password-strength-strong {
            background: var(--success-color);
        }

        .password-requirements {
            font-size: 12px;
            color: #777;
            margin-top: 5px;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--nyote-purple), var(--nyote-blue));
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        .btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 1;
            }
            20% {
                transform: scale(25, 25);
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes glow {
            from { text-shadow: 0 0 5px #fff, 0 0 10px #fff, 0 0 15px var(--nyote-yellow), 0 0 20px var(--nyote-yellow); }
            to { text-shadow: 0 0 10px #fff, 0 0 20px #fff, 0 0 30px var(--nyote-yellow), 0 0 40px var(--nyote-yellow); }
        }

        .message {
            padding: 12px;
            margin: 15px 0;
            border-radius: 8px;
            text-align: center;
            display: none;
            animation: fadeIn 0.5s;
        }

        .success {
            background: rgba(46, 204, 113, 0.2);
            color: var(--success-color);
            border: 1px solid var(--success-color);
        }

        .error {
            background: rgba(231, 76, 60, 0.2);
            color: var(--error-color);
            border: 1px solid var(--error-color);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 43px;
            color: #777;
            cursor: pointer;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: var(--nyote-purple);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .social-login {
            margin-top: 25px;
            text-align: center;
        }

        .social-login p {
            margin-bottom: 15px;
            position: relative;
            color: #777;
        }

        .social-login p::before,
        .social-login p::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background: #ddd;
        }

        .social-login p::before {
            left: 0;
        }

        .social-login p::after {
            right: 0;
        }

        .social-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .social-btn {
            padding: 12px 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
        }

        .social-btn.google {
            color: #DB4437;
        }

        .social-btn.facebook {
            color: #4267B2;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Animation for form switching */
        .form {
            transition: all 0.3s ease;
        }

        .hidden {
            display: none;
        }

        .fade-in {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive styles */
        @media (max-width: 480px) {
            .container {
                max-width: 100%;
                border-radius: 10px;
            }
            
            .header {
                padding: 20px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .nyote-text {
                font-size: 28px;
            }
            
            .nyote-star {
                font-size: 28px;
            }
            
            .form-container {
                padding: 20px;
            }
            
            .toggle-btn {
                font-size: 14px;
                padding: 12px;
            }
            
            .social-buttons {
                flex-direction: column;
            }
        }

        /* Accessibility improvements */
        input:focus, button:focus, .social-btn:focus {
            outline: 2px solid var(--nyote-purple);
            outline-offset: 2px;
        }

        .high-contrast {
            filter: contrast(1.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="nyote-badge">
                <div class="nyote-star" id="nyoteStar">
                    <i class="fas fa-star"></i>
                </div>
                <div class="nyote-text" id="nyoteText">TICKIFY</div>
            </div>
            <p>Secure Authentication Portal</p>
            <div class="security-badge">
                <i class="fas fa-shield-alt"></i> Secured
            </div>
        </div>

        <div class="form-container">
            <div class="form-toggle">
                <button class="toggle-btn active" id="loginToggle">Login</button>
                <button class="toggle-btn" id="registerToggle">Register</button>
            </div>

            <!-- Success/Error Messages -->
            <div id="message" class="message"></div>

            <!-- Login Form -->
            <form id="loginForm" class="form" action="login.php" method="Post">
                <input type="hidden" id="login_csrf" name="csrf_token" value="csrf_token_placeholder">
                
                <div class="form-group">
                    <label for="loginEmail">Email Address</label>
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" id="loginEmail" placeholder="Enter your email address" required aria-required="true">
                </div>
                
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="loginPassword" placeholder="Enter your password" required aria-required="true">
                    <i class="fas fa-eye password-toggle" onclick="togglePassword('loginPassword')" aria-label="Show password"></i>
                </div>
                <div class="form-group" style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <input type="checkbox" id="rememberMe" style="width: auto; margin-right: 5px;">
                        <label for="rememberMe" style="display: inline;">Remember me</label>
                    </div>
                    <a href="#" style="color: var(--nyote-purple); text-decoration: none;" onclick="showPasswordReset()">Forgot Password?</a>
                </div>
                <button type="submit" class="btn">Login</button>

                <div class="social-login">
                    <p>Or login with</p>
                    <div class="social-buttons">
                        <button type="button" class="social-btn google">
                            <i class="fab fa-google"></i> Google
                        </button>
                        <button type="button" class="social-btn facebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </button>
                    </div>
                </div>
            </form>

            <!-- Register Form -->
            <form id="registerForm" class="form hidden" action="register.php" method="post">
                <input type="hidden" id="register_csrf" name="csrf_token" value="csrf_token_placeholder">
                
                <div class="form-group">
                    <label for="registerName">Full Name</label>
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" id="registerName" placeholder="Enter your full name" required aria-required="true">
                </div>
                <div class="form-group">
                    <label for="registerEmail">Email Address</label>
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" id="registerEmail" placeholder="Enter your email address" required aria-required="true">
                </div>
                <div class="form-group">
                    <label for="registerPhone">Phone Number</label>
                    <i class="fas fa-phone input-icon"></i>
                    <input type="tel" id="registerPhone" placeholder="Enter your phone number" required aria-required="true">
                </div>
                <div class="form-group">
                    <label for="registerPassword">Password</label>
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="registerPassword" placeholder="Create a strong password" required aria-required="true" oninput="checkPasswordStrength(this.value)">
                    <i class="fas fa-eye password-toggle" onclick="togglePassword('registerPassword')" aria-label="Show password"></i>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="passwordStrengthBar"></div>
                    </div>
                    <div class="password-requirements" id="passwordRequirements">
                        Must be at least 8 characters with a number and symbol
                    </div>
                </div>
                <div class="form-group">
                    <label for="registerConfirmPassword">Confirm Password</label>
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="registerConfirmPassword" placeholder="Confirm your password" required aria-required="true">
                    <i class="fas fa-eye password-toggle" onclick="togglePassword('registerConfirmPassword')" aria-label="Show password"></i>
                </div>
                <div class="form-group">
                    <input type="checkbox" id="termsAgree" style="width: auto; margin-right: 5px;" required aria-required="true">
                    <label for="termsAgree" style="display: inline;">I agree to the <a href="privancy and terms.html" style="color: var(--nyote-purple);">Terms & Conditions</a></label>
                </div>
                <button type="submit" class="btn">Create Account</button>

                <div class="social-login">
                    <p>Or register with</p>
                    <div class="social-buttons">
                        <button type="button" class="social-btn google">
                            <i class="fab fa-google"></i> Google
                        </button>
                        <button type="button" class="social-btn facebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </button>
                    </div>
                </div>
            </form>

            <!-- Password Reset Form -->
            <form id="resetForm" class="form hidden" action="reset-request.php" method="post">
                <input type="hidden" id="reset_csrf" name="csrf_token" value="csrf_token_placeholder">
                
                <div class="form-group">
                    <label for="resetEmail">Email Address</label>
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" id="resetEmail" name="email" placeholder="Enter your registered email" required aria-required="true">
                </div>
                <button type="submit" class="btn">Send Reset Link</button>
                <div class="footer">
                    <a href="#" onclick="showLoginForm()">Back to Login</a>
                </div>
            </form>

            <!-- Reset Password Form (after clicking email link) -->
            <form id="newPasswordForm" class="form hidden" action="reset-password.php" method="post">
                <input type="hidden" id="new_password_csrf" name="csrf_token" value="csrf_token_placeholder">
                <input type="hidden" id="resetToken" name="reset_token">
                
                <div class="form-group">
                    <label for="newPassword">New Password</label>
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="newPassword" placeholder="Enter new password" required aria-required="true" oninput="checkPasswordStrength(this.value, 'new')">
                    <i class="fas fa-eye password-toggle" onclick="togglePassword('newPassword')" aria-label="Show password"></i>
                    <div class="password-strength">
                        <div class="password-strength-bar" id="newPasswordStrengthBar"></div>
                    </div>
                    <div class="password-requirements" id="newPasswordRequirements">
                        Must be at least 8 characters with a number and symbol
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirmNewPassword">Confirm New Password</label>
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="confirmNewPassword" name="confirm_password" placeholder="Confirm new password" required aria-required="true">
                    <i class="fas fa-eye password-toggle" onclick="togglePassword('confirmNewPassword')" aria-label="Show password"></i>
                </div>
                <button type="submit" class="btn">Reset Password</button>
                <div class="footer">
                    <a href="#" onclick="showLoginForm()">Back to Login</a>
                </div>
            </form>

            <div class="footer">
                <p>By using this service, you agree to our <a href="privancy and terms.html">Privacy Policy</a> and <a href="privancy and terms.html">Terms of Service</a></p>
            </div>
        </div>
    </div>

    <script>
        // Generate CSRF token (in a real app, this would come from the server)
        function generateCsrfToken() {
            return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        }

        // Set CSRF tokens
        document.getElementById('login_csrf').value = generateCsrfToken();
        document.getElementById('register_csrf').value = generateCsrfToken();
        document.getElementById('reset_csrf').value = generateCsrfToken();
        document.getElementById('new_password_csrf').value = generateCsrfToken();

        // NYOTE animations
        const nyoteStar = document.getElementById('nyoteStar');
        const nyoteText = document.getElementById('nyoteText');
        
        nyoteStar.addEventListener('click', function() {
            this.classList.add('spin');
            setTimeout(() => {
                this.classList.remove('spin');
            }, 1000);
        });
        
        nyoteText.addEventListener('click', function() {
            this.classList.toggle('glow');
        });

        // Check if URL has reset token (simulating email link click)
        const urlParams = new URLSearchParams(window.location.search);
        const resetToken = urlParams.get('token');
        if (resetToken) {
            document.getElementById('resetToken').value = resetToken;
            showNewPasswordForm();
        }

        // Toggle between login and register forms
        const loginToggle = document.getElementById('loginToggle');
        const registerToggle = document.getElementById('registerToggle');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const resetForm = document.getElementById('resetForm');
        const newPasswordForm = document.getElementById('newPasswordForm');

        loginToggle.addEventListener('click', () => {
            loginToggle.classList.add('active');
            registerToggle.classList.remove('active');
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            resetForm.classList.add('hidden');
            newPasswordForm.classList.add('hidden');
            document.getElementById('message').style.display = 'none';
        });

        registerToggle.addEventListener('click', () => {
            registerToggle.classList.add('active');
            loginToggle.classList.remove('active');
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
            resetForm.classList.add('hidden');
            newPasswordForm.classList.add('hidden');
            document.getElementById('message').style.display = 'none';
        });

        function showPasswordReset() {
            loginForm.classList.add('hidden');
            registerForm.classList.add('hidden');
            resetForm.classList.remove('hidden');
            newPasswordForm.classList.add('hidden');
            document.getElementById('message').style.display = 'none';
        }

        function showNewPasswordForm() {
            loginForm.classList.add('hidden');
            registerForm.classList.add('hidden');
            resetForm.classList.add('hidden');
            newPasswordForm.classList.remove('hidden');
            document.getElementById('message').style.display = 'none';
            loginToggle.classList.remove('active');
            registerToggle.classList.remove('active');
        }

        function showLoginForm() {
            resetForm.classList.add('hidden');
            newPasswordForm.classList.add('hidden');
            loginForm.classList.remove('hidden');
            document.getElementById('message').style.display = 'none';
            loginToggle.classList.add('active');
            registerToggle.classList.remove('active');
        }

        // Toggle password visibility
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = passwordInput.parentNode.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
                eyeIcon.setAttribute('aria-label', 'Hide password');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
                eyeIcon.setAttribute('aria-label', 'Show password');
            }
        }

        // Check password strength
        function checkPasswordStrength(password, formType = 'register') {
            const strengthBar = document.getElementById(formType === 'register' ? 'passwordStrengthBar' : 'newPasswordStrengthBar');
            const requirements = document.getElementById(formType === 'register' ? 'passwordRequirements' : 'newPasswordRequirements');
            let strength = 0;
            
            // Reset class and width
            strengthBar.className = 'password-strength-bar';
            strengthBar.style.width = '0';
            
            // If password is not empty
            if (password.length > 0) {
                // If password contains both lower and uppercase characters
                if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1;
                
                // If it has numbers and characters
                if (password.match(/([0-9])/)) strength += 1;
                
                // If it has special characters
                if (password.match(/([!,@,#,$,%,^,&,*,?,_,~])/)) strength += 1;
                
                // If it is longer than 7 characters
                if (password.length > 7) strength += 1;
                
                // Update strength bar
                if (strength === 0) {
                    strengthBar.style.width = '0%';
                } else if (strength === 1) {
                    strengthBar.style.width = '25%';
                    strengthBar.classList.add('password-strength-weak');
                    requirements.style.color = 'var(--error-color)';
                } else if (strength === 2) {
                    strengthBar.style.width = '50%';
                    strengthBar.classList.add('password-strength-weak');
                    requirements.style.color = 'var(--error-color)';
                } else if (strength === 3) {
                    strengthBar.style.width = '75%';
                    strengthBar.classList.add('password-strength-medium');
                    requirements.style.color = 'var(--warning-color)';
                } else if (strength === 4) {
                    strengthBar.style.width = '100%';
                    strengthBar.classList.add('password-strength-strong');
                    requirements.style.color = 'var(--success-color)';
                }
            } else {
                requirements.style.color = '#777';
            }
        }

        // Show message
        function showMessage(message, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = message;
            messageDiv.className = 'message ' + type;
            messageDiv.style.display = 'block';
            
            // Focus on message for screen readers
            messageDiv.setAttribute('tabindex', '-1');
            messageDiv.focus();
        }

        // Handle login form submission
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            const csrfToken = document.getElementById('login_csrf').value;
            const rememberMe = document.getElementById('rememberMe').checked;
            
            // Simple validation
            if (!email || !password) {
                showMessage('Please fill in all fields', 'error');
                return;
            }
            
            // Simulate login process
            simulateLogin(email, password, csrfToken, rememberMe);
        });

        // Handle register form submission
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const name = document.getElementById('registerName').value;
            const email = document.getElementById('registerEmail').value;
            const phone = document.getElementById('registerPhone').value;
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('registerConfirmPassword').value;
            const termsAgree = document.getElementById('termsAgree').checked;
            const csrfToken = document.getElementById('register_csrf').value;
            
            // Validation
            if (!name || !email || !phone || !password || !confirmPassword) {
                showMessage('Please fill in all fields', 'error');
                return;
            }
            
            if (password !== confirmPassword) {
                showMessage('Passwords do not match', 'error');
                return;
            }
            
            if (password.length < 8) {
                showMessage('Password must be at least 8 characters', 'error');
                return;
            }
            
            if (!/(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])/.test(password)) {
                showMessage('Password must contain at least one number and one symbol', 'error');
                return;
            }
            
            if (!termsAgree) {
                showMessage('You must agree to the terms and conditions', 'error');
                return;
            }
            
            // Simulate registration process
            simulateRegistration(name, email, phone, password, csrfToken);
        });

        // Handle password reset request form submission
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('resetEmail').value;
            const csrfToken = document.getElementById('reset_csrf').value;
            
            if (!email) {
                showMessage('Please enter your email address', 'error');
                return;
            }
            
            // Simulate password reset request process
            simulatePasswordResetRequest(email, csrfToken);
        });

        // Handle new password form submission
        document.getElementById('newPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const newPassword = document.getElementById('newPassword').value;
            const confirmNewPassword = document.getElementById('confirmNewPassword').value;
            const resetToken = document.getElementById('resetToken').value;
            const csrfToken = document.getElementById('new_password_csrf').value;
            
            if (!newPassword || !confirmNewPassword) {
                showMessage('Please fill in all fields', 'error');
                return;
            }
            
            if (newPassword !== confirmNewPassword) {
                showMessage('Passwords do not match', 'error');
                return;
            }
            
            if (newPassword.length < 8) {
                showMessage('Password must be at least 8 characters', 'error');
                return;
            }
            
            if (!/(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])/.test(newPassword)) {
                showMessage('Password must contain at least one number and one symbol', 'error');
                return;
            }
            
            // Simulate password reset process
            simulatePasswordReset(newPassword, resetToken, csrfToken);
        });

        // Simulate login process (to be replaced with actual AJAX call)
        function simulateLogin(email, password, csrfToken, rememberMe) {
            showMessage('Logging in...', 'success');
            
            // This would be replaced with an actual AJAX call to the server
            setTimeout(() => {
                // Simulate successful login
                showMessage('Login successful! Redirecting to dashboard...', 'success');
                
                // Redirect to dashboard after successful login
                setTimeout(() => {
                    window.location.href = 'dashboard.html';
                }, 1500);
            }, 1000);
        }

        // Simulate registration process (to be replaced with actual AJAX call)
        function simulateRegistration(name, email, phone, password, csrfToken) {
            showMessage('Creating your account...', 'success');
            
            // This would be replaced with an actual AJAX call to the server
            setTimeout(() => {
                // SAVE NAME (TEMPORARY)
               let username = email.split("@")[0];
                localStorage.setItem("tickify_user_name", username);
                // Simulate successful registration
                showMessage('Registration successful! You can now login.', 'success');
                
                // Switch to login form after successful registration
                setTimeout(() => {
                    loginToggle.click();
                    document.getElementById('loginEmail').value = email;
                    document.getElementById('loginPassword').value = '';
                }, 1500);
            }, 1000);
        }

        // Simulate password reset request process (to be replaced with actual AJAX call)
        function simulatePasswordResetRequest(email, csrfToken) {
            showMessage('Sending reset instructions to your email...', 'success');
            
            // This would be replaced with an actual AJAX call to the server
            setTimeout(() => {
                // Simulate successful reset request
                showMessage('Password reset instructions sent to your email', 'success');
                
                // Switch to login form
                setTimeout(() => {
                    showLoginForm();
                }, 2000);
            }, 1000);
        }

        // Simulate password reset process (to be replaced with actual AJAX call)
        function simulatePasswordReset(newPassword, resetToken, csrfToken) {
            showMessage('Resetting your password...', 'success');
            
            // This would be replaced with an actual AJAX call to the server
            setTimeout(() => {
                // Simulate successful password reset
                showMessage('Password reset successful! You can now login with your new password.', 'success');
                
                // Switch to login form
                setTimeout(() => {
                    showLoginForm();
                }, 2000);
            }, 1000);
        }
        // Initialize form with focus on first input
        document.getElementById('loginEmail').focus();
    </script>
</body>
</html>