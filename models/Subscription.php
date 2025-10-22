<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subscription".
 *
 * @property int $id
 * @property int $author_id
 * @property string $phone
 * @property string|null $created_at
 *
 * @property Author $author
 */
class Subscription extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'phone'], 'required'],
            ['author_id', 'integer'],
            ['phone', 'match', 'pattern' => '/^7\d{10}$/', 'message' => 'Телефон должен быть в формате 7XXXXXXXXXX (11 цифр, начиная с 7)'],
            [['author_id', 'phone'], 'unique', 'targetAttribute' => ['author_id', 'phone'], 'message' => 'Вы уже подписаны на этого автора с этим номером.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'phone' => 'Phone',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

}
