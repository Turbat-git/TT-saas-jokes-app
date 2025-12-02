import './bootstrap';

import {ClassicEditor, Essentials, Bold, Italic, Font, Paragraph} from 'ckeditor5';

import 'ckeditor5/ckeditor5.css';

document.addEventListener('DOMContentLoaded', function () {

    var targets = ['#Description', "#Content"]

    for (var target in targets) {
        var targetElement = document.querySelector(targets[target])
        if (targetElement !== null) {
            ClassicEditor
                .create(targetElement, {
                    licenseKey: 'GPL', // Or '<YOUR_LICENSE_KEY>'.
                    plugins: [Essentials, Bold, Italic, Font, Paragraph],
                    toolbar: [
                        'undo', 'redo', '|', 'bold', 'italic', '|',
                        'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor'
                    ]
                })
                .then(editor => {
                    window.editor = editor;
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
});
