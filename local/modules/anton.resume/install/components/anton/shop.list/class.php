<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\Loader;
use Anton\Resume\{ManufacturerTable,ModelTable,NotebookTable};
use Bitrix\Main\Engine\Contract\Controllerable;


\Bitrix\Main\UI\Extension::load('ui.buttons'); 
\CJSCore::Init(['jquery','popup']);


if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}
Loader::includeModule('anton.resume');
class Listcomponent extends CBitrixComponent implements Controllerable
{

    public $gridColums;
    public $gridId;
    public $backPage;
    public $navParams;
    public $count;
    public $navi;
    public $gridOption;
    public $addManuf;
    
    public function configureActions()
    {
        return [
            'addManufactere' => [ // Проверяем код
                'prefilters' => [],
            ]
        ];
    }

    public function addManufactereAction(array $data){
        if($data[0]){
           $result=ManufacturerTable::add(['NAME'=>$data[0]]);
        }else{
            return ['error'=>'Не заполнены поля'];
        }
        if($result->isSuccess()){
            return $result->getId();
        }else{
            return ['error'=>'Непредвиденная ошибка'];
        }
        
    }


    public static function setColumnsManuf()
    {
        $columns = [
            ['id' => 'NAME',    'name' => 'Производитель',  'sort' => 'NAME',   'default' => true],
            ['id' => 'cnt',     'name' => 'Кол-во моделей',   'sort' => 'cnt',   'default' => true],
         ];
        return $columns;
    }

    public static function setColumnsBrand()
    {
        $columns = [
            ['id' => 'NAME',       'name' => 'Бренд',          'sort' => 'NAME',         'default' => true],
            ['id' => 'NAME_MANUF', 'name' => 'Производитель',  'sort' => 'MANUFACTURE_NAME',   'default' => true],
         ];
        return $columns;
    }

    public static function setColumnsNoteBook()
    {
        $columns = [
            ['id' => 'NAME',       'name' => 'Модель',            'sort' => 'NAME',     'default' => true],
            ['id' => 'BRAND',      'name' => 'Бренд',             'sort' => 'MODEL_NAME',         'default' => true],
            ['id' => 'NAME_MANUF', 'name' => 'Производитель',     'sort' => 'MANUFAC',   'default' => true],
            ['id' => 'DATE',       'name' => 'Дата поступления ', 'sort' => 'DateField',         'default' => true],
            ['id' => 'OPTIONS',    'name' => 'Опции',             'sort' => 'OPTION_NAME',   'default' => true],
            ['id' => 'PRICE',      'name' => 'Цена',              'sort' => 'PRICE',   'default' => true],
         ];
        return $columns;
    }

    public function getArSort(){
        $sort = $this->gridOption->GetSorting([]);
        if($sort){
            foreach ($sort['sort'] as $key => $value) {
                $arSort[$key]=$value;
            }
        }
        return $arSort;
    }

    public function getManuf(){
        $arSort=$this->getArSort();
        $query=ManufacturerTable::query();
        $query->setSelect(['NAME','cnt'])
        ->registerRuntimeField(
            'MODELTABLE',
                [
                    'data_type'=>ModelTable::class,
                    'reference'=>['this.ID'=>'ref.MANUFACTURER_ID']
                ]
            )
        ->registerRuntimeField("cnt", array(
                "data_type" => "integer",
                "expression" => array("count(%s)", "MODELTABLE.MANUFACTURER_ID")
                )
            ) 
        ->setOffset($this->navParams->getOffset())
        ->setLimit($this->navParams->getLimit())
        ->setGroup('ID')
        ->setCacheTtl(3600)
        ->cacheJoins(true)
        ->countTotal(true);
        if($arSort){
            $query ->setOrder($arSort);
        }
        $dbResult=$query->exec(); 
        $this->navParams->setRecordCount($dbResult->getCount());
        $this->count=$dbResult->getCount();
        while($rsResult=$dbResult->fetch()){
            $arResult[]=$rsResult;
        }  
        return $arResult;  
    }

    public function getBrand(){
        $arSort=$this->getArSort();
        $query=ModelTable::query();
        $query->setSelect(['NAME','MANUFACTURE_NAME'=>'MANUFACTURER.NAME'])
              ->setFilter(['MANUFACTURE_NAME'=>$this->arParams['brand']])
              ->setOffset($this->navParams->getOffset())
              ->setLimit($this->navParams->getLimit())
              ->setCacheTtl(3600)
              ->cacheJoins(true)
              ->countTotal(true);
        if($arSort){
            $query ->setOrder($arSort);
        }
        $dbResult=$query->exec(); 
        $this->navParams->setRecordCount($dbResult->getCount());
        $this->count=$dbResult->getCount();
        while($rsResult=$dbResult->fetch()){
            $arResult[]=$rsResult;
        }  
        return $arResult;  
    }

