<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Inheritance\DiscriminatorColumn;

#[Entity(role: 'event', table: 'events')]
#[DiscriminatorColumn(name: 'action')]
abstract class BaseEvent
{
    #[Column(type: 'primary')]
    public int $id;

    #[Column(type: 'string')]
    public string $action;
}
