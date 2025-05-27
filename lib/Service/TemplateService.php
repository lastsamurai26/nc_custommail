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
        if ($template === '') {
            // Standardtemplate laden, falls noch keines gesetzt wurde
            $filename = \OC_App::getAppPath('nc_custom_emailtemplates') . "/defaults/{$type}_{$lang}.html";
            if (file_exists($filename)) {
                $template = file_get_contents($filename);
            } else {
                // Fallback: englisches Standardtemplate, falls Sprache nicht existiert
                $filename = \OC_App::getAppPath('nc_custom_emailtemplates') . "/defaults/{$type}_en.html";
                if (file_exists($filename)) {
                    $template = file_get_contents($filename);
                } else {
                    $template = '';
                }
            }
        }
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
        $files = $this->backupDir->getDirectoryListing();
        $result = [];
        foreach ($files as $file) {
            if (fnmatch($pattern, $file->getName())) {
                $result[] = $file->getName();
            }
        }
        return $result;
    }

    public function restoreBackup($type, $lang, $filename) {
        $file = $this->backupDir->get($filename);
        $content = $file->getContent();
        $this->setTemplate($type, $lang, $content);
    }
    public function resetToDefault($type, $lang = 'en') {
        $defaultsPath = \OC_App::getAppPath('nc_custom_emailtemplates') . "/defaults/{$type}_{$lang}.html";
        if (!file_exists($defaultsPath)) {
            // Fallback: En, wenn z.B. de fehlt
            $defaultsPath = \OC_App::getAppPath('nc_custom_emailtemplates') . "/defaults/{$type}_en.html";
        }
        $defaultContent = file_get_contents($defaultsPath);
        $this->setTemplate($type, $lang, $defaultContent);
        return $defaultContent;
    }
}