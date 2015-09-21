<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
	//'sourceLanguage'=>'ru',
	'language'=>'ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'urlManager'=>[
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules'=>[
				''=>'site/index',
                                'login'=>'login/index',
                                'iam'=>'iam/index',
                                'text/<translit:\w+>'=>'text/index',
                                'catalog'=>'catalog/all',
                                'catalog/<translit:\w+>'=>'catalog/index',
                                'products/search'=>'products/search',
                                'products/compare'=>'products/compare',
                                'products/<translit:\w+>'=>'products/index',
                                'products/<translit_rubric:\w+>/<translit:[\w\-]+>-<id:\d+>'=>'products/show',
                                'news/<translit:\w+>-<id:\d+>'=>'news/show',
                                'brends/<translit:[\w\-]+>'=>'brends/show',
                                'brends'=>'brends/index',
                                'blog'=>'articles/index',
                                'blog/<translit:[\w\-]+>-<id:\d+>'=>'articles/show',
                                
                            
                            
                                '<language:(ru|ua|en)>/<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
				'<language:(ru|ua|en)>/<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<language:(ru|ua|en)>/admin'=>'admin/default/index',
				'<language:(ru|ua|en)>/admin/users'=>'admin/users/index',
				'admin'=>'admin/menu/index',
                                'admin/users'=>'admin/users/index',
				'admin/users/save'=>'admin/users/save',
				'admin/users/delete'=>'admin/users/delete',
				
				'admin/menu'=>'admin/menu/index',
				'admin/menu/save'=>'admin/menu/save',
				'admin/menu/delete'=>'admin/menu/delete',

				'admin/text'=>'admin/text/index',
				'admin/text/save'=>'admin/text/save',
				'admin/text/delete'=>'admin/text/delete',	

				'admin/catalog'=>'admin/catalog/index',
				'admin/catalog/save'=>'admin/catalog/save',
				'admin/catalog/delete'=>'admin/catalog/delete',                            
			],			
			'class'=>'app\components\urlManager\LangUrlManager',
            'languages'=>['ru','ua','en'],
			'lang'=>'ru',
            'langParam'=>'language',
		],
		'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'enter your secret key here',
			'class' => 'app\components\urlManager\LangRequest'
        ],
       'authManager' => [
          'class' => 'yii\rbac\DbManager',
		  'defaultRoles' => ['guest'],
        ],	
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
			'loginUrl'=>array('login'),
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
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
        'db' => require(__DIR__ . '/db.php'),
    'i18n' => [
        'translations' => [
            'app*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                //'basePath' => '@app/messages',
                //'sourceLanguage' => 'en-US',
                'fileMap' => [
                    'app'       => 'app.php',
                    'app/error' => 'error.php',
                ],
            ],
            'admin*' => [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@app/modules/admin/messages',
				//'sourceLanguage' => 'ru',
            ],			
        ],
    ],
        
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,   // do not publish the bundle
                    'js' => [
                        'http://code.jquery.com/jquery-1.11.3.min.js',
                    ]
                ],
            ],
        ],        

    ],
'controllerMap' => [
        'elfinder' => [
            'class' => 'app\mihaildev\elfinder\PathController',
            'access' => ['@'],
            'root' => [
				'baseUrl'=>'@web',
                'basePath'=>'@webroot',
                'path' => 'files',
                'name' => 'Files',
				'access' => ['read' => '*', 'write' => '*']
            ],
            'watermark' => [
                        'source'         => __DIR__.'/logo.png', // Path to Water mark image
                         'marginRight'    => 5,          // Margin right pixel
                         'marginBottom'   => 5,          // Margin bottom pixel
                         'quality'        => 95,         // JPEG image save quality
                         'transparency'   => 70,         // Water mark image transparency ( other than PNG )
                         'targetType'     => IMG_GIF|IMG_JPG|IMG_PNG|IMG_WBMP, // Target image formats ( bit-field )
                         'targetMinPixel' => 200         // Target image minimum pixel size
            ]
        ]
    ],	
    'params' => $params,
		'modules' => [
			'admin' => [
				'class' => 'app\modules\admin\admin',
				'layout' => 'main',
			],
		],	
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii']['class'] = 'yii\gii\Module';
    $config['modules']['gii']['allowedIPs'] = ['127.0.0.1','::1','*.*.*.*'];
	
}

return $config;
