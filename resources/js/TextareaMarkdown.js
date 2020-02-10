import * as SimpleMDE from "SimpleMDE"

export default class TextareaMarkdown {
    constructor(element) {
      new SimpleMDE({
        element: element,
        status: false,
        spellChecker: false,
        toolbar: ["bold", "italic", "link", "|", "quote", "unordered-list", "|", "preview"]
      })
    }
}
