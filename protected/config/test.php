<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'db'=>array(
				'pdoClass' => 'NestedPDO',			
				'connectionString' => 'pgsql:host=localhost;dbname=mgsis',
				'emulatePrepare' => true,
				'username' => 'mgsis_yii',
				'password' => 'mgsis_yii',
				'charset' => 'utf8',
			),
		),
	)
);
