<?php

declare(strict_types=1);

namespace App\Endpoint\Console;

use App\Domain\User\Entity\Comment;
use App\Domain\User\Entity\CommentCreated;
use Cycle\ORM\EntityManagerInterface;
use Spiral\Console\Attribute\AsCommand;
use Spiral\Console\Command;

#[AsCommand(name: 'test', description: 'Test.')]
final class Test extends Command
{
    public function __invoke(EntityManagerInterface $entityManager): int
    {
        $comment = new Comment();
        $comment->body = 'test';

        $event = new CommentCreated();
        $event->object = $comment;

        $entityManager->persist($event);
        $entityManager->run();

        return self::SUCCESS;
    }
}
