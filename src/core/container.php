<?php

use src\interfaces\NexusRepositoryInterface;
use src\interfaces\NotificationInterface;
use src\repositories\NexusRepository;
use src\support\Notification;

$containerBuilder = (new  DI\ContainerBuilder());

$containerBuilder->useAttributes(true);

$containerBuilder->addDefinitions(
    [        
        NexusRepositoryInterface::class => DI\autowire(NexusRepository::class),
        NotificationInterface::class => DI\autowire(Notification::class),
    ]
);

return $containerBuilder->build();