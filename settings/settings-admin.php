<?php

script('custommailtext', 'admin');

use OCP\IConfig;
use OCP\Util;
use CustomMailText\Service\SettingsService;

$config = \OC::$server->get(IConfig::class);
$settings = new SettingsService($config);

$welcomeText = $settings->getWelcomeText();
$resetText = $settings->getResetText();

?>

<div class="section">
    <h2>Benutzerdefinierte E-Mail-Texte</h2>
    <form id="custommailtext-form" method="post">
        <?php \OCP\Util::addCSRFToken(); ?>
        <label for="welcome_text">Text für neue Benutzer:</label><br/>
        <textarea name="welcome_text" rows="5" cols="60"><?php p($welcomeText); ?></textarea><br/><br/>

        <label for="reset_text">Text für Passwort-Zurücksetzen:</label><br/>
        <textarea name="reset_text" rows="5" cols="60"><?php p($resetText); ?></textarea><br/><br/>

        <button class="button primary" type="submit">Speichern</button>
    </form>
</div>
