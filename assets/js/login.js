// assets/js/login.js (Adapted for your project)

// Password toggle functionality
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.querySelector('.toggle-password');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.textContent = '🙈';
    } else {
        passwordInput.type = 'password';
        toggleIcon.textContent = '👁️';
    }
}

document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");
    
    if (!loginForm) {
        console.error('Login form with id="loginForm" not found');
        return;
    }

    loginForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const submitBtn = document.querySelector('.submit-btn');

        // Basic validation
        if (!email || !password) {
            showMessage("Please fill in all fields", "error");
            return;
        }

        // Disable submit button and show loading
        submitBtn.disabled = true;
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Signing In...';

        try {
            // Call login API
            const response = await fetch('./api/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password })
            });

            const result = await response.json();

            if (result.success) {
                // Store user data in localStorage
                localStorage.setItem("user", JSON.stringify(result.data));
                
                showMessage("Login successful! Redirecting...", "success");
                
                // Redirect to dashboard after a short delay
                setTimeout(() => {
                    window.location.replace("landing_page.php");
                }, 1500);
                
            } else {
                showMessage(result.message || "Login failed", "error");
            }

        } catch (err) {
            console.error('Login error:', err);
            showMessage("Unexpected error during login.", "error");
        } finally {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
});

// Message display function (similar to their showUserMessage style)
function showMessage(message, type) {
    // Remove existing messages
    const existingMessage = document.querySelector('.login-message');
    if (existingMessage) {
        existingMessage.remove();
    }
    
    const messageDiv = document.createElement('div');
    messageDiv.className = 'login-message';
    messageDiv.style.cssText = `
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
        font-size: 14px;
        font-weight: 500;
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        min-width: 300px;
        transition: all 0.5s ease-in-out;
    `;
    
    if (type === 'success') {
        messageDiv.style.cssText += `
            background-color: #28a745;
            color: white;
            border: 1px solid #1e7e34;
        `;
    } else {
        messageDiv.style.cssText += `
            background-color: #dc3545;
            color: white;
            border: 1px solid #bd2130;
        `;
    }
    
    messageDiv.textContent = message;
    document.body.appendChild(messageDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.remove();
        }
    }, 5000);
}

// Make functions available globally
window.togglePassword = togglePassword;