'use strict';
{
    /**
     * スライダー(slick)設定
     */
    let window_w = window.innerWidth;
    let slidesToShow_value = 5;
    function slides_count() {
        if (window_w <= 768) {
            slidesToShow_value = 1;
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
}
