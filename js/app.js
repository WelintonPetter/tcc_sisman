document.addEventListener('DOMContentLoaded', function() {
    var btnSignin = document.querySelector("#signin");
    var btnSignup = document.querySelector("#signup");
    var signinButton = document.querySelector("#signinButton");
    var signupButton = document.querySelector("#signupButton");

    var body = document.querySelector("body");
    var languageSelect = document.getElementById('language-select');

    const textElements = {
        'pt': {
            'welcomeBack': 'Bem-vindo de volta!',
            'stayConnected': 'Para se manter conectado',
            'loginWithPersonalInfo': 'Faça login com suas informações pessoais',
            'signIn': 'Entrar',
            'createAccount': 'Criar Conta',
            'useEmailToRegister': 'ou use seu e-mail para cadastro:',
            'namePlaceholder': 'Nome',
            'emailPlaceholder': 'Email',
            'passwordPlaceholder': 'Senha',
            'signUp': 'Cadastrar',
            'letsStart': 'Vamos Começar?',
            'insertData': 'Insira seus dados e inicie sua jornada de eficiência',
            'inMaintenance': 'na gestão de manutenção conosco.',
            'loginToPlatform': 'Faça login na plataforma',
            'useEmailToLogin': 'ou use sua conta de e-mail:',
            'forgotPassword': 'Esqueceu sua senha?',
            'remind': 'lembrar-me?'
        },
        'en': {
            'welcomeBack': 'Welcome back!',
            'stayConnected': 'To stay connected',
            'loginWithPersonalInfo': 'Login with your personal info',
            'signIn': 'Sign In',
            'createAccount': 'Create Account',
            'useEmailToRegister': 'or use your email for registration:',
            'namePlaceholder': 'Name',
            'emailPlaceholder': 'Email',
            'passwordPlaceholder': 'Password',
            'signUp': 'Sign Up',
            'letsStart': 'Let\'s Start?',
            'insertData': 'Enter your details and start your journey of efficiency',
            'inMaintenance': 'in maintenance management with us.',
            'loginToPlatform': 'Login to the platform',
            'useEmailToLogin': 'or use your email account:',
            'forgotPassword': 'Forgot your password?',
            'remind': 'Remind Me'
        },
        'es': {
            'welcomeBack': '¡Bienvenido de nuevo!',
            'stayConnected': 'Para mantenerse conectado',
            'loginWithPersonalInfo': 'Inicia sesión con tu información personal',
            'signIn': 'Iniciar sesión',
            'createAccount': 'Crear Cuenta',
            'useEmailToRegister': 'o usa tu correo electrónico para registrarte:',
            'namePlaceholder': 'Nombre',
            'emailPlaceholder': 'Correo electrónico',
            'passwordPlaceholder': 'Contraseña',
            'signUp': 'Registrarse',
            'letsStart': '¿Empezamos?',
            'insertData': 'Ingrese sus datos y comience su viaje de eficiencia',
            'inMaintenance': 'en la gestión de mantenimiento con nosotros.',
            'loginToPlatform': 'Inicia sesión en la plataforma',
            'useEmailToLogin': 'o usa tu cuenta de correo:',
            'forgotPassword': '¿Olvidaste tu contraseña?',
            'remind': 'Recuérdame?'
        }
    };

    function updateLanguage(language) {
        document.querySelector('.title-primary').textContent = textElements[language]['letsStart'];
        document.querySelectorAll('.description-primary')[0].textContent = textElements[language]['insertData'];
        document.querySelectorAll('.description-primary')[1].textContent = textElements[language]['inMaintenance'];
        document.getElementById('signin').textContent = textElements[language]['signIn'];
        document.querySelectorAll('.title-second')[0].textContent = textElements[language]['createAccount'];
        document.querySelectorAll('.description-second')[0].textContent = textElements[language]['useEmailToRegister'];
        document.getElementById('name').placeholder = textElements[language]['namePlaceholder'];
        document.getElementById('email-signup').placeholder = textElements[language]['emailPlaceholder'];
        document.getElementById('password-signup').placeholder = textElements[language]['passwordPlaceholder'];
        signupButton.textContent = textElements[language]['signUp'];
        document.querySelectorAll('.title-second')[1].textContent = textElements[language]['loginToPlatform'];
        document.querySelectorAll('.description-second')[1].textContent = textElements[language]['useEmailToLogin'];
        document.querySelector('.password').textContent = textElements[language]['forgotPassword'];
        document.querySelector('.remember-forgot label').textContent = textElements[language]['remind'];
        
        
        signinButton.textContent = textElements[language]['signIn'];
    }

    btnSignin.addEventListener("click", function () {
        body.className = "sign-in-js";
        updateLanguage(languageSelect.value);
    });

    btnSignup.addEventListener("click", function () {
        body.className = "sign-up-js";
        updateLanguage(languageSelect.value);
    });

    signupButton.addEventListener('click', function() {
        window.location.href = 'home.html';
    });

    signinButton.addEventListener('click', function() {
        window.location.href = 'home.html';
    });

    languageSelect.addEventListener('change', function(event) {
        updateLanguage(event.target.value);
    });

    updateLanguage('pt');
    
});
// Crie um arquivo app.js e adicione este código

