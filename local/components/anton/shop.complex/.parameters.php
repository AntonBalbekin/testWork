<?

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (!CModule::IncludeModule('anton.resume')) {
    return;
}

$arComponentParameters = [
    "PARAMETERS" => [
        "VARIABLE_ALIASES" => [
            "SEF_FOLDER" => [
                "NAME" => 'Производитель',
            ],
            "BRAND" => [
                "NAME" => 'Бренд',
            ],
            "MODEL" => [
                "NAME" => 'Модель',
            ],
            "NOTEBOOK" => [
                "NAME" => 'Ноутбук',
            ],
        ],
        'SEF_MODE'=>[
            'list_manuf'=>[
                'NAME'=>'список производителей',
                'DEFAULT'=>'#SEF_FOLDER#/'
            ],
            'list_model'=>[
                'NAME'=>'список моделей производителей',
                'DEFAULT'=>'#SEF_FOLDER#/#BRAND#/'
            ],
            'list_notebook'=>[
                'NAME'=>' список ноутбуков модели',
                'DEFAULT'=>'#SEF_FOLDER#/#BRAND#/#MODEL#/'
            ],
            'viev'=>[
                'NAME'=>' детальная страница ноутбука',
                'DEFAULT'=>'#SEF_FOLDER#/detail/#NOTEBOOK#/'
            ],
        ]
    ]
];