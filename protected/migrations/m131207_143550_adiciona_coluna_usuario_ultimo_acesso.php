<?php

class m131207_143550_adiciona_coluna_usuario_ultimo_acesso extends CDbMigration
{
	public function up()
	{
		Yii::app()->db->createCommand('alter table tblusuario add ultimoacesso TIMESTAMP WITHOUT TIME ZONE')->execute();
		Yii::app()->db->createCommand('alter table tblusuario add inativo DATE')->execute();
	}

	public function down()
	{
		echo "m131207_143550_adiciona_coluna_usuario_ultimo_acesso does not support migration down.\n";
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