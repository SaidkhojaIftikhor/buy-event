<?php

use app\ClientRepository;
use app\Commands;

require_once __DIR__ . "/vendor/autoload.php";

$clientRepository = new ClientRepository();

$commands = new Commands($clientRepository);

$commands->run();