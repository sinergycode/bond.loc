<?php
use kartik\datecontrol\Module;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'gii', 'debug'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'generators' => [ //here
                'crud' => [ // generator name
                    'class' => 'yii\gii\generators\crud\Generator', // generator class
                    'templates' => [ //setting for out templates
                        'myGii' => '@common/generators/crud/default', // template name => path to template
                    ]
                ]
            ],
        ],
        'debug' => 'yii\debug\Module',
        'blog' => [
            'class' => 'sinergycode\blog\Blog',
        ],
            'datecontrol' => [
                'class' => 'kartik\datecontrol\Module',

                 // format settings for displaying each date attribute (ICU format example)
                'displaySettings' => [
                    Module::FORMAT_DATE => 'php:d-M-Y',
                    Module::FORMAT_TIME => 'php: H:i',
                    Module::FORMAT_DATETIME => 'php:d-m-Y H:i', 
                ],

                // format settings for saving each date attribute (PHP format example)
                'saveSettings' => [
//                    Module::FORMAT_DATE => 'yyyy-M-dd', // saves as unix timestamp
                    Module::FORMAT_DATE => 'php: U', // saves as unix timestamp
                    Module::FORMAT_TIME => 'H:i:s',
                    Module::FORMAT_DATETIME => 'yyyy-M-dd H:i:s',
                ],

                // set your display timezone
                'displayTimezone' => 'UTC',

                // set your timezone for date saved to db
                'saveTimezone' => 'UTC',

                // automatically use kartik\widgets for each of the above formats
                'autoWidget' => true,
            ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
            'timeFormat' => 'php: H:i',
            'dateFormat' => 'php: d/M/Y',
            'datetimeFormat' => 'php: d/M/Y H:i',
        ],   
    ],
    'params' => $params,
];
