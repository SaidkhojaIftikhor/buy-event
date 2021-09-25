<?php

namespace app\interfaces;


interface INotifier
{
    public function notify(array $client): void;
}