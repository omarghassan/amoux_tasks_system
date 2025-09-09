// assets/js/signup.js

// Import their centralized API system
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

// Form submission handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('signupForm') || document.querySelector('form');
    const submitBtn = document.querySelector('.submit-btn');
    
    if (!form || !submitBtn) {
        console.error('Form or submit button not found');
        return;
    }
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Get form data
        const formData = {
            name: document.getElementById('name').value.trim(),
            email: document.getElementById('email').value.trim(),
            password: document.getElementById('password').value
        };
        
        // Basic client-side validation
        if (!validateForm(formData)) {
            return;
        }
        
        // Disable submit button and show loading
        submitBtn.disabled = true;
        const originalText = submitBtn.textContent;
        submitBtn.textContent = 'Creating Account...';
        
        try {
            // Use their centralized API system
            const result = await callApi('signup', formData);
            
            if (result && result.success) {
                showUserMessage('Account created successfully! Redirecting...', 'success');
                
                // Clear form
                form.reset();
                clearAllFieldErrors();
                
                // Redirect to login page after 2 seconds
                setTimeout(() => {
                    window.location.href = './dashboard.php';
                }, 2000);
                
            } else {
                // The callApi function already shows error messages via showUserMessage
                // But we can show additional validation errors if they exist
                if (result && result.data && result.data.errors) {
                    const errorList = result.data.errors.join(', ');
                    showUserMessage(errorList, 'error');
                }
            }
            
        } catch (error) {
            console.error('Error during signup:', error);
            showUserMessage('An error occurred. Please try again.', 'error');
        } finally {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
});

// Client-side form validation
function validateForm(data) {
    let isValid = true;
    
    // Clear previous errors
    clearAllFieldErrors();
    
    // Name validation
    if (!data.name) {
        showFieldError('name', 'Name is required');
        isValid = false;
    } else if (data.name.length < 2) {
        showFieldError('name', 'Name must be at least 2 characters');
        isValid = false;
    }
    
    // Email validation
    if (!data.email) {
        showFieldError('email', 'Email is required');
        isValid = false;
    } else if (!isValidEmail(data.email)) {
        showFieldError('email', 'Please enter a valid email');
        isValid = false;
    }
    
    // Password validation
    if (!data.password) {
        showFieldError('password', 'Password is required');
        isValid = false;
    } else if (data.password.length < 8) {
        showFieldError('password', 'Password must be at least 8 characters');
        isValid = false;
    }
    
    return isValid;
}

// Email validation helper
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Show field error
function showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId);
    if (!field) return;
    
    const fieldContainer = field.parentNode.classList.contains('password-container') 
        ? field.parentNode.parentNode 
        : field.parentNode;
    
    // Remove existing error
    const existingError = fieldContainer.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.style.cssText = `
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    `;
    errorDiv.textContent = message;
    
    fieldContainer.appendChild(errorDiv);
    field.style.borderColor = '#dc3545';
}

// Clear field error
function clearFieldError(fieldId) {
    const field = document.getElementById(fieldId);
    if (!field) return;
    
    const fieldContainer = field.parentNode.classList.contains('password-container') 
        ? field.parentNode.parentNode 
        : field.parentNode;
    
    const existingError = fieldContainer.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    field.style.borderColor = '#ddd';
}

// Clear all field errors
function clearAllFieldErrors() {
    const errors = document.querySelectorAll('.field-error');
    errors.forEach(error => error.remove());
    
    const inputs = document.querySelectorAll('.form-input');
    inputs.forEach(input => {
        if (input.style.borderColor === 'rgb(220, 53, 69)') { // #dc3545 in rgb
            input.style.borderColor = '#ddd';
        }
    });
}

// Make togglePassword available globally for the onclick handler
window.togglePassword = togglePassword;