function showForm(formId) {
    // Esconde todos os formulários
    document.querySelectorAll('.form-container').forEach(function(form) {
        form.classList.remove('active');
    });

    // Mostra o formulário clicado
    document.getElementById(formId).classList.add('active');
}

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('imagePreview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}


document.addEventListener('DOMContentLoaded', function() {
    fetch('get_sectors.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('sector').innerHTML = data;
        })
        .catch(error => console.error('Erro ao carregar setores:', error));
});

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('imagePreview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}