import TextareaAutoResize from "./TextareaAutoResize.js"

document.addEventListener('DOMContentLoaded', function() {
    const textareaElements = document.querySelectorAll('textarea')
    for (const textareaElement of textareaElements) {
        new TextareaAutoResize( textareaElement )
    }
});

function copy() {
  var copyText = document.querySelector("#js-copy-target");
  copyText.select();
  document.execCommand("copy");
  document.querySelector("#js-copy-btn").classList.remove('secondary');
}

document.querySelector("#js-copy-btn").addEventListener("click", copy);
