<?php

declare(strict_types=1);

namespace Cycle\Annotated;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Table;
use Cycle\Annotated\Exception\AnnotationException;
use Cycle\Schema\Definition\Entity as EntitySchema;
use Cycle\Schema\GeneratorInterface;
use Cycle\Schema\Registry;
use Doctrine\Common\Annotations\Reader as DoctrineReader;
use Spiral\Attributes\ReaderInterface;

/**
 * Copy column definitions from Mapper/Repository to Entity.
 */
final class MergeColumns implements GeneratorInterface
{
    private ReaderInterface $reader;

    private Configurator $generator;

    public function __construct(DoctrineReader|ReaderInterface $reader = null)
    {
        $this->reader = ReaderFactory::create($reader);
        $this->generator = new Configurator($this->reader);
    }

    public function run(Registry $registry): Registry
    {
        foreach ($registry as $e) {
            if ($e->getClass() === null || !$registry->hasTable($e)) {
                continue;
            }

            $this->copy($e, $e->getClass());

            // copy from related classes
            $this->copy($e, $e->getMapper());
            $this->copy($e, $e->getRepository());
            $this->copy($e, $e->getSource());
            $this->copy($e, $e->getScope());

            foreach ($registry->getChildren($e) as $child) {
                $this->copy($child, $child->getClass());
            }
        }

        return $registry;
    }

    /**
     * @param class-string|null  $class
     */
    private function copy(EntitySchema $e, ?string $class): void
    {
        if ($class === null) {
            return;
        }

        try {
            $class = new \ReflectionClass($class);
        } catch (\ReflectionException) {
            return;
        }

        try {
            $columns = $class->getParentClass()
                ? \array_merge($this->getColumns($class->getParentClass()), $this->getColumns($class))
                : $this->getColumns($class);
        } catch (\Exception $e) {
            throw new AnnotationException($e->getMessage(), $e->getCode(), $e);
        }

        $columns = \array_filter(
            $columns,
            static fn (string $field): bool => !$e->getFields()->has($field),
            \ARRAY_FILTER_USE_KEY
        );

        if ($columns === []) {
            return;
        }

        // additional columns (mapped to local fields automatically)
        $this->generator->initColumns($e, $columns, $class);
    }

    private function getColumns(\ReflectionClass $class): array
    {
        $columns = [];

        /** @var Table|null $table */
        $table = $this->reader->firstClassMetadata($class, Table::class);
        foreach ($table === null ? [] : $table->getColumns() as $name => $column) {
            if (\is_numeric($name)) {
                $name = $column->getProperty() ?? $column->getColumn();
            }
            $columns[$name] = $column;
        }

        foreach ($this->reader->getClassMetadata($class, Column::class) as $column) {
            $columns[] = $column;
        }

        return $columns;
    }
}
