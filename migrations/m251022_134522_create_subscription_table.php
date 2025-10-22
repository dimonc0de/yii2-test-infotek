<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscription}}`.
 */
class m251022_134522_create_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscription}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(11)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-subscription-author-phone',
            '{{%subscription}}',
            ['author_id', 'phone'],
            true
        );

        $this->addForeignKey(
            'fk-subscription-author',
            '{{%subscription}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-subscription-author', '{{%subscription}}');
        $this->dropIndex('idx-subscription-author-phone', '{{%subscription}}');
        $this->dropTable('{{%subscription}}');
    }
}
