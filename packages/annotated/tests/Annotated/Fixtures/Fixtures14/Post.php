<?php

declare(strict_types=1);

namespace Cycle\Annotated\Tests\Fixtures\Fixtures14;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

/**
 * @Entity()
 */
#[Entity]
class Post
{
    /** @Column(type="integer", primary=true) */
    #[Column(type: 'integer', primary: true)]
    protected int $id1;

    /** @Column(type="integer", primary=true) */
    #[Column(type: 'integer', primary: true)]
    protected int $id2;
}
