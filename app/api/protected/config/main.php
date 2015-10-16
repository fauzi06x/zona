<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1234',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),
	'defaultController'=>'post',

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'globalFunction'=>array(
			'class'=>'GlobalFunction'
		),
		
		// 'db'=>array(
			// 'connectionString' => 'sqlite:protected/data/blog.db',
			// 'tablePrefix' => 'tbl_',
		// ),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'pgsql:host=localhost;dbname=sibisnis',
			'emulatePrepare' => true,
			'username' => 'postgres',
			'password' => 'kodok',
			'charset' => 'utf8',
		),
			
		// 'errorHandler'=>array(
			// use 'site/error' action to display errors
            // 'errorAction'=>'site/error',
        // ),
		
        'urlManager'=>array(
        	'urlFormat'=>'path',
        	'rules'=>array(
                        'post/<id:\d+>/<title:.*?>'=>'post/view',
                        'posts/<tag:.*?>'=>'post/index',
                        // REST patterns
						array('account/login', 'pattern'=>'login/<model:\w+>', 'verb'=>'POST'),
                        array('api/list', 'pattern'=>'api/list', 'verb'=>'POST'),
						array('api/search', 'pattern'=>'api/search', 'verb'=>'POST'),
                        array('api/view', 'pattern'=>'api/view', 'verb'=>'POST'),
                        array('api/update', 'pattern'=>'api/update', 'verb'=>'POST'),  // Update
                        array('api/delete', 'pattern'=>'api/delete', 'verb'=>'POST'),
                        array('api/create', 'pattern'=>'api/create', 'verb'=>'POST'), // Create
                        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        	),
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);
