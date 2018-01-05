<?php
use \kartik\datecontrol\Module;
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    // set target language to be Russian
    'language' => 'id-ID',

    // set source language to be English
    'sourceLanguage' => 'en-US',
    'modules' => [
        'wewenang' => [
            'class' => 'mdm\admin\Module',
            'mainLayout' => '@app/views/layouts/main.php',
            'layout' => null, // default to null. other avaliable value 'right-menu' and 'top-menu'
            
            'menus' => [
                'assignment' => [
                    'label' => 'Assignment' // change label
                ]
            ],
        ],
    	'security' => [
            'class' => 'app\modules\security\Security',
            'mainLayout' => '@app/views/layouts/main.php',
            'layout' => null,


        ],
    	'autentikasi' => [
            'class' => 'app\modules\security\Security',
            'layout' => null,
        ],
        'treemanager' =>  [
                'class' => '\kartik\tree\Module',
                // other module settings, refer detailed documentation
            ],
        'pidum' => [
            'class' => 'app\modules\pidum\Pidum',
        ],
        'pdsold' => [
            'class' => 'app\modules\pdsold\Pdsold',
        ],
		'pidsus' => [
            'class' => 'app\modules\pidsus\Pidsus',
        ],
		'datun' => [
            'class' => 'app\modules\datun\Datun',
        ],
        'pengawasan' => [
            'class' => 'app\modules\pengawasan\Pengawasan',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
        'user' => [
            'class' => 'dektrium\user\Module',
            'modelMap' => [
                'User' => 'app\models\User',
            ],
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin']
        ],
        'datecontrol' =>  [
            'class' => '\kartik\datecontrol\Module',
            // format settings for displaying each date attribute (ICU format example)
            'displaySettings' => [
                Module::FORMAT_DATE => 'php:d-m-Y',
                Module::FORMAT_TIME => 'HH:mm:ss a',
                Module::FORMAT_DATETIME => 'dd-MM-yyyy HH:mm:ss a',
            ],
            // format settings for saving each date attribute (PHP format example)
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:Y-m-d',
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
            'autoWidget' => true,
            'autoWidgetSettings' => [
                Module::FORMAT_DATE => ['type'=>1, 'pluginOptions'=>['autoclose'=>true, 'startDate' => '-2y','endDate' => '0']],
                Module::FORMAT_DATETIME => [], // setup if needed
                Module::FORMAT_TIME => [], // setup if needed
            ],

        ],
    ],
    
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JhmYwzxpcnrA8Ei35aFMeXqa6CLw9G40',
            // 'enableCsrfValidation' => false,
        ],
        'assetManager' => [
            'linkAssets' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        /*'user' => [
            'identityClass' => 'app\models\User',
        ],*/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            //'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                // [
                //     'class' => 'yii\log\FileTarget',
                //     'levels' => ['error', 'warning'],
                // ],
            //    'file' => [
            //     'class' => 'yii\log\FileTarget',
            //    // 'logFile' => '@runtime/logs/profile.log',
            //     //'logVars' => [],
            //     'levels' => ['profile'],
            //     'categories' => ['yii\db\Command::execute'],
            //     'prefix' => function($message) {
            //         return '';
            //     }
            // ]
                [
                 'class' => 'yii\log\DbTarget',
                    'levels' => ['info'],
                    'categories' => ['yii\db\Command::execute','yii\db\Command::query'],
                 ]
            
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'authManager' => [
            'class' => 'yii\rbac\DbManager'
        ],
        'autoincrement' => [
            'class' => 'app\components\AutoincrementComponent',
        ],
    	'globalfunc' => [
    		'class' => 'app\components\GlobalFuncComponent',
    	],
    	'inspektur' => [
    		'class' => 'app\components\InspekturComponent',
    	],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],

    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/logout',
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
