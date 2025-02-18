document.addEventListener('DOMContentLoaded', function() {
    const burger = document.querySelector('.navbar__burger');
    const menu = document.querySelector('.navbar__menu');

    burger.addEventListener('click', function() {
        menu.classList.toggle('active');
    });
}); 



    document.querySelector('.toggle-password').addEventListener('click', function() {
        const password = document.querySelector('#password');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
