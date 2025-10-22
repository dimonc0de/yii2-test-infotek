<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m251021_195241_create_user_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32),
            'access_token' => $this->string(64),
            'email' => $this->string()->unique(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
