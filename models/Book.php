<?php

namespace app\models;

use app\services\subscription\SubscriptionNotificationQueueService;
use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property string $publish_date
 * @property string|null $description
 * @property string $isbn
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Author[] $authors
 * @property BookAuthor[] $bookAuthors
 * @property BookImage[] $bookImages
 */
class Book extends \yii\db\ActiveRecord
{
    public $imageFile;

    public $authorIds = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'default', 'value' => null],
            [['title', 'publish_date', 'isbn'], 'required'],
            [['publish_date', 'created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 20],
            [['isbn'], 'unique'],
            ['imageFile', 'file', 'extensions' => 'png, jpg, jpeg', 'skipOnEmpty' => false],
            ['authorIds', 'required', 'message' => 'Пожалуйста, выберите хотя бы одного автора'],
            ['authorIds', 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'publish_date' => 'Publish Date',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $subscriptionService = new SubscriptionNotificationQueueService();
            $subscriptionService->enqueueNotifications($this);
        }
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    public function getMainImage()
    {
        return $this->hasOne(BookImage::class, ['book_id' => 'id'])->andWhere(['is_main' => 1]);
    }
}
