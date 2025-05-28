<?php

use OCP\IRequest;
use OCP\IConfig;
use CustomMailText\Service\SettingsService;

$request = \OC::$server->get(IRequest::class);
$config = \OC::$server->get(IConfig::class);
$settings = new SettingsService($config);

if ($request->getMethod() === 'POST' && \OC::$server->get(\OCP\Security\ICSRFTokenManager::class)->isTokenValid($request->getParam('requesttoken'))) {
    $welcomeText = $request->getParam('welcome_text');
    $resetText = $request->getParam('reset_text');

    if ($welcomeText !== null) {
        $settings->setWelcomeText($welcomeText);
    }
    if ($resetText !== null) {
        $settings->setResetText($resetText);
    }

    \OCP\Util::addStyle('custommailtext', 'admin');
    \OC::$server->get(\OCP\IUserSession::class)->createSessionToken(); // Optional: Refresh session
}
