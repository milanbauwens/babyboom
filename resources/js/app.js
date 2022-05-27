require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Password hide and show
const showBtn = document.getElementById('show');
const hideBtn = document.getElementById('hide');
const password = document.getElementById('wishlistPasswordVisible');
const passwordDashed = document.getElementById('wishlistPasswordInvisible');

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

// copy link to clipboard
const copyBtn = document.getElementById('copyLink');
const link = document.getElementById('linkWishlist').innerText;

copyBtn.addEventListener('click', () => {
    try {
        navigator.clipboard.writeText(link);
        alert('Link copied to clipboard')
      } catch(err) {
        alert('Error in copying text: ', err);
      }
})
