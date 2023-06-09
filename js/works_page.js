'use strict';

{
    /**
     * 画像の(ラップの)幅を取得して高さを設定
     */
    let wraps = document.querySelectorAll('.w_img_wrap');
    function change_height() {
        wraps.forEach(wrap => {
            let wrap_w = wrap.clientWidth;
            wrap.style.height = Math.floor(wrap_w * 2 / 3) + "px";
            const img = wrap.children[0];
            const img_w = img.clientWidth;
            if (img_w < wrap_w) {
                img.style.width = "100%";
                img.style.height = "auto";
            }
        });
    }
    window.addEventListener('DOMContentLoaded', change_height);
    window.addEventListener('resize', change_height);
}
