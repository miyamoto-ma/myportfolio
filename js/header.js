'use strict';

{
    /**
     * メニュー（ナビ）現在ページのボタンにクラスを付ける
     */
    const file_name = location.href.split('/').pop();
    let lists = Array.from(document.getElementById('h_nav').children[0].children);
    lists.pop();
    window.addEventListener('load', () => {
        lists.forEach(list => {
            let a_tag = list.children[0];
            let href_file_name = a_tag.href.split('/').pop();
            if (file_name === href_file_name) {
                a_tag.classList.add('active');
            } else {
                a_tag.classList.remove('active');
            }
        });
    });

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
