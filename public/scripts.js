function showImageToText() {
    hideAllForms();
    document.getElementById('imageToText').classList.remove('hidden');
}

function showTextToText() {
    hideAllForms();
    document.getElementById('textToText').classList.remove('hidden');
}

function showDocumentToText() {
    hideAllForms();
    document.getElementById('documentToText').classList.remove('hidden');
}

function showUrlToText() {
    hideAllForms();
    document.getElementById('urlToText').classList.remove('hidden');
}

function hideAllForms() {
    const forms = document.querySelectorAll('.form-container');
    forms.forEach(form => {
        form.classList.add('hidden');
    });
}
