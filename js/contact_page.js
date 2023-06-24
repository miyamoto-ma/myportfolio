'use strict';

{
    const contents = document.getElementById('contents');
    const char_contents = document.getElementById('char_contents');
    const clear = document.getElementById('clear');
    const input_c_arr = document.querySelectorAll('.input_c');

    // target:対象input要素、char_span:文字数を出力する要素
    function charCount(target, char_span) {
        window.addEventListener('load', () => {
            char_span.textContent = target.value.length;
        });
        clear.addEventListener('click', () => {
            char_span.textContent = 0;
            contents.textContent = '';
            input_c_arr.forEach(input => {
                input.defaultValue = '';
            });
        });
        target.addEventListener('keyup', () => {
            char_span.textContent = target.value.length;
        });
    }

    charCount(contents, char_contents);


    /**
     * 「クリア」ボタンをクリックでvalueをクリアする
     */
    // clear.addEventListener('click', () => {
    //     input_title.defaultValue = '';
    //     input_text.defaultValue = '';
    //     input_skill.defaultValue = '';
    //     input_link1.defaultValue = '';
    //     input_link_text1.defaultValue = '';
    //     input_link2.defaultValue = '';
    //     input_link_text2.defaultValue = '';
    //     input_file.value = '';
    //     preview.src = '';
    // });
}
