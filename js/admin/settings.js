OCA.NC_custom_emailtemplates = {
    init: function() {
        // CKEditor initialisieren
        ClassicEditor.create(document.querySelector('#template-editor')).then(editor => {
            window.templateEditor = editor;
        });

        $('#save-template').click(function() {
            // AJAX: Template speichern
        });
        $('#preview-template').click(function() {
            // Vorschau anzeigen
            const html = window.templateEditor.getData();
            $('#template-preview').html(html.replace('{user}', 'Max Mustermann').replace('{server}', 'cloud.example.com'));
        });
        $('#backup-list').click(function() {
            // AJAX: Backups laden und anzeigen
        });
    }
};
$(document).ready(OCA.NC_custom_emailtemplates.init);