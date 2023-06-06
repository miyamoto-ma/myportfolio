'use strict';
{
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        // 閉じるボタン
        const modal_btn = document.createElement('p');
        modal_btn.classList.add('modal_btn');
        // 背景(こちらでも閉じられる)
        const modal_back = document.createElement('div');
        modal_back.classList.add('modal_back');
        // 画像
        const modal_img = modal.childNodes[1];
        // 画像をラップするdiv
        const img_wrap = document.createElement('div');
        img_wrap.classList.add('img_wrap');

        // 要素の配置
        modal.appendChild(img_wrap);
        modal.appendChild(modal_back);
        img_wrap.appendChild(modal_btn);
        img_wrap.appendChild(modal_img);

        // 画像の元々のサイズを取得しておく
        const o_img_width = modal_img.clientWidth;
        const o_img_height = modal_img.clientHeight;

        // HTML要素の取得
        const html = document.querySelector('html');

        // モーダルを開く
        modal_img.addEventListener('click', () => {
            const window_w = window.innerWidth;
            const window_h = window.innerHeight;

            // とりあえず高さの90％のサイズで画像を収めるようにする
            img_wrap.style.height = window_h * 0.8 + 'px';
            img_wrap.style.width = 'auto';
            modal_img.style.height = 100 + '%';
            modal_img.style.width = 'auto';
            // その状態で画像がウィンドウの横幅を超えるなら再調整
            if (modal_img.clientWidth > window_w) {
                img_wrap.style.height = 'auto';
                img_wrap.style.width = window_w * 0.9 + 'px';
                modal_img.style.height = 'auto';
                modal_img.style.width = 100 + '%';
            }
            modal.classList.add('active');
            html.classList.add('modal_html');
        });

        // モーダルを閉じる（閉じるボタンより））
        modal_btn.addEventListener('click', () => {
            img_wrap.style.height = 'auto';
            img_wrap.style.width = 100 + '%';
            modal_img.style.height = 'auto';
            modal_img.style.width =  100 + '%';

            modal.classList.remove('active');
            html.classList.remove('modal_html');
        });
        // モーダルを閉じる（背景より）
        modal_back.addEventListener('click', () => {
            img_wrap.style.height = 'auto';
            img_wrap.style.width = 100 + '%';
            modal_img.style.height = o_img_height + 'px';
            modal_img.style.width =  o_img_width + 'px';

            modal.classList.remove('active');
            html.classList.remove('modal_html');
        });
    });
}
