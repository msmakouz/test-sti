<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Table;

#[Entity(role: 'comment', table: 'comments')]
#[Table(columns: [
    new Column(type: 'primary', property: 'id'),
    new Column(type: 'string', property: 'body', nullable: true)
])]
class Comment implements EventEmitterInterface
{
    public int $id;
    public ?string $body = null;
}
