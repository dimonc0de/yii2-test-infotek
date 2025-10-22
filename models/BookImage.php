<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book_image".
 *
 * @property int $id
 * @property int $book_id
 * @property string $image_path
 * @property int $is_main
 * @property string $created_at
 *
 * @property Book $book
 */
class BookImage extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_main'], 'default', 'value' => 0],
            [['book_id', 'image_path'], 'required'],
            [['book_id', 'is_main'], 'integer'],
            [['created_at'], 'safe'],
            [['image_path'], 'string', 'max' => 255],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['book_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'image_path' => 'Image Path',
            'is_main' => 'Is Main',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::class, ['id' => 'book_id']);
    }

}
