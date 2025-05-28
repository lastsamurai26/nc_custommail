<?php
use OCP\IConfig;
use OCP\Util;

$config = \OC::$server->get(IConfig::class);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && \OC::$server->get(\OCP\Security\ICSRFTokenManager::class)->isTokenValid($_POST['csrf_token'])) {
    $welcomeText = $_POST['welcome_text'] ?? '';
    $resetText = $_POST['reset_text'] ?? '';

    $config->setAppValue('nc_custommail', 'welcome_text', $welcomeText);
    $config->setAppValue('nc_custommail', 'reset_text', $resetText);

    Util::addSuccess('Einstellungen gespeichert');
}

$welcomeText = $config->getAppValue('nc_custommail', 'welcome_text', 'Standard Willkommensnachricht');
$resetText = $config->getAppValue('nc_custommail', 'reset_text', 'Standard Passwort zurücksetzen Nachricht');
?>
