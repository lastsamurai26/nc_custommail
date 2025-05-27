<?php

namespace OCA\NC_custom_emailtemplates\Controller;

use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;
use OCP\IRequest;
use OCP\IConfig;
use OCP\IL10N;
use OCP\ILogger;
use OCP\Files\IRootFolder;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http;

use OCA\NC_custom_emailtemplates\Service\TemplateService;

class AdminController extends Controller
{
    private $templateService;
    private $userId;

    public function __construct(
        $AppName,
        IRequest $request,
        TemplateService $templateService,
        $userId
    ) {
        parent::__construct($AppName, $request);
        $this->templateService = $templateService;
        $this->userId = $userId;
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function getTemplate($type, $lang)
    {
        if (!$this->isAdmin()) {
            return new JSONResponse(['error' => 'Forbidden'], Http::STATUS_FORBIDDEN);
        }
        $tpl = $this->templateService->getTemplate($type, $lang);
        return new JSONResponse(['template' => $tpl]);
    }

    /**
     * @NoAdminRequired
     */
    public function setTemplate($type, $lang)
    {
        if (!$this->isAdmin()) {
            return new JSONResponse(['error' => 'Forbidden'], Http::STATUS_FORBIDDEN);
        }
        $content = $this->request->getParam('content');
        $this->templateService->setTemplate($type, $lang, $content);
        return new JSONResponse(['status' => 'ok']);
    }

    /**
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function listBackups($type, $lang)
    {
        if (!$this->isAdmin()) {
            return new JSONResponse(['error' => 'Forbidden'], Http::STATUS_FORBIDDEN);
        }
        $backups = $this->templateService->listBackups($type, $lang);
        return new JSONResponse(['backups' => $backups]);
    }

    /**
     * @NoAdminRequired
     */
    public function restoreBackup($type, $lang, $filename)
    {
        if (!$this->isAdmin()) {
            return new JSONResponse(['error' => 'Forbidden'], Http::STATUS_FORBIDDEN);
        }
        $this->templateService->restoreBackup($type, $lang, $filename);
        return new JSONResponse(['status' => 'ok']);
    }

    private function isAdmin() {
        $user = \OC::$server->getUserSession()->getUser();
        return $user && $user->isAdmin();
    }
}