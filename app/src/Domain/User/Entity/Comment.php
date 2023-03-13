<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(role: 'comment', table: 'comments',)]
class Comment implements EventEmitterInterface
{
    #[Column(type: 'primary')]
    public int $id;

    #[Column(type: 'string', nullable: true)]
    public ?string $body = null;
}
