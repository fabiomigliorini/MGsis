<?php

class m140128_213322_adiciona_impressoramatricial_tblusuario extends CDbMigration
{
	public function up()
	{
		Yii::app()->db->createCommand('alter table tblusuario add impressoramatricial varchar(20)')->execute();		
		Yii::app()->db->createCommand('update tblusuario set impressoramatricial = \'EscritorioEpson\'')->execute();		
	}

	public function down()
	{
		echo "m140128_213322_adiciona_impressoramatricial_tblusuario does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}