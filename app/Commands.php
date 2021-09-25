<?php


namespace app;


use app\interfaces\INotifier;

class Commands
{
    private ClientRepository $clientRepository;
    const SMS = 1;
    const EMAIL = 2;
    private bool $statement = true;

    /**
     * Commands constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function run()
    {
        while ($this->statement) {
            $this->showClients();

            $clientId = readline('Выберите клиент по ID: ');

            $this->exitCommand($clientId);

            if ($this->emptyChecker($clientId)) continue;

            $selectedClient = $this->showClientInfo($clientId);

            $selectedNotifyMethod = $this->askForNotifyMethod();

            if ($this->emptyChecker($selectedNotifyMethod)) continue;

            $notifier = $this->handleUserSelectedMethod($selectedNotifyMethod);

            $notifier->notify($selectedClient);

            $this->statement = false;
        }
    }

    public function exitCommand(string $userInput): void
    {
        if (trim($userInput) === 'exit') {
            echo "Bye Bye!";
            exit();
        }
    }

    public function emptyChecker(string $userInput): bool
    {
        if (trim($userInput) === '') {
            echo "Попробуйте снова!\n";
            return true;
        }
        return false;
    }

    public function showClients(): void
    {
        echo "Списка клиентов: \n";
        $clients = $this->clientRepository->getAll();
        foreach ($clients as $client) {
            echo $client['id'] . '.' . $client['name'] . "\n";
        }
    }

    public function showClientInfo(string $clientId): array
    {
        $selectedClient = $this->clientRepository->getById($clientId);
        if (empty($selectedClient)) {
            echo "Client Not found!";
            (new Logger)->log('Client Not found!');
            exit();
        }

        echo "Имя клиента: " . $selectedClient[0]['name'] . "\n" . "Номер телефон клиента: " . $selectedClient[0]['phone_number'] . "\n";
        echo "Заказы: \n";
        foreach ($selectedClient as $order) {
            echo "Товар: " . $order['product'] . ' | ' . "Цена: " . $order['price'] . "$\n";
        }
        return $selectedClient;
    }

    public function askForNotifyMethod(): string
    {
        echo "Выберите способ отправки: \n";
        echo "1. SMS: \n";
        echo "2. Email: \n";
        return readline('>>>');
    }

    public function handleUserSelectedMethod(string $selectedNotifyMethod): INotifier
    {
        switch ($selectedNotifyMethod) {
            case self::SMS:
                return new FakeSmsSender();
            case self::EMAIL:
                return new FakeEmailSender();
            default:
                (new Logger)->log('Notify method doesnt exist!');
                exit();
        }
    }
}       