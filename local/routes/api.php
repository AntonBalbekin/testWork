<?php
use Bitrix\Main\Routing\RoutingConfigurator;
use Bitrix\Main\HttpRequest;
use Anton\Resume\Controller\Users;
\Bitrix\Main\Loader::includeModule('anton.resume');
return function (RoutingConfigurator $routes) {
   /*$routes->get('/countries', function (HttpRequest $request) {
        return 'tyty';
    });*/
    //$routes->get('/countries', [Users::class,'get']);
    //$routes->post('/countries', Users::class);
    $routes->post('/countries', [Users::class,'get']);
};