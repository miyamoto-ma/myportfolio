'use strict';
{
    /**
     * スライダー(slick)設定
     */
    let window_w = window.innerWidth;
    let slidesToShow_value = 5;
    function slides_count() {
        if (window_w <= 768) {
            slidesToShow_value = 2;
        } else if (window_w <= 1024) {
            slidesToShow_value = 3;
        }
    }
    window.addEventListener('load', slides_count());
    window.addEventListener('resize', slides_count());
    $(function () {
        $('#blog_slider').slick({
            // スライダー部分
            speed: 300, // 切り替え時間
            autoplay: true, // 自動再生
            autoplaySpeed: 3000, // スライドの表示時間
            infinity: true, // スライドのループ
            cssEase: 'linear', // イージング
            focusOnSelect: false,

            // オプション
            arrows: true, // 左右の矢印
            prevArrow: '<button class="slick-prev"></button>',
            nextArrow: '<button class="slick-next"></button>',
            dots: true, // ドットインジケーター
            slidesToShow: slidesToShow_value, // スライドの表示数
            slidesToScroll: 1, // 一度にスライドする数
            centerMode: true, // センターモード
        });
    });

    /**
     * 画像のインナーのbox-shadowのサイズを調整
     */
    const h_imgs = document.querySelectorAll('.h_img');
    function adjust_height(shadow, img) {
        let img_height = img.clientHeight;
        shadow.style.height = img_height + 'px';
    }
    h_imgs.forEach(h_img => {
        let img = h_img.children[0];
        window.addEventListener('load', () => { adjust_height(h_img, img); });
        window.addEventListener('resize', () => { adjust_height(h_img, img); });
    });

    /**
     * 画像枠のパララックス
     */
    const targets = document.querySelectorAll('.parallax');
    let window_h = window.innerHeight;  // ウィンドウの高さ
    let targets_pos = [];
    const offset = 50;
    targets.forEach((target, index) => {
        targets_pos[index] = target.getBoundingClientRect().top - offset;
    });
    let speed = 0;
    function getSpeed() {
        speed = -0.13;
        if (window.innerWidth <= 768) {
            speed = speed / 2;
        }
    }
    let timer = null;
    function parallax() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            let window_pos = window.scrollY;        // ウィンドウのスクロール量(縦)
            targets.forEach((target, index) => {
                let pos = targets_pos[index];
                if (window_pos + window_h >= pos) {
                    let translateY = 0;
                    if (pos + offset < window_h) {
                        translateY = window_pos * speed;
                    } else {
                        translateY = (window_pos + window_h - pos) * speed;
                    }
                    target.style.transform = "translateY(" + translateY + "px)";
                }
            });
        }, 8);
    }
    window.addEventListener('DOMContentLoaded', getSpeed);
    window.addEventListener('resize', getSpeed);
    window.addEventListener('scroll', parallax, {passive: true});


    /**
     * 画像の幅を取得して高さを設定
     */
    let cubes = document.querySelectorAll('.cube');
    function change_height() {
        cubes.forEach(cube => {
            let cube_w = cube.clientWidth;
            cube.style.height = cube_w + "px";
            const img = cube.children[0];
            const img_w = img.clientWidth;
            if (img_w < cube_w) {
                img.style.width = "100%";
                img.style.height = "auto";
            }
        });
    }
    window.addEventListener('DOMContentLoaded', change_height);
    window.addEventListener('resize', change_height);

}
