<?
$APPLICATION->IncludeComponent(
	"anton:shop.list", 
	"", 
	array(
        'folder'=>$arResult['VARIABLES']['SEF_FOLDER'],
		'sef_folder'=>$arParams['SEF_FOLDER']
	),
	false
);