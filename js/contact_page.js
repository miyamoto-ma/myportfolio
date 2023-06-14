'use strict';

{
    const contents = document.getElementById('contents');
    const char_contents = document.getElementById('char_contents');
    const clear = document.getElementById('clear');

    // target:対象input要素、char_span:文字数を出力する要素
    function charCount(target, char_span) {
        window.addEventListener('load', () => {
            char_span.textContent = target.value.length;
        });
        clear.addEventListener('click', () => {
            char_span.textContent = 0;
        });
        target.addEventListener('keyup', () => {
            char_span.textContent = target.value.length;
        });
    }

    charCount(contents, char_contents);
}
