<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/identified-case' => [
            [['_route' => 'add_identified_case', '_controller' => 'App\\Controller\\IdentifiedCaseController::addIdentifiedCase'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'show_list_identified_case', '_controller' => 'App\\Controller\\IdentifiedCaseController::listIdentifiedCase'], null, ['GET' => 0], null, false, false, null],
        ],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api/enterprises/([^/]++)(*:67)'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        67 => [
            [['_route' => 'enterprise_edit', '_controller' => 'App\\Controller\\EnterpriseController::editEnterprise'], ['enterprise'], ['POST' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
