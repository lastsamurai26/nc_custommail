<?php

namespace OCA\NC_custom_emailtemplates\Service;

use OCP\IConfig;
use OCP\IL10N;
use OCP\ILogger;
use OCP\Files\IRootFolder;

class TemplateService {
    private $config;
    private $logger;
    private $l10n;
    private $backupDir;

    public function __construct(IConfig $config, ILogger $logger, IL10N $l10n, IRootFolder $rootFolder) {
        $this->config = $config;
        $this->logger = $logger;
        $this->l10n = $l10n;
        $this->backupDir = $rootFolder->getUserFolder('admin')->newFolder('emailtemplate_backups');
    }

    public function getTemplate($type, $lang = 'en') {
        $key = "custom_emailtemplate_{$type}_{$lang}";
        $template = $this->config->getAppValue('nc_custom_emailtemplates', $key, '');
        return $template;
    }

    public function setTemplate($type, $lang, $content) {
        $key = "custom_emailtemplate_{$type}_{$lang}";
        $this->backupTemplate($type, $lang);
        $this->config->setAppValue('nc_custom_emailtemplates', $key, $content);
    }

    private function backupTemplate($type, $lang) {
        $current = $this->getTemplate($type, $lang);
        if ($current) {
            $file = sprintf('%s_%s_%s.bak.html', $type, $lang, date('Ymd_His'));
            $this->backupDir->newFile($file)->putContent($current);
        }
    }

    public function listBackups($type, $lang) {
        $pattern = sprintf('%s_%s_*.bak.html', $type, $lang);
        return $this->backupDir->search($pattern);
    }

    public function restoreBackup($file) {
        $content = $file->getContent();
        $parts = explode('_', $file->getName());
        $type = $parts[0];
        $lang = $parts[1];
        $this->setTemplate($type, $lang, $content);
    }
}