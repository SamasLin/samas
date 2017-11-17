<?php
return [
	'asset' => [
		'init' => [
			// empty
		],
		'sql' => [
			'data'  => [
				// empty
			],
			'table' => [
				'user' => 'sql'
			]
		],
		'template' => [
			'ActionTemplate'     => 'php',
			'APITemplate'        => 'php',
			'ControllerTemplate' => 'php',
			'ListerTemplate'     => 'php',
			'ModelTemplate'      => 'php',
			'TableSQLTemplate'   => 'sql'
		]
	],
	'class' => [
		'core' => [
			'dao' => [
				'DatabaseMysqli' => 'php',
				'DatabasePDO'    => 'php'
			],
			'BaseLister'      => 'php',
			'BaseModel'       => 'php',
			'DaoAdapter'      => 'php',
			'ReflectionModel' => 'php'
		],
		'lister' => [
			'UserLister' => 'php'
		],
		'model' => [
			'UserModel' => 'php'
		],
		'service' => [
			'WebService' => 'php',
			'DevelopService' => 'php'
		],
		'trait' => [
			'FileOutput' => 'php'
		],
		'util' => [
			'StringUtil' => 'php'
		],
		'web' => [
			'AJAXResponser' => 'php',
			'PJAXLoader'    => 'php',
			'RequestParser' => 'php'
		]
	],
	'config' => [
		'class_loader'     => 'php',
		'database_config'  => 'php',
		'system_config'    => 'php'
	],
	'lib' => [
		// empty
	],
	'router' => [
		'action' => [
			'DevelopAction' => 'php',
			'SiteAction'    => 'php'
		],
		'api' => [
			'SiteAPI' => 'php'
		],
		'controller' => [
			'BackyardController' => 'php',
			'DevelopeController' => 'php',
			'SiteController'     => 'php'
		]
	],
	'static' => [
		'css' => [
			'main'  => 'css',
			'reset' => 'css'
		],
		'image' => [
			// empty
		],
		'js' => [
			'main' => 'js'
		],
		'lib' => [
			'jquery' => [
			],
			'jquery-form' => [
			],
			'jquery-ui' => [
			],
			'konami' => [
			],
			'masony' => [
			],
			'pjax' => [
			]
		]
	],
	'view' => [
		'component' => [
			'backyard' => [
				'breadcrumbs' => 'php'
			],
			'develop' => [
				'arrange-database' => 'php',
				'eval-code'        => 'php'
			]
		],
		'layout' => [
			'layout' => 'php'
		],
		'page' => [
			'backyard' => [
				'index' => 'php'
			],
			'develop' => [
				'data-export'      => 'php',
				'data-import'      => 'php',
				'data-truncate'    => 'php',
				'database-arrange' => 'php',
				'php-test'         => 'php',
				'phpinfo'          => 'php',
				'router-create'    => 'php',
				'table-create'     => 'php',
				'table-drop'       => 'php',
				'table-export'     => 'php',
				'table-import'     => 'php'
			],
			'error' => [
				'access-not-allowed'  => 'php',
				'page-not-found'      => 'php',
				'service-unavailable' => 'php'
			],
			'site' => [
				'login'  => 'php',
				'signup' => 'php'
			],
			'index' => 'php'
		]
	],
	'.htaccess'       => '',
	'global_function' => 'php',
	'index'           => 'php',
	'README'          => 'md'
];