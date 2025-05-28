<?php

namespace CustomMailText\Mail;

use OC\Mail\EMailTemplate;
use CustomMailText\Service\SettingsService;
use OCP\IConfig;

class CustomEMailTemplate extends EMailTemplate {
    private SettingsService $settings;

    public function __construct(string $lang = 'de') {
        parent::__construct($lang);

        // Manuelle Initialisierung, da kein DI hier
        $config = \OC::$server->get(IConfig::class);
        $this->settings = new SettingsService($config);
    }

    public function addBodyText(string $text, bool $wrap = true): void {
        if (strpos($text, 'password reset') !== false) {
            $text = $this->settings->getResetText();
        } elseif (strpos($text, 'welcome') !== false || strpos($text, 'invited') !== false) {
            $text = $this->settings->getWelcomeText();
        }

        parent::addBodyText($text, $wrap);
    }
}
