<?php
namespace app\services\subscription;

use app\models\SubscribeQueueSms;
use app\models\Book;
use app\models\Subscription;
use app\services\base\BaseService;
use app\services\interfaces\NotificationQueueServiceInterface;
use Yii;

class SubscriptionNotificationQueueService extends BaseService implements NotificationQueueServiceInterface
{
    /**
     * Добавляет уведомления о новой книге в очередь подписчиков авторов
     * @param Book $book
     */
    public function enqueueNotifications(Book $book): void
    {
        if (empty($book->authorIds)) {
            return;
        }

        $authorIds = implode(',', array_map('intval', $book->authorIds));

        $db = Yii::$app->db;

        $sql = "
        INSERT INTO {{%subscribe_queue_sms}} (subscription_id, message, status)
        SELECT s.id, CONCAT('Новая книга от автора: \"', :title, '\"'), 'pending'
        FROM {{%subscription}} s
        WHERE s.author_id IN ($authorIds)
          AND s.phone IS NOT NULL
        ";

        $db->createCommand($sql, [':title' => $book->title])->execute();
    }
}