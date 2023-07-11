<?php

use Bitrix\Main\Loader;
 
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
 
class ComplexComponent extends CBitrixComponent
{
    protected array $arComponentVariables = [
        "SECTION",
    ];
 

    protected function sefMode()
    {
        //Значение алиасов по умолчанию.
        $arDefaultVariableAliases404 = [];
 
        /**
         * Значение масок для шаблонов по умолчанию. - маски без корневого раздела,
         * который указывается в $arParams["SEF_FOLDER"]
         */
        $arDefaultUrlTemplates404 = [
            "list_manuf" => "/#SEF_FOLDER#/",
            "list_manuf" => "/#SEF_FOLDER#/#BRAND#/",
            "list_manuf" => "/#SEF_FOLDER#/#BRAND#/#MODEL#/",
            "viev" => "/#SEF_FOLDER#/detail/#NOTEBOOK#/",
        ];
 
        //В этот массив будут заполнены переменные, которые будут найдены по маске шаблонов url
        $arVariables = [];
 
        $engine = new CComponentEngine($this);
 
        //Объединение дефолтных параметров масок шаблонов и алиасов. Параметры из настроек заменяют дефолтные.
        $arUrlTemplates = CComponentEngine::makeComponentUrlTemplates($arDefaultUrlTemplates404, $this->arParams["SEF_URL_TEMPLATES"]);
        $arVariableAliases = CComponentEngine::makeComponentVariableAliases($arDefaultVariableAliases404, $this->arParams["VARIABLE_ALIASES"]);
 
        //Поиск шаблона
        $componentPage = $engine->guessComponentPath(
            $this->arParams["SEF_FOLDER"],
            $arUrlTemplates,
            $arVariables
        );
 
        //Проброс значений переменных из алиасов.
        CComponentEngine::initComponentVariables($componentPage, $this->arComponentVariables, $arVariableAliases, $arVariables);
        $this->arResult = [
            "VARIABLES" => $arVariables,
            "ALIASES" => $arVariableAliases
        ];
 
        return $componentPage;
    }
 
    protected function noSefMode()
    {

 
      
    }
    public function executeComponent()
    {
        Loader::includeModule('iblock');
 
        if ($this->arParams["SEF_MODE"] === "Y") {
            $componentPage = $this->sefMode();
        } else {
            $componentPage = $this->noSefMode();
        }
 
        //Отдать 404 статус если не найден шаблон
        if (!$componentPage) {

        }
 
        $this->IncludeComponentTemplate($componentPage);
    }
 
}