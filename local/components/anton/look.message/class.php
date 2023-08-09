<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
class LookMessage extends CBitrixComponent
{

    public function executeComponent()
    {
        try {
            $this->includeComponentTemplate();
            
        } catch (\Bitrix\Main\SystemException $e) {
            ShowError($e->getMessage());
        }
    }
}