<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @github https://github.com/cinghie/yii2-dictionary
 * @license GNU GENERAL PUBLIC LICENSE VERSION 3
 * @package yii2-dictionary
 * @version 0.1.0
 */

use cinghie\traits\migrations\Migration;

class m170636_185700_create_dictionary_tables extends Migration
{
	/**
	 * @inheritdoc
	 */
	public function safeUp()
	{
		$this->createTable('{{%dictionary_keys}}', [
			'id' => $this->primaryKey(),
			'key' => $this->string(255)->notNull(),
		], $this->tableOptions);

		$this->createTable('{{%dictionary_values}}', [
			'id' => $this->primaryKey(),
			'key_id' => $this->integer(11),
			'value' => $this->string(255)->defaultValue(''),
			'lang' => $this->string(3)->notNull(),
			'lang_tag' => $this->string(5)->notNull(),
		], $this->tableOptions);

		// Add Index and Foreign Key key_id
		$this->createIndex(
			'index_dictionary_values_key_id',
			'{{%dictionary_values}}',
			'key_id'
		);

		$this->addForeignKey('fk_dictionary_values_key_id',
			'{{%dictionary_values}}', 'key_id',
			'{{%dictionary_keys}}', 'id',
			'SET NULL', 'CASCADE'
		);
	}

	/**
	 * @inheritdoc
	 */
	public function safeDown()
	{
		$this->dropTable('{{%dictionary_values}}');
		$this->dropTable('{{%dictionary_keys}}');
	}
}
