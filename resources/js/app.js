require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const editBtn = document.getElementById('editSettings');
const data = document.querySelectorAll('.settings__data');

editBtn.addEventListener('click', (e) => {
    e.preventDefault();
    data.forEach(dataElement => {
        const input = document.createElement('input');
        input.type = 'text';
        input.className = 'settings__input'
        input.value = dataElement.innerHTML;
        dataElement.replaceWith(input);
    });
})
