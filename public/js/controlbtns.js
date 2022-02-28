function insert_Link(elementId) {
    this.insertTextAtCursor(document.getElementById(elementId), '<a href=\"адрес сылки\">текст ссылки<\/a>')
}

function insert_Strong(elementId) {
    this.insertTextAtCursor(document.getElementById(elementId), '<strong>текст жирным<\/strong>')
}

function insert_Img(elementId) {
    this.insertTextAtCursor(document.getElementById(elementId), '<img src=\"путь к картинке или ссылка\" width=\"ширина\" height=\"высота\" alt=\"описание картинки\" title=\"описание картинки\">')
}

function insert_Br(elementId) {
    this.insertTextAtCursor(document.getElementById(elementId), '<br>')
}

function insert_Hr(elementId) {
    this.insertTextAtCursor(document.getElementById(elementId), '<hr>')
}

function insert_4p(elementId) {
    this.insertTextAtCursor(document.getElementById(elementId), '&nbsp;&nbsp;&nbsp;&nbsp;')
}

function insert_h3(elementId) {
    this.insertTextAtCursor(document.getElementById(elementId), '<h3>заголовок<\/h3>')
}

function insertTextAtCursor(el, text, offset) {
    var val = el.value, endIndex, range, doc = el.ownerDocument;
    if (typeof el.selectionStart == "number"
            && typeof el.selectionEnd == "number") {
        endIndex = el.selectionEnd;
        el.value = val.slice(0, endIndex) + text + val.slice(endIndex);
        el.selectionStart = el.selectionEnd = endIndex + text.length + (offset ? offset : 0);
    } else if (doc.selection != "undefined" && doc.selection.createRange) {
        el.focus();
        range = doc.selection.createRange();
        range.collapse(false);
        range.text = text;
        range.select();
    }
}