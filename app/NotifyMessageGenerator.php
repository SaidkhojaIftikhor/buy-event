<?php

namespace app;

class NotifyMessageGenerator
{
    public static function generateMessage($client)
    {
        echo "Здраствуйте ". $client[0]['name'] . "! Ваш заказ готов: \n";
        foreach ($client as $order) {
            echo $order['product'] . ' | ' . $order['price'] . 'c.' ."\n";
        }
        echo "Итого: " . array_sum(array_column($client, 'price')) . "с.";
    }
}