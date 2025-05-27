<?php

return [
    'routes' => [
        ['name' => 'admin#getTemplate', 'url' => '/admin/template', 'verb' => 'GET'],
        ['name' => 'admin#setTemplate', 'url' => '/admin/template', 'verb' => 'POST'],
        ['name' => 'admin#listBackups', 'url' => '/admin/backups', 'verb' => 'GET'],
        ['name' => 'admin#restoreBackup', 'url' => '/admin/restore', 'verb' => 'POST'],
    ]
];