<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_image}}`.
 */
class m251021_200611_create_book_image_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%book_image}}', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->notNull(),
            'image_path' => $this->string(255)->notNull(),
            'is_main' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-book_image-book_id', '{{%book_image}}', 'book_id');
        $this->createIndex('idx-book_image-book_id-is_main', '{{%book_image}}', ['book_id', 'is_main']);

        $this->addForeignKey(
            'fk-book_image-book_id',
            '{{%book_image}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE'
        );

        // ✅ Создаём триггер для INSERT
        $this->execute("
            CREATE TRIGGER before_insert_book_image
            BEFORE INSERT ON {{%book_image}}
            FOR EACH ROW
            BEGIN
                IF NEW.is_main THEN
                    IF EXISTS (
                        SELECT 1 FROM {{%book_image}}
                        WHERE book_id = NEW.book_id AND is_main = TRUE
                    ) THEN
                        SIGNAL SQLSTATE '45000'
                            SET MESSAGE_TEXT = 'Main image for this book already exists';
                    END IF;
                END IF;
            END;
        ");

        // Делаем ограничение на уровне sql чтобы главная фото могло быть только одно
        $this->execute("
            CREATE TRIGGER before_update_book_image
            BEFORE UPDATE ON {{%book_image}}
            FOR EACH ROW
            BEGIN
                IF NEW.is_main AND (OLD.is_main IS FALSE OR OLD.is_main IS NULL) THEN
                    IF EXISTS (
                        SELECT 1 FROM {{%book_image}}
                        WHERE book_id = NEW.book_id AND is_main = TRUE AND id != OLD.id
                    ) THEN
                        SIGNAL SQLSTATE '45000'
                            SET MESSAGE_TEXT = 'Main image for this book already exists';
                    END IF;
                END IF;
            END;
        ");
    }

    public function safeDown()
    {
        $this->execute("DROP TRIGGER IF EXISTS before_insert_book_image;");
        $this->execute("DROP TRIGGER IF EXISTS before_update_book_image;");

        $this->dropForeignKey('fk-book_image-book_id', '{{%book_image}}');
        $this->dropIndex('idx-book_image-book_id-is_main', '{{%book_image}}');
        $this->dropIndex('idx-book_image-book_id', '{{%book_image}}');
        $this->dropTable('{{%book_image}}');
    }
}
