import './bootstrap';
import Alpine from 'alpinejs';
import '../css/app.css';

window.Alpine = Alpine;
Alpine.start();

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    // Register form validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            let isValid = true;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            // Password validation
            if (password.length < 8) {
                document.getElementById('passwordError').textContent = 'A senha deve ter pelo menos 8 caracteres';
                isValid = false;
            } else {
                document.getElementById('passwordError').textContent = '';
            }

            // Confirm password validation
            if (password !== confirmPassword) {
                document.getElementById('passwordConfirmError').textContent = 'As senhas não coincidem';
                isValid = false;
            } else {
                document.getElementById('passwordConfirmError').textContent = '';
            }

            if (!isValid) {
                e.preventDefault();
            }
        });
    }

    // Auto-hide alerts
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
});