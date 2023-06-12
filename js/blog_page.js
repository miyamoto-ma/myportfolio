'use strict';

{
    let path_name = (new URL(window.location.href).pathname);
    let sepa1 = path_name.lastIndexOf('/');
    let file = path_name.substring(sepa1 + 1);
    let sepa2 = file.lastIndexOf('.');
    const base = file.substring(0, sepa2);
    let itemId;

    /**
     * 「編集」をクリックで、blogIdとuserIdをセットしてジャンプ
     */
    let edits = document.querySelectorAll('.edit');
    edits.forEach(edit => {
        edit.addEventListener('click', e => {
            itemId = e.target.parentNode.dataset.item_id;
            let current_page = e.target.parentNode.dataset.page;
            location.href = 'edit.php?base='+ base +'&action=edit&itemId=' + itemId + '&page=' + current_page + '&d_flag=true';
        });
    });

    /**
     * 「削除」をクリックで、itemIdとtokenをセットしてAjax
     */
    let deletes = document.querySelectorAll('.delete');
    const token = document.querySelector('main').dataset.token;
    deletes.forEach(del => {
        del.addEventListener('click', e => {
            let conf_res = confirm('削除してよろしいですか？');
            let err_del = e.target.previousElementSibling.previousElementSibling;
            if (conf_res) {
                itemId = e.target.parentNode.dataset.item_id;
                // location.href = '?action=delete&itemId=' + itemId;
                fetch('?action=delete', {
                    method: 'POST',
                    body: new URLSearchParams({
                        itemId: itemId,
                        token: token,
                    }),
                })
                .then(res => res.json())
                .then(json => {
                    if (json['res'] === 'OK') {
                        document.getElementById('item_' + itemId).remove();
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
