'use strict';

{
    /**
     * トップへ戻るボタン
     */

    // トップへ戻る機能
    const to_top = document.getElementById('to_top');
    to_top.addEventListener('click', () => {
        window.scroll({ top: 0, behavior: 'smooth' });
    });

    // 下にスクロールしたらボタン表示
    const window_h = window.innerHeight;
    let timer = null;
    function func() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            if (window.pageYOffset > window_h) {
                to_top.classList.remove('hide');
            } else {
                to_top.classList.add('hide');
            }
        }, 16);
    }
    window.addEventListener('scroll', func, {passive: true});


}
