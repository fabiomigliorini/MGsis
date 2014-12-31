<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'MGsis',
    //'theme'=>'mgsis',
	//'sourceLanguage'=>'pt_br',
	'language'=>'pt-BR',
	
	// preloading 'log' component
	'preload'=>array(
		'log',
		'bootstrap'
		),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.srbac.controllers.SBaseController'
	),
	
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123321',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
                        'generatorPaths'=>array(
                            'bootstrap.gii',
                        ),                    
		),
		'srbac'=>
			array(
				"userclass"=>"Usuario",
				"userid"=>"codusuario",
				"username"=>"usuario",
				"debug"=>false,
				"pageSize"=>30,
				"superUser" =>"Administrador",
				"alwaysAllowed"=>array(
					'SiteLogin',
					'SiteLogout',
					//'SiteIndex',
					//'SiteAdmin',
					'SitePage',
					'SiteCaptcha',
					'SiteError',
					'SiteContact',
					//'PessoaAjaxBuscaPessoa',
					//'PessoaAjaxInicializaPessoa',
				),
				'notAuthorizedView'=> 'srbac.views.authitem.unauthorized', // default:
				//'notAuthorizedView'=> 'siteerror', // default:
				// The operation assigned to users
				"userActions"=>array(
					"Index",
					"View",
				),
				// The number of lines of the listboxes
				//"listBoxNumberOfLines" => 10,
				// The path to the custom images relative to basePath (default the srbac images path)
				//"imagesPath"=>"../images",
				//The icons pack to use (noia, tango)
				//"imagesPack"=>"noia",
				// Whether to show text next to the menu icons (default false)
				"iconText"	=>true,
			)		
		),
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		'format'=>array(
			'class'=>'application.components.MGFormatter',
		),
		'authManager'=>array(
			'class'=>'application.modules.srbac.components.SDbAuthManager',
			'connectionID'=>'db',
			'itemTable'=>'mgsis.tblauthitem',
			'assignmentTable'=>'mgsis.tblauthassignment',
			'itemChildTable'=>'mgsis.tblauthitemchild',
		),
		'bootstrap' => array(
			'class' => 'application.extensions.yiibooster.components.Bootstrap',
		),		

		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		 * 
		 */
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			'showScriptName'=>false,
		),
		 * 
		 */
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		'db'=>array(
			'pdoClass' => 'NestedPDO',			
			'connectionString' => 'pgsql:host=127.0.0.1;dbname=mgsis',
			//'emulatePrepare' => true,
			'username' => 'mgsis_yii',
			'password' => 'mgsis_yii',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
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
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);