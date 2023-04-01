'use strict';

// スライダー(slick)設定
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
        slidesToShow: 3, // スライドの表示数
        slidesToScroll: 1, // 一度にスライドする数
        centerMode: true, // センターモード
    });
});
