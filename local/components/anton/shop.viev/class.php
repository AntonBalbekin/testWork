<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Loader;
use Anton\Resume\{ModelTable,NotebookTable};


\Bitrix\Main\UI\Extension::load("ui.bootstrap4");


if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

Loader::includeModule('anton.resume');

class Listcomponent extends CBitrixComponent
{


    public function getNootebokInfo():array{
        $query=NotebookTable::query()
              ->setSelect(['DateField','MODELNAME'=>'MODEL.NAME','MODELID'=>'MODEL.ID',
              'OPTIONNAME'=>'OPTION.NAME','MANUFAC'=>'MODELTABLE.MANUFACTURER.NAME','DESCRIPTION','PRICE'])
              ->setFilter(['NAME'=>$this->arParams['notebook']])
              ->registerRuntimeField(
                'MODELTABLE',
                    [
                        'data_type'=>ModelTable::class,
                        'reference'=>['this.MODELID'=>'ref.ID']
                    ]
                );
        $dbResult=$query->exec(); 
        while($rsResult=$dbResult->fetch()){
            $arResult[]=$rsResult;
        }
        return $arResult;       
    }

    public function executeComponent()
    {
        try {
            $this->arResult['bookInfo']=$this->getNootebokInfo();
            $this->includeComponentTemplate();
            
        } catch (\Bitrix\Main\SystemException $e) {
            ShowError($e->getMessage());
        }
    }
}

