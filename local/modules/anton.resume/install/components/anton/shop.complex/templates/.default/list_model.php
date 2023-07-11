<?
$APPLICATION->IncludeComponent(
	"anton:shop.list", 
	"", 
	array(
        'folder'=>$arResult['VARIABLES']['SEF_FOLDER'],
        'brand'=>$arResult['VARIABLES']['BRAND'],
		'sef_folder'=>$arParams['SEF_FOLDER']

	),
	false
);