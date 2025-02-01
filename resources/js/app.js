import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    console.log('%c Bienvenido al sistema de Vacas 🐄! ', 'background: #222; color: #bada55; font-size: 24px; padding: 6px;');

    /*==== Si existe el Menu de Main ====*/
    if (document.querySelector('#search_menu')) {
        /*==== SubMenus Toggle ====*/
        // Seleccionar todos los elementos del menú que tienen un submenú
        const menuList = document.querySelectorAll('#menu_list');

        /*==== Menu Toggle ====*/

        const hamburgerMenu = document.querySelector('.hamburger-menu');
        const searchMenu = document.querySelector('#search_menu');

        hamburgerMenu.addEventListener('click', () => {
            searchMenu.classList.toggle('-left-52');
            searchMenu.classList.toggle('left-2');

            hamburgerMenu.classList.toggle('active')
            // Quitar menus SubMenus Toggle
            hiddenOtherMenus(menuList);
        });

        menuList.forEach(item => {
            item.addEventListener('click', (event) => {
                // Evitar el comportamiento predeterminado del enlace
                event.preventDefault();
                // Agregar o eliminar la clase "active" del elemento del menú
                // item.classList.toggle('active');
                hiddenOtherMenus(menuList, item);

                // Obtener el submenú correspondiente
                const submenu = item.nextElementSibling;
                // La imagen de flecha del submenu
                const arrowImg = item.querySelector('#arrow_img');
                // Mostrar u ocultar el submenú
                if (submenu.style.display === 'flex') {
                    submenu.style.display = 'none';
                    arrowImg.classList.remove('transform', '-rotate-90');
                } else {
                    submenu.style.display = 'flex';
                    arrowImg.classList.add('transform', '-rotate-90');
                }
            });
        });

        function hiddenOtherMenus(arrList, item = '') {
            // Ocultar todos los submenús menos el actual si se hace clic en el mismo elemento
            arrList.forEach(otherItem => {
                const arrowImg = otherItem.querySelector('#arrow_img');
                if (item) {
                    if (otherItem !== item) {
                        const otherSubmenu = otherItem.nextElementSibling;
                        otherSubmenu.style.display = 'none';
                        arrowImg.classList.remove('transform', '-rotate-90');
                    }
                } else {
                    const otherSubmenu = otherItem.nextElementSibling;
                    otherSubmenu.style.display = 'none';
                    arrowImg.classList.remove('transform', '-rotate-90');
                }
            });
        }
    }
})