<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$APPLICATION->IncludeComponent(
	"anton:shop.viev", 
	"", 
	array(
        'notebook'=>$arResult['VARIABLES']['NOTEBOOK']
	),
	false
);
