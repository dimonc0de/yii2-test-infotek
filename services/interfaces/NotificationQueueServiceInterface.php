<?php
namespace app\services\interfaces;

use app\models\Book;

interface NotificationQueueServiceInterface
{
    /**
     * @param Book $book
     * @return void
     */
    public function enqueueNotifications(Book $book): void;

}