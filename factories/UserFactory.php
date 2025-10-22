<?php

namespace app\factories;

use app\models\User;
use Yii;

class UserFactory
{
    /**
     * Создает нового пользователя
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @return User
     */
    public static function create(string $username, string $email, string $password): User
    {
        $user = new User();
        $user->username = $username;
        $user->email = $email;
        $user->password_hash = Yii::$app->security->generatePasswordHash($password);
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->access_token = Yii::$app->security->generateRandomString(64);

        $user->save();
        return $user;
    }
}