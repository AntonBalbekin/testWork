<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $USER;

    if($USER->IsAdmin() && $arResult['addManuf']){
        ?>
            <button id="addManuf" class="ui-btn ui-btn-success"><?=getMessage("ADD_MANUF")?></button>
        <?
    }
?>
<div class="">
    <div class="">
        <?
            if($arResult['backPage']){
                echo $arResult['backPage'];
            }
        ?>
    </div>
<?
    $APPLICATION->IncludeComponent(
        'bitrix:main.ui.grid',
        '.default',
        [
            'GRID_ID' => $arResult['gridId'],
            'COLUMNS' => $arResult['colums'],
            'ROWS'    => $arResult['rows'],
            'NAV_OBJECT' => $arResult['navi'],
            'AJAX_MODE' => 'Y',
            'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
            'PAGE_SIZES' => [
                ['NAME' => "1",  'VALUE' => '1'],
                ['NAME' => "3",  'VALUE' => '3'],
                ['NAME' => "5",  'VALUE' => '5'],
                ['NAME' => "20",  'VALUE' => '20'],
                ['NAME' => "100",  'VALUE' => '100'],
            ],
            'AJAX_OPTION_JUMP' => 'N',
            'SHOW_CHECK_ALL_CHECKBOXES' => false,
            'SHOW_ROW_CHECKBOXES' => false,
            'SHOW_ROW_ACTIONS_MENU' => true,
            'SHOW_GRID_SETTINGS_MENU' => false,
            'SHOW_NAVIGATION_PANEL' => true,
            'SHOW_PAGINATION' => true,
            'SHOW_SELECTED_COUNTER' => false,
            'SHOW_TOTAL_COUNTER' => true,
            'TOTAL_ROWS_COUNT' => $arResult['rows_count'],
            'SHOW_PAGESIZE' => true,
            'SHOW_ACTION_PANEL' => true,
            'ALLOW_COLUMNS_SORT' => true,
            'ALLOW_COLUMNS_RESIZE' => true,
            'ALLOW_HORIZONTAL_SCROLL' => true,
            'ALLOW_SORT' => true,
            'ALLOW_PIN_HEADER' => true,


            'AJAX_OPTION_HISTORY' => 'N',
        ]
    );
    ?>
</div>
<?
echo '<pre>';
print_r($arParams);