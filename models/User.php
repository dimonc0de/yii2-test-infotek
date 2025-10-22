<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string|null $auth_key
 * @property string|null $access_token
 * @property string|null $email
 * @property string|null $created_at
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['created_at'], 'safe'],
            [['username', 'password_hash', 'auth_key', 'access_token', 'email'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'email' => 'Email',
            'created_at' => 'Created At',
        ];
    }


    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}