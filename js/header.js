'use strict';

{
    /**
     * ハンバーガーメニュー
     */
    const hum_btn = document.getElementById('hum_btn');
    const h_nav = document.getElementById('h_nav');
    const nav_back = document.getElementById('nav_back');
    const header = document.getElementById('header');
    const html = document.querySelector('html');
    function humberger() {
        hum_btn.classList.toggle('active');
        h_nav.classList.toggle('active');
        html.classList.toggle('hum_active');
        if (header.classList.contains('active')) {
            setTimeout(() => {
                header.classList.remove('active');
            }, 500);
        } else {
            header.classList.add('active');
        }
    }
    hum_btn.addEventListener('click', humberger);
    nav_back.addEventListener('click', humberger);
}
