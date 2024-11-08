
function toggleForms() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    loginForm.classList.toggle('hidden');
    registerForm.classList.toggle('hidden');
}

document.getElementById('register').addEventListener('submit', function(event) {
    const password = document.getElementById('registerPassword').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        alert('Passwords do not match');
        event.preventDefault();
    }
});

function alertMessage() {
    let outputMessage = "<?php echo isset($_SESSION['outputResponse']) ? $_SESSION['outputResponse'] : ''; ?>";
    if (outputMessage) {
        alert(outputMessage);
    }
}

