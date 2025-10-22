<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book}}`.
 */
class m251021_194134_create_book_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'publish_date' => $this->date()->notNull(),
            'description' => $this->text(),
            'isbn' => $this->string(20)->notNull()->unique(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }


    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }
}
