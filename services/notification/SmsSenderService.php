<?php
namespace app\services\notification;

use app\services\interfaces\NotificationSenderInterface;
use Yii;

class SmsSenderService implements NotificationSenderInterface
{
    public function send(string $phone, string $message): void
    {
        // TODO: подключить реальный SMS API
        Yii::info("Отправка SMS на $phone: $message");
    }
}