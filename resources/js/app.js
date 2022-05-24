require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const showBtn = document.getElementById('show');
const hideBtn = document.getElementById('hide');
const password = document.getElementById('wishlistPasswordVisible')
const passwordDashed = document.getElementById('wishlistPasswordInvisible')

showBtn.addEventListener('click', () => {
    showBtn.setAttribute('hidden', 'true')
    hideBtn.removeAttribute('hidden')
    passwordDashed.setAttribute('hidden', 'true')
    password.removeAttribute('hidden')
})

hideBtn.addEventListener('click', () => {
    hideBtn.setAttribute('hidden', 'true')
    showBtn.removeAttribute('hidden')
    passwordDashed.removeAttribute('hidden')
    password.setAttribute('hidden', 'true')
})
