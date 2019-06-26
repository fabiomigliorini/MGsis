<?php

class m131209_130759_cria_tabelas_rbac extends CDbMigration
{
	public function up()
	{
		// authItem = roles, tasks, and operations
		$this->createTable(
				'tblauthitem', 
				array(
					'name' =>'varchar(64) NOT NULL',
					'type' =>'integer NOT NULL',
					'description' =>'text',
					'bizrule' =>'text',
					'data' =>'text',
					'PRIMARY KEY (name)',
				)
			);
		
		//the relation between the 3 categories - parent/child
		$this->createTable(
				'tblauthitemchild', 
				array(
					'parent' =>'varchar(64) NOT NULL',
					'child' =>'varchar(64) NOT NULL',
					'PRIMARY KEY (parent,child)',
				)
			);
		
		//the tblauthitemchild.parent is a reference to tblauthitem.name
		$this->addForeignKey("fk_auth_item_child_parent", "tblauthitemchild", "parent", "tblauthitem", "name", "CASCADE", "CASCADE");
		
		//the tblauthitemchild.child is a reference to tblauthitem.name
		$this->addForeignKey("fk_auth_item_child_child", "tblauthitemchild", "child", "tblauthitem", "name", "CASCADE", "CASCADE");
		
		//relation between user and some auth item
		$this->createTable(
				'tblauthassignment', 
				array(
					'itemname' =>'varchar(64) NOT NULL',
					'userid' =>'bigint NOT NULL',
					'bizrule' =>'text',
					'data' =>'text',
					'PRIMARY KEY (itemname,userid)',
				)
			);
		
		//the tblauthassignment.itemname is a reference
		//to tblauthitem.name
		$this->addForeignKey(
			"fk_auth_assignment_itemname",
			"tblauthassignment",
			"itemname",
			"tblauthitem",
			"name",
			"CASCADE",
			"CASCADE"
		);
		
		//the tblauthassignment.codusuario is a reference
		//to tblusuario.codusuario
		$this->addForeignKey(
			"fk_auth_assignment_codusuario",
			"tblauthassignment",
			"userid",
			"tblusuario",
			"codusuario",
			"CASCADE",
			"CASCADE"
		);
		
	}
	public function down()
	{
		//$this->truncateTable('tblauthassignment');
		//$this->truncateTable('tblauthitemchild');
		//$this->truncateTable('tblauthitem');
		$this->dropTable('tblauthassignment');
		$this->dropTable('tblauthitemchild');
		$this->dropTable('tblauthitem');
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