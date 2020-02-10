import TextareaAutoResize from "./TextareaAutoResize.js"
import TextareaMarkdown from "./TextareaMarkdown.js"

document.addEventListener('DOMContentLoaded', function() {
    const textareaElements = document.querySelectorAll('textarea')
    for (const textareaElement of textareaElements) {
        new TextareaAutoResize(textareaElement)
    }

    const simplemdeElements = document.querySelectorAll(".js-simplemde")
    for (const textareaElement of simplemdeElements) {
        new TextareaMarkdown(textareaElement)
    }
});

function copy() {
  var copyText = document.querySelector("#js-copy-target")
  copyText.select()
  document.execCommand("copy")
  document.querySelector("#js-copy-btn").classList.remove('secondary')
}

if (document.getElementById('#js-copy-btn')) {
  document.getElementById('#js-copy-btn').addEventListener("click", copy)
}
