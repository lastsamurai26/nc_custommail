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
        $('#reset-template').click(function() {
            // Aktuelle Auswahl holen
            const type = $('#template-type').val();
            const lang = $('#template-lang').val();
            OC.msg.confirm('Bestätigen', 'Wirklich auf Standard zurücksetzen?', function(ok) {
                if (!ok) return;
                $.post(OC.generateUrl('/apps/nc_custom_emailtemplates/admin/reset'), {type:type, lang:lang}, function(result) {
                    if (result.template) {
                        window.templateEditor.setData(result.template);
                        OC.msg.finishedSuccess('#emailtemplate-settings', 'Standardvorlage geladen!');
                    }
                });
            });
        });
    }
};
$(document).ready(OCA.NC_custom_emailtemplates.init);