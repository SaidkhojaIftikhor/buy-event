<?php

namespace app;

use app\interfaces\INotifier;

class FakeSmsSender implements INotifier
{
    public function notify($client): void
    {
        echo "Сообщения был отправлен на номер: {$client[0]['phone_number']} \n";
        NotifyMessageGenerator::generateMessage($client);
    }
}