<?php
script('nc_custom_emailtemplates', 'admin/settings');
style('nc_custom_emailtemplates', 'admin/settings');
?>
<div id="emailtemplate-settings">
    <h2><?php p($l->t('E-Mail Templates bearbeiten')); ?></h2>
    <div>
        <label for="template-type"><?php p($l->t('Template-Typ')); ?>:</label>
        <select id="template-type">
            <option value="welcome"><?php p($l->t('Willkommensnachricht')); ?></option>
            <option value="reset"><?php p($l->t('Passwort-Reset')); ?></option>
        </select>
        <label for="template-lang"><?php p($l->t('Sprache')); ?>:</label>
        <select id="template-lang">
            <option value="de">Deutsch</option>
            <option value="en">English</option>
        </select>
    </div>
    <textarea id="template-editor"></textarea>
    <button id="save-template"><?php p($l->t('Speichern')); ?></button>
    <button id="preview-template"><?php p($l->t('Vorschau')); ?></button>
    <button id="backup-list"><?php p($l->t('Backups anzeigen')); ?></button>
    <div id="template-preview"></div>
    <div id="backups-modal" class="hidden"></div>
    <p>
        <?php p($l->t('Verfügbare Platzhalter:')); ?>
        <code>{user}</code>, <code>{server}</code>
    </p>
</div>