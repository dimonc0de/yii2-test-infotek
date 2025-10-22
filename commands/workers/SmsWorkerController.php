<?php
namespace app\commands\workers;

use app\services\notification\SmsSenderService;
use yii\console\Controller;
use app\models\SubscribeQueueSms;
use yii\db\Exception;

class SmsWorkerController extends Controller
{
    /**
     * @return void
     * @throws Exception
     */
    public function actionRun()
    {
        $sender = new SmsSenderService();

        while (true) {
            $sms = SubscribeQueueSms::find()
                ->where(['status' => 'pending'])
                ->orderBy(['created_at' => SORT_ASC])
                ->one();

            if (!$sms) {
                sleep(5);
                continue;
            }

            $sms->status = 'processing';
            $sms->save(false);

            try {
                $sender->send($sms->subscription->phone, $sms->message);
                $sms->status = 'sent';
                $sms->error_message = null;
            } catch (\Exception $e) {
                $sms->status = 'error';
                $sms->error_message = $e->getMessage();
            }

            $sms->save(false);
            usleep(500_000);
        }
    }
}
