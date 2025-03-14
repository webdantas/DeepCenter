import './bootstrap';
import jQuery from 'jquery';
import '@popperjs/core';
import 'bootstrap';

window.$ = jQuery;

// Configuração global do jQuery para AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Exemplo de validação de formulário com jQuery
$(document).ready(function() {
    // Validação do formulário de registro
    $('#registerForm').on('submit', function(e) {
        let isValid = true;
        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();

        // Validação de senha
        if (password.length < 8) {
            $('#passwordError').text('A senha deve ter pelo menos 8 caracteres');
            isValid = false;
        } else {
            $('#passwordError').text('');
        }

        // Validação de confirmação de senha
        if (password !== confirmPassword) {
            $('#passwordConfirmError').text('As senhas não coincidem');
            isValid = false;
        } else {
            $('#passwordConfirmError').text('');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Validação do formulário de login
    $('#loginForm').on('submit', function(e) {
        let isValid = true;
        const email = $('#email').val();

        // Validação de email
        if (!email.includes('@')) {
            $('#emailError').text('Por favor, insira um email válido');
            isValid = false;
        } else {
            $('#emailError').text('');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    // Feedback visual para o usuário
    $('.alert').fadeOut(5000);
});