document.addEventListener('DOMContentLoaded', function() {
    const notify = document.querySelector('.notify');
    const avatar = document.querySelector('.avatar');
    const drop = document.querySelectorAll('.drop'); // Usando querySelectorAll para obter ambos os menus

    // Função para alternar a visibilidade do dropdown
    function toggleDropdown(element) {
        element.classList.toggle('show');
    }

    avatar.addEventListener('click', function() {
        toggleDropdown(drop[1]); // Segundo menu drop é o do avatar
    });

    notify.addEventListener('click', function() {
        toggleDropdown(drop[0]); // Primeiro menu drop é o da notificação
    });

    // Fecha o dropdown se o usuário clicar fora dele
    window.onclick = function(event) {
        if (!event.target.matches('.avatar')) {
            if (drop[1].classList.contains('show')) {
                drop[1].classList.remove('show');
            }
        }
        if (!event.target.matches('.notify')) {
            if (drop[0].classList.contains('show')) {
                drop[0].classList.remove('show');
            }
        }
    }
});





document.getElementById('signupButton').addEventListener('click', function(event) {
    // Obtém os valores dos campos
    var nome = document.getElementById('name').value.trim();
    var email = document.getElementById('email-signup').value.trim();
    var senha = document.getElementById('password-signup').value.trim();

    // Verifica se algum campo está vazio
    if (nome === '' || email === '' || senha === '') {
        alert('Por favor, preencha todos os campos.');
        event.preventDefault(); // Impede o envio do formulário
    }
});

document.addEventListener("DOMContentLoaded", function () {
    // Defina a data final da contagem regressiva
    const countdownDate = new Date("Nov 04, 2024 00:00:00").getTime();

    // Atualiza o temporizador a cada segundo
    const timerInterval = setInterval(function() {
        // Data e hora atuais
        const now = new Date().getTime();

        // Distância entre a data atual e a data de contagem regressiva
        const distance = countdownDate - now;

        // Cálculos de dias, horas, minutos e segundos
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Exibe os valores calculados nos elementos HTML correspondentes
        document.getElementById("days").textContent = days.toString().padStart(2, '0');
        document.getElementById("hours").textContent = hours.toString().padStart(2, '0');
        document.getElementById("minutes").textContent = minutes.toString().padStart(2, '0');
        document.getElementById("seconds").textContent = seconds.toString().padStart(2, '0');

        // Se a contagem regressiva terminar, parar o intervalo
        if (distance < 0) {
            clearInterval(timerInterval);
            document.getElementById("countdown").textContent = "Tempo Esgotado!";
        }
    }, 1000);
});
