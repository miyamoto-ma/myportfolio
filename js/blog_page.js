'use strict';

{
    let path_name = (new URL(window.location.href).pathname);
    let sepa1 = path_name.lastIndexOf('/');
    let file = path_name.substring(sepa1 + 1);
    let sepa2 = file.lastIndexOf('.');
    const base = file.substring(0, sepa2);

    /**
     * 「編集」をクリックで、blogIdとuserIdをセットしてジャンプ
     */
    let edits = document.querySelectorAll('.edit');
    edits.forEach(edit => {
        edit.addEventListener('click', e => {
            let blogId = e.target.parentNode.dataset.blog;
            let current_page = e.target.parentNode.dataset.page;
            location.href = 'edit.php?base='+ base +'&action=edit&blogId=' + blogId + '&page=' + current_page;
        });
    });

    /**
     * 「削除」をクリックで、blogIdとtokenをセットしてAjax
     */
    let deletes = document.querySelectorAll('.delete');
    const token = document.querySelector('main').dataset.token;
    deletes.forEach(del => {
        del.addEventListener('click', e => {
            let conf_res = confirm('投稿を削除します。');
            let err_del = e.target.previousElementSibling.previousElementSibling;
            if (conf_res) {
                let blogId = e.target.parentNode.dataset.blog;
                // location.href = '?action=delete&blogId=' + blogId;
                fetch('?action=delete', {
                    method: 'POST',
                    body: new URLSearchParams({
                        blogId: blogId,
                        token: token,
                    }),
                })
                .then(res => res.json())
                .then(json => {
                    if (json['res'] === 'OK') {
                        document.getElementById('blog_' + blogId).remove();
                    } else {
                        err_del.textContent = json['res'];
                    }
                })
                .catch(err => {
                    alert(err.message);
                });
            }
        });
    });

}
