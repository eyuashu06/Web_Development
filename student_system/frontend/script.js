// ===========================================
// FORM HANDLING & AJAX REQUESTS
// ===========================================

// Handle Registration Form Submission
const registrationForm = document.getElementById('registrationForm');
if (registrationForm) {
    registrationForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(registrationForm);
        
        try {
            const response = await fetch('register-process.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                showMessage(result.message, 'success');
                setTimeout(() => {
                    window.location.href = 'login.html';
                }, 2000);
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            showMessage('An error occurred. Please try again.', 'error');
        }
    });
}

// Handle Login Form Submission
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = new FormData(loginForm);
        
        try {
            const response = await fetch('login-process.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.success) {
                showMessage(result.message, 'success');
                setTimeout(() => {
                    window.location.href = 'dashboard.php';
                }, 1500);
            } else {
                showMessage(result.message, 'error');
            }
        } catch (error) {
            showMessage('An error occurred. Please try again.', 'error');
        }
    });
}

// Show Message Function
function showMessage(message, type) {
    const messageArea = document.getElementById('messageArea');
    if (messageArea) {
        messageArea.innerHTML = `
            <div class="alert alert-${type}">
                ${message}
            </div>
        `;
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            messageArea.innerHTML = '';
        }, 5000);
    }
}

// Password confirmation validation (real-time)
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirm_password');

if (password && confirmPassword) {
    confirmPassword.addEventListener('input', () => {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match!');
        } else {
            confirmPassword.setCustomValidity('');
        }
    });
}