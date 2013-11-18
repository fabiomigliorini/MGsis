<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

    'commandMap'=>array(
        'migrate'=>array(
            'class'=>'system.cli.commands.MigrateCommand',
            'migrationPath'=>'application.migrations',
            'migrationTable'=>'mgsis.tbl_migration',
            'connectionID'=>'db',
            'templateFile'=>'application.migrations.template',
        ),
    ),
	
	// application components
	'components'=>array(
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		'db'=>array(
			'connectionString' => 'pgsql:host=localhost;dbname=mgsis',
			'emulatePrepare' => true,
			'username' => 'mgsis_yii',
			'password' => 'mgsis_yii',
			'charset' => 'utf8',
		),
		'migrateCommand'=>array(
			'migrationTable'=>'mgsis.yii_tblmigration',
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