    public function getNoteBook(){
        $arSort=$this->getArSort();
        $query=NotebookTable::query();
        $query  ->setSelect(['NAME','DateField','MODEL_NAME'=>'MODEL.NAME','MODELID'=>'MODEL.ID',
                                               'OPTION_NAME'=>'OPTION.NAME','MANUFAC'=>'MODELTABLE.MANUFACTURER.NAME','PRICE'])
                ->registerRuntimeField(
                    'MODELTABLE',
                        [
                            'data_type'=>ModelTable::class,
                            'reference'=>['this.MODELID'=>'ref.ID']
                        ]
                    )
                ->setFilter(['MODEL_NAME'=>$this->arParams['noteBook']])
                ->setOffset($this->navParams->getOffset())
                ->setLimit($this->navParams->getLimit())
                ->setCacheTtl(3600)
                ->cacheJoins(true)
                ->countTotal(true);
        if($arSort){
            $query ->setOrder($arSort);
        }
        $dbResult=$query->exec(); 
        $this->navParams->setRecordCount($dbResult->getCount());
        $this->count=$dbResult->getCount();
        while($rsResult=$dbResult->fetch()){
            $arResult[]=$rsResult;
        }
        return $arResult;  
    }

    public function setGridNav(){
        $this->gridOption=$gridOptions = new GridOptions($this->gridId);
        $nav_params = $gridOptions->GetNavParams();
        
        $nav = new PageNavigation($this->gridId);
        $nav->allowAllRecords(true)
            ->setPageSize($nav_params['nPageSize'])
            ->initFromUri();
        $this->navParams=$nav;
    }

    public function setGridManufSettings(){
        $this->gridColums=self::setColumnsManuf();
        $this->gridId='manuf_grid';
        $this->addManuf=true;
        $this->setGridNav();
    }

    public function setGridBrandSettings(){
        $this->gridColums=self::setColumnsBrand();
        $this->gridId='brand_grid';
        if($this->arParams['sef_folder']){
            $this->backPage='<a href='.$this->arParams['sef_folder'].$this->arParams['folder'].'/>К списку производителей</a>';
        }else{
            $this->backPage='<a href=/'.$this->arParams['folder'].'/>К списку производителей</a>';
        }
        $this->setGridNav();
    }

    public function setGridNoteBookSettings(){
        $this->gridColums=self::setColumnsNoteBook();
        $this->gridId='NoteBook_grid';
        $this->setGridNav();
    }

    public function getRows(){
       if($this->arParams['folder'] && !$this->arParams['brand']){
            $this->setGridManufSettings();
            $arRows=$this->getManuf();
            foreach ($arRows as $value) {
                $rows[]=[
                    'data'=>
                    [
                        'NAME'=> '<a href="'.$value['NAME'].'/">'.$value['NAME'].'</a>',
                        'cnt'=>$value['cnt']
                    ]
                ];
            }
       }elseif($this->arParams['folder'] && $this->arParams['brand'] && !$this->arParams['noteBook']){
            $this->setGridBrandSettings();
            $arRows=$this->getBrand();
            foreach ($arRows as $value) {
                $rows[]=[
                    'data'=>
                    [
                        'NAME'=> '<a href="'.$value['NAME'].'/">'.$value['NAME'].'</a>',
                        'NAME_MANUF'=> '<span style="color:green">'.$value['MANUFACTURE_NAME'].'</span>',
                    ]
                ];
            }
        }elseif($this->arParams['folder'] && $this->arParams['brand'] && $this->arParams['noteBook']){
            $this->setGridNoteBookSettings();
            $arRows=$this->getNoteBook();
            foreach ($arRows as $value) {
                if($this->arParams['sef_folder']){
                    $detalHref='<a href="'.$this->arParams['sef_folder'].$this->arParams['folder'].'/detail/'.$value['NAME'].'/">'.$value['NAME'].'</a>';
                }else{
                    $detalHref='<a href="/'.$this->arParams['folder'].'/detail/'.$value['NAME'].'/">'.$value['NAME'].'</a>';
                }
                $rows[]=[
                    'data'=>
                    [
                        'NAME'       => $detalHref,//'<a href="/'.$this->arParams['folder'].'/detail/'.$value['NAME'].'/">'.$value['NAME'].'</a>',
                        'BRAND'      => $value['MODEL_NAME'],
                        'NAME_MANUF' => $value['MANUFAC'],
                        'DATE'       => $value['DateField']?$value['DateField']->format('d.m.Y'):'',
                        'OPTIONS'    => $value['OPTION_NAME'],
                        'PRICE'      =>$value['PRICE'],
                    ]
                ];
            }
        }
       return $rows;
    }


    public function executeComponent()
    {
        try {
            
            $this->arResult['rows']=$this->getRows();
            $this->arResult['gridId']=$this->gridId;
            $this->arResult['colums']=$this->gridColums;
            $this->arResult['rows_count']=$this->count;
            $this->arResult['navi'] = $this->navParams;
            $this->arResult['backPage']=$this->backPage;
            $this->arResult['addManuf']=$this->addManuf;
            $this->includeComponentTemplate();
            
        } catch (\Bitrix\Main\SystemException $e) {
            ShowError($e->getMessage());
        }
    }
 
}