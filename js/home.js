document.addEventListener('DOMContentLoaded', function() {
    const notify = document.querySelector('.notify');
    const avatar = document.querySelector('.avatar');
    const drop = document.querySelectorAll('.drop'); // Obtendo ambos os menus

    // Função para alternar a visibilidade do dropdown
    function toggleDropdown(dropdown) {
        dropdown.classList.toggle('show');
    }

    // Função para fechar todos os dropdowns
    function closeAllDropdowns() {
        drop.forEach(d => d.classList.remove('show'));
    }

    avatar.addEventListener('click', function(event) {
        event.stopPropagation(); // Evita que o clique se propague para o window.onclick
        closeAllDropdowns(); // Fecha todos os dropdowns antes de abrir o do avatar
        toggleDropdown(drop[1]); // Segundo menu drop é o do avatar
    });

    notify.addEventListener('click', function(event) {
        event.stopPropagation(); // Evita que o clique se propague para o window.onclick
        closeAllDropdowns(); // Fecha todos os dropdowns antes de abrir o das notificações
        toggleDropdown(drop[0]); // Primeiro menu drop é o da notificação
    });

    // Fecha o dropdown se o usuário clicar fora dele
    window.onclick = function(event) {
        if (!event.target.matches('.avatar') && !event.target.matches('.notify')) {
            closeAllDropdowns(); // Fecha todos os dropdowns se clicar fora deles
        }
    }
});




