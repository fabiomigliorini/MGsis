<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
	
	'import'=>array(
		'application.components.*',
	),

	'commandMap' => array(
		'migrate' => array(
			'class' => 'system.cli.commands.MigrateCommand',
			'migrationTable' => 'mgsis.tbl_migration'
		)
	),
	/*
    'commandMap'=>array(
        //'migrate'=>array(
            //'class'=>'system.cli.commands.MigrateCommand',
            //'migrationPath'=>'application.migrations',
            //'migrationTable'=>'mgsis.tbl_migration',
            //'connectionID'=>'db',
            //'templateFile'=>'application.migrations.template',
        //),
    ),
	*/
	
	// application components
	'components'=>array(
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		'db'=>array(
			'pdoClass' => 'NestedPDO',			
			'connectionString' => 'pgsql:host=localhost;dbname=mgsis',
			'emulatePrepare' => true,
			'username' => 'mgsis_yii',
			'password' => 'mgsis_yii',
			'charset' => 'utf8',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);