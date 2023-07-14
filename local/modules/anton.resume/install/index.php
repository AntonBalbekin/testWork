<?
use Anton\Resume\{ManufacturerTable,ModelTable,NotebookTable,OptionsTable};
use \Bitrix\Main\{Application,ModuleManager,Loader};
use Bitrix\Main\Type\DateTime;
use \Bitrix\Main\ORM\Entity;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Option;
//Loc::loadMessages(__FILE__);
class anton_resume extends CModule
{

    public $exclusionAdminFiles;

    public function __construct()
    {
        
        include(__DIR__."/version.php");

        $this->exclusionAdminFiles=array(
            '..',
            '.',
            'menu.php',
            'operation_description.php',
            'task_description.php'
        );

        $this->MODULE_ID='anton.resume';
        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        $this->MODULE_NAME = Loc::getMessage("B_AN_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("B_AN_MODULE_DESC");
        $this->PARTNER_NAME = Loc::getMessage('B_AN_PARTNER_NAME');
    }

    public function GetPath($notDocumentRoot=false)
    {
        if($notDocumentRoot)
            return str_ireplace(Application::getDocumentRoot(),'',dirname(__DIR__));
        else
            return dirname(__DIR__);
    }

    public function isVersion()
    {
        return CheckVersion(ModuleManager::getVersion('main'),'14.00.00');
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }



    public function InstallDB()
    {
        
        if(Loader::includeModule($this->MODULE_ID)){
            if(!Application::getConnection(ManufacturerTable::getConnectionName())->isTableExists(
                Entity::getInstance('\Anton\Resume\ManufacturerTable')->getDBTableName()
                )
            )
            {
                Entity::getInstance('\Anton\Resume\ManufacturerTable')->createDbTable();
                for ($i=0; $i <30 ; $i++) { 
                    ManufacturerTable::add(['NAME'=>$this->generateRandomString(random_int(3,8))]);
                }
                
            }
    
            if(!Application::getConnection(ModelTable::getConnectionName())->isTableExists(
                Entity::getInstance('\Anton\Resume\ModelTable')->getDBTableName()
                )
            )
            {
                Entity::getInstance('\Anton\Resume\ModelTable')->createDbTable();
                for ($i=0; $i < 150; $i++) { 
                    ModelTable::add(['NAME'=>$this->generateRandomString(random_int(3,8)),'MANUFACTURER_ID'=>random_int(1,30)]);
                }
            }
    
            if(!Application::getConnection(NotebookTable::getConnectionName())->isTableExists(
                Entity::getInstance('\Anton\Resume\NotebookTable')->getDBTableName()
                )
            )
            {
                Entity::getInstance('\Anton\Resume\NotebookTable')->createDbTable();
                for ($i=0; $i < 450; $i++) { 
                    NotebookTable::add(['NAME'=>$this->generateRandomString(random_int(3,10)),
                                     'MODEL_ID'=>random_int(1,150),
                                     'DESCRIPTION'=>$this->generateRandomString(random_int(30,100)),
                                     'PRICE'=>random_int(3000,50000),
                                     'PHOTO'=>1,
                                     'OPTION_ID'=>random_int(1,10),
                                     'DateField'=>DateTime::createFromUserTime(random_int(1,30).'.'.random_int(1,12).'.'.random_int(2015,2023))  
                                    ]);
                }
            }
    
            if(!Application::getConnection(OptionsTable::getConnectionName())->isTableExists(
                Entity::getInstance('\Anton\Resume\OptionsTable')->getDBTableName()
                )
            )
            {
                Entity::getInstance('\Anton\Resume\OptionsTable')->createDbTable();
                for ($i=0; $i < 10; $i++) {
                    OptionsTable::add(['NAME'=>$this->generateRandomString(random_int(3,8))]);
                 }
                
            }
        }

 
        return true;
    }

    function InstallFiles($arParams = array())
	{
        $path=$this->GetPath()."/install/components";

        if(\Bitrix\Main\IO\Directory::isDirectoryExists($path))
            CopyDirFiles($path, $_SERVER["DOCUMENT_ROOT"]."/local/components", true, true);
        else
            throw new \Bitrix\Main\IO\InvalidPathException($path);

        if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/admin'))
        {
            CopyDirFiles($this->GetPath() . "/install/admin/", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin"); //если есть файлы для копирования
            if ($dir = opendir($path))
            {
                while (false !== $item = readdir($dir))
                {
                    if (in_array($item,$this->exclusionAdminFiles))
                        continue;
                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/bitrix/admin/'.$this->MODULE_ID.'_'.$item,
                        '<'.'? require($_SERVER["DOCUMENT_ROOT"]."'.$this->GetPath(true).'/admin/'.$item.'");?'.'>');
                }
                closedir($dir);
            }
        }

        return true;
	}


    public function DoInstall()
    {
        global $USER, $APPLICATION;

        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();

        if(!$request["step"]){
            $APPLICATION->IncludeAdminFile(Loc::getMessage('B_AN_INSTALL_TITLE'),  $_SERVER['DOCUMENT_ROOT']."/local/modules/anton.resume/install/step.php");
        }elseif($request["step"]==2){
            ModuleManager::registerModule($this->MODULE_ID);
            if($request['delltable']=="on"){
                
                $this->UnInstallDB();
                if($USER->IsAdmin()){
                    if($this->isVersion() ){
                        if($this->InstallDB()){
                           // $this->InstallEvents();
                            $this->InstallFiles();
                        }
                    }else{
                        $APPLICATION->ThrowException(Loc::getMessage('B_AN_INSTALL_BAD_VERSION'));
                    }
                }
            }else{
                if($USER->IsAdmin()){
                    if($this->isVersion() ){
                        if($this->InstallDB()){
                           // $this->InstallEvents();
                            $this->InstallFiles();
                        }
                       
                    }else{
                        $APPLICATION->ThrowException(Loc::getMessage('B_AN_INSTALL_BAD_VERSION'));
                    }
                }
            }
        }
        $APPLICATION->IncludeAdminFile(Loc::getMessage('B_AN_INSTALL_TITLE'),  $_SERVER['DOCUMENT_ROOT']."/local/modules/anton.resume/install/step2.php");
    }


    public function UnInstallDB(){
        Loader::includeModule($this->MODULE_ID);

        Application::getConnection(\Anton\Resume\ManufacturerTable::getConnectionName())->
            queryExecute('drop table if exists '.Entity::getInstance('\Anton\Resume\ManufacturerTable')->getDBTableName());

        Application::getConnection(\Anton\Resume\ModelTable::getConnectionName())->
            queryExecute('drop table if exists '.Entity::getInstance('\Anton\Resume\ModelTable')->getDBTableName());

        Application::getConnection(\Anton\Resume\NotebookTable::getConnectionName())->
            queryExecute('drop table if exists '.Entity::getInstance('\Anton\Resume\NotebookTable')->getDBTableName());

        Application::getConnection(\Anton\Resume\OptionsTable::getConnectionName())->
            queryExecute('drop table if exists '.Entity::getInstance('\Anton\Resume\OptionsTable')->getDBTableName());

        Option::delete($this->MODULE_ID);
    }

    public function DoUninstall()
    {
        global $APPLICATION;
        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();
        if($request["stepUn"]<2){
            $APPLICATION->IncludeAdminFile(Loc::getMessage("B_AN_UNINSTALL_TITLE"),$_SERVER['DOCUMENT_ROOT']."/local/modules/anton.resume/install/unstep1.php");
        }elseif($request["stepUn"]==2){
            if($request['savedata']!="on"){
                $this->UnInstallDB();
            }
            ModuleManager::unRegisterModule($this->MODULE_ID);
            $APPLICATION->IncludeAdminFile(Loc::getMessage("B_AN_UNINSTALL_TITLE"),$_SERVER['DOCUMENT_ROOT']."/local/modules/anton.resume/install/unstep2.php");
        }
    }

}