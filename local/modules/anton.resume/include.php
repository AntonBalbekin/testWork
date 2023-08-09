<?
$module_folder = \Bitrix\Main\Application::getDocumentRoot() . '/local/modules/anton.resume';
\Bitrix\Main\Loader::registerNamespace('Anton\Resume\Controller', $module_folder . '/Controller');