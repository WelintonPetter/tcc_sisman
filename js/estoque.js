document.addEventListener('DOMContentLoaded', function() {
    var btnSignin = document.querySelector("#signin");
    var btnSignup = document.querySelector("#signup");
    var signinButton = document.querySelector("#signinButton");
    var signupButton = document.querySelector("#signupButton");

    var body = document.querySelector("body");
    var languageSelect = document.getElementById('language-select');



    

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
    const avatar = document.querySelector('.avatar');
    const drop = document.querySelector('.drop');

    avatar.addEventListener('click', function() {
        drop.classList.toggle('show');
    });

    // Fecha o dropdown se o usuário clicar fora dele
    window.onclick = function(event) {
        if (!event.target.matches('.avatar')) {
            if (drop.classList.contains('show')) {
                drop.classList.remove('show');
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
    const countdownDate = new Date("Nov 04, 2024 00:00:00").getTime();

    const timerInterval = setInterval(function() {
        const now = new Date().getTime();
        const distance = countdownDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("days").textContent = days.toString().padStart(2, '0');
        document.getElementById("hours").textContent = hours.toString().padStart(2, '0');
        document.getElementById("minutes").textContent = minutes.toString().padStart(2, '0');
        document.getElementById("seconds").textContent = seconds.toString().padStart(2, '0');

        if (distance < 0) {
            clearInterval(timerInterval);
            document.getElementById("countdown").textContent = "Tempo Esgotado!";
        }
    }, 1000);
});

