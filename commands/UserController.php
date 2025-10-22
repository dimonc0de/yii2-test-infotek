<?php

namespace app\commands;

use yii\console\Controller;
use app\factories\UserFactory;

class UserController extends Controller
{

    /**
     * @param $username
     * @param $email
     * @param $password
     * @return void
     */
    public function actionCreate($username, $email, $password)
    {
        $user = UserFactory::create($username, $email, $password);

        if ($user->hasErrors()) {
            $this->stderr("Ошибка при создании пользователя:\n");
            foreach ($user->errors as $errors) {
                foreach ($errors as $error) {
                    $this->stderr("$error\n");
                }
            }
        } else {
            $this->stdout("Пользователь $username создан.\n");
        }
    }
}