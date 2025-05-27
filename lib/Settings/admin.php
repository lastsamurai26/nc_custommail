<?php

namespace OCA\NC_custom_emailtemplates\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\Settings\ISettings;

class Admin implements ISettings {

    public function getForm() {
        // settings.php wird als Template verwendet
        return new TemplateResponse('nc_custom_emailtemplates', 'settings', []);
    }

    public function getSection() {
        return 'server'; // Zeigt die App im Bereich Verwaltung/Server an
    }

    public function getPriority() {
        return 50;
    }
}
