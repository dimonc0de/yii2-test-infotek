<?php
namespace app\services\interfaces;

interface NotificationSenderInterface
{
    /**
     * @param string $to
     * @param string $message
     * @return void
     */
    public function send(string $to, string $message): void;
}