'use strict';

{
    // 「編集」をクリックで、blogIdとuserIdをセットしてジャンプ
    let edits = document.querySelectorAll('.edit');
    edits.forEach(edit => {
        edit.addEventListener('click', e => {
            let blogId = e.target.parentNode.dataset.blog;
            location.href = '?action=edit&blogId=' + blogId;
        });
    });

    // 「削除」をクリックで、blogIdとuserIdをセットしてジャンプ
    let deletes = document.querySelectorAll('.delete');
    deletes.forEach(del => {
        del.addEventListener('click', e => {
            let blogId = e.target.parentNode.dataset.blog;
            location.href = '?action=delete&blogId=' + blogId;
        })
    });
}
