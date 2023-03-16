<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Inheritance\DiscriminatorColumn;
use Cycle\Annotated\Annotation\Table;

#[Entity(role: 'event', table: 'events')]
#[Table(columns: [
    new Column(type: 'primary', property: 'id'),
    new Column(type: 'string', property: 'action'),
    new Column(type: 'string', property: 'object_type', nullable: true),
    new Column(type: 'integer', property: 'object_id', nullable: true),
])]
#[DiscriminatorColumn(name: 'action')]
abstract class BaseEvent
{
    public int $id;
    public string $action;
    public ?string $object_type = null;
    public ?int $object_id = null;
}
