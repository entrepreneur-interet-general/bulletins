/**
 * Auto Resizing for Textarea Elements.
 *
 * This automatically resizes textarea elemens when the content gets
 * longer than the initial height of the element to ease writing for users.
 */
export default class TextareaAutoResize {
    constructor(element) {
        this.element = element
        this.element.addEventListener('input', this.textareaDidChange.bind( this ))

        this.textareaDidChange()
    }

    /**
     * Applies the scrollHeight to the element if content exceeds, otherwise 'auto'.
     */
    textareaDidChange() {
        this.element.style.height = 'auto'
        this.element.style.height = this.element.scrollHeight + 'px'
    }
}
