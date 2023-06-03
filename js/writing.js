'use strict';
{

    /**
     * ファイル選択時に、ファイルのサイズと拡張子をチェックする処理
     */
    const img_max_size = 1024 * 1024 * 1;   // 画像の最大サイズ
    const allow_exts = new Array('jpg', 'jpeg', 'gif');
    const input_file = document.getElementById('file');

    // ファイルをチェックする関数
    const handleFileSelect = () => {
        const files = input_file.files;
        for (let i = 0; i < files.length; i++) {
            let filename = files[i].name;
            let ext = getExt(filename);
            if (files[i].size > img_max_size && allow_exts.indexOf(ext) === -1) {
                alert(files[i].name + 'はアップロードできません。\n (拡張子は[.jpg, .jpeg, .gif]のいずれか)\n (ファイルサイズは1MB以内)');
                input_file.value = '';
                return false;
            } else if (files[i].size > img_max_size) {
                alert('ファイルサイズが1MBを超えています。');
                input_file.value = '';
                return false;
            } else if (allow_exts.indexOf(ext) === -1) {
                alert('画像ファイル(.jpg, .jpeg, .gif)を選択してください。');
                input_file.value = '';
                return false;
            }
            return true;
        }
    }

    // ファイル名から拡張子を取得する関数
    function getExt(filename) {
        let pos = filename.lastIndexOf('.');
        if (pos === -1) return '';
        return filename.slice(pos + 1);
    }

    // ファイル選択時に上記のhandleFileSelectを発火
    input_file.addEventListener('change', handleFileSelect);


    /**
     * ファイルを選択時にプレビューを表示する処理
    */
    let reader = new FileReader();
    const preview = document.getElementById('new_img');
    reader.addEventListener('load', function () {
        preview.src = reader.result;
    }, false);
    input_file.addEventListener('change', function (e) {
        let input = input_file.files[0];
        reader.readAsDataURL(input);
    }, false);

    /**
     * 「クリア」ボタンをクリックで選択画像もクリアする
     */
    const clear = document.getElementById('clear');
    clear.addEventListener('click', () => {
        input_file.value = '';
        preview.src = '';
    });


    /**
     * 必須文字列の現在の文字数を表示する処理
     */
    const input_title = document.getElementById('title');
    const char_title = document.getElementById('char_title');
    const input_text = document.getElementById('text');
    const char_text = document.getElementById('char_text');

    // target:対象input要素、char_span:文字数を出力する要素
    function charCount(target, char_span) {
        target.addEventListener('keyup', () => {
            char_span.textContent = target.value.length;
        });
    }
    charCount(input_title, char_title);
    charCount(input_text, char_text);

}
