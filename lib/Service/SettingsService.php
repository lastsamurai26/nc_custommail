<?php

namespace CustomMailText\Service;

use OCP\IConfig;

class SettingsService {
    private IConfig $config;
    private string $appId = 'custommailtext';

    public function __construct(IConfig $config) {
        $this->config = $config;
    }

    public function getWelcomeText(): string {
        return $this->config->getAppValue($this->appId, 'welcome_text', 'Willkommen bei Nextcloud!');
    }

    public function setWelcomeText(string $text): void {
        $this->config->setAppValue($this->appId, 'welcome_text', $text);
    }

    public function getResetText(): string {
        return $this->config->getAppValue($this->appId, 'reset_text', 'Hier kannst du dein Passwort zurücksetzen.');
    }

    public function setResetText(string $text): void {
        $this->config->setAppValue($this->appId, 'reset_text', $text);
    }
}
