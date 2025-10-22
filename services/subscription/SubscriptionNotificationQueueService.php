<?php
namespace app\services\subscription;

use app\models\SubscribeQueueSms;
use app\models\Book;
use app\models\Subscription;
use app\services\base\BaseService;
use app\services\interfaces\NotificationQueueServiceInterface;

class SubscriptionNotificationQueueService extends BaseService implements NotificationQueueServiceInterface
{
    /**
     * Добавляет уведомления о новой книге в очередь подписчиков авторов
     * @param Book $book
     */
    public function enqueueNotifications(Book $book) : void
    {
        if (empty($book->authorIds)) {
            return;
        }

        foreach ($book->authorIds as $authorId) {
            $subscriptions = Subscription::find()->where(['author_id' => $authorId])->all();

            foreach ($subscriptions as $subscription) {
                if (empty($subscription->phone)) {
                    continue;
                }

                $queueItem = new SubscribeQueueSms();
                $queueItem->subscription_id = $subscription->id;
                $queueItem->message = "Новая книга от автора: \"{$book->title}\"";
                $queueItem->status = 'pending';

                $queueItem->save();
            }
        }
    }
}