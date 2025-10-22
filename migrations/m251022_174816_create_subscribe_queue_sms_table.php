<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscribe_queue_sms}}`.
 */
class m251022_174816_create_subscribe_queue_sms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscribe_queue_sms}}', [
            'id' => $this->primaryKey(),
            'subscription_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'status' => $this->string(20)->notNull()->defaultValue('pending'),
            'error_message' => $this->text()->null(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-subscribe_queue_sms-subscription_id',
            '{{%subscribe_queue_sms}}',
            'subscription_id'
        );

        $this->addForeignKey(
            'fk-subscribe_queue_sms-subscription_id',
            '{{%subscribe_queue_sms}}',
            'subscription_id',
            '{{%subscription}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-subscribe_queue_sms-subscription_id', '{{%subscribe_queue_sms}}');
        $this->dropIndex('idx-subscribe_queue_sms-subscription_id', '{{%subscribe_queue_sms}}');
        $this->dropTable('{{%subscribe_queue_sms}}');
    }
}
