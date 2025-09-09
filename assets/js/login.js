// assets/js/login.js

import { callApi, showUserMessage } from './api_calls.js';

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

document.addEventListener("DOMContentLoaded", function () {
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
      showUserMessage("Please fill in all fields", "error");
      return;
    }

    // Email format validation
    if (!isValidEmail(email)) {
      showUserMessage("Please enter a valid email address", "error");
      return;
    }

    // Disable submit button and show loading
    submitBtn.disabled = true;
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Signing In...';

    try {
      // Use company's centralized API system
      const result = await callApi('login', { email, password });

      if (result && result.success) {
        // Store user data in localStorage (following company pattern)
        localStorage.setItem("user", JSON.stringify(result.data));

        showUserMessage("Login successful!", "success");

        // Set login session
        const sessionResult = await callApi('set_login_session', { 
          user_id: result.data.id 
        });

        if (sessionResult && sessionResult.success) {
          showUserMessage("Redirecting to dashboard...", "success");
          
          // Redirect to dashboard page after a short delay
          setTimeout(() => {
            window.location.replace("dashboard.php");
          }, 1500);
        } else {
          showUserMessage("Session setup failed. Redirecting anyway...", "warning");
          setTimeout(() => {
            window.location.replace("dashboard.php");
          }, 1500);
        }

      } else {
        // The callApi function already shows error messages via showUserMessage
        // But we can handle specific login errors here if needed
        console.log('Login failed:', result?.message);
      }

    } catch (err) {
      console.error('Login error:', err);
      showUserMessage("Unexpected error during login.", "error");
    } finally {
      // Re-enable submit button
      submitBtn.disabled = false;
      submitBtn.textContent = originalText;
    }
  });
});

// Email validation helper function
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

// Make togglePassword available globally for the onclick handler
window.togglePassword = togglePassword;