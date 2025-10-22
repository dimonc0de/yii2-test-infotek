<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%author}}`.
 */
class m251021_194153_create_author_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'surname' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'patronymic' => $this->string()->null(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%author}}');
    }
}
