<?php

namespace app;

use app\interfaces\INotifier;

class FakeEmailSender implements INotifier
{
    public function notify($client): void
    {
        echo "Сообщения успешно отправлен на почту: {$client[0]['email']}\n";
        NotifyMessageGenerator::generateMessage($client);
    }
}