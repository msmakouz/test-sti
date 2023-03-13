<?php

declare(strict_types=1);

namespace App\Domain\User\Entity;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Inheritance\SingleTable;
use Cycle\Annotated\Annotation\Relation\Morphed\BelongsToMorphed;

#[Entity]
#[SingleTable(value: 'comment.created')]
class CommentCreated extends BaseEvent
{
    #[BelongsToMorphed(
        target: EventEmitterInterface::class,
        innerKey: 'object_id',
        morphKey: 'object_type',
        indexCreate: false,
    )]
    public EventEmitterInterface|Comment $object;
}
