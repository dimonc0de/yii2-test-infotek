<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subscribe_queue_sms".
 *
 * @property int $id
 * @property int $subscription_id
 * @property string $message
 * @property string $status
 * @property string|null $error_message
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Subscription $subscription
 */
class SubscribeQueueSms extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscribe_queue_sms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['error_message'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'pending'],
            [['subscription_id', 'message'], 'required'],
            [['subscription_id'], 'integer'],
            [['message', 'error_message'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'string', 'max' => 20],
            [['subscription_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subscription::class, 'targetAttribute' => ['subscription_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subscription_id' => 'Subscription ID',
            'message' => 'Message',
            'status' => 'Status',
            'error_message' => 'Error Message',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Subscription]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubscription()
    {
        return $this->hasOne(Subscription::class, ['id' => 'subscription_id']);
    }

}
