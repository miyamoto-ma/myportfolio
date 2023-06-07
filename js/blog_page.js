'use strict';

{
    /**
     * 「編集」をクリックで、blogIdとuserIdをセットしてジャンプ
     */
    let edits = document.querySelectorAll('.edit');
    edits.forEach(edit => {
        edit.addEventListener('click', e => {
            let blogId = e.target.parentNode.dataset.blog;
            location.href = 'edit.php?action=edit&blogId=' + blogId;
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